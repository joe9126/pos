$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});




$(".item-tile").on("hover", function () {
    $(".edit-prod").show();
});

/***
 * Register new product
 */
$("#newitembtn").on("click",function(event){
    $.ajax({
        method: "get",
        url:"products/new",
        dataType: "html",
        success: (data) => {
            $(".modal-content").html(data);
            $(".modal-content").toggle("bounce", { times: 3 }, "slow");
            $("#main_modal").show();
        }

    });
});

// submit new product form
$(".modal-content").on('submit', '#new_product_form', function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: "products/store",
        method: 'post',
        data: formData,
        dataType: "json",
        contentType: false,
        processData: false,
        beforeSend: function () { 
            $("#msg").text("Creating new product...");
            $(".alert").show().fadeOut(4000);
        },
        success: function (data) {

            if (data.status == "success") {
                $(".alert").removeClass("alert-danger");
                $(".alert").addClass("alert-success");
                $('#new_product_form')[0].reset();
                $('#new_product_form').parsley().reset();
                $("#productimage").css('background-image', 'url(public_uploads/box.png)');
                setTimeout(function(){
                    location.reload();
                },1000);
            } else {
                $(".alert").addClass("alert-danger");
                $(".alert").removeClass("alert-success");
            }
            $("#msg").text(data.message);
            $(".alert").show().fadeOut(4000);

        }
    });

});



/**
 * Edit product item in Products list
 */
$(".prod_item_link").on("click", function (event) {
    event.preventDefault();
});

$("#products_list").on('click', '.edit-pen', function (event) {
    event.preventDefault();
    var str = $(this).closest("a").attr('href').split("/");
    var prod_sku = str[1];
    $.ajax({
        method: "get",
        url: "products/show/" + prod_sku,
        dataType: "html",
        success: (data) => {
            $(".modal-content").html(data);
            $(".modal-content").toggle("bounce", { times: 3 }, "slow");
            setTimeout(function () {
                $("#main_modal").show();
            }, 800);

        }
    });

});


/** Add product stock */

$("#products_list").on("click", ".cart-pen", function (event) {
    event.preventDefault();
    var str = $(this).closest("a").attr('href').split("/");
    let prod_sku = str[1];

    $.ajax({
        method: "get",
        url: "products/show_update/" + prod_sku,
        dataType: "html",
        success: (data) => {
            $(".modal-content").html(data);
            $(".modal-content").toggle("bounce", { times: 3 }, "slow");
            setTimeout(function () {
                $("#main_modal").show();
                $("#quantity").focus();
            }, 500);
        }
    });

});

$(document).ready(function () {
    $("#addstockform").parsley();
    $(".modal-content").on("submit", "#addstockform", function (event) {
      
        event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "products/update",
                method: 'post',
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $(".msg2").text("Updating. Please wait...");
                    $(".alert").removeClass("alert-danger");
                    $(".alert").addClass("alert-primary");
                    $(".alert").show();
                },
                success: (data) => {
                   // console.log(data);
                    if (data.status == "success") {
                        $(".alert").removeClass("alert-danger");
                        $(".alert").addClass("alert-success");
                        $("#addstockform")[0].reset();
                        $("#addstockform").parsley().reset();
                        setTimeout(function(){
                            location.reload();
                        },500);
                    } else {
                        $(".alert").addClass("alert-danger");
                        $(".alert").removeClass("alert-success");
                    }
                    $(".msg2").text(data.message);
                    $(".alert").show().fadeOut(4000);;

                }
            });
       
    });
});

/**
 * Add Item to low stock product request list
 */

$("#low_stock_list").on("click",".low_stock_item",function(){
var sku = $(this).attr('id');
//alert(sku);
$.ajax({
    method:"get",
    url:"products/edit/"+sku,
    dataType:"json",
    success:(data)=>{
       
        var item = "<tr>"+
                        "<td>"+data[0].sku+"</td>"+
                        "<td>"+data[0].title+"</td>"+
                        "<td>"+data[0].quantity+"</td>"+
                    "</tr>";
           var count = document.getElementById("low_stock_table").rows.length;
         //  console.log(count);
           if(count==0){
            $("#low_stock_table tbody").append(item);
            $('#send_requestbtn').show();
            $('#print_requestbtn').show();
           }else{
            var match =-1;
            $("#low_stock_table tbody tr").each(function(){
                var itemsku = $(this).find('td:nth-child(1)').html();
                
                if(itemsku==data[0].sku){
                   // 
                   match = $(this).index();
                    return true;
                }
            });
           if( match >-1 ){
            $("#global_msg").text("Item already added.");
            $("#msg_panel").show().delay(3000).hide(1);
           }  else{
                $("#low_stock_table tbody").append(item);
           }
             
           }
       
    }
});

});

/**
 * Send product restock request
 */
