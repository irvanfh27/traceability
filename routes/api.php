<?php

use App\Http\Controllers\VendorController;
use App\Stockpile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.')->group(function (){
    Route::get('supplier/{stockpileId}','VendorController@supplierByStockpile')->name('supplierByStockpile');

    Route::get('stockpile', function () {
        return [
            'aaData' => Stockpile::all()
        ];
    })->name('stockpile');

    Route::get('supplierMaps/{stockpileId}', 'VendorController@apiMaps')->name('supplierMaps');
    Route::get('stockpileMaps', 'StockpileController@apiMaps')->name('stockpileMaps');
    Route::post('districts', 'HomeController@districts')->name('districts');

    // Route::get('stockpile/{id}', function ($id) {
    //     return Stockpile::where('stockpile_id',$id)->first();
    // });

});
