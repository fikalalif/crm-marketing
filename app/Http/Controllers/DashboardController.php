<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. KPI Cards (Sudah ada)
        $totalLeads = Lead::count();
        $coolLeads = Lead::where('status', 'cool')->count();
        $warmLeads = Lead::where('status', 'warm')->count();
        $hotLeads = Lead::where('status', 'hot')->count();
        $closeLeads = Lead::where('status', 'close')->count();

        $conversionRate = 0;
        if ($totalLeads > 0) {
            $conversionRate = round(($closeLeads / $totalLeads) * 100, 1);
        }

        // 2. Data untuk Chart: Leads berdasarkan Source
        $sourceData = Lead::selectRaw('source, count(*) as total')
            ->whereNotNull('source')
            ->groupBy('source')
            ->pluck('total', 'source')
            ->toArray();

        // 3. Data untuk Chart: Leads masuk berdasarkan waktu
        // Mengambil filter waktu dari request, default 7 hari
        $days = $request->input('range', 7);
        $dateData = Lead::selectRaw('DATE(created_at) as date, count(*) as total')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        return view('dashboard', compact(
            'totalLeads', 'coolLeads', 'warmLeads', 'hotLeads', 'closeLeads', 'conversionRate',
            'sourceData', 'dateData', 'days'
        ));
    }
}
