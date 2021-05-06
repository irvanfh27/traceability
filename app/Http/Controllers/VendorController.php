<?php

namespace App\Http\Controllers;

use App\CategoryDocument;
use App\Http\Resources\MapResource;
use App\Http\Resources\SupplierResource;
use App\Http\Resources\VendorResource;
use App\Province;
use App\Vendor;
use App\VendorDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $vendor = Vendor::select('vendor_id', 'vendor_name', 'vendor_address')->get();

            return [
                'aaData' => VendorResource::collection($vendor)
            ];
        }

        return view('pages.vendor.index');
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
        $input = $request->except(['_token', 'photo1', 'photo2', 'photo3', 'photo4']);
        $photo1 = $request->file('photo1');
        $photo2 = $request->file('photo2');
        $photo3 = $request->file('photo3');
        $photo4 = $request->file('photo4');

        if ($photo1) {
            $filenameWithExt1 = $photo1->getClientOriginalName();
            $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
            $extension1 = $photo1->getClientOriginalExtension();
            $filenameSimpan1 = $filename1 . '_' . time() . '.' . $extension1;
            $path1 = $photo1->storeAs('public/photos/supplier', $filenameSimpan1);
            $input['photo_1'] = url(Storage::url('photos/supplier/') . $filenameSimpan1);
        }

        if ($photo2) {
            $filenameWithExt2 = $photo2->getClientOriginalName();
            $filename2 = pathinfo($filenameWithExt2, PATHINFO_FILENAME);
            $extension2 = $photo2->getClientOriginalExtension();
            $filenameSimpan2 = $filename2 . '_' . time() . '.' . $extension2;
            $path2 = $photo2->storeAs('public/photos/supplier', $filenameSimpan2);
            $input['photo_2'] = url(Storage::url('photos/supplier/') . $filenameSimpan2);
        }

        if ($photo3) {
            $filenameWithExt3 = $photo3->getClientOriginalName();
            $filename3 = pathinfo($filenameWithExt3, PATHINFO_FILENAME);
            $extension3 = $photo3->getClientOriginalExtension();
            $filenameSimpan3 = $filename3 . '_' . time() . '.' . $extension3;
            $path3 = $photo3->storeAs('public/photos/supplier', $filenameSimpan3);
            $input['photo_3'] = url(Storage::url('photos/supplier/') . $filenameSimpan3);
        }

        if ($photo4) {
            $filenameWithExt4 = $photo4->getClientOriginalName();
            $filename4 = pathinfo($filenameWithExt4, PATHINFO_FILENAME);
            $extension4 = $photo4->getClientOriginalExtension();
            $filenameSimpan4 = $filename4 . '_' . time() . '.' . $extension4;
            $path4 = $photo4->storeAs('public/photos/supplier', $filenameSimpan4);
            $input['photo_4'] = url(Storage::url('photos/supplier/') . $filenameSimpan4);
        }

        if (isset($vendor)) {
            VendorDetail::where('vendor_id', $request->vendor_id)->update($input);
        } else {
            VendorDetail::create($input);
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

        // return Carbon::createFrom(41356)->toDateTimeString();
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
        $province = Province::all();

        return view('pages.vendor.create', compact('vendor', 'vendorHeader', 'province'));
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
