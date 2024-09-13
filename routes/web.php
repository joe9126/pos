<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PartialsController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CashierController;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function(){
    Route::get('pos',[POSController::class,'index'])->name('pos');
    Route::get('pos/{id}',[POSController::class,'show'])->name('pos.show');
    Route::post('pos/transact',[POSController::class,'store'])->name('pos.store');
    Route::get('pos/search/{phrase}',[PartialsController::class,'posproductsearch'])->name('pos.search');

    Route::get('products',[ProductController::class,'index'])->name('products');
    Route::get('products/new',[PartialsController::class,'new_product'])->name('products.new');
    Route::get('products/show/{sku}',[PartialsController::class,'show'])->name('products.show');
    Route::get('products/show_update/{sku}',[PartialsController::class,'show_update'])->name('products.show_update');
    Route::post('products/store',[ProductController::class,'store'])->name('products.store');
    Route::get('products/edit/{sku}',[ProductController::class,'edit'])->name('products.edit');
    Route::get('products/search/{sku}',[PartialsController::class,'prod_man_search'])->name('products.prod_man_search');
    Route::post('products/update',[ProductController::class,'update'])->name('products.update');
    Route::get('products/low_stock',[PartialsController::class,'low_stock_prods'])->name('products.low_stock');
    Route::post('products/request',[ProductController::class,'restockrequest'])->name('products.restock');
    Route::get('products/restock_requests',[PartialsController::class,'restock_requests'])->name('products.restock_requests');
    Route::get('products/request/{id}',[PartialsController::class,'restock_requests_items'])->name('products.restock_requests_items');


    Route::get('suppliers',[SupplierController::class,'create'])->name('suppliers.create');

    Route::get('sales',[SalesController::class,'create'])->name('sales.create');
    Route::get('sales/transaction/{id}',[PartialsController::class,'create'])->name('sales.transaction');
    Route::post('sales/finalize/{id}',[SalesController::class,'update'])->name('sales.update');
    Route::post('sales/delete/{id}',[SalesController::class,'destroy'])->name('sales.delete');
    Route::get('sales/search/{id}',[PartialsController::class,'sales_history_search'])->name('sales.show');
    Route::get('sales/receipt/{id}',[PartialsController::class,'load_receipt'])->name('sales.receipt');
    
    Route::get('cashier',[CashierController::class,'create'])->name('cashier.create');
    Route::get('cashier/sales',[PartialsController::class,'cashiersales'])->name('cashier.sales');
    Route::get('cashier/today_sales_data',[CashierController::class,'todaycashiersalesdata'])->name('cashier.todaysalesdata');
    Route::get('/today_trans',[CashierController::class,'index'])->name('cashier.today_trans');
    Route::get('cashier/test',[PartialsController::class,'test'])->name('cashier.test');
    Route::get('cashier/history',[CashierController::class,'saleshistory'])->name('cashier.history');
    Route::get('cashier/history_data',[CashierController::class,'cashierhistorydata'])->name('cashier.historydata');
   Route::post('/close_drawer',[CashierController::class,'close_drawer'])->name('cashier.close_drawer');

   Route::get('cashier/drawerhistory_data',[CashierController::class,'drawerhistorydata'])->name('cashier.drawerhistorydata');
   
   Route::get('settings',[SettingsController::class,'create'])->name('settings.create');
   Route::post('setting/update',[SettingsController::class,'update'])->name('settings.update');
   Route::post('settings/store_update',[SettingsController::class,'store_update'])->name('settings.store_update');
   Route::post('setting/disc_delete/{code}',[SettingsController::class,'delete'])->name('settings.delete');
   Route::post('settings/update_discount',[SettingsController::class,'update_discount'])->name('settings.update_discount');
   Route::get('settings/users',[SettingsController::class,'users'])->name('settings.users');
   Route::post('settings/new_user',[SettingsController::class,'new_user'])->name('settings.new_user');
   Route::post('settings/update_pword',[SettingsController::class,'update_password'])->name('settings.update_pword');
   
   
});
