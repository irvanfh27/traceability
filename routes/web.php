<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
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
    Route::get('report-document/detail', 'ReportController@detailReportDocument')->name('report.document.detail');
    Route::post('vendor/{vendorId}/document','ReportController@importDocument')->name('document.import');

    Route::get('vendor/{vendorId}/followUp', [App\Http\Controllers\FollowUPDocumentController::class, 'create'])->name('followUp.supplier');

    Route::get('vendor/{vendorId}/document/{categoryId}', [App\Http\Controllers\DocumentController::class, 'create'])->name('document.supplier');

    Route::get('stockpile/{stockpileId}/document/{categoryId}', [App\Http\Controllers\DocumentController::class, 'createDocumentStockpile'])->name('document.stockpile');

    Route::resource('document', DocumentController::class);
    Route::resource('category', CategoryDocumentController::class);
});