$('#send_requestbtn').on("click",function(){
    var count = document.getElementById("low_stock_table").rows.length;
    if( count ==0 ){
        $("#global_msg").text("Add at least one product.");
        $("#msg_panel").show().delay(3000).hide(1);
       } else{
        var restockitems = [];
        var formData = new FormData();
        $("#low_stock_table tbody tr").each(function(){
            var itemsku = $(this).find('td:nth-child(1)').html();
            var title = $(this).find('td:nth-child(2)').html();
            var qty =  $(this).find('td:nth-child(3)').html();
            var item = {"sku":itemsku,"title":title,"quantity":qty};
            restockitems.push(item);
           
        });
        formData.append('formdata',JSON.stringify(restockitems));
        $.ajax({
            method:"POST",
            processData: false,
            contentType: false,
            cache: false,
            url:"products/request",
            data:formData,
            dataType:"json",
            beforeSend:function(){
                $(".global_msg").text("Sending request. Please wait ...");
                $("#msg_panel").show();
            },
            success:(data)=>{
                $("#msg_panel").hide();
                 $(".global_msg").text(data.message);
            if(data.status=="success"){
             $("#msg_success").show().delay(3000).hide(1);
           
            setTimeout(function(){
                location.reload();
            },3000);
           }else{
            $("#msg_error").show().delay(3000).hide(1);
           }
            }
        });

       }
});

/**
 * Add item to POS list
 */
$(function () {
    $('.itemslist').on("click", '.item_link', function (event) {
        event.preventDefault();
        const link = this.href;
        var salestotal = 0;
        $.ajax({
            type: 'get',
            url: link,
            success: function (data) {
              
                if (data.quantity < 1) {
                    $("#msg_error").show().delay(3000).hide(1);
                    $(".global_msg").text("Product quantity is not enough.");

                } else {
                    $("#msg_success").show().delay(3000).hide(1);
                    $(".global_msg").text("Item added to list");

                    let item =
                        "<tr>" +
                        "<td class='prodID'>" + data.id + "</td>" +
                        "<td>" + data.title + "</td>" +
                        "<td>" +
                        "<a href='#' class='addunit'><i class='fa-solid fa-circle-plus text-success'></i></a>" +
                        "</td>" +
                        "<td style='text-align:center'>1</td>" +
                        "<td>" +
                        "<a href='#' class='subtractunit'><i class='fa-solid fa-circle-minus text-danger'></i></a>" +
                        "</td>" +
                        "<td>" + data.unit_price + "</td>" +
                        "<td>" +
                        "<div class='col-md-2 d-flex justify-content-end'>" +
                        "<a href='#' class='positem_remove'>" +
                        "<i class='fa-solid fa-circle-xmark'></i>" +
                        "</a>" +
                        "</div>" +
                        "</td>" +
                        "</tr>";

                    var rows = $("table#pos_table >tbody >tr").length;

                    if (rows == 0) {
                        $("#pos_table").find('tbody').append(item);
                        $(".posactivitybtn").prop('disabled', false);


                    } else {
                        var match = -1; var matchqty=1;
                        $("#pos_table tbody tr").each(function () {
                            var itemlistid = $(this).find("td:nth-child(1)").html();

                            if (itemlistid == data.id) {
                                match = $(this).index();
                                matchqty = $(this).find("td:nth-child(4)").html();
                                return true;
                            }
                        });

                        if (match > -1) {
                           
                                if((parseInt(matchqty)+1) >= data.quantity){
                                    $("#msg_panel").show().delay(3000).hide(1);
                                    $("#global_msg").text("Quantity is not enough.");
                                }else{
                                    var itemqty = parseInt($("table#pos_table >tbody >tr:nth-child(" + (match + 1) + ") td:nth-child(4)").text()) + 1;
                                    $("#pos_table tbody tr:nth-child(" + (parseInt(match + 1)) + ") td:nth-child(4)").text(itemqty);
                                }
                           
                           
                        } else {
                            $("#pos_table").find('tbody').append(item);
                        }
                    }

                    getSalestotal();
                }
            }
        });
    });
});

/**
 * Set POS discount
 */
$("#sel_discount").on("change",function(){
    var disc_rate  = $(this).find(':selected').val();
    $(this).closest('td').next('td').html(disc_rate);
    getSalestotal();

});
/**
 * Calculate POS sales total
 */
