<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadStatus;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $days = $request->input('days', 30);
        $startDate = now()->subDays($days)->startOfDay();

        // Total leads masuk di range waktu
        $totalLeads = Lead::where('created_at', '>=', $startDate)->count();

        // Cari ID status untuk 'Close' secara dinamis
        $closeStatusIds = LeadStatus::where('name', 'like', '%close%')
                                    ->orWhere('name', 'like', '%won%')
                                    ->pluck('id');

        // Hitung leads yang statusnya Close pada range waktu tersebut
        $closeLeads = Lead::whereIn('lead_status_id', $closeStatusIds)
                          ->where('created_at', '>=', $startDate)
                          ->count();

        $conversionRate = $totalLeads > 0 ? round(($closeLeads / $totalLeads) * 100, 1) : 0;

        $leadsBySource = Lead::selectRaw('source, count(*) as total')
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('source')
            ->groupBy('source')
            ->get();

        return view('reports.index', compact('totalLeads', 'closeLeads', 'conversionRate', 'days', 'leadsBySource'));
    }
}
