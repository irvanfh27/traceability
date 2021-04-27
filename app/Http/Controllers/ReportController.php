<?php

namespace App\Http\Controllers;

use App\Vendor;
use App\Stockpile;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('pages.report.supplier-report');
    }

    public function reportStockpile()
    {
        return view('pages.report.stockpile-report');
    }

}
