<div class="col-md-6" style="border-right: 1px solid #ccc; min-height:75vh">
  
    
    <div class="alert alert-info alert-dismissible" role="alert" style="height:3rem; display:none">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div><span class="msg"></span></div>
    </div>

    <div class="card-info">
        <div class="d-flex flex-column mt-3">
            <h6>Transaction ID</h6>
            <h6 id="transaction_id" class="text-primary fw-bold">#{{$transaction_data->id}}</h6>
            <hr>
        </div>
        <div class="d-flex flex-column">
            <h6>Transaction Date</h6>
            <div class="d-flex flex-row">
                <i class="fa-solid fa-calendar-days text-primary"></i>
                <h6 id="transaction_date" class="text-primary fw-bold" style="padding-right:10px !important;">
                    {{\Carbon\Carbon::parse($transaction_data->created_at)->format('d/m/Y h:m a')}}
                </h6>
            </div>
            <hr>
        </div>
        <div class="d-flex flex-column">
            <h6>Payment Mode</h6>
            <h6 id="transaction_id" class="text-primary fw-bold">{{$transaction_data->payment_mode}}</h6>
            <hr>
        </div>
        <div class="d-flex flex-column">
            <h6>Cashier</h6>
            <div class="d-flex flex-row">
                <i class="fa-solid fa-user text-primary"></i>
                <h6 id="transaction_date" class="text-primary fw-bold" style="padding-right:10px !important;"> 
                  {{$transaction_data->user->name}}
                </h6>
            </div>
            <hr>
        </div>
        <div class="d-flex flex-row justify-content-center">
            @if ($transaction_data->status ==1)
                 <button class="btn btn-primary mt-2" id="print-receipt-btn">
                    <i class="fa-solid fa-print"></i> Print Receipt
                </button>
                @else
                <button class="btn btn-primary mt-2 m-2 w-50" id="complete-trans-btn">
                    Finalize <i class="fa-solid fa-circle-check"></i>
                </button>
                <button class="btn btn-danger mt-2 m-2 w-50" id="delete-trans-btn">
                    Delete <i class="fa-solid fa-circle-xmark"></i>  
                </button>
            @endif
           
        </div>
    </div>
</div>

<div class="col-md-6" style="border-right: 1px solid #ccc; min-height:75vh">
    <div class="card-info">
        <h5 class="fw-bold">Transaction Summary</h5>
        <table class="table">
            <tbody id="summary_tbody">
                @foreach ($transaction_data->product as $product)
                    <tr>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->pivot['units'] }} units</td>
                        <td>{{ number_format($product->pivot['unitprice'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="fw-bold">Subtotal</td>
                    <td class="fw-bold">{{ number_format($transaction_data->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2">Discount (-)</td>
                    <td class="text-danger">{{ number_format($transaction_data->discount, 2) }}</td>
                </tr>
                <tr>
                    @php
                        $taxamount =
                            ($transaction_data->taxrate / 100) *
                            ($transaction_data->subtotal - $transaction_data->discount);
                    @endphp
                    <td colspan="2">Taxes (+) {{ $transaction_data->taxrate }}%</td>
                    <td class="text-success">{{ number_format($taxamount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="fw-bold">Grand Total</td>
                    <td class="fw-bold">{{ number_format($transaction_data->grandtotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2">Payment</td>
                    <td>{{ number_format($transaction_data->payment, 2) }}</td>
                </tr>
                <tr>
                    @php
                        $balance = $transaction_data->payment - $transaction_data->grandtotal;
                    @endphp
                    <td colspan="2">Balance</td>
                    <td>{{ number_format($balance, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
