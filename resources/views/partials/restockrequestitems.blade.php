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
                                <h6>SKU #{{ $product->sku }} {{ $product->title }}</h6>
                            </div>
                        </td>
                        <td>{{ $product->quantity }} pieces left</td>

                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
