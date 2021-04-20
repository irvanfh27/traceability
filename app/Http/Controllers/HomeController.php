<?php

namespace App\Http\Controllers;

use App\Districts;
use App\Stockpile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stockpile = [
            "id" => "places",
            "type" => "symbol",
            "source" => [
                "type" => "geojson",
                "data" => [
                    "type" => "FeatureCollection",
                    "features" => \App\Http\Resources\StockpileMapsResource::collection(Stockpile::all())
                ]
            ],
            "layout" => [
                "icon-image" => "cat",
                "icon-size" => 0.25,
                'text-field' => ['get', 'title'],
                'text-offset' => [0, 1.25],

            ]
        ];

        $stockpileJson = collect($stockpile)->toJson();

        // return $stockpileJson;

        return view('home', compact('stockpileJson'));
    }

    public function districts(Request $request)
    {
        $districts = Districts::select('id','nama as text')->where('provinsi_id', $request->provinceId)->get();

        return response()->json($districts);
    }


}
