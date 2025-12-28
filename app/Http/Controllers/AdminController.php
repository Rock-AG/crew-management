<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin()
    {
        $plans = Plan::orderBy('title')->get();

        return view('admin', [
            'plans' => $plans,
        ]);
    }
}
