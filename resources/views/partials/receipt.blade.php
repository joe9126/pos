<div class="row">
    <div class="col-md-4">
        <div id="wrapper">
            <div id="invoice-POS" class="printable">

                <center id="top">
                    <div class="logo"></div>
                    <div class="info">
                        <h2 style="font-size: 1rem">{{$store_info[0]->store_name}}</h2>
                        <p style="font-size: 0.6rem">Telephone {{$store_info[0]->slogan}}</p>
                    </div><!--End Info-->
                </center><!--End InvoiceTop-->

                <div id="mid">
                    <div class="info" style="text-align: center; font-size:0.7rem;">
                        <p >
                            {{$store_info[0]->address}}</br>
                            {{$store_info[0]->email}}</br>
                            {{$store_info[0]->telephone}}</br>
                        </p>
                    </div>
                </div><!--End Invoice Mid-->

                <div id="bot">
                    <p class="info"  style="font-size:0.7rem; text-align:center">
                        <strong>Receipt </strong> #{{ $transaction_data->id }}
                        <strong>Date: </strong>
                        {{ \Carbon\Carbon::parse($transaction_data->created_at)->format('d/m/Y h:m a') }}
                    </p>
                    <div id="table">
                        <table style="width: 100%;">
                            <tr class="tabletitle">
                                <td style="font-size:0.7rem; "><strong>Item</strong> </td>
                                <td style="font-size:0.7rem; "><strong>Qty</strong> </td>
                                <td style="font-size:0.7rem; "><strong>@ Price</strong> </td>
                            </tr>
                            @foreach ($transaction_data->product as $product)
                                <tr class="service">
                                    <td class="tableitem">
                                        <p style="font-size:0.6rem;">
                                            {{ $product->title }}
                                        </p>
                                    </td>
                                    <td class="tableitem">
                                        <p style="font-size:0.6rem;">
                                           {{$currency}}{{ number_format($product->pivot['units'], 2) }}
                                        </p>
                                    </td>
                                    <td class="tableitem">
                                        <p style="font-size:0.6rem;">
                                            {{$currency}}{{ number_format($product->pivot['unitprice'], 2) }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                            <tfoot>
                                <tr>
                                    <td colspan="3"><div style="width:10rem;height:1px; background-color:black; margin-bottom:2px;"></div></td>
                                </tr>
                                <tr class="tabletitle">
                                    <td colspan="2" style="font-size:0.7rem; font-weight:bold;">Subtotal</td>
                                    <td style="font-size:0.7rem; font-weight:bold;"> {{$currency}}{{ number_format($transaction_data->subtotal, 2) }}</td>
                                </tr>
                                <tr class="tabletitle">
                                    <td colspan="2" style="font-size:0.7rem;">Discount (-)</td>
                                    <td style="font-size:0.7rem;">{{$currency}}{{ number_format($transaction_data->discount, 2) }}</td>
                                </tr>
                                <tr class="tabletitle">
                                    <td style="font-size:0.7rem;" colspan="2">Taxes (+) {{ $transaction_data->taxrate }}%</td>

                                    @php
                                        $taxamount =
                                            ($transaction_data->taxrate / 100) *
                                            ($transaction_data->subtotal - $transaction_data->discount);
                                    @endphp

                                    <td class="text-success payment" style="font-size:0.7rem;">{{$currency}}{{ number_format($taxamount, 2) }}</td>
                                </tr>
                                <tr class="tabletitle">
                                    <td colspan="2" class="fw-bold" style="font-weight:bold; font-size:0.7rem">Grand Total</td>
                                    <td class="fw-bold payment" style="font-size:0.7rem;font-weight:bold;">{{$currency}}{{ number_format($transaction_data->grandtotal, 2) }}
                                    </td>
                                </tr>
                                <tr class="tabletitle">
                                    <td colspan="2" style="font-size:0.7rem;">Payment</td>
                                    <td style="font-size:0.7rem;">{{$currency}}{{ number_format($transaction_data->payment, 2) }}</td>
                                </tr>
                                <tr class="tabletitle">
                                    @php
                                        $balance = $transaction_data->payment - $transaction_data->grandtotal;
                                    @endphp
                                    <td colspan="2" style="font-size:0.7rem;">Balance</td>
                                    <td style="font-size:0.7rem;">{{$currency}}{{ number_format($balance, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div><hr><!--End Table-->

                    <div id="legalcopy">
                        <p class="legal" style="font-size:0.7rem; text-align:center"><strong>Thank you for your business!</strong><br>
                            You were served by {{ $transaction_data->user->name }}
                        </p>
                    </div>

                </div><!--End InvoiceBot-->
            </div><!--End Invoice-->
        </div>
    </div>
</div>

</html>
