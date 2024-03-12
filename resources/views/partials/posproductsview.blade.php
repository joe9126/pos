<div class="d-flex flex-row flex-wrap align-items-start justify-content-center">
    @foreach ($prod_search_result as $product)
        <a href="pos/{{ $product->id }}" class="item_link">
            <div class="item-tile p-2 m-1">
                <div class="d-flex align-items-center justify-content-center">
                    @if ($product->image == null || $product->image == '')
                        <img id="prod_image" src="public_uploads/box.png" alt="Image">
                    @else
                        <img id="prod_image" src="public_uploads/{{ $product->image }}" alt="Image">
                    @endif

                </div>

                <h5 class="item_title">{{ $product->title }}</h5>
                <h6>{{ $product->quantity }} units left</h6>
                <span class="item_cat">{{ $product->category->title }}</span>
                <h5 class="item-txt fw-bold"> KES. {{number_format($product->unit_price,2) }}</h5>
                <div class="d-flex justify-content-center star-container">
                    <span class="stars" data-rating="{{ $product->rating }}" data-num-stars="5"></span>
                </div>

            </div>
        </a>
    @endforeach
</div>