function getSalestotal() {
    var itemprice = 0; var itemqty = 0; var itemtotal = 0; var salestotal = 0;
    $("#pos_table >tbody >tr").each(function () {
        itemprice = parseFloat(numeral($(this).find("td:nth-child(6)").html()).format("0.0"));

        itemqty = parseFloat(numeral($(this).find("td:nth-child(4)").html()).format("0.0"));

        itemtotal = parseFloat(itemprice) * parseFloat(itemqty);
        salestotal += parseFloat(itemtotal);
    });
    document.getElementById("pos_subtotal").innerHTML = numeral(salestotal).format('0,0.00');
    var discount = parseFloat(numeral($(this).find("td:nth-child(6)").html()).format("0.0")) || 0;
    var newsubtotal = ((100 - discount) / 100) * salestotal;

    var taxrate = 0; var totaltax = 0;

    var discountrate = parseFloat($("#pos_cost_table tbody tr:nth-child(2) td:nth-child(2)").text());
    var totaldiscount = newsubtotal * (discountrate / 100);
    document.getElementById("pos_discount").innerHTML = numeral(totaldiscount).format('0,0.00');

    taxrate = parseFloat($("#pos_cost_table tbody tr:nth-child(3) td:nth-child(2)").text());
    totaltax = (parseFloat(taxrate) / 100) * newsubtotal;
    document.getElementById("tax_rate").innerHTML = numeral(totaltax).format('0,0.00');

    var grandtotal = newsubtotal + totaltax - totaldiscount;
    document.getElementById("pos_grandtotal").innerHTML = numeral(grandtotal).format('0,0.00');

    return grandtotal;
}


/**
 * Add item units on POS list
 */
$("table#pos_table #items_tbody").on('click', ".addunit", function (event) {
    event.preventDefault();
    var units = parseInt($(this).closest('td').next('td').html());
    var id = $(this).closest('tr').find('td:nth-child(1)').text();
    var stockqty = 0;

    $.ajax({
        url: "pos/" + id,
        type: "get",
        success: (data) => {
            stockqty = data.quantity;
            if (parseInt(stockqty) > units) {
                var qty = parseInt(units) + 1;
                $(this).closest('td').next('td').html(qty);
                getSalestotal();
                $("#msg_success").show().delay(3000).hide(1);
                $(".global_msg").text("Quantity added.");
            } else {
                $("#msg_error").show().delay(3000).hide(1);
                $(".global_msg").text("Product quantity is not enough.");
            }

        }
    });


});

/**
 * Subtract item units
 */
$("#items_tbody").on('click', ".subtractunit", function (event) {
    event.preventDefault();
    var units = $(this).closest('td').prev('td').html();
    if (parseInt(units) <= 1) { 
        $("#msg_error").show().delay(3000).hide(1);
        $(".global_msg").text("Minimum of 1 unit is required.");
    }
    else { 
        $(this).closest('td').prev('td').html(parseInt(units) - 1); 
        $("#msg_success").show().delay(3000).hide(1);
        $(".global_msg").text("1 unit removed.");
    }
    getSalestotal();
});

/**
 * Apply discount
 */
$("#pos_cost_table").on("input", "td[contenteditable]", function () {
    getSalestotal();
});

/**
 *  Remove item from POS list
 */
var interval;
$("#items_tbody").on('click', ".positem_remove", function (event) {
    $(this).closest('tr').remove(); var list = 0;
    list = document.getElementById("pos_table").rows.length;

    interval = setInterval(disablePOSbtns, 500);
    getSalestotal();
});
function disablePOSbtns() {

    //var pos_list = $("#pos_table");
    var currCount = $("#pos_table>tbody>tr").length;
    if (currCount < 1) {
        $(".posactivitybtn").prop('disabled', true);
        clearInterval(interval);
        // console.log(currCount);
    }

}
/**
 * clear POS list
 */

$("#clearposbtn").on('click', function () {
    $("#pos_table tbody tr").remove();
    $('.posactivitybtn').prop('disabled', true);

    getSalestotal();
});



/**
 * Switch POS Views
 */

$("#transactbtn").on("click", function () {
    var totalsale = document.getElementById("pos_grandtotal").innerHTML;

    if (totalsale < 1) {
        $("#msg_error").show().delay(3000).hide(1);
        $(".global_msg").text("Please add items to cart");
    } else {

        $("#pos_view").hide().slideUp();
        $("#transact_view").slideDown();
        $("#payment").focus();
        $("#cashtotal").text(numeral(totalsale).format("0,00.00"))
    }

});
$("#exittransbtn").on("click", function () {
    $("#transact_view").hide().slideUp();
    $("#pos_view").slideDown();
});

/**
 * Cash entry calculate balance
 */

$("#payment").on("keyup change", function () {
    var amountpaid = parseFloat(numeral($(this).val()).format("0.00"));
    var saletotal = parseFloat(numeral($("#cashtotal").text()).format("0.00"));
    var balance = amountpaid - saletotal;
    $("#cashbalance").text(numeral(balance).format("0,00.00"));
    balance >= 0 && saletotal > 0 ? $("#executebtn").prop('disabled', false) : $("#executebtn").prop('disabled', true);
});


/**
 * EXECUTE TRANSACTION
 */
$("#executebtn").on('click', function (event) {
    var payment = parseFloat($("#payment").val());
    var payment_mode = "Cash";

    completeTransaction(payment, payment_mode, "cash");
});

/**
 * HOLD TRANSACTION
 */

