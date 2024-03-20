
<div class="row mt-2">
    <div class="col-md-12">
        <div class=" pl-3 pr-4 m-3">
            <div class="alert alert-danger alert-block statusmsg w-75 ml-4" style="display: none;" id="statusalert">
                <strong> <span id="msg" style="font-size:0.8rem"></span></strong>
            </div>

            <form action="#" id="new_product_form" data-parsley-validate="">
                @csrf
               
                    <div class="row ">
                        <div class="col-md-3">
                            <div id="productimage"></div>
                        </div>

                        <div class="col-md-9 ">
                            <div class="input-group mb-2">
                                <span class="input-group-text ">SKU *</span>
                                <input type="text" name="sku" id="sku" class="form-control"
                                    placeholder="Product SKU *" required=""
                                    data-parsley-required-message="SKU is required. It's product ID"
                                    autocomplete="off">
                            </div>

                            <input type="file" name="image" id="image" class="form-control mt-3 prod-input" accept="image/png, image/jpeg" >
                        </div>
                    </div>
                    <div class="input-group mb-3 mt-3">
                        <span class="input-group-text">Title *</span>
                        <input type="text" name="title" id="title" class="form-control prod-input"
                            placeholder="Product title *" required="" 
                            data-parsley-required-message="Product title is required.">

                    </div>
                

                <div class="row">
                   <div class="col-md-6">
                       <div class="input-group mb-3">
                           <span class="input-group-text">Category</span>
                           <select name="category" id="category" class="form-select prod-select" required
                               data-parsley-required-message="Category is required.">
                               <option value="" selected="selected">Select Category *</option>
                               @foreach ($categories as $category)
                                   <option  value="{{ $category->id }}">{{ $category->title }}</option>
                               @endforeach
                           </select>
                       </div>
                   </div>
                   <div class="col-md-6">
                       <div class="input-group mb-3">
                           <span class="input-group-text">Unit Price</span>
                           <input type="number" name="unitprice" id="unitprice" class="form-control prod-input"
                               style="margin-right:3px !important;" min="0" placeholder="Unit Price *"
                               required=""
                               data-parsley-required-message="Unit price is required." data-parsley-trigger="change">
                       </div>
                   </div>
                </div>
                

                <div class="row">
                  
                    <div class="col-md-6">
                        <div class="input-group mb-3 ml-3" style="margin-right:3px !important;">
                            <span class="input-group-text">Status</span>
                            <select name="status" id="status" class="form-select prod-select">
                                <option value="" selected="selected">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Locked</option>
                            </select>
                        </div>
                    </div>
                                
                    <div class="col-md-6">
                        <div class="input-group mb-3 ml-3">
                            <span class="input-group-text ">Status</span>
                            <select name="rating" id="rating" class="form-select prod-select">
                                <option value="0" selected="selected">Select Rating</option>
                                <option value="1">1 Star</option>
                                <option value="2">2 Star</option>
                                <option value="3">3 Star</option>
                                <option value="4">4 Star</option>
                                <option value="5">5 Star</option>
                            </select>
                        </div>
                    </div>
               </div>
               <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-3 ml-3">
                        <span class="input-group-text ">Tax</span>
                        <select name="tax_id" id="tax_id" class="form-select prod-select">
                            <option value="0" selected="selected">Select Tax</option>
                            @foreach ($taxes as $tax)
                            <option value="{{$tax->id}}">{{$tax->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
               </div>
        <div class="d-flex flex-row justify-content-center">
            <button type="submit" class="btn btn-primary btn-block w-25 m-2">
               Save <i class="fa-solid fa-floppy-disk"></i> 
            </button>
            <button type="button" class="btn btn-danger btn-block w-25 m-2">
                    Delete  <i class="fa-solid fa-trash"></i>
            </button>
        </div>

        </form>
    </div>
</div>
