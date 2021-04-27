<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockpileReportResource;
use App\Http\Resources\SupplierReportResource;
use App\Stockpile;
use App\Vendor;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function reportSupplier(): array
    {
        return [
            'aaData' => SupplierReportResource::collection(Vendor::all())
        ];
    }

    public function reportStockpile(): array
    {
        return [
            'aaData' => StockpileReportResource::collection(Stockpile::all())
        ];
    }
}