$("#holdtransactionbtn").on('click', function (event) {
    completeTransaction(0, "None", "hold");
});


//Complete POS Transaction
function completeTransaction(payment, payment_mode, transaction_type) {
    /**GET TRANSACTED ITEMS */
    var sale_data = [];
    var rows = $("#pos_cost_table tbody tr").length;
    $("#pos_table tbody tr").each(function () {
        let item_sale = {
            product_id: $(this).find("td:nth-child(1)").text(),
            units: $(this).find("td:nth-child(4)").text(),
            unitprice: $(this).find("td:nth-child(6)").text(),
            subtotal: parseFloat($(this).find("td:nth-child(6)").text()) * parseFloat($(this).find("td:nth-child(4)").text())
        }
        sale_data.push(item_sale);
    });

    //get  tranaction totals

    var subtotal = parseFloat(numeral($("#pos_cost_table tbody tr:nth-child(1) td:nth-child(2)").text()).format('0.00'));
    var discount = parseFloat(numeral($("#pos_cost_table tbody tr:nth-child(2) td:nth-child(3)").text()).format('0.00'));
    var taxrate = parseFloat($("#pos_cost_table tbody tr:nth-child(3) td:nth-child(2)").text());
    var grandtotal = parseFloat(numeral($("#pos_cost_table tbody tr:nth-child(4) td:nth-child(2)").text()).format('0.00'));
    var status;
    transaction_type == "hold" ? status = 0 : status = 1;

    let transaction = {
        subtotal: subtotal, discount: discount,
        taxrate: taxrate, grandtotal: grandtotal,
        payment: payment, payment_mode: payment_mode,
        status: status
    };

    $.ajax({
        method: 'post',
        data: { "transaction": transaction, "sale_data": sale_data },
        url: "pos/transact",
        dataType: "json",
        beforeSend: function () {
            $("#msg_panel").show();
            $(".global_msg").text("Transacting. Please wait...");
           
        },
        success: (data) => {
            $("#msg_panel").hide();
            $(".global_msg").text(data.message);

            if(data.status=="success"){
             $("#msg_success").show().delay(3000).hide(1);
             transaction_type == "hold" ? $(".global_msg").text("Transaction kept on hold.") : $(".global_msg").text(data.message);
             $("#payment").val(''); $("#payment").focus();
             $("#cashtotal").text('0.00');
             $("#cashbalance").text('0.00');
             $("#executebtn").prop('disabled', true);

             if (transaction_type == "cash" || transaction_type == "mpesa") {
                 printReceipt(data.transaction_id);
             }
            setTimeout(function(){
                $("#pos_table tbody tr").remove();
                $('.posactivitybtn').prop('disabled', true);
            },3000);
           }else{
            $("#msg_error").show().delay(3000).hide(1);
           }
        }
    });
}

/**
 * SEARCH PRODUCT IN POS
 */

$("#searchitem").on('change keyup paste', function () {
    let searchphrase = $(this).val();
    //alert(searchphrase);
    var msg = "<h4>No product found.</h4>";
    if (searchphrase == null || searchphrase == '') {

        $("#searchresultview").html(msg);
    } else {
        $("#products_list").hide();
        $("#searchresultview").show();
        $.ajax({
            method: "get",
            url: "pos/search/" + searchphrase,
            dataType: "html",
            success: (data) => {
                var star_rating = "";

                data ? $("#searchresultview").html(data) : $("#searchresultview").html(msg);
            }
        });
    }
});

/**
 * Category search button
 */
$(".category_search").on("click", function (event) {
    event.preventDefault();
    var category = $(this).text();
    // alert(category);
    $.ajax({
        method: "get",
        url: "pos/search/" + category,
        dataType: "html",
        success: (data) => {
            var star_rating = "";
            $("#products_list").hide();
            $("#searchresultview").show();
            data ? $("#searchresultview").html(data) : $("#searchresultview").html(msg);
        }
    });

});

/**
 * Apply star rating to products view in POS
 */
$(document).ready(function () {
    $(function () {
        $('span.stars').stars();
    });
});



/**
 * Set Product Image background in Products
 */

    $(".modal-content").on("change","#image", function(){
        const filechooser = document.getElementById("image");
        if (filechooser) {
            //filechooser.addEventListener('change', readURL, true);
            var file = document.getElementById("image").files[0];
            var reader = new FileReader();
            reader.onloadend = function () {
                document.getElementById("productimage").style.backgroundImage = "url(" + reader.result + ")";
            }
            if (file) {
                reader.readAsDataURL(file);
            }
        }
    });
   
/**
 * Store logo
 */
   
$("#logo").on("change", function(){
    const filechooser = document.getElementById("logo");
    if (filechooser) {
        //filechooser.addEventListener('change', readURL, true);
        var file = document.getElementById("logo").files[0];
        var reader = new FileReader();
        reader.onloadend = function () {
            document.getElementById("logo_display").style.backgroundImage = "url(" + reader.result + ")";
            $("#logo_display").show();
        }
        if (file) {
            reader.readAsDataURL(file);
        }
    }
});


