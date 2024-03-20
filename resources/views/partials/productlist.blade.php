    <div class="d-flex flex-row flex-wrap align-items-start justify-content-start prod_itemslist">
        @foreach ($products as $product)
            <a href="pos/{{ $product->sku }}" class="prod_item_link">
                <div class="item-tile p-2 m-1">
                    <div class="d-flex flex-row align-items-end justify-content-center edit-prod">
                        @if ($product->status ==1)
                        <button class="text-success text-right edit-pen">
                            <i class="fa-solid fa-unlock text-success"></i>
                        </button>
                       
                        @else
                        <button class="text-danger text-right edit-pen">
                            <i class="fa-solid fa-lock text-danger"></i>
                        </button>
                       
                        @endif
                        <button class="text-primary text-right edit-pen">
                            <i class="fa-solid fa-pencil"></i>
                        </button>
                        <button class="text-primary text-right cart-pen">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </div>

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
                    <h5 class="item-txt fw-bold"> KES. {{ number_format($product->unit_price, 2) }}</h5>
                    <div class="d-flex justify-content-center">
                        <span class="stars" data-rating="{{ $product->rating }}" data-num-stars="5"></span>
                    </div>

                </div>
            </a>
        @endforeach
    </div>
