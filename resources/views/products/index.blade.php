@extends('layouts.app')
@section('title')  - Products @endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <div class="card pl-3 pr-4">
                <h4>Product</h4><hr>

                <div class="alert alert-danger alert-block statusmsg w-75 ml-4" style="display: none;" id="statusalert" >
                    <strong> <span id="msg" style="font-size:0.8rem"></span></strong>
               </div>

                <form action="#" id="product_form" data-parsley-validate="">
                    @csrf
                    <div class="d-flex flex-column justify-content-center ">
                        <div class="row " style="margin-left:4px !important">
                            <div class="col-md-3 ml-4" id="productimage"></div>

                            <div class="col-md-9">
                                <input type="text" name="sku" id="sku" class="form-control" placeholder="Product SKU *" required="" data-parsley-required-message="SKU is required. It's product ID" autocomplete="off">
                                
                                <input type="file" name="image" id="image" class="form-control mt-3">
                            </div>
                            
                        </div>
                       
                        <input type="text" name="title" id="title" class="form-control mt-3" placeholder="Product title *" required=""  data-parsley-required-message="Product title is required.">
                        <select name="category" id="category" class="form-select mt-3" required data-parsley-required-message="Category is required.">
                            <option value="">Select Category *</option>
                            @foreach ($categories as $category )
                                <option value="{{$category->id}}">{{$category->title}}</option>
                            @endforeach
                        </select>

                        <div class="d-flex flex-row justify-content-between">
                            <input type="number" name="unitprice" id="unitprice" class="form-control mt-3 mr-3 w-50" style="margin-right:3px !important" min="0" placeholder="Unit Price *" required=""  data-parsley-required-message="Unit price is required." data-parsley-trigger="change">
                            <input type="number" name="discount" id="discount" class="form-control mt-3 mr-3 w-50" style="margin-left:3px !important" min="0" placeholder="Discount rate" data-parsley-trigger="change">
                        
                        </div>
                        
                        <div class="d-flex flex-row justify-content-between ">
                          <select name="status" id="status" class="form-select mt-3 pr-3 w-50" style="margin-right:6px;">
                            <option value="1">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Locked</option>
                          </select>
                          <select name="tax_id" id="tax_id" class="form-select mt-3 ml-3 w-50" required  data-parsley-required-message="Tax group is required.">
                            <option value="">Select Tax Group *</option>
                            @foreach ($taxgroups as $tax )
                             <option value="{{$tax->id}}">{{$tax->title}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                          <input type="number" name="stock_notice" id="stock_notice" class="form-control mt-3 w-50" min="1" placeholder="Low stock level *" required=""  data-parsley-required-message="Low stock level is required." data-parsley-trigger="change">
                                <select name="rating" id="rating" class="form-select mt-3 w-50" style="margin-left:6px">
                                    <option value="0">Select Rating</option>
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Star</option>
                                    <option value="3">3 Star</option>
                                    <option value="4">4 Star</option>
                                    <option value="5">5 Star</option>
                                </select>
                        </div>

                    </div>
                    <div class="d-flex flex-row justify-content-between mt-3">
                        <input type="submit" value="Save" class="btn btn-primary btn-block w-50 m-2">
                        <input type="button" value="Delete" class="btn btn-danger btn-block w-50 m-2">
                    </div>
                    
                </form>
            </div>

        </div>
        <div class="col-md-7 d-flex flex-column">
            <div class="card">
                <h4>Add Stock</h4><hr>
                <div class="alert alert-danger alert-block statusmsg w-75 ml-4" style="display: none;" id="alert" >
                    <strong> <span id="msg2" style="font-size:0.8rem"></span></strong>
               </div>
                <input type="search" class="form-control" name="search_item" id="search_item" placeholder="Search product by SKU " autocomplete="off">
            
                    <form action="#" data-parsley-validate="" id="addstockform">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 ">
                            <label for="stock_sku" class="mt-2 w-50">Product SKU <span class="text-danger">*</span></label>
                            <input type="text" name="stock_sku" id="stock_sku" class="form-control w-70" placeholder="Product SKU" readonly required  data-parsley-required-message="Search product to set SKU"></input>
                        </div>
                        <div class="col-md-6">
                            <label for="stock_title" class="mt-2 w-50">Product Title</label>
                            <input type="text" name="stock_title" id="stock_title" class="form-control w-70" placeholder="Title" readonly></input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="stock_unitcost" class="mt-2 w-50">Unit Cost <span class="text-danger">*</span></label>
                            <input type="number" name="stock_unitcost" min="1" id="stock_unitcost" class="form-control w-100" placeholder="0.00" required  data-parsley-required-message="Unit cost is required"></input>
                            
                        </div>
                        <div class="col-md-6">
                            <label for="stock_quantity" class="mt-2 w-50">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="stock_quantity" min="1" id="stock_quantity" class="form-control w-100" placeholder="0" required  data-parsley-required-message="Quantity is required"></input>
                                                       
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="stock_supplier" class="mt-2 w-50">Supplier <span class="text-danger">*</span></label>
                             <select name="stock_supplier" id="stock_supplier" class="form-select" required  data-parsley-required-message="Supplier is required">
                               <option value="">Select Supplier</option>
                               @foreach ($suppliers as $supplier )
                               <option value="{{$supplier->id}}">{{$supplier->title}}</option>
                               @endforeach
                             </select>
                        </div>
                        <div class="col-md-6">
                            <label for="stock_supply_term" class="mt-2 w-50">Supply Term <span class="text-danger">*</span></label>
                             <select name="stock_supply_term" id="stock_supply_term" class="form-select" required  data-parsley-required-message="Supply term is required">
                               <option value="">Select Supply Term</option>
                               <option value="30">30 Days Credit</option>
                               <option value="60">60 Days Credit</option>
                               <option value="Cash">Cash</option>
                             </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex flex-row justify-content-between mt-2">
                            <label for="stock_comments" class="mt-2 mr-4" style="margin-right:26px">Comments</label>
                            <textarea name="stock_comments" id="stock_comments" cols="30" rows="3" class="form-control mt-2 w-100"></textarea>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-8 d-flex flex-row justify-content-center">
                            <input type="submit" value="Add" class="btn btn-primary btn-block w-50 m-2">
                            <input type="button" value="Cancel" class="btn btn-danger btn-block w-50 m-2">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection