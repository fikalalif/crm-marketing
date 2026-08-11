<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung KPI Leads
        $totalLeads = Lead::count();
        $coolLeads = Lead::where('status', 'cool')->count();
        $warmLeads = Lead::where('status', 'warm')->count();
        $hotLeads = Lead::where('status', 'hot')->count();
        $closeLeads = Lead::where('status', 'close')->count();

        // Menghitung Conversion Rate (Close / Total * 100)
        $conversionRate = 0;
        if ($totalLeads > 0) {
            $conversionRate = round(($closeLeads / $totalLeads) * 100, 1);
        }

        // Kirim semua variabel ke view dashboard
        return view('dashboard', compact(
            'totalLeads',
            'coolLeads',
            'warmLeads',
            'hotLeads',
            'closeLeads',
            'conversionRate'
        ));
    }
}
