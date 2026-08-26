<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadStatus;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Total Leads
        $totalLeads = Lead::count();

        // 2. Ambil Semua Status Secara Dinamis
        $statuses = LeadStatus::orderBy('order', 'asc')->get();

        $statusCounts = [];
        $chartLabels = [];
        $chartColors = [];
        $closeLeads = 0;

        foreach ($statuses as $status) {
            $count = Lead::where('lead_status_id', $status->id)->count();

            // Simpan data untuk View (KPI Card & Chart)
            $statusCounts[$status->id] = $count;
            $chartLabels[] = $status->name;

            // Ekstrak kode warna hex dari Tailwind class (misal: bg-[#93c5fd] jadi #93c5fd)
            preg_match('/\[(.*?)\]/', $status->color, $match);
            $chartColors[] = $match[1] ?? '#cccccc'; // Warna fallback kalau gagal ekstrak

            // Logic hitung Conversion Rate: cari status yang namanya mengandung 'close' atau 'won'
            if (stripos($status->name, 'close') !== false || stripos($status->name, 'won') !== false) {
                $closeLeads += $count;
            }
        }

        // 3. Hitung Conversion Rate
        $conversionRate = 0;
        if ($totalLeads > 0) {
            $conversionRate = round(($closeLeads / $totalLeads) * 100, 1);
        }

        // 4. Data untuk Chart: Leads berdasarkan Source
        $sourceData = Lead::selectRaw('source, count(*) as total')
            ->whereNotNull('source')
            ->groupBy('source')
            ->pluck('total', 'source')
            ->toArray();

        // 5. Data untuk Chart: Leads masuk berdasarkan waktu
        $days = $request->input('range', 7);
        $dateData = Lead::selectRaw('DATE(created_at) as date, count(*) as total')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        return view('dashboard', compact(
            'totalLeads', 'statuses', 'statusCounts', 'conversionRate',
            'sourceData', 'dateData', 'days', 'chartLabels', 'chartColors'
        ));
    }
}
