<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    public function index(){}

    public function create(){}

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
}
