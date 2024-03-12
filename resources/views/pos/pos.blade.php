@extends('layouts.app')
@section('title')
    - Point of Sale
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row" id="pos_view">
            <div class="col-md-7 card">

                <div class="item-category mb-4">
                    <h4 class="text-left">Search Item</h4>
                    <hr>
                    <ul>
                        <li><a href="#" class="bg-primary text-white category_search">All</a></li>
                        @foreach ($categories as $category)
                            <li><a href="#" class="bg-primary text-white category_search">{{ $category->title }}</a>
                            </li>
                        @endforeach

                    </ul>
                </div>
                <div class="items-list">

                    <div class="d-flex flex-colum mb-2">
                        <input type="text" class="form-control" name="searchitem" id="searchitem"
                            placeholder="Search item" autocomplete="off">
                    </div>
                    <hr>
                    <div class="" id="products_list">
                        <div class="d-flex flex-row flex-wrap align-items-start justify-content-center itemslist">
                            @foreach ($products as $product)
                                <a href="pos/{{ $product->id }}" class="item_link">
                                    <div class="item-tile p-2 m-1">
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
                    <div id="searchresultview" class="itemslist">
                        <!-- Product search results loaded dynamically via posproductsviewblade-->

                    </div>

                </div>

            </div>
            <div class="col-md-5 vh-75" id="pos_trans_view">
                <!-- POS view -->
                <div class="card">
                    <h4>POS</h4>
                    <hr>
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-danger alert-block statusmsg w-75 ml-4" style="display: none;"
                            id="statusalert">
                            <strong> <span id="msg" class="alert-msg" style="font-size:0.8rem"></span></strong>
                        </div>
                    </div>

                    <div class="pos_list mb-2">
                        <table id="pos_table" class="table table-striped">
                            <thead>
                                <th>ID</th>
                                <th>Item</th>
                                <th></th>
                                <th>Units</th>
                                <th></th>
                                <th>Price</th>
                                <th></th>
                            </thead>
                            <tbody id="items_tbody"></tbody>
                        </table>
                    </div>

                    <table id="pos_cost_table" style="width:100%; border-collapse:collapse;" class="">
                        <tbody>
                            <tr>
                                <td style="width:30%; border:1px solid #c7c7c7;" class="fw-bold" colspan="2">Subtotal
                                </td>
                                <td id="pos_subtotal" style="width:40%; border:1px solid #c7c7c7;">0.00</td>
                            </tr>
                            <tr>
                                <td style="width:30%; border:1px solid #c7c7c7;" class="text-danger fw-bold">Discount %</td>
                                <td contenteditable="true" style="width:30%; border:1px solid #c7c7c7;"
                                    class="text-danger fw-bold">0</td>
                                <td style="width:30%; border:1px solid #c7c7c7;" id="pos_discount"
                                    class="text-danger fw-bold">0.00</td>
                            </tr>

                            <tr>
                                <td style="width:30%; border:1px solid #c7c7c7;">Vat Total</td>
                                <td>

                                    @foreach ($taxgroups as $taxgroup)
                                        {{ $taxgroup->rate }}
                                    @endforeach

                                </td>
                                <td style="width:30%; border:1px solid #c7c7c7;" id="tax_rate">0.00</td>
                            </tr>
                            <tr>
                                <td style="width:30%; border:1px solid #c7c7c7;" class="fw-bold" colspan="2">Grand total
                                </td>
                                <td id="pos_grandtotal" class="fw-bold" style="width:30%; border:1px solid #c7c7c7;">0.00
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex flex-row justify-content-between mt-3">
                        <button type="button" id="transactbtn" class="btn btn-primary w-50 m-2">Transact</button>
                        <button type="button" id="clearposbtn" class="btn btn-danger w-50 m-2">Clear</button>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <input type="button" value="Hold Transaction" class="btn btn-secondary btn-block w-100 m-2">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Transact view -->
        <div id="transact_view" style="display:none; height:auto; min-height:70vh" class="card p-3">
            <div class="d-flex flex-row">
                <h4>Complete Transaction</h4>
                <div class="alert alert-danger alert-block statusmsg w-75 ml-4" style="display:none;">
                    <strong> <span class="msg" style="font-size:0.8rem"></span></strong>
                </div>
            </div>
            <hr>

            <div class="row ml-3">
                <div class="col-md-2 justify-content-center" style="border-right:1px solid #ccc; height:50vh">
                    <div class="tab">
                        <button class="tablinks cashview active w-100" style="border-radius:0; border:none;">Cash
                            Payment</button>
                        <button class="tablinks mpesaview w-100" style="border-radius:0; border:none;">M-Pesa</button>
                    </div>
                    <button class="btn btn-danger w-100 mt-3" id="exittransbtn"><i
                            class="fa-solid fa-circle-arrow-left"></i> Exit</button>
                </div>
                <div class="col-md-10">
                    <div class="tabcontent" id="cashview" style="display:block;">
                        <div class=" p-4 w-50 d-flex justify-content-center flex-column">
                            <div class="d-flex flex-row justify-content-between">
                                <h4>Grand Total</h4>
                                <h4 id="cashtotal">0.00</h4>
                            </div>
                            <hr>
                            <div class="d-flex flex-row justify-content-between">
                                <input type="number" name="payment" id="payment" class="form-control p-2 mb-3"
                                    placeholder="Cash Amount " autofocus>
                            </div>
                            <hr>
                            <div class="d-flex flex-row justify-content-between">
                                <h4>Balance</h4>
                                <h4 id="cashbalance">0.00</h4>
                            </div>
                            <hr>
                            <button type="button" class="btn btn-primary btn-block w-100" disabled id="executebtn"
                                class="btn btn-primary w-50 m-2">Complete Payment</button>
                        </div>
                    </div>

                    <div class="tabcontent" id="mpesaview" style="display:none;">
                        <p>MPESA Comming soon!</p>
                    </div>
                </div>
            </div>



        </div>
    </div>
@endsection
