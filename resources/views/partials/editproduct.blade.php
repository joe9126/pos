 <!-- Edit Product -->

 <div class="row mt-2">
     <div class="col-md-12">
         <div class=" pl-3 pr-4 m-3">
             <div class="alert alert-danger alert-block statusmsg w-75 ml-4" style="display: none;" id="statusalert">
                 <strong> <span id="msg" style="font-size:0.8rem"></span></strong>
             </div>

             <form action="#" id="product_form" data-parsley-validate="">
                 @csrf
                 <div class="d-flex flex-column justify-content-center ">
                     <div class="row " style="margin-left:4px !important">
                         <div class="col-md-3 ml-4" id="productimage"></div>

                         <div class="col-md-9 d-flex flex-column">
                             <div class="input-group mb-2">
                                 <span class="input-group-text text-primary">SKU *</span>
                                 <input type="text" name="sku" id="sku" class="form-control"
                                     placeholder="Product SKU *" required="" value="{{ $prod_data[0]->sku }}"
                                     data-parsley-required-message="SKU is required. It's product ID"
                                     autocomplete="off">
                             </div>

                             <input type="file" name="image" id="image" class="form-control mt-3 prod-input">
                         </div>

                     </div>
                     <div class="input-group mb-3 mt-3">
                         <span class="input-group-text text-primary">Title *</span>
                         <input type="text" name="title" id="title" class="form-control prod-input"
                             placeholder="Product title *" required="" value="{{ $prod_data[0]->title }}"
                             data-parsley-required-message="Product title is required.">

                     </div>
                 </div>

                 <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text text-primary">Category</span>
                            <select name="category" id="category" class="form-select prod-select" required
                                data-parsley-required-message="Category is required.">
                                <option value="" selected="selected">Select Category *</option>
                                @foreach ($categories as $category)
                                    <option selected="selected" value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text text-primary">Unit Price</span>
                            <input type="number" name="unitprice" id="unitprice" class="form-control prod-input"
                                style="margin-right:3px !important;" min="0" placeholder="Unit Price *"
                                required="" value={{ $prod_data[0]->unit_price }}
                                data-parsley-required-message="Unit price is required." data-parsley-trigger="change">
                        </div>
                    </div>
                 </div>
                 

                 <div class="row">
                   
                     <div class="col-md-6">
                         <div class="input-group mb-3 ml-3" style="margin-right:3px !important;">
                             <span class="input-group-text text-primary">Status</span>
                             <select name="status" id="status" class="form-select prod-select">
                                 <option value="" selected="selected">Select Status</option>
                                 <option value="1">Active</option>
                                 <option value="0">Locked</option>
                             </select>
                         </div>
                     </div>
                                 
                     <div class="col-md-6">
                         <div class="input-group mb-3 ml-3">
                             <span class="input-group-text text-primary">Status</span>
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
         <div class="d-flex flex-row justify-content-center">
             <button type="submit" class="btn btn-primary btn-block w-25 m-2">
                 <i class="fa-solid fa-floppy-disk"></i> Save
             </button>
             <button type="button" class="btn btn-danger btn-block w-25 m-2">
                 <i class="fa-solid fa-trash"></i> Delete
             </button>
         </div>

         </form>
     </div>
 </div>
