@extends('layouts.app')
@section('title')
    - Cashier
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Tab links -->
                <div class="tab ml-3">
                    <button class="tablinks close_counter active">Drawer</button>
                    <button class="tablinks today_sales">Today's Sales</button>
                    <button class="tablinks sales_history">Sales History</button>
                </div>
                <hr>

                <!-- Tab Contents -->

                <!-- Close Counter Tab -->
                <div id="close_counter" class="tabcontent" style="display: block;">
                    <div id="drawer">
                    <form action="#" method="post" id="drawer_form" data-parasley-validate="">
                        <div class="row">

                            @csrf
                            <div class="col-md-4 p-3" style="border-right:1px solid #ccc; min-height:70vh">
                                <h6 class="fw-bold">Drawer Amount Details</h6>
                                <hr>

                                <div class="d-flex flex-column">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Opening Balance ({{ $currency }}) <span
                                                class="text-danger">
                                                *</span> </span>
                                        <input type="number" name="opening_balance" id="opening_balance"
                                            class="form-control drawer-input" placeholder="0.00" min="1" required
                                            autofocus data-parsley-required-message="Opening balance amount required.">
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Cash Float ({{ $currency }}) <span
                                                class="text-danger">*</span> </span>
                                        <input type="number" name="cash_float" id="cash_float"
                                            class="form-control drawer-input" placeholder="0.00" min="1" required
                                            data-parsley-required-message="Cash float amount required.">
                                    </div>
                                </div>
                                <div class="d-flex flex-column fw-bold">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Today's Sales ({{ $currency }})</span>
                                        <input type="text" name="todaysales_amount" id="todaysales_amount"
                                            class="form-control prod-input fw-bold" placeholder="0.00" min="1"
                                            value="{{ number_format($today_cashier_sales,2) }}" readonly>
                                    </div>
                                </div>
                                <div class="d-flex flex-columnfw-bold">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Expected Drawer Amount ({{ $currency }})</span>
                                        <input type="text" name="expected_drawer_amount" id="expected_drawer_amount"
                                            class="form-control prod-input fw-bold" placeholder="0.00" min="1"
                                            value="{{ number_format($today_cashier_sales,2) }}" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4 p-3" style="border-right:1px solid #ccc; min-height:70vh">
                                <h6 class="fw-bold">Close Drawer</h6>
                                <hr>

                                <div class="input-group mt-3 mb-3">
                                    <span class="input-group-text">Counted Drawer Amount ({{ $currency }}) <span class="text-danger">
                                            *</span> </span>
                                    <input type="number" name="counted_drawer_amount" id="counted_drawer_amount"
                                        class="form-control prod-input" placeholder="0.00" min="1" required
                                        data-parsley-required-message="Counted drawer amount required.">
                                </div>
                                <label for="remark">Remark </label>
                                <textarea name="remark" id="remark" cols="30" rows="3" class="form-control"></textarea>

                                <div class="input-group mt-3 mb-3">
                                    <span class="input-group-text">Total Drawer Amount ({{ $currency }})</span>
                                    <input type="text" name="total_drawer_amount" id="total_drawer_amount"
                                        class="form-control prod-input fw-bold" placeholder="0.00" min="1" readonly>
                                </div>

                                <div class="input-group mt-3 mb-3">
                                    <span class="input-group-text">Cash Balance ({{ $currency }})</span>
                                    <input type="text" name="cash_balance" id="cash_balance"
                                        class="form-control prod-input fw-bold" placeholder="0.00" min="1" readonly>
                                </div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="submit" class="btn btn-primary w-75">Close Drawer</button>
                                </div>
                               
                            </div>
                            <div class="col-md-4 p-3 ">
                                <h6 class="fw-bold">Drawer History</h6><hr> 
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <button type="button" class="btn btn-primary m-2 p-2" id="viewhistorybtn">View History <i class="fa-solid fa-arrow-right"></i></button>
                                </div>        
                              
                            </div>
                        </div>
                    </form>
                </div>
                <div id="drawer_history" style="display: none">
                    <div class="d-flex flex-row justify-content-start align-items-center">
                        <button class="btn btn-danger m-2 p-2" id="exit_history_btn"><i class="fa-solid fa-arrow-left"></i> </button>
                        <h6 class="fw-bold p-2 m-2">Drawer History </h6> |
                         <h6 class="fw-bold p-2 m-2"> <i class="fa-solid fa-user"></i>Cashier {{Auth::user()->name}}</h6>
                    </div><hr>
                   <div class="row">
                    <div class="col-md-12">
                          <table class="table table-striped" id="drawer_history_table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Opening Bal</th>
                                            <th> Cash Float</th>
                                            <th> Day's Sales</th>
                                            <th>Expected Amount</th>
                                            <th>Counted Amount</th>
                                            <th>Remark</th>
                                            <th>Cash Balance</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                </div>
                </div>

                <!-- Today Sales Tab -->
                <div id="today_sales" class="tabcontent" style="display: none;">

                    <div id="cashiersalesinfo">
                        <!--data loaded dynamically via tabscripts.js and partials.cashiersales-->
                    </div>
                </div>

                <!-- Sales History Tab -->
                <div id="sales_history" class="tabcontent" style="display: none;">
                    <!-- Data rendered dynamically through tabscripts.js and partials.cashierhistory-->
                </div>

            </div>
        </div>
    </div>
@endsection
