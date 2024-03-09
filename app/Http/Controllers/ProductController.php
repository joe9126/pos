<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tax;
use App\Models\Supplier;
use App\Models\Supplier_product;

class ProductController extends Controller
{
    public function index(){

        $categories  = Category::all();
        $taxgroups = Tax::all();
        $suppliers = Supplier::all();
        return view('products.index',compact(['categories','taxgroups','suppliers']));
    }

    public function show($id){
        
    }

    public function create(){
        
    }

    public function store(Request $request){
        $prod_data = $request->all();
        $status = 0;  $filename ="box.png";

        if($request->hasFile('image')){
            $product = Product::where('sku',$prod_data['sku'])->first();
            $file = $request->file('image');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('/public_uploads'),$filename);
            if($product){
                Product::update(['image',$filename]);
            }           
        }
        
            $status = Product::updateOrCreate(
                ['sku'=>$prod_data['sku']],
                [
                    'title'=>$prod_data['title'],
                    'category_id'=>$prod_data['category'],
                    'unit_price'=>$prod_data['unitprice'],
                    'discount'=>$prod_data['discount'],
                    'tax_id'=>$prod_data['tax_id'],
                    'stock_notice'=>$prod_data['stock_notice'],
                    'rating'=>$prod_data['rating'],
                    'status'=>$prod_data['status'],
                    ]
            );
         

        if(!$status){
        return response()->json(['status'=>'error','message'=>'Error occured, product details not saved'],500);
       }
       return response()->json(['status'=>'success','message'=>'Product details saved.'],200);
    }

    /**
     * Retrieve a product for editing
     */
    public function edit($sku){
      
        $prod_data = Product::where('sku','=',$sku)
                    ->with('category','tax')
                    ->get();
        return response()->json($prod_data);
    }

    //U = UPDATE update product quantity

    public function update(Request $request){
        $data = $request->all();
       // var_dump($data['stock_quantity']);
        $product = Product::where('sku',$data['stock_sku'])->first();
       
        if($product){
             $product->increment('quantity', (int)$data['stock_quantity']);
             $product->save(); 
            $supp_product = new Supplier_product();
            $supp_product->supplier_id = $data['stock_supplier'];
            $supp_product->product_id = $product['id'];
            $supp_product->quantity = $data['stock_quantity'];
            $supp_product->unit_cost = $data['stock_unitcost'];
            $supp_product->supply_term = $data['stock_supply_term'];
            $supp_product->comment = $data['stock_comments'];
            $supp_product->user_id = Auth::user()->id;
            $status = $supp_product->save();
            
        }
        if(!$status){
            return response()->json(['status'=>'error',"message"=>"Item not found, stock not updated."],500);
        }
            return response()->json(['status'=>'success',"message"=>"Stock updated."],200);
    }


    public function destroy($id){
        
    }
}
