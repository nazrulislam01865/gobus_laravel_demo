<?php

namespace App\Http\Controllers;

use App\Models\BusCompany;
use App\Models\Promotion;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->get();

        $busCompanies = BusCompany::latest()->get();

        $activeSection = session('active_section', 'revenue');

        return view('admin.dashboard', compact(
            'promotions',
            'busCompanies',
            'activeSection'
        ));
    }
}
