<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tax;
use App\Models\Transaction;
use App\Models\Product_transaction;

class POSController extends Controller
{
    
    public function index(Category $category){
       $products = Product::where('rating','>=',3)->limit(10)->get();
       $categories = Category::all();
       $taxgroups = Tax::where('status',1)->get();
        return view('pos.pos',compact(['products','categories','taxgroups']));
    }

    public function create(Request $request){
       
    }

    /**
     * Store a new transaction
     */
    public function store(Request $request){
       $prod_transact = $request->get('sale_data');
       $transaction_data  = $request->get('transaction');

       $transaction_data['soldby'] = Auth::user()->id;

        $transaction = Transaction::create($transaction_data);
        $transactionID = $transaction->id;

        foreach($prod_transact as $productData){
            $productData['transaction_id'] = $transactionID;
            $soldQty = $productData['units'];
            $status  = Product_transaction::create($productData);

            //fetch product from inventory
            $product = Product::find($productData['product_id']);

            //subtract sold quantity from product stock
            $newQty = $product->quantity - $soldQty;

            //update product quantity
            $product->quantity = $newQty;
            $product->save();

            if(!$status){
                return response()->json(['status'=>'error','message'=>'Failed to save transaction!'],500);
            }
        }
       return response()->json(['status'=>'success','message'=>'Transaction Completed Successfully'],200);
      
    }

/**
 * show a single item by id
 */
    public function show($id){
       $itemdata = Product::find($id);
       return response()->json($itemdata);
    }

    public function edit(Request $request){
       
    }

    public function update(Request $request){
       
    }

    public function destroy(Request $request){
       
    }

    /**
     * Search by phrase
     */

     public function search($keyword){
       $data = Product::where('id','like','%'.$keyword.'%')
                ->orWhere('title','like','%'.$keyword.'%')
                ->orWhere('sku','like','%'.$keyword.'%')
                ->with('category') 
                ->get();

        if($keyword ==null||$keyword==''){
            $data = Product::all()->with('category')->get();
        }
        return response()->json($data);
     }
}
