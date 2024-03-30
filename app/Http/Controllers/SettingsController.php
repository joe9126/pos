<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Discount;
use App\Models\User;

class SettingsController extends Controller
{
    public function index(){}

    public function create(){
        $store_info = Settings::all();
        $users = User::all();
        $discounts  = Discount::orderBy('created_at','desc')->get();
        return view('settings.settings', compact(['discounts','store_info','users']));
    }

    public function show($id){}

    public function store(Request $request){
        //$settings = 
    }

    public function update(Request $request){
        $settings = $request->all();
       
        $model = Settings::findOrFail(1);
      
         // Filter the request data to remove any null values
        $filteredData = array_filter($settings);
        $status  = $model->update($filteredData);
        if(!$status){
            return response()->json(['status'=>'error','message'=>'Settings not updated.'],500);
        }
        return response()->json(['status'=>'success','message'=>'Settings updated.'],200);
    }

    //Update or Create new discount

    public function update_discount(Request $request){
        $disc_data = $request->all();
        $disc_code = $disc_data['code'];
      
        $status = Discount::updateOrCreate(
            ['code'=> $disc_code],
            [
                'title'=>$disc_data['title'],
                'rate'=>$disc_data['rate'],
                'status'=>$disc_data['status']
            ]
        );
        

       $message ="Discount saved successfully"; $status_code =200; $status = "success";
       
        if(!$status){
            $message = "An error occured. Changes not saved.";
            $status_code = 500;
            $status = "error";
        }
        return response()->json(['status'=>$status,'message'=>$message],$status_code);
    }

    //Delete a discount
    public function delete($code){
       
        $status = Discount::where('code',$code)->delete();
        if(!$status){
            return response()->json(['status'=>'error','message'=>'Discount not deleted.'],500);
        }
        return response()->json(['status'=>'success','message'=>'Discount deleted.'],200);
    }

    //update store details
    public function store_update(Request $request){
        if($request->hasFile('logo')){
            $file = $request->file('logo');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('/public_uploads'),$filename);
            Settings::update(['logo'=>$filename]);
        }
        $status = Settings::updateOrCreate(
            ['id'=>1],
            [
                'store_name'=>$request['store_name'],
                'slogan'=>$request['slogan'],
                'address'=>$request['address'],
                'telephone'=>$request['telephone'],
                'email'=>$request['email'],
            ]
        );
        if(!$status){
            return response()->json(['status'=>'error','message'=>'Outlet details not updated'],500);
        }
     
        return response()->json(['status'=>'success','message'=>'Outlet details updated.'],200);
    }
}
