<div class="row">
    <div class="col-md-4">
        <div id="wrapper">
            <div id="invoice-POS" class="printable">

                <center id="top">
                    <div class="logo"></div>
                    <div class="info">
                        <h2 style="font-size: 1rem">SBISTechs Inc</h2>
                    </div><!--End Info-->
                </center><!--End InvoiceTop-->

                <div id="mid">
                    <div class="info">
                        <h2 style="font-size:0.5rem">Contact Info</h2>
                        <p>
                            Address : street city, state 0000</br>
                            Email : JohnDoe@gmail.com</br>
                            Phone : 555-555-5555</br>
                        </p>
                    </div>
                </div><!--End Invoice Mid-->

                <div id="bot">
                    <p class="headertxt">
                        <strong>Trans. ID: </strong> #{{ $transaction_data->id }}
                        <strong>Date: </strong>
                        {{ \Carbon\Carbon::parse($transaction_data->created_at)->format('d/m/Y h:m a') }}
                    </p>
                    <div id="table">
                        <table>
                            <tr class="tabletitle">
                                <td class="headertxt"><strong>Item</strong> </td>
                                <td class="headertxt"><strong>Qty</strong> </td>
                                <td class="headertxt"><strong>@ Price</strong> </td>
                            </tr>
                            @foreach ($transaction_data->product as $product)
                                <tr class="service">
                                    <td class="tableitem">
                                        <p class="itemtext">
                                            {{ $product->title }}
                                        </p>
                                    </td>
                                    <td class="tableitem">
                                        <p class="itemtext">
                                            {{ number_format($product->pivot['units'], 2) }}
                                        </p>
                                    </td>
                                    <td class="tableitem">
                                        <p class="itemtext">
                                            {{ number_format($product->pivot['unitprice'], 2) }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                            <tfoot>
                                <tr class="tabletitle">
                                    <td colspan="2">Subtotal</td>
                                    <td class="payment"> {{ number_format($transaction_data->subtotal, 2) }}</td>
                                </tr>
                                <tr class="tabletitle">
                                    <td colspan="2" class="Rate">Discount (-)</td>
                                    <td>{{ number_format($transaction_data->discount, 2) }}</td>
                                </tr>
                                <tr class="tabletitle">
                                    <td colspan="2" class="Rate">Taxes (+) {{ $transaction_data->taxrate }}%</td>

                                    @php
                                        $taxamount =
                                            ($transaction_data->taxrate / 100) *
                                            ($transaction_data->subtotal - $transaction_data->discount);
                                    @endphp

                                    <td class="text-success payment">{{ number_format($taxamount, 2) }}</td>
                                </tr>
                                <tr class="tabletitle">
                                    <td colspan="2" class="fw-bold" style="font-weight:bold">Grand Total</td>
                                    <td class="fw-bold payment">{{ number_format($transaction_data->grandtotal, 2) }}
                                    </td>
                                </tr>
                                <tr class="tabletitle">
                                    <td colspan="2" class="payment">Payment</td>
                                    <td>{{ number_format($transaction_data->payment, 2) }}</td>
                                </tr>
                                <tr class="tabletitle">
                                    @php
                                        $balance = $transaction_data->payment - $transaction_data->grandtotal;
                                    @endphp
                                    <td colspan="2">Balance</td>
                                    <td>{{ number_format($balance, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!--End Table-->

                    <div id="legalcopy">
                        <p class="legal"><strong>Thank you for your business!</strong>
                            You were served by {{ $transaction_data->user->name }}
                        </p>
                    </div>

                </div><!--End InvoiceBot-->
            </div><!--End Invoice-->
        </div>
    </div>
</div>

</html>
