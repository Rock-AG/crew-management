<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class HomepageController extends Controller
{
    public function homepage()
    {
        // Get plans to show and order by start date
        $plans = Plan::withAggregate('shifts', 'start')
            ->where('show_on_homepage', true)
            ->orderBy('shifts_start')
            ->get();
        return view('home', ['plans' => $plans]);
    }
}