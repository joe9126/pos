<!-- Add item stock -->
<div class="addstock p-3">
    <h4>Add Stock</h4><hr>
    <div class="alert alert-danger alert-block statusmsg w-75 ml-4" style="display: none;" id="statusalert">
        <strong> <span class="msg2" style="font-size:0.8rem"></span></strong>
    </div>
    <form action="#" method="post" id="addstockform" class="mt-3" data-parsley-validate>
        @csrf
        <div class="d-flex flex-column justify-content-center ">
            <div class="row " style="margin-left:4px !important">
                <div class="col-md-3 ml-4" id="productimage"></div>

                <div class="col-md-9 d-flex flex-column">
                    <div class="input-group mb-2 w-100">
                        <span class="input-group-text text-secondary">SKU</span>
                        <input type="text" name="stock_sku" id="stock_sku" class="form-control text-secondary"
                            placeholder="Product SKU *" readonly value="{{ $prod_data[0]->sku }}">
                    </div>

                    <div class="input-group mb-2 mt-2">
                        <span class="input-group-text text-secondary">Title</span>
                        <input type="text" name="title" id="title" class="form-control prod-input text-secondary"
                            placeholder="Product title *" readonly value="{{ $prod_data[0]->title }}">

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mt-3">
                        <span class="input-group-text">Quantity <span class="text-danger"> *</span> </span>
                        <input type="number" name="quantity" id="quantity" class="form-control prod-input" 
                            placeholder="Quantity *" min="1" required data-parsley-required-message="Add stock quantity.">
                    </div>
                </div>
                <div class="col-md-6"> 
                        <div class="input-group mt-3">
                            <span class="input-group-text">Unit Cost <span class="text-danger"> *</span> </span>
                            <input type="number" name="unit_cost" id="unit_cost" class="form-control prod-input" 
                                placeholder="Unit cost *" min="1" required data-parsley-required-message="Add unit cost.">
                        </div> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mt-3">
                        <span class="input-group-text">Supplier <span class="text-danger"> *</span></span>
                        <select name="supplier_id" id="supplier_id" class="form-select" 
                             required data-parsley-required-message="Select supplier">
                            <option value="">Select supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{$supplier->id}}">{{$supplier->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group mt-3">
                        <span class="input-group-text">Supply term</span>
                        <select name="supply_term" id="supply_term" class="form-select" 
                             required data-parsley-required-message="Select supply term">
                            <option value="Full payment">Select term</option>
                            <option value="Credit">Credit</option>
                            <option value="Full payment">Full payment</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="input-group mt-3">
                <textarea name="comment" id="comment" cols="30" rows="3" class="form-control stock-comment" placeholder="Comment (optional)"></textarea>
            </div>

            <div class="d-flex flex-row justify-content-center">
            <button  type="submit" class="btn btn-primary btn-block w-25 mt-2 p-2" id="addstockbtn">
                Save <i class="fa-solid fa-floppy-disk"></i>
            </button>
            <button type="button" id="cancelstockbtn" class="btn btn-danger w-25 mt-2 p-2 ">
                Cancel <i class="fa-solid fa-ban"></i>
            </button>
        </div>
        </div>
    </form>
</div>