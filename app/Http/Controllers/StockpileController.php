<?php

namespace App\Http\Controllers;

use App\CategoryDocument;
use App\Http\Resources\StockpileResource;
use App\Stockpile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function GuzzleHttp\Promise\all;

class StockpileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return [
                'aaData' => StockpileResource::collection(Stockpile::all())
            ];
        }
        return view('pages.stockpile.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stockpile = Stockpile::findOrFail($id);
        $category = CategoryDocument::where('category_for', 2)->get();

        return view('pages.stockpile.show', compact('stockpile', 'category'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stockpile = Stockpile::findOrFail($id);

        return view('pages.stockpile.forms', compact('stockpile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $stockpile = Stockpile::findOrFail($id);

        $input = $request->all();


        $input['updated_by'] = auth()->user()->id;

        $stockpile->update($input);

        return redirect()->route('stockpile.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function apiMaps()
    {
        return [
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
    }
}

