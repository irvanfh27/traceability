<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Resources\MapResource;
use App\Stockpile;
use App\Vendor;
use App\VendorDetail;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();
Route::prefix('home')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('stockpile', StockpileController::class);
    Route::resource('vendor', VendorController::class);
    Route::resource('followUp', FollowUPDocumentController::class);
    Route::get('report-supplier', 'ReportController@index')->name('report.supplier');
    Route::get('report-stockpile', 'ReportController@reportStockpile')->name('report.stockpile');
    Route::get('report-document', 'ReportController@reportDocument')->name('report.document');
    Route::get('report-supplier-group', 'ReportController@reportGroupSupplier')->name('report.supplier.group');

    Route::get('report-document/detail', 'ReportController@detailReportDocument')->name('report.document.detail');
    Route::post('vendor/{vendorId}/document', 'ReportController@importDocument')->name('document.import');

    Route::get('vendor/{vendorId}/followUp', [App\Http\Controllers\FollowUPDocumentController::class, 'create'])->name('followUp.supplier');

    Route::get('vendor/{vendorId}/document/{categoryId}', [App\Http\Controllers\DocumentController::class, 'create'])->name('document.supplier');
    Route::post('vendor/{vendorId}/documentStatus', 'DocumentController@updateStatusDocument')->name('document.status');

    Route::get('stockpile/{stockpileId}/document/{categoryId}', [App\Http\Controllers\DocumentController::class, 'createDocumentStockpile'])->name('document.stockpile');

    Route::resource('document', DocumentController::class);
    Route::resource('category', CategoryDocumentController::class);

    Route::get('/export/DocumentHasFile', function () {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\DocumentHasFileReport(request()->stockpileId), 'Report-Document-Terlampir.xlsx');
    })->name('export.documentHasFile');
    Route::get('mapbox/{stockpileId}', function ($stockpileId) {
        //Get Stockpile Lat & Loing
        $stockpile = Stockpile::findOrFail($stockpileId);
        $stockpileLat = $stockpile->latitude;
        $stockpileLong = $stockpile->longitude;
        if(!isset($stockpileLat)|| !isset($stockpileLong) || $stockpileLat == "" || $stockpileLong == ""){
            return [
                'success' => false,
                'message' => 'stockpile coordinate not valid'
            ];
        }
        //Get Vendor Data
        $vendors = Vendor::whereHas('contract', function ($q) use ($stockpileId) {
            $q->whereHas('stockpileContract', function ($qq) use ($stockpileId) {
                $qq->where('stockpile_id', $stockpileId);
            });
        })->whereHas('detail', function ($q) {
            $q->whereNotNull('latitude')->whereNotNull('longitude');
        })->get();

        $num = 1;
        $number = [];
        $coordinate =[];
        $vendorId = [];
        foreach ($vendors as $key => $val) {
            $number[] = $num++;
            $vendorId[] = $val->vendor_id;
            $coordinate[]= $val->detail->longitude."|".$val->detail->latitude;
        }

        //Reformat Numbering For API Request
        $newNumber =  json_encode($number);
        $replaceNumber = str_replace(",",";",$newNumber);
        $replaceNumber = str_replace("[","",$replaceNumber);
        $replaceNumber = str_replace("]","",$replaceNumber);

        //Reformat Coordinate For API Request
        $newCoordinate = json_encode($coordinate);
        $replaceCoordinate = str_replace("[","",$newCoordinate);
        $replaceCoordinate = str_replace("]","",$replaceCoordinate);
        $replaceCoordinate = str_replace('"',"",$replaceCoordinate);
        $replaceCoordinate = str_replace(',',";",$replaceCoordinate);
        $replaceCoordinate = str_replace('|',",",$replaceCoordinate);

        //Get Data FROM API
        $client = new Client(); //GuzzleHttp\Client
        $apiKey = "pk.eyJ1Ijoic29pbG5vaXN0dXJlIiwiYSI6ImNqdzIyeDUycDA4MWY0OHBtcDMydzVqOGsifQ.sa7RFCSwXU0JZjkaWHgd-w";
        $url = "https://api.mapbox.com/directions-matrix/v1/mapbox/driving/".$stockpileLong.",".$stockpileLat.";".$replaceCoordinate."?sources=0&annotations=distance&access_token=".$apiKey;

        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);

        //Reformat Response Data FROM API
        $responseBody = json_decode($response->getBody());
        $distances = $responseBody->distances[0];
        unset($distances[0]);
        $newDistances = array_values($distances);

        //Update Data Distance
        $status = false;
        foreach ($newDistances as $key => $row) {
          $vd = VendorDetail::where('vendor_id', $vendorId[$key])->update([
            'distance' => $row
          ]);

          if($vd){
            $status = true;
            $message = "succes to update distance";
          }else{
            $message = "failed to update distance";
          }

        }
        return [
            'success' => $status,
            'message' => $message
        ];
    });
});

