<?php

namespace App\Http\Controllers;

use App\Models\SetoranDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetoranController extends Controller
{
    public function nasabahDetail()
    {

        return view('nasabah-detail');
    }
}