/**
 * Search item by SKU in products page
 */
$("#sku").on("change paste keyup", function () {
    var sku = $(this).val();

    $.ajax({
        method: "get",
        url: "products/edit/" + sku,
        dataType: "json",
        success: function (data) {
            if (data.length != 0) {
                console.log(data);
                $("#title").val(data[0].title);
                $("select#category").val(data[0].category_id).change();
               
                $("#unitprice").val(data[0].unit_price);
                $("#discount").val(data[0].discount);
                $("select#tax_id option:selected").val(data[0].tax_id);
                $("select#tax_id option:selected").text(data[0].tax.title);
                $("#stock_notice").val(data[0].stock_notice);

                $("select#status").val(data[0].status).change();
                $("select#status").text(data[0].status ? "Active" : "Locked");

                $("select#rating option:selected").val(data[0].rating);
                $("select#rating option:selected").text(data[0].rating + " Star");
                $("#productimage").css('background-image', 'url(public_uploads/' + data[0].image + ')');
            } else {
                $(".prod-input").val('');
                $(".prod-select option").each(function () {
                    if (this.defaultSelected) {
                        this.selected = true;
                    }
                });
            }

        }
    });
});


/**
 * Submit product edit form
 */
$(document).ready(function () {
    $("#product_form").parsley();
    $(".modal-content").on('submit', '#product_form', function (event) {

        event.preventDefault();
        if ($('#product_form').parsley().isValid()) {
            var formData = new FormData(this);

            $.ajax({
                url: "products/store",
                method: 'post',
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function () { 
                    $("#msg_panel").hide();
                    $(".global_msg").text("Updating...");
                },
                success: function (data) {

                    $("#msg_panel").hide();
                    $(".global_msg").text(data.message);
                    if(data.status=="success"){
                     $("#msg_success").show().delay(3000).hide(1);
                     $('#product_form')[0].reset();
                     $('#product_form').parsley().reset();
                     $("#productimage").css('background-image', 'url(public_uploads/box.png)');
                    setTimeout(function(){
                        location.reload();
                    },3000);
                   }else{
                    $("#msg_error").show().delay(3000).hide(1);
                   }
                }
            });
        }
    });
});

/**
 * Product management  search
 */
$("#search_item").on('change keyup paste', function () {
    var phrase = $(this).val();
    if($(this).val()){
  
    $("#products_list").html('');
    $.ajax({
        method: "get",
        url: "products/search/" + phrase,
        dataType: "html",
        success: function (data) {
            console.log(data);
            if (data.length>0) {
                $("#products_list").html(data);
            }else{
                var msg = "<h5 class='text-danger'>No results found.</h5>";
                $("#products_list").html(msg);
            }
        }
    });
}
});


/**
 * Transaction history table click
 */
$("#transactions_table ").on('click', 'tbody tr', function (e) {
    var str = $(this).find("td:nth-child(1)").text();
    var trans_id = str.substring(1);
    //alert(trans_id);
    $(this).hasClass('current') ? $(this).removeClass('current') : $(this).addClass('current');

    $.ajax({
        url: "sales/transaction/" + trans_id,
        method: "get",
        dataType: "html",
        success: (data) => {
            console.log(data);
            // $("#trans_data").html(data);
            $(".card-info").show();
            $("#trans_data").html(data);
        }
    });
});



/**
 * Fetch pending transaction by id
 */

$("#held_transactions_table").on("click", 'tbody tr', function (event) {
    let str = $(this).find("td:nth-child(1)").text();
    var trans_id = str.substring(1);
    $.ajax({
        url: "sales/transaction/" + trans_id,
        method: "get",
        dataType: "html",
        success: (data) => {
            $("#print-receipt-btn").hide();
            $(".card-info").show();
            $("#held_trans_data").html(data);
        }
    });
});

/**
 * Complete Held Transaction
 */
$("#held_trans_data").on('click', '#complete-trans-btn', function () {
    var str = $("#transaction_id").text()
    var trans_id = str.substring(1);
    $.ajax({
        url: "sales/finalize/" + trans_id,
        method: "post",
        dataType: "json",
        beforeSend:function(){
            $("#msg_panel").show();
            $(".global_msg").text("Completing transaction...");
        },
        success: (data) => {
            printReceipt(trans_id);
            
            $("#msg_panel").hide();
            $(".global_msg").text(data.message);
            if(data.status=="success"){
             $("#msg_success").show().delay(3000).hide(1);
           
            setTimeout(function(){
                location.reload();
            },3000);
           }else{
            $("#msg_error").show().delay(3000).hide(1);
           }

        }
    });
});

/**
 * delete pending transaction 
 */
