<?php

namespace App\Http\Controllers;

use App\Vendor;
use App\Stockpile;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();

        return view('pages.report.supplier-document', compact('vendors'));
    }

    public function reportStockpile()
    {
        $stockpiles = Stockpile::all();

        return view('pages.report.stockpile-document', compact('stockpiles'));
    }

}
