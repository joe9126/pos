<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tax;
use App\Models\Supplier;
use App\Models\Settings;
use App\Models\Restockrequest;

class PartialsController extends Controller
{
    public function create($id){
        $transaction_data = Transaction::with('product','user')->find($id);
       // var_dump($transaction_data);
        return view('partials.loopContainer',compact(['transaction_data']));
       
    }

    //search product in product management

    public function prod_man_search($keyword){
        $products = Product::search($keyword)->get();
        return view('partials.productlist',compact(['products']));
    }

    //Sales search by transaction id
    public function sales_history_search($id){
        $transaction_search = Transaction::find($id);
        return view('partials.salessearch',compact(['transaction_search']));
    }


     /**
     * POS Search product by phrase
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
            $store_info = Settings::all();
           // var_dump($store_info);
           return view('partials.receipt',compact(['transaction_data','store_info']));
       }

// show new product form
       public function new_product(){
        $categories  = Category::all();
        $taxes = Tax::all();
        $suppliers = Supplier::all();
        return view('partials.newproduct',compact(['suppliers','categories','taxes']));
       }


// show product for editing
       public function show($sku){
        $prod_data = Product::where('sku',$sku)
        ->with('category','tax')
        ->get();
        //var_dump($prod_data);
        $categories  = Category::all();
        $taxgroups = Tax::all();
        $suppliers = Supplier::all();
        return view('partials.editproduct',compact(['prod_data','taxgroups','suppliers','categories']));
       }

// show products to update qty
    public function show_update($sku){
        $prod_data = Product::where('sku',$sku)
        ->with('category','tax')
        ->get();
        $suppliers = Supplier::all();
        return view('partials.addstock', compact(['prod_data','suppliers']));
    }


    //get low stock products
    public function low_stock_prods(){
        $stock_limit = Settings::pluck('low_stock_level');
        $low_stock = Product::where('quantity','<=',  $stock_limit)
        ->with('category','tax')
        ->get();

        return view('partials.low_stock', compact(['low_stock']));
    }


    //get restock requests

    public function restock_requests(){
        $restock_reqs = Restockrequest::orderBy('created_at','desc')->with('user')->get();
        return view('partials.restockrequests',compact(['restock_reqs']));
    }

    //get restock request items
    public function restock_requests_items($id){
        $restock_req_items = Restockrequest::where('id',$id)->with('product')->get();
        //var_dump($restock_req_items);
        return view('partials.restockrequestitems', compact(['restock_req_items']));
    }

}