$("#held_trans_data").on('click', '#delete-trans-btn', function () {
    var str = $("#transaction_id").text();
    var trans_id = str.substring(1);
    $.ajax({
        url: "sales/delete/" + trans_id,
        method: "post",
        dataType: "json",
        beforeSend:function(){
            $("#msg_panel").show();
            $(".global_msg").text("Deleting...");
        },
        success: (data) => {
            printReceipt(trans_id);

            $("#msg_panel").hide();
            $(".global_msg").text(data.message);
            if(data.status=="success"){
             $("#msg_success").show().delay(3000).hide(1);
           
            setTimeout(function(){
                location.reload();
            },3000);
           }else{
            $("#msg_error").show().delay(3000).hide(1);
           }

          
        }
    });
});

/**
 * search sales history
 */
$("#searchhistory").on("change keyup paste", function () {
    $("#transactions_table tbody tr").remove();

    var trans_id = $(this).val();
    searchTransaction(trans_id, "sales_history");

});

//search pending sales
$("#searchpendingsales").on("change keyup paste", function () {

    var trans_id = $(this).val();
    searchTransaction(trans_id, "pending_sales");

});


function searchTransaction(id, trans_type) {

    return $.ajax({
        url: "sales/search/" + id,
        method: "get",
        dataType: "html",
        cache: false,
        success: (data) => {
            trans_type == "sales_history" ?
                $("#transactions_table tbody").html(data) :
                $("#held_transactions_table tbody").html(data);
        }
    });

}



/**
 * fetch items in a Product Request 
 */
$("#requests_table tbody").on("click",'tr',function(){
    
    var str = $(this).find("td:nth-child(1)").html();
    var request_id = str.substring(1);
 
    $.ajax({
        method:"get",
        url:"products/request/"+request_id,
        dataType:"html",
        success:(data)=>{
            $("#requested_items").html(data);
        }
    });
});

/**
 * set low stock level
 */
$("#stock_level").on("change paste keyup",function(){
    if($(this).val()>0){
        $("#stock_limit_btn").prop('disabled',false);
    }else{
        $("#stock_limit_btn").prop('disabled',true);
    }
});
$("#stock_limit_btn").on("click",function(event){
    event.preventDefault();

    var formdata = new FormData();
  
    var formdata = {'low_stock_level':$("#stock_level").val()};
   
   // console.log(formdata);
    $.ajax({
        url: "setting/update",
        method: 'post',
        data: formdata,
        dataType: "json",
        beforeSend:function(){
            $(".global_msg").text("Submitting...");
            $("#msg_panel").show();
           
        },
        success:(data)=>{
            $("#msg_panel").hide();
            $(".global_msg").text(data.message);
            if(data.status=="success"){
             $("#msg_success").show().delay(3000).hide(1);
             $("#product_settings_form")[0].reset();
            setTimeout(function(){
                location.reload();
            },3000);
           }else{
            $("#msg_error").show().delay(3000).hide(1);
           }
           
        }
    });
});


/**
 * Cashier Drawer activity
 */

$(".drawer-input").on('change keyup paste',function(){
    var opening_balance = parseFloat($('#opening_balance').val())||0;
    var cash_float = parseFloat($("#cash_float").val() || 0);
    var today_sales = parseFloat(numeral($("#todaysales_amount").val()).format('0.00'));
    var expected_amount = opening_balance + today_sales + cash_float;

    $("#expected_drawer_amount").val(numeral(expected_amount).format('0,000.00'));
});

$("#counted_drawer_amount").on('change keyup paste',function(){
    var counted_drawer_amount = $(this).val()||0;
$('#total_drawer_amount').val(numeral(counted_drawer_amount).format('0,000.00'));
var expected_amount = parseFloat(numeral($('#expected_drawer_amount').val()).format('0.00'))
var cash_balance  =  parseFloat(counted_drawer_amount) - expected_amount;
cash_balance>=0 ? $("#cash_balance").css({'color':'green'}) : $("#cash_balance").css({'color':'red'});
$("#cash_balance").val(numeral(cash_balance).format('0,000.00'));

});


//Submit drawer form
$("#drawer_form").on("submit",function(event){
    event.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        method:'post',
        url:"/close_drawer",
        data:formData,
        dataType:"json",
        beforeSend:function(){
            $("#msg_panel").show();
            $(".global_msg").text("Closing drawer. Please wait...");
        },
        processData:false,
        contentType:false,
        success: (data)=>{
            if(data.status == "success"){
                $("#msg_panel").hide();
                $(".global_msg").text(data.message);
                if(data.status=="success"){
                 $("#msg_success").show().delay(3000).hide(1);
                setTimeout(function(){
                    location.reload();
                },3000);
               }else{
                $("#msg_error").show().delay(3000).hide(1);
               }
            }
        }

    });
});

/**
 * View drawer history
 */
