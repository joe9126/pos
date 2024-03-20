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
    </div><hr>

    <!--Manage products Tab Content  -->
    <div id="products" class="tabcontent mt-3" style="display: block;">
        <div class="row w-50 mb-3">
            <div class="col-md-8">
                <div class="input-group mb-2 ">
                    <span class="input-group-text text-secondary">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="search" name="search_item" id="search_item" class="form-control" autocomplete="off"
                        placeholder="Search by sku or title">
                </div>
            </div>
            <div class="col-md-4">
                <button id="newitembtn" class="btn btn-primary ">New Product <i class="fa-regular fa-square-plus"></i></button>
            </div>
        </div>

        <div class="d-flex flex-row flex-wrap " id="product_list">
            <div class="" id="products_list">
                <div class="d-flex flex-row flex-wrap align-items-start justify-content-start prod_itemslist">
                    @foreach ($products as $product)
                        <a href="pos/{{ $product->sku }}" class="prod_item_link">
                            <div class="item-tile p-2 m-1">
                                <div class="d-flex flex-row align-items-end justify-content-center edit-prod">
                                    @if ($product->status ==1)
                                    <button class="text-success text-right edit-pen">
                                        <i class="fa-solid fa-unlock text-success"></i>
                                    </button>
                                   
                                    @else
                                    <button class="text-danger text-right edit-pen">
                                        <i class="fa-solid fa-lock text-danger"></i>
                                    </button>
                                   
                                    @endif
                                    <button class="text-primary text-right edit-pen">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                    <button class="text-primary text-right cart-pen">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </button>
                                </div>

                                <div class="d-flex align-items-center justify-content-center">
                                    @if ($product->image == null || $product->image == '')
                                        <img id="prod_image" src="public_uploads/box.png" alt="Image">
                                    @else
                                        <img id="prod_image" src="public_uploads/{{ $product->image }}" alt="Image">
                                    @endif

                                </div>

                                <h6 class="item_title">SKU #{{ $product->sku }}</h6>
                                <h6 class="item_title"> {{ $product->title }}</h6>
                                <h6 class="item_title">{{ $product->quantity }} units left</h6>
                                <span class="item_cat">{{ $product->category->title }}</span>
                                <h5 class="item-txt fw-bold"> {{$currency}}{{ number_format($product->unit_price, 2) }}</h5>
                                <div class="d-flex justify-content-center">
                                    <span class="stars" data-rating="{{ $product->rating }}" data-num-stars="5"></span>
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
        <div class="col-md-8 vh-100" style="border-right:1px solid #ccc;">
            <div class="d-flex flex-row flex-wrap mt-3" id="low_stock_list">
               <!-- data loaded dynamically in tabscript.js -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex flex-column align-items-center justify-content-center">
           
            <h4 class="mt-3">Request Restock</h4>
            <table class="table" id="low_stock_table">
                <tbody></tbody>
            </table>
            <div class="d-flex flex-row m-2 p-2  justify-content-center">
                <button class="btn btn-primary btn-block" id="send_requestbtn">
                    Request <i class="fa-solid fa-envelope"></i>
                </button>
                <button class="btn btn-secondary btn-block" id="print_requestbtn">
                    Print <i class="fa-solid fa-print"></i>
                </button>
            </div>
           
        </div>
        </div>
       </div>
    </div>

    <!--  Restock Request  Tab content -->
    <div id="restock_request" class="tabcontent" style="display:none">
        <div class="row  mb-3">
            <div class="col-md-5" style="border-right:1px solid #ccc; height: 80vh">
                <div class="input-group mb-2 ">
                    <span class="input-group-text text-secondary">
                        <i class="fa fa-search"></i>
                    </span>
                    <input type="search" name="search_request" id="search_request" class="form-control" autocomplete="off"
                        placeholder="Search by sku or title">
                </div>
                <div id="requests_list">
                    <table id="requests_table" class="table table-striped">
                      
                        <tbody id="requests_table_tbody"></tbody>
                    </table>
                </div>

            </div>
            <div class="col-md-6">
                <div id="requested_items"></div>
            </div>
        </div>
   
    </div>

    <!-- Product Settings -->
    <div id="product_settings" class="tabcontent" style="display: none;">
        <div class="row ">
            <div class="col-md-4">
                <div class="d-flex flex-column align-items-center justify-content-center mt-3 p-3">
                    <form action="#" id="product_settings_form" method="POST">
                        @csrf
                        <div class="input-group mb-2 w-100">
                            <span class="input-group-text text-secondary">Low stock limit<span class="text-danger"> *</span></span>
                            <input type="number" min="1" name="stock_level" id="stock_level" class="form-control"
                                placeholder="Low stock limit *">
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn btn-primary btn-block w-50" id="stock_limit_btn" disabled>
                                Save <i class="fa-solid fa-floppy-disk"></i>
                            </button>
                        </div>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
