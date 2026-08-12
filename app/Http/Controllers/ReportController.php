<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default range waktu: 30 hari terakhir jika tidak ada filter
        $days = $request->input('days', 30);
        $startDate = now()->subDays($days)->startOfDay();

        // Rekapitulasi Data
        $totalLeads = Lead::where('created_at', '>=', $startDate)->count();
        $closeLeads = Lead::where('status', 'close')->where('created_at', '>=', $startDate)->count();

        $conversionRate = $totalLeads > 0 ? round(($closeLeads / $totalLeads) * 100, 1) : 0;

        // Data Breakdown per Source
        $leadsBySource = Lead::selectRaw('source, count(*) as total')
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('source')
            ->groupBy('source')
            ->get();

        return view('reports.index', compact('totalLeads', 'closeLeads', 'conversionRate', 'days', 'leadsBySource'));
    }
}
