<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product_transaction;
use App\Models\Transaction;

class SalesController extends Controller
{
    public function create(){
        $transactions = Transaction::all();
        return view('sales.sales',compact(['transactions']));
    }

    public function index(){}

    public function show($id){
        $transaction = Transaction::with('product')->find($id);
        return response()->json($transaction);
    }

    public function edit($id){}

    public function update($id){}

    public function destroy($id){}
}
