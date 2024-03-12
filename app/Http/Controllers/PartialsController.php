<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;

class PartialsController extends Controller
{
    public function create($id){
        $transaction_data = Transaction::with('product','user')->find($id);
       // var_dump($transaction_data);
        return view('partials.loopContainer',compact(['transaction_data']));
       
    }



     /**
     * Search by phrase
     */

     public function posproductsearch($keyword){
        if($keyword =="All"){
            $prod_search_result = Product::all(); //->with('category')->get(); 
        } else{
             // Search products by title, SKU, or category
        $prod_search_result = Product::search($keyword)->get();
        }
       
         return view('partials.posproductsview',compact(['prod_search_result']));
       
      }

      /**
       * Load POS receipt
       */

       public function load_receipt($transaction_id){
            $transaction_data = Transaction::with('product','user')->find($transaction_id);
            return view('partials.receipt',compact(['transaction_data']));
       }
}
