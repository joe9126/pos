@extends('layouts.app')
@section('title')
    - Products
@endsection
@section('content')
    <!-- Tab links -->
    <div class="tab">
        <button class="tablinks products active">Manage Products</button>
        <button class="tablinks low_stock">Low Stock Products</button>
        <button class="tablinks restock_request">Restock Requests</button>
        <button class="tablinks product_settings">Settings</button>
    </div>

    <!--Manage products Tab Content  -->
    <div  id="products" class="tabcontent mt-3" style="display: block;">
        <div class="d-flex flex-row flex-wrap " id="product_list">
            <div class="" id="products_list">
                <div class="d-flex flex-row flex-wrap align-items-start justify-content-start prod_itemslist">
                    @foreach ($products as $product)
                        <a href="pos/{{ $product->sku }}" class="prod_item_link" id="{{ $product->sku }}">
                            <div class="item-tile p-2 m-1">
                                <div class="d-flex flex-column align-items-end edit-prod">
                                    <span class="text-danger text-right"><i class="fa-solid fa-pencil"></i></span>
                                </div>
                               
                                <div class="d-flex align-items-center justify-content-center">
                                    @if ($product->image == null || $product->image == '')
                                        <img id="prod_image" src="public_uploads/box.png" alt="Image">
                                    @else
                                        <img id="prod_image" src="public_uploads/{{ $product->image }}"
                                            alt="Image">
                                    @endif

                                </div>

                                <h5 class="item_title">{{ $product->title }}</h5>
                                <h6>{{ $product->quantity }} units left</h6>
                                <span class="item_cat">{{ $product->category->title }}</span>
                                <h5 class="item-txt fw-bold"> KES. {{ $product->unit_price }}</h5>
                                <div class="d-flex justify-content-center">
                                    <span class="stars" data-rating="{{ $product->rating }}"
                                        data-num-stars="5"></span>
                                </div>

                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

   
   
    <!-- Low Stock Tab content -->
    <div id="low_stock" class="tabcontent" style="display:none;">
        <div class="row">
            <div class="col-md-8 ">
                <div class="d-flex flex-column">
                    <div class="card p-4">
                        <h4>Add Stock</h4>
                        <hr>
                        <div class="alert alert-danger alert-block statusmsg w-75 ml-4" style="display: none;"
                            id="alert">
                            <strong> <span id="msg2" style="font-size:0.8rem"></span></strong>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <div class="form-floating">
                                <input type="search" class="form-control" name="search_item" id="search_item"
                                    placeholder="Search product by SKU " autocomplete="off">
                                <label for="search_item">Search product by SKU </label>
                            </div>
                        </div>
                        <form action="#" data-parsley-validate="" id="addstockform">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 ">
                                    <label for="stock_sku" class="mt-2 w-50">Product SKU <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="stock_sku" id="stock_sku" class="form-control w-70"
                                        placeholder="Product SKU" readonly required
                                        data-parsley-required-message="Search product to set SKU"></input>
                                </div>
                                <div class="col-md-6">
                                    <label for="stock_title" class="mt-2 w-50">Product Title</label>
                                    <input type="text" name="stock_title" id="stock_title" class="form-control w-70"
                                        placeholder="Title" readonly></input>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="stock_unitcost" class="mt-2 w-50">Unit Cost <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="stock_unitcost" min="1" id="stock_unitcost"
                                        class="form-control w-100" placeholder="0.00" required
                                        data-parsley-required-message="Unit cost is required"></input>

                                </div>
                                <div class="col-md-6">
                                    <label for="stock_quantity" class="mt-2 w-50">Quantity <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="stock_quantity" min="1" id="stock_quantity"
                                        class="form-control w-100" placeholder="0" required
                                        data-parsley-required-message="Quantity is required"></input>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="stock_supplier" class="mt-2 w-50">Supplier <span
                                            class="text-danger">*</span></label>
                                    <select name="stock_supplier" id="stock_supplier" class="form-select" required
                                        data-parsley-required-message="Supplier is required">
                                        <option value="">Select Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="stock_supply_term" class="mt-2 w-50">Supply Term <span
                                            class="text-danger">*</span></label>
                                    <select name="stock_supply_term" id="stock_supply_term" class="form-select" required
                                        data-parsley-required-message="Supply term is required">
                                        <option value="">Select Supply Term</option>
                                        <option value="30">30 Days Credit</option>
                                        <option value="60">60 Days Credit</option>
                                        <option value="Cash">Cash</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex flex-row justify-content-between mt-2">
                                    <label for="stock_comments" class="mt-2 mr-4"
                                        style="margin-right:26px">Comments</label>
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
    </div>

    <!--  Restock Request  Tab content -->
    <div id="restock_request"></div>
@endsection
