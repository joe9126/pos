<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product_transaction;
use App\Models\Transaction;

class SalesController extends Controller
{
    public function create(){
        $transactions = Transaction::where('status',true)->latest('created_at')->take(10)->get();
        $held_transactions = Transaction::where('status',false)->latest('created_at')->take(10)->get();
        return view('sales.sales',compact(['transactions','held_transactions']));
    }

    public function index(){}

    public function show($id){
        $transaction = Transaction::with('product')->find($id);
        return response()->json($transaction);
    }

    public function edit($id){
        
    }

    public function update($id){
        $status = Transaction::where('id',$id)
        ->update([
            'status'=>true,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        if(!$status){
            return response()->json(['status'=>'error','message'=>'Transaction not completed.'],500);
        }
        return response()->json(['status'=>'success','message'=>'Transaction completed.'],200);
    }

    public function destroy($id){
        $transaction = Transaction::find($id);
        $status = $transaction->delete();
        $message="Pending transaction deleted."; $status="success";  $response_code =200;
        if(!$status){
            $message = "Pending transaction not deleted.";
            $status = "error";
            $response_code =500;
        }
        return response()->json(['status'=>$status,'message'=>$message],$response_code);
    }
}
