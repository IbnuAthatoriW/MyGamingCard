<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function index(Request $request): View
    {
        $cards = $request->user()->gamingCards()->latest()->get();

        return view('dashboard', compact('cards'));
    }
}
