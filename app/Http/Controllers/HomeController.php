<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;

class HomeController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::orderBy('price', 'asc')->get();
        return view('landing.index', compact('plans'));
    }
}
