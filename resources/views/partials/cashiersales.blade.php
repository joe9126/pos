<div class="row">
    <div class="col-md-12">
    <div class="d-flex flex-row justify-content-start   p-2">
        <div class="card-info p-3 m-2 bg-dark sale_info" style="width:10em; height:5em">
            <h6 class="text-white fw-bold">Today's Cashier <i class="fa-solid fa-user"></i></h6>
            <span class="fw-bold">
                {{ Auth::user()->name }}
            </span>
        </div>

        @php $grandtotal =0; @endphp
        @foreach ($today_sales as $sale)
            @php  $mpesa_check =0; $grandtotal += $sale->total_amount; @endphp
        @switch($sale->payment_mode)
            @case('Cash')
                @php
                    
                @endphp
            <div class="card-info p-3 m-2 bg-primary sale_info" style="width:10em; height:5em">
                <h6 class="text-white fw-bold">Cash Sales <i class="fa-solid fa-money-bill"></i></h6>
                <span class="fw-bold">
                    {{ $currency }}{{ number_format($sale->total_amount, 2) }}
                </span>
            </div>
                @break
                @case('M-PESA')
              
                <div class="card-info p-3 m-2 bg-success sale_info" style="width:10em; height:5em">
                    <h6 class="text-white fw-bold">M-PESA Sales <i class="fa-solid fa-mobile-retro"></i></h6>
                    <span class="fw-bold">
                        {{ $currency }}{{ number_format($sale->total_amount, 2) }}
                    </span>
                </div>
                @break
        
            @default
            <div class="card-info p-3 m-2 sale_info" style="width:10em; height:5em">
                <h6 class="text-danger fw-bold text-center">No Transactions Today</h6>
            </div>
          @endswitch  
        @endforeach
        @if($today_sales->where("M-PESA")->isEmpty())
        <div class="card-info p-3 m-2 bg-success sale_info" style="width:10em; height:5em">
            <h6 class="text-white fw-bold">M-PESA Sales <i class="fa-solid fa-mobile-retro"></i></h6>
            <span class="fw-bold">
                {{ $currency }}0.00
            </span>
        </div>
        @endif
        
         <div class="card-info p-3 m-2 bg-secondary sale_info" style="width:10em; height:5em">
            <h6 class="text-white fw-bold">Total Discounts <i class="fa-solid fa-coins"></i></h6>
            <span class="fw-bold">{{ $currency }}{{ number_format($today_cashier_disc, 2) }}</span>
        </div>
        <div class="card-info p-3 m-2 bg-danger sale_info" style="width:10em; height:5em">
            @php $grandtotal -= $today_cashier_disc;  @endphp
            <h6 class=" fw-bold">Total Sales <i class="fa-solid fa-sack-dollar"></i></h6>

            <span class="fw-bold">{{ $currency }}{{ number_format($grandtotal, 2) }}</span>
        </div>
    </div>
</div>
</div>


<div class="row ">
    <div class="col-md-12 mr-3">
        <h6 class="fw-bold mb-2">Today's Transactions</h6><hr>
        <div class="">
        <table class="table table-striped cashier_todaysales_table" id="cashier_todaysales_table">
            <thead> 
                <tr>
                    <th>Transaction #</th>
                    <th>Date</th>
                    <th>Subtotal</th>
                    <th>Discount</th>
                    <th>Vat%</th>
                    <th>Grand total</th>
                    <th>Payment mode</th>
                </tr> 
            </thead>
            <tbody></tbody>
        </table>
    </div>
    </div>
</div>