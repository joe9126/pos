<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PartialsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function(){
    Route::get('pos',[POSController::class,'index'])->name('pos');
    Route::get('pos/{id}',[POSController::class,'show'])->name('pos.show');
    Route::post('pos/transact',[POSController::class,'store'])->name('pos.store');
    Route::get('pos/search/{phrase}',[PartialsController::class,'posproductsearch'])->name('pos.search');

    Route::get('products',[ProductController::class,'index'])->name('products');
    Route::post('products/store',[ProductController::class,'store'])->name('products.store');
    Route::get('products/edit/{sku}',[ProductController::class,'edit'])->name('products.edit');
    Route::post('products/update',[ProductController::class,'update'])->name('products.update');

    Route::get('suppliers',[SupplierController::class,'create'])->name('suppliers.create');

    Route::get('sales',[SalesController::class,'create'])->name('sales.create');
    Route::get('sales/transaction/{id}',[PartialsController::class,'create'])->name('sales.transaction');
});
