<?php

namespace App\Http\Controllers;

use App\CategoryDocument;
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
    public function index()
    {
        $stock = Stockpile::all();
        return view('pages.stockpile.index', compact('stock'));
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
        $photo1 = $request->file('photo1');
        $photo2 = $request->file('photo2');
        $photo3 = $request->file('photo3');
        $photo4 = $request->file('photo4');
        $input = $request->all();

        if ($photo1) {
            $filenameWithExt1 = $photo1->getClientOriginalName();
            $filename1 = pathinfo($filenameWithExt1, PATHINFO_FILENAME);
            $extension1 = $photo1->getClientOriginalExtension();
            $filenameSimpan1 = $filename1 . '_' . time() . '.' . $extension1;
            $path1 = $photo1->storeAs('public/photos/stockpile', $filenameSimpan1);
            $input['photo_1'] = url(Storage::url('photos/stockpile/').$filenameSimpan1);
        }

        if ($photo2) {
            $filenameWithExt2 = $photo2->getClientOriginalName();
            $filename2 = pathinfo($filenameWithExt2, PATHINFO_FILENAME);
            $extension2 = $photo2->getClientOriginalExtension();
            $filenameSimpan2 = $filename2 . '_' . time() . '.' . $extension2;
            $path2 = $photo2->storeAs('public/photos/stockpile', $filenameSimpan2);
            $input['photo_2'] = url(Storage::url('photos/stockpile/').$filenameSimpan2);
        }

        if ($photo3) {
            $filenameWithExt3 = $photo3->getClientOriginalName();
            $filename3 = pathinfo($filenameWithExt3, PATHINFO_FILENAME);
            $extension3 = $photo3->getClientOriginalExtension();
            $filenameSimpan3 = $filename3 . '_' . time() . '.' . $extension3;
            $path3 = $photo3->storeAs('public/photos/stockpile', $filenameSimpan3);
            $input['photo_3'] = url(Storage::url('photos/stockpile/').$filenameSimpan3);
        }

        if ($photo4) {
            $filenameWithExt4 = $photo4->getClientOriginalName();
            $filename4 = pathinfo($filenameWithExt4, PATHINFO_FILENAME);
            $extension4 = $photo4->getClientOriginalExtension();
            $filenameSimpan4 = $filename4 . '_' . time() . '.' . $extension4;
            $path4 = $photo4->storeAs('public/photos/stockpile', $filenameSimpan4);
            $input['photo_4'] = url(Storage::url('photos/stockpile/').$filenameSimpan4);
        }

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

