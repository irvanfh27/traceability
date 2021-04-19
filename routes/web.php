<?php

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
    Route::resource('report', ReportController::class);

    Route::get('vendor/{vendorId}/followUp', [App\Http\Controllers\FollowUPDocumentController::class, 'create'])->name('followUp.supplier');

    Route::get('vendor/{vendorId}/document/{categoryId}', [App\Http\Controllers\DocumentController::class, 'create'])->name('document.supplier');

    Route::get('stockpile/{stockpileId}/document/{categoryId}', [App\Http\Controllers\DocumentController::class, 'createDocumentStockpile'])->name('document.stockpile');

    Route::resource('document', DocumentController::class);
    Route::resource('category', CategoryDocumentController::class);

});

