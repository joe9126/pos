@foreach ($low_stock as $product)
<div class="item-tile p-2 m-2 low_stock_item" id="{{ $product->sku }}">
    <div class="d-flex align-items-center justify-content-center">
        @if ($product->image == null || $product->image == '')
            <img id="prod_image" src="public_uploads/box.png" alt="Image">
        @else
            <img id="prod_image" src="public_uploads/{{ $product->image }}" alt="Image">
        @endif
    </div>
    <h6 class="item_title">SKU #{{ $product->sku }}</h6>
    <h6 class="item_title"> {{ $product->title }}</h6>
    <h6 class="item_title">{{ $product->quantity }} units left</h6>
    <span class="item_cat">{{ $product->category->title }}</span>

</div>
@endforeach