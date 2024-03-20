<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tax;
use App\Models\Supplier;
use App\Models\Settings;
use App\Models\Supplier_product;
use App\Models\Restockrequest;
use App\Models\Product_restockrequest;
use Carbon\Carbon;
use Mail;

class ProductController extends Controller
{
    public function index(){
        $products = Product::latest('created_at')->take(13)->get();
        $categories  = Category::all();
        $taxgroups = Tax::all();
        $suppliers = Supplier::all();
        
        return view('products.products',compact(['categories','taxgroups','suppliers','products']));
    }

    public function show($sku){

    
    }

    public function create(){
       
       
    }

    /**store or update product */
    public function store(Request $request){
        $prod_data = $request->all();
        $status = 0;  $filename ="box.png";

        if($request->hasFile('image')){
            $product = Product::where('sku',$prod_data['sku'])->get();
            $file = $request->file('image');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('/public_uploads'),$filename);
            if($product){
                Product::where('sku',$prod_data['sku'])
                        ->update(['image'=>$filename]);
            }           
        }
        
            $status = Product::updateOrCreate(
                ['sku'=>$prod_data['sku']],
                [
                    'title'=>$prod_data['title'],
                    'category_id'=>$prod_data['category'],
                    'unit_price'=>$prod_data['unitprice'],
                    //'discount'=>$prod_data['discount'],
                    'tax_id'=>$prod_data['tax_id'],
                    //'stock_notice'=>$prod_data['stock_notice'],
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
      
        $prod_data = Product::where('sku',$sku)
                    ->with('category','tax')
                    ->get();
                   // var_dump($prod_data)
        return response()->json($prod_data);
    }

    //U = UPDATE update product quantity

    public function update(Request $request){
        $data = $request->all();
       // var_dump($data['stock_quantity']);
        $product = Product::where('sku',$data['stock_sku'])->first();
       
        if($product){
             $product->increment('quantity', (int)$data['quantity']);
             $product->save(); 

            $supp_product = new Supplier_product();
            $supp_product->supplier_id =$data['supplier_id'];
            $supp_product->product_id = $product['id'];
            $supp_product->quantity = $data['quantity'];
            $supp_product->unit_cost = $data['unit_cost'];
            $supp_product->supply_term = $data['supply_term'];
            $supp_product->comment = $data['comment'];
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

   

    /**
     * Restock request
     */
    public function restockrequest(Request $request){
        $data = json_decode($request->input('formdata'));

        $request_data['user_id'] = Auth::user()->id;
        $request_data['status'] = 0;
        $restockrequest = Restockrequest::create($request_data);
        $request_id  =  $restockrequest->id;

        $request_prod = [];
        foreach($data as $key => $request_item){
            $request_prod['restockrequest_id'] = $request_id;
            $prod_id = Product::where('sku',$request_item->sku )->value('id');
            $request_prod['product_id'] =  $prod_id;
            $request_prod['quantity'] = $request_item->quantity;
            
            $status = Product_restockrequest::create($request_prod);
         
        }

        if(!$status){
            return response()->json(['status'=>'error','message'=>'Request not sent.'],500);
        }else{
            $subject = "Reminder on ".Carbon::now()->format('jS M Y').": Restock Needed for Inventory Items";
            $recipient = "joeasewe@gmail.com";
            $status = Mail::send('mail.newemail',['data'=>$data],
            function($message) use ($recipient, $subject){
                $message->to($recipient,'')
                ->subject($subject);
                }
            );
        }
        return response()->json(['status'=>'success','message'=>'Request sent'],200);
    }
}
