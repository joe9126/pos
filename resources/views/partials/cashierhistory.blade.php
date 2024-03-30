<div class="row">
    <div class="col-md-12">
        <div class="d-flex flex-row">
            <div class="card-info  p-3 m-2 bg-dark text-white sale_info" style="width:10em; height:5em">
                <h6 class="text-white fw-bold">Cashier <i class="fa-solid fa-user"></i></h6>
                <span class="fw-bold">{{ Auth::user()->name }}</span>
               
            </div>
            @foreach ($cashier_history as $history)
            @switch($history->payment_mode)
                @case('Cash')
                <div class="card-info p-3 m-2 bg-primary  sale_info" style="width:10em; height:5em">
                    <h6 class="text-white fw-bold">Cash Sales <i class="fa-solid fa-money-bill"></i></h6>
                    <span class="fw-bold">
                        {{ $currency }}{{ number_format($history->total_amount, 2) }}
                    </span>
                </div>
                @break

                @case('M-PESA')
                <div class="card-info p-3 m-2 bg-success sale_info" style="width:10em; height:5em">
                    <h6 class="text-white fw-bold">M-PESA Sales <i class="fa-solid fa-mobile-retro"></i></h6>
                    <span class="fw-bold">
                        {{ $currency }}{{ number_format($history->total_amount, 2) }}
                    </span>
                </div>
                    
                @break
            
                @default
                    
            @endswitch
            
            @endforeach
            <div class="card-info p-3 m-2 bg-danger sale_info" style="width:10em; height:5em">
                <h6 class="text-white fw-bold">Total Sales <i class="fa-solid fa-sack-dollar"></i></h6>
                <span class="fw-bold">
                    {{ $currency }}{{ number_format($total_sales[0]->total_sales, 2) }}
                </span>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
        <h6 class="fw-bold mt-2">All Transactions</h6><hr>
        <table class="table table-bordered data-table" id="cashierhistory_table">
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
</div>