$("#viewhistorybtn").on('click',function(){
    $("#drawer").slideUp('slow');
    $("#drawer_history").slideDown();
    var count =  $("#drawer_history_table tbody tr").length;
    if(count==0){
   // fetch drawer history data for datatable
   $("#drawer_history_table").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "cashier/drawerhistory_data",
      type: "GET",
      dataType: "json"
    },
    columns: [
    
      { data: 'created_at', type: 'num', render: { _: 'display', sort: 'timestamp' } },
      { data: 'opening_balance', name: 'opening_balance' },
      { data: 'cash_float', name: 'cash_float' },
      { data: 'today_sales', name: 'today_sales' },
      { data: 'expected_amount', name: 'expected_amount' },
      { data: 'counted_amount', name: 'counted_amount' },
      { data: 'remark', name: 'remark' },
      { data: 'cash_balance', name: 'cash_balance' },

    ],
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]

  });
}
});

$("#exit_history_btn").on('click',function(){
    $("#drawer").slideDown('slow');
    $("#drawer_history").slideUp();
});

/**
 * New discount
 */
$("#new_discount").on('click',function(){
    $("#discounts_section").slideDown('slow');
    $(".disc_action_type").text("New Discount");
    $("#discount_code").focus();
    $("#discount_code").attr('readonly',false);
    $("#discount_code").css({"background-color":"inherit"});
    $("#discounts_form")[0].reset();
});

/**
 * Save a discount or promotion
 */
$("#discounts_form").on("submit",function(event){
    event.preventDefault();
    $(this).parsley();
    if($(this).parsley().isValid()){
        var formdata = new FormData();
        formdata.append('code',$("#discount_code").val());
        formdata.append('title',$("#discount_title").val());
        formdata.append('rate',$("#discount_rate").val());
        formdata.append('status',$('input[name="vbtn-radio"]:checked').val());

        console.log(JSON.stringify(formdata));

        $.ajax({
            url: 'settings/update_discount',
            data: formdata,
            contentType: false,
            processData: false,
            type: 'POST',
            beforeSend:function(){
                $("#msg_panel").show();
                $(".global_msg").text("Saving. Please wait...");
            },
            success: function(data){
                $("#msg_panel").hide();
                $(".global_msg").text(data.message);
                if(data.status=="success"){
                 $("#msg_success").show().delay(3000).hide(1);
                setTimeout(function(){
                    location.reload();
                },3000);
               }else{
                $("#msg_error").show().delay(3000).hide(1);
               }
            }
        });
    }
});

/**Show / View Discounts */
$("#viewdiscountbtn").on("click",function(){
    $("#discounts_section").slideUp('slow');
    $("#discounts_list").slideDown('slow');
    
});

/**
 * Edit discount list hover
 */
$(".disc_list").on("mouseenter",'.card-discount', function(){
    $(this).find(".edit_discount").show('slow');
}).on('mouseleave','.card-discount',function(){
    $(this).find(".edit_discount").hide('slow');
});
/**
 * Edit discount
 */
$(".disc_list").on("click",'.card-discount', function(){
    
    $("#discounts_section").show('slow');
    var disc_code = $(this).find(".disc_id").text();
   
    var disc_title = $(this).find(".disc_title").text();
    var str = $(this).find(".disc_rate").text();
    var disc_rate = str.match(/\d+/);
    $("#discount_code").val(disc_code);
    $("#discount_code").attr('readonly',true);
    $("#discount_code").css({"background-color":"#ccc"});
   $("#discount_title").val(disc_title);
   $("#discount_rate").val(disc_rate);
   
});

/**
 * Delete discount
 */
$("#deletediscountbtn").on("click",function(){
    var disc_code = $("#discount_code").val();
    $.ajax({
        url:"setting/disc_delete/"+disc_code,
        method:"post",
        dataType:"json",
        beforeSend:function(){
            $("#msg_panel").show();
            $(".global_msg").text("Deleting. Please wait...");
        },
        success:(data)=>{
                $("#msg_panel").hide();
                $(".global_msg").text(data.message);

                if(data.status=="success"){
                 $("#msg_success").show().delay(3000).hide(1);
                setTimeout(function(){
                    location.reload();
                },3000);
               }else{
                $("#msg_error").show().delay(3000).hide(1);
               }
        }
    });
});

/**
 * Edit store details
 */
$(".edit_storebtn").on('click',function(){
    $("#store_info").show('slow');
    $("#store_display").hide('slow');
});

/**
 * Update store info
 */
$("#store_info_form").on("submit", function(event){
    event.preventDefault();
    $("#store_info_form").parsley();

    if($("#store_info_form").parsley().isValid()){
        var formdata = new FormData(this);
       // formdata.append('store_name',$("#store_name").val())
       $.ajax({
            url:"settings/store_update",
            method:"post",
            dataType:"json",
            data:formdata,
            processData:false,
            contentType:false,
            beforeSend:function(){
                $("#msg_panel").show();
                $(".global_msg").text("Updating. Please wait...");
            },
            success:(data)=>{
                $("#msg_panel").hide();
                $(".global_msg").text(data.message);
                if(data.status=="success"){
                 $("#msg_success").show().delay(3000).hide(1);
                setTimeout(function(){
                    location.reload();
                },3000);
               }else{
                $("#msg_error").show().delay(3000).hide(1);
               }
            }

       });
    }
});

