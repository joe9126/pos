@extends('layouts.app')
@section('title') - Sales @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
           <!-- Tab links -->
           <div class="tab">
              <button class="tablinks sale_history active" >Sales History</button>
              <button class="tablinks held_sales" >Pending Sales</button>
              <button class="tablinks sales_reports">Sales Reports</button>
           </div>

           <!-- Sales History Tab content -->
           <div id="sale_history" class="tabcontent" style="display:block;">
               <div class="row">
                    <div class="col-md-4" style="border-right: 1px solid #ccc; min-height:75vh">
                        <div class="input-icons">
                            <input type="search" name="searchhistory" id="searchhistory" class="form-control searchfield mt-2 p-2" placeholder="Search by transaction id">
                        </div>
                       <table class="table table-striped mt-3" id="transactions_table">
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>#{{$transaction->id}}</td>
                                        <td>{{\Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y h:m a')}}</td>
                                        <td>{{ number_format($transaction->grandtotal,2)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                       </table>
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
              <h3>Pending Sales</h3>
              <p>London is the capital city of England.</p>
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