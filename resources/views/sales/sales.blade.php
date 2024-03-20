@extends('layouts.app')
@section('title')
    - Sales
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Tab links -->
                <div class="tab">
                    <button class="tablinks sale_history active">Sales History</button>
                    <button class="tablinks held_sales">Held Transactions</button>
                    <button class="tablinks sales_reports">Sales Reports</button>
                </div>

                <!-- Sales History Tab content -->
                <div id="sale_history" class="tabcontent" style="display:block;">
                    <div class="row">
                        <div class="col-md-4" style="border-right: 1px solid #ccc; min-height:75vh">
                            <div class="input-group mb-3 mt-2 p-2">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <div class="form-floating">
                                    <input type="search" name="searchhistory" id="searchhistory"
                                        class="form-control searchfield" placeholder="Search by transaction id" autocomplete="off">
                                    <label for="searchhistory">Search by transaction id</label>
                                </div>
                            </div>
                            <div id="sales_history_view">
                                <table class="table table-striped mt-3" id="transactions_table">
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>#{{ $transaction->id }}</td>
                                                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y g:i A') }}
                                                </td>
                                                <td>{{$currency}}{{ number_format($transaction->grandtotal, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <!-- Data fetched dynamically in loopContainer blade -->
                            <div class="row" id="trans_data"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Pending Sales Tab-->
            <div id="held_sales" class="tabcontent">
                <div class="row">
                    <div class="col-md-4 p-2" style="border-right: 1px solid #ccc; min-height:75vh;">
                        <div class="input-group mb-3 mt-2 p-2">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <div class="form-floating">
                                <input type="search" class="form-control searchfield" id="searchpendingsales"
                                    placeholder="Search by transaction id" autocomplete="off">
                                <label for="searchpendingsales">Search by transaction id</label>
                            </div>
                        </div>

                        <table class="table table-striped mt-3" id="held_transactions_table">
                            <tbody>
                                @foreach ($held_transactions as $held_transaction)
                                    <tr>
                                        <td>#{{ $held_transaction->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($held_transaction->created_at)->format('d/m/Y g:i A') }}
                                        </td>
                                        <td>{{$currency}}{{ number_format($held_transaction->grandtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-8">
                        <div class="row" id="held_trans_data"></div>

                    </div>
                </div>
            </div>

            <!-- Sales Reports Tab-->
            <div id="sales_reports" class="tabcontent">
                <h3> Sales Reports</h3>
                <p>London is the capital city of England.</p>
            </div>
        </div>
    </div>
    </div>
@endsection
