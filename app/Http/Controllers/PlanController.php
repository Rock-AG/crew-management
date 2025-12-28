<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function create(Request $request): View
    {
        $plan = new Plan();
        return view('plan.create', ['plan' => $plan]);
    }
}