/**
 * Toggle users list card view
 */
$(".list_view").on('click',function(){
    $("#users_list").show('slow');
    $("#card-view").hide('slow');
});

$(".card_view").on('click',function(){
    $("#users_list").hide('slow');
    $("#card-view").show('slow');
});

//new user form display
$(".new_user").on("click",function(){
    $(".manage_user").show('slow');
    $("#user_form")[0].reset();
});

/**
 * Edit User list hover
 */
$(".users_list").on("mouseenter",'.card-template', function(){
    $(this).find(".edit_btn").show('slow');
}).on('mouseleave','.card-template',function(){
    $(this).find(".edit_btn").hide('slow');
});

/**
 * Edit user click
 */
$(".users_list").on("click",'.card-template', function(){
    $(".manage_user").show('slow');
    var email = $(this).find(".user_email").text();
    $("#useremail").val(email); 

    var name = $(this).find(".user_name").text();
    $("#name").val(name);

    var role = $(this).find(".user_role").text();
    $("#role").val(role).change();
});

/**
 * Submit user form
 */
$("#user_form").on("submit",function(event){
    event.preventDefault();
    if($("#user_form").parsley().isValid()){
    var formdata = new FormData(this);
    $.ajax({
        url:"settings/new_user",
        method:"post",
        data:formdata,
        processData:false,
        contentType:false,
        dataType:"json",
        beforeSend: function () { 
            $("#msg_panel").show();
            $(".global_msg").text("Submitting. Please wait...");
        },
        success:(data)=>{
            $("#msg_panel").hide();
            $(".global_msg").text(data.message);
            if(data.status=="success"){
                $("#msg_success").show().delay(3000).hide(1);
                setTimeout(function(){
                    location.reload();
                },3000);
            }else{
                $("#msg_error").show().delay(3000).hide(1);
            }
        }
    });
}
});

/**
 * Change password
 */
$("#change_password_form").on("submit",function(event){
    event.preventDefault();

    if($("#change_password_form").parsley().isValid()){
        var new_pword = $("#new_password").val();
        var confirm_pword = $("#confirm_password").val();

        if(new_pword !== confirm_pword ){
            $("#global_msg").text("Passwords do not match");
            $("#msg_panel").show();
            $("#msg_panel").delay(3000).hide(1);
           
            
        }else{
            var formdata = new FormData(this);
            $.ajax({
                url:"settings/update_pword",
                method:"post",
                data:formdata,
                dataType:"json",
                processData:false,
                contentType:false,
                beforeSend:function(){
                    $("#msg_panel").show();
                    $(".global_msg").text("Updating...");
                },
                success:(data)=>{
                    $("#msg_panel").hide();
                    $(".global_msg").text(data.message);
                    if(data.status=="success"){
                        $("#msg_success").show().delay(3000).hide(1);
                        setTimeout(function(){
                            $("#change_password_form")[0].reset();
                        },3000);
                    }else{
                        $("#msg_error").show().delay(3000).hide(1);
                    }
                }

            });
        }

    }
});

/**
 * Print POS receipt 
 */

$("#trans_data").on('click', '#print-receipt-btn', function () {
    //alert("printed");
    var str = $("#transaction_id").text();
    var transaction_id = str.substring(1);

    printReceipt(transaction_id);
});

function printReceipt(transaction_id) {
    $.ajax({
        url: "sales/receipt/" + transaction_id,
        method: "get",
        dataType: "html",
        success: (data) => {
            var mywindow = window.open('', 'new div', 'height=600,width=800');
            mywindow.document.title = "receipt no. " + transaction_id;
            mywindow.document.write('<html><head><title>receipt no.' + transaction_id+'</title>');
            mywindow.document.write('<style>@page{size:auto; margin: 0mm;}</style><link rel="stylesheet" href="http://localhost:8000/assets/scss/receipt.scss" type="text/css" media="print"/>');
            mywindow.document.write('</head><body onload="window.print();window.close()">');
            mywindow.document.write(data);
            mywindow.document.write('</body></html>');
            mywindow.document.close();
            mywindow.focus();
            setTimeout(function () {
                mywindow.print();
            }, 5000);
            //  mywindow.close();
            return true;
        }
    });
}





/**
 * Close modal.  When the user clicks anywhere outside of the modal, close it
 */

var modal = document.getElementById("main_modal");
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

/**
 * Random colors
 */
const randomColor = "#"+((1<<24)*Math.random()|0).toString(16); 
document.documentElement.style.setProperty('--randombg', randomColor);

