<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $urls              = Auth::user()->url()->with('hits')->withCount(['hits', 'lead'])->get();
        $total_hits_count  = 0;
        $total_leads_count = 0;

        foreach ($urls as $url) {
            $total_leads_count = $total_leads_count + $url->lead_count;
        }

        foreach ($urls as $url) {
            $total_hits_count = $total_hits_count + $url->hits_count;
        }

        return view('dashboard', [
            'urls'              => $urls,
            'total_hits_count'  => $total_hits_count,
            'total_leads_count' => $total_leads_count,
        ]);
    }
}
