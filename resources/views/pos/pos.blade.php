@extends('layouts.app')
@section('title') Point of Sale @endsection
@section('content')
<div class="row">
    <div class="col-md-7 card">
        
        <div class="item-category mb-4">
            <h4 class="text-left">Search Item</h4><hr>
            <ul>
                <li><a href="#home" class="bg-primary text-white">All</a></li>
                @foreach ($categories as $category)
                  <li><a href="#home" class="bg-primary text-white">{{$category->title}}</a></li>
                @endforeach
               
              </ul>
        </div>
        <div class="items-list">
           
            <div class="d-flex flex-colum">
                <input type="text" class="form-control" name="searchitem" id="searchitem" placeholder="Search item" autocomplete="off">
            </div><hr>
            <div class="d-flex flex-row align-items-center justify-content-center" id="products_list">
                @foreach ($products as $product)
                <a href="pos/{{$product->id}}" class="item_link">
                    <div class="item-tile p-2 m-1">
                        <div class="d-flex align-items-center justify-content-center" >
                            <img id="prod_image" src="assets/images/box.png" alt="Image" >
                        </div>
                       
                        <h5 class="item_title">{{$product->title}}</h5>
                        <h6>{{$product->quantity}} units left</h6>
                        <span class="item_cat">{{$product->category->title}}</span>
                        <h5 class="item-txt fw-bold"> KES. {{$product->unit_price}}</h5>
                    </div>
                </a>
                @endforeach
            </div>
           
        </div>

    </div>
    <div class="col-md-5 vh-75">
        <div class="card">
            <div class="d-flex flex-row">
                <h4>POS</h4><hr>
                <div class="alert alert-danger alert-block statusmsg w-75 ml-4" style="display: none;" id="statusalert" >
                     <strong> <span id="msg" style="font-size:0.8rem"></span></strong>
                </div>
            </div>
           
            <div class="pos_list mb-2">
            <table id="pos_table" class="table table-striped">
                <thead><th>ID</th><th>Item</th><th></th><th>Units</th><th></th><th>Price</th><th></th></thead>
                <tbody id="items_tbody"></tbody>
            </table>
        </div>

            <table id="pos_cost_table" style="width:100%; border-collapse:collapse;" class="">
                <tbody>
                    <tr> 
                        <td style="width:30%; border:1px solid #c7c7c7;" class="fw-bold" colspan="2">Subtotal</td>
                        <td id="pos_subtotal" style="width:40%; border:1px solid #c7c7c7;">0.00</td></tr>
                    <tr>
                        <td style="width:30%; border:1px solid #c7c7c7;" class="text-danger fw-bold">Discount %</td>
                        <td contenteditable="true" style="width:30%; border:1px solid #c7c7c7;" class="text-danger fw-bold">0</td>
                        <td style="width:30%; border:1px solid #c7c7c7;" id="pos_discount" class="text-danger fw-bold">0.00</td>
                    </tr>
                       
                    <tr> 
                        <td style="width:30%; border:1px solid #c7c7c7;">Vat Total</td>
                        <td>
                           
                                @foreach ($taxgroups as $taxgroup )
                                   {{$taxgroup->rate}}
                                @endforeach
                           
                        </td>
                        <td style="width:30%; border:1px solid #c7c7c7;" id="tax_rate">0.00</td></tr>
                    <tr>
                         <td style="width:30%; border:1px solid #c7c7c7;" class="fw-bold"  colspan="2">Grand total</td>
                         <td id="pos_grandtotal" class="fw-bold"  style="width:30%; border:1px solid #c7c7c7;">0.00</td></tr>
                </tbody>
            </table>
            <div class="d-flex flex-row justify-content-between mt-3">
                <button type="button" id="transactbtn" class="btn btn-primary w-50 m-2">Transact</button>
                <button type="button" class="btn btn-danger w-50 m-2">Clear</button>
            </div>
        </div>
    </div>
</div>
@endsection