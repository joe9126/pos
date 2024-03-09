<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{

    //C = CREATE display the form for supplier in view
    public function create(){
       
    }
    

     //C = CREATE store a new supplier record submitted by form
    public function store(){
        
    }

     //R = READ retrieves all suppliers 
     public function index(){
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }
    
    //R = READ search single supplier by id
    public function show($id){
        $supplier = Supplier::find($id);
        return response()->json($supplier);
    }

    // U = UPDATE fetch supplier for editing
    public function edit($id){
        
    }

     // U = UPDATE update specific supplier in the db
     public function update($id){
        
     }

     //D = DELETE delete/destroy specific supplier in db.
    public function destroy($id){
        
    }
}
