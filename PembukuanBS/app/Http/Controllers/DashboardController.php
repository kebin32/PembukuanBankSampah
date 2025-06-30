<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;

class DashboardController extends Controller
{
    public function index()
    {
        $bankSampah = Nasabah::find(1);
        return view('dashboard', compact('bankSampah'));
    }
}
