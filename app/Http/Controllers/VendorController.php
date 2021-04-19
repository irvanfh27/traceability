<?php

namespace App\Http\Controllers;

use App\CategoryDocument;
use App\Http\Resources\MapResource;
use App\Http\Resources\SupplierResource;
use App\Vendor;
use App\VendorDetail;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::all();
        return view('pages.vendor.index', compact('vendors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vendor = VendorDetail::where('vendor_id', $request->vendor_id)->first();

        if (isset($vendor)) {
            VendorDetail::where('vendor_id', $request->vendor_id)->update($request->except(['_token']));
        } else {
            VendorDetail::create($request->except(['_token']));
        }

        return redirect()->route('vendor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = Vendor::with('documents')->findOrFail($id);
        $category = CategoryDocument::where('category_for', 1)->get();

        return view('pages.vendor.show', compact('vendor', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return request()->route()->parameters;
        $vendor = VendorDetail::where('vendor_id', $id)->first();
        $vendorHeader = Vendor::findOrFail($id);

        return view('pages.vendor.create', compact('vendor', 'vendorHeader'));
    }

    public function apiMaps($stockpileId)
    {
        $vendor = Vendor::whereHas('contract', function ($q) use ($stockpileId) {
            $q->whereHas('stockpileContract', function ($qq) use ($stockpileId) {
                $qq->where('stockpile_id', $stockpileId);
            });
        })->whereHas('detail', function ($q) {
            $q->whereNotNull('latitude')->whereNotNull('longitude');
        })->get();


//         $vendor = DB::select("SELECT (ATAN(
//     SQRT(
//         POW(COS(RADIANS(v.`vendor_longitude`)) * SIN(RADIANS(v.`vendor_longitude`) - RADIANS(sto.`stockpile_longitude`)), 2) +
//         POW(COS(RADIANS(sto.`stockpile_latitude`)) * SIN(RADIANS(v.`vendor_latitude`)) -
//        SIN(RADIANS(19.391124)) * cos(RADIANS(v.`vendor_latitude`)) * cos(RADIANS(v.`vendor_longitude`) - RADIANS(sto.`stockpile_longitude`)), 2)
//     )
//     ,
//     SIN(RADIANS(sto.`stockpile_latitude`)) *
//     SIN(RADIANS(v.`vendor_latitude`)) +
//     COS(RADIANS(sto.`stockpile_latitude`)) *
//     COS(RADIANS(v.`vendor_latitude`)) *
//     COS(RADIANS(v.`vendor_longitude`) - RADIANS(sto.`stockpile_longitude`))
//  ) * 6371000) as distance,
// v.`vendor_name`, v.vendor_longitude, v.vendor_latitude,v.vendor_id,v.vendor_address, vd.kapasitas_produksi
// FROM
// 	vendor as v,
// 	`stockpile` as sto,
//     `vendor_detail` as vd
// WHERE v.`stockpile_id` = sto.`stockpile_id`
// AND sto.`stockpile_id` = '$stockpileId' AND (ATAN(
//     SQRT(
//         POW(COS(RADIANS(v.`vendor_longitude`)) * SIN(RADIANS(v.`vendor_longitude`) - RADIANS(sto.`stockpile_longitude`)), 2) +
//         POW(COS(RADIANS(sto.`stockpile_latitude`)) * SIN(RADIANS(v.`vendor_latitude`)) -
//        SIN(RADIANS(19.391124)) * cos(RADIANS(v.`vendor_latitude`)) * cos(RADIANS(v.`vendor_longitude`) - RADIANS(sto.`stockpile_longitude`)), 2)
//     )
//     ,
//     SIN(RADIANS(sto.`stockpile_latitude`)) *
//     SIN(RADIANS(v.`vendor_latitude`)) +
//     COS(RADIANS(sto.`stockpile_latitude`)) *
//     COS(RADIANS(v.`vendor_latitude`)) *
//     COS(RADIANS(v.`vendor_longitude`) - RADIANS(sto.`stockpile_longitude`))
//  ) * 6371000) is not null
// ORDER BY distance ASC");


        return [
            "id" => "places",
            "type" => "symbol",
            "source" => [
                "type" => "geojson",
                "data" => [
                    "type" => "FeatureCollection",
                    "features" => MapResource::collection($vendor)
                ]
            ],
            "layout" => [
                "icon-image" => "cat",
                "icon-size" => 0.25,
                'text-field' => ['get', 'title'],
                'text-offset' => [0, 1.25],
            ]
        ];
    }

    public function supplierByStockpile($stockpileId)
    {

        $vendor = Vendor::whereHas('contract', function ($q) use ($stockpileId) {
            $q->whereHas('stockpileContract', function ($qq) use ($stockpileId) {
                $qq->where('stockpile_id', $stockpileId);
            });
        })->get();

        return [
            'aaData' => SupplierResource::collection($vendor)
        ];
    }
}
