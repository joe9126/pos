<div class="card-info">
    <h5>Request #{{$restock_req_items[0]->id}}</h5>
    <table class="table">
        <tbody>

            @foreach ($restock_req_items as $item)
                @foreach ($item->product as $product)
                    <tr>
                        <td>
                            <div class="d-flex flex-row align-items-center justify-content-start ">
                                <img src="public_uploads/{{ $product->image }}" alt="{{ $product->image }}" width="50"
                                    height="50">
                                <span>SKU #{{ $product->sku }} {{ $product->title }}</span>
                            </div>
                        </td>
                        <td>{{ $product->quantity }} pieces left</td>
                        <td>Last updated {{\Carbon\Carbon::parse($product->updated_at)->format('d/m/Y g:i A')}}</td>
                        <td>
                            @if ($product->quantity >= $stock_limit)
                            <i class="fa-solid fa-circle-check text-success"></i>
                            @else
                            <i class="fa-solid fa-circle-xmark text-danger"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
