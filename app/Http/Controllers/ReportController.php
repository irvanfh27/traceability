<?php

namespace App\Http\Controllers;

use App\Vendor;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();

        return view('pages.report.index', compact('vendors'));
    }

}
