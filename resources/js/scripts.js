$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


/**
 * Add item to POS list
 */
$(function(){
    $('#products_list').on("click",'.item_link',function(event){
        event.preventDefault();
        const link =this.href;
        var salestotal=0;
        $.ajax({
            type:'get',
            url:link,
            success:function(data){
               // console.log(data);
               if(data.quantity<1){
                $("#statusalert").addClass("alert-danger");
                $("#statusalert").removeClass("alert-success");
                $("#msg").text("Units not enough.");
                $("#statusalert").show().fadeOut(4000);
            }else{
               let item = 
               "<tr>"+
               "<td class='prodID'>"+data.id+"</td>"+
               "<td>"+data.title+"</td>"+
                "<td>"+
                           "<a href='#' class='addunit'><i class='fa-solid fa-circle-plus text-success'></i></a>"+ 
                "</td>"+
                "<td style='text-align:center'>1</td>"+
                "<td>"+ 
                    "<a href='#' class='subtractunit'><i class='fa-solid fa-circle-minus text-danger'></i></a>"+
                "</td>"+
                 "<td>"+data.unit_price+"</td>"+
                "<td>"+
                       "<div class='col-md-2 d-flex justify-content-end'>"+
                           "<a href='#' class='positem_remove'>"+
                               "<i class='fa-solid fa-circle-xmark'></i>"+
                          "</a>"+
                       "</div>"+
               "</td>"+
           "</tr>";

           var rows = $("table#pos_table >tbody >tr").length ;
           
           if(rows == 0){
            $("#pos_table").find('tbody').append(item);
           }else{
            var match = -1; 
            $("#pos_table tbody tr").each(function(){
                var itemlistid = $(this).find("td:nth-child(1)").html();
              
                if(itemlistid == data.id){
                   match = $(this).index();                   
                    return true;
                }
           });
         
          if(match>-1){
            
                var itemqty = parseInt($("table#pos_table >tbody >tr:nth-child("+(match+1)+") td:nth-child(4)").text()) + 1;
  
                $("#pos_table tbody tr:nth-child("+(parseInt(match+1))+") td:nth-child(4)").text(itemqty);
            }else{
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
 * Calculate POS sales total
 */
function getSalestotal(){
    var itemprice = 0; var itemqty = 0; var itemtotal = 0; var salestotal=0;
    $("#pos_table >tbody >tr").each(function(){
        itemprice = parseFloat(numeral($(this).find("td:nth-child(6)").html()).format("0.0"));
       
        itemqty =  parseFloat(numeral($(this).find("td:nth-child(4)").html()).format("0.0"));
      
        itemtotal = parseFloat(itemprice) * parseFloat(itemqty);
        salestotal += parseFloat(itemtotal);
    });
    document.getElementById("pos_subtotal").innerHTML  = numeral(salestotal).format('0,0.00');
    var discount = parseFloat(numeral($(this).find("td:nth-child(6)").html()).format("0.0")) || 0;
    var newsubtotal = ((100-discount)/100) * salestotal;

    var taxrate = 0; var totaltax=0;
   
    var discountrate = parseFloat($("#pos_cost_table tbody tr:nth-child(2) td:nth-child(2)").text());
    var totaldiscount = newsubtotal * ( discountrate/100);
    document.getElementById("pos_discount").innerHTML  =  numeral(totaldiscount).format('0,0.00');

    taxrate = parseFloat($("#pos_cost_table tbody tr:nth-child(3) td:nth-child(2)").text());
    totaltax = (parseFloat(taxrate)/100) * newsubtotal;
     document.getElementById("tax_rate").innerHTML  =  numeral(totaltax).format('0,0.00');

    var grandtotal = newsubtotal + totaltax - totaldiscount;
    document.getElementById("pos_grandtotal").innerHTML  = numeral(grandtotal).format('0,0.00');
   
    return grandtotal;
}

/**
 * Add item units on POS list
 */
$("table#pos_table #items_tbody").on('click',".addunit",function(event){
        event.preventDefault();
        var units  = parseInt($(this).closest('td').next('td').html());
        var id = $(this).closest('tr').find('td:nth-child(1)').text();
        var stockqty = 0;
        
        $.ajax({
            url:"pos/"+id,
            type:"get",
            success:(data)=>{
                stockqty = data.quantity;
                if(parseInt(stockqty)>units){
                    var qty = parseInt(units)+1;
                    $(this).closest('td').next('td').html(qty);                    
                    getSalestotal();
                }else{
                    $("#statusalert").addClass("alert-danger");
                    $("#statusalert").removeClass("alert-success");
                    $("#msg").text("Units not enough.");
                    $("#statusalert").show().fadeOut(4000);;
                }
               
            }
        });       
        
       
});

/**
 * Subtract item units
 */
$("#items_tbody").on('click',".subtractunit",function(event){
    event.preventDefault();
    var units  = $(this).closest('td').prev('td').html();
    if(parseInt(units)<=1){}
    else{ $(this).closest('td').prev('td').html(parseInt(units)-1);}
    getSalestotal();
});

/**
 * Apply discount
 */
$("#pos_cost_table").on("input","td[contenteditable]", function(){
    getSalestotal();
});

/**
 *  Remove item from POS list
 */
$("#items_tbody").on('click',".positem_remove",function(event){
    $(this).closest('tr').remove();
    getSalestotal();
});

/**
 * clear POS list
 */

$("#clearposbtn").on('click',function(){
    $("#pos_table tbody tr").remove();
});



/**
 * Transact POS
 */

$("#transactbtn").on("click",function(){
    var totalsale = document.getElementById("pos_grandtotal").innerHTML;
  
    if(totalsale<1){
        $("#statusalert").show().fadeOut(4000);
        $("#msg").text("Please add items to cart!");
    }else{
        /**GET TRANSACTED ITEMS */
        var sale_data = []; 
       var rows = $("#pos_cost_table tbody tr").length;
       $("#pos_table tbody tr").each(function(){
        let item_sale =   {
            product_id: $(this).find("td:nth-child(1)").text(),
            units:$(this).find("td:nth-child(4)").text(),
            unitprice: $(this).find("td:nth-child(6)").text(),
            subtotal: parseFloat($(this).find("td:nth-child(6)").text())* parseFloat($(this).find("td:nth-child(4)").text())
        }
         sale_data.push(item_sale);
       });
       
       /**GET TRANSACTION TOTALS */
    
       var subtotal = parseFloat(numeral($("#pos_cost_table tbody tr:nth-child(1) td:nth-child(2)").text()).format('0.00'));
       var discount = parseFloat(numeral($("#pos_cost_table tbody tr:nth-child(2) td:nth-child(3)").text()).format('0.00'));
       var taxrate = parseFloat($("#pos_cost_table tbody tr:nth-child(3) td:nth-child(2)").text());
       var grandtotal = parseFloat(numeral($("#pos_cost_table tbody tr:nth-child(4) td:nth-child(2)").text()).format('0.00'));
       
       let transaction = {
                subtotal:subtotal, discount:discount,taxrate:taxrate,grandtotal:grandtotal
            };
     
           
            $.ajax({
                method:'post',
                data:{"transaction":transaction,"sale_data":sale_data},
                url:"pos/transact",
                dataType:"json",
                beforeSend:function()
                {
                      $("#statusalert").removeClass("alert-danger");
                        $("#statusalert").addClass("alert-primary");
                        $("#msg").text("Transacting. Please wait...");
                        $("#statusalert").css("display","block");
                        $(".spinner-border").css("display","block");
                        
                },
                success:function(data){
                    console.log(data);
                    if(data.status = 'success'){
                        $("#statusalert").removeClass("alert-danger");
                        $("#statusalert").addClass("alert-success");
                        $("#msg").text(data.message);
                        $("#statusalert").show();
                        $(".spinner-border").css("display","none");
                        setTimeout(function(){
                            $("#statusalert").slideUp('slow').fadeOut(function(){
                                window.location.reload();
                            });
                        },4000);
                    }
                }
            });
    }

});


/**
 * SEARCH PRODUCT IN POS
 */

$("#searchitem").on('change keyup paste',function(){
    let searchphrase = $(this).val();
    //alert(searchphrase);
    if(searchphrase ==null || searchphrase == ''){
        $(".item_link").show();
    }else{
    $.ajax({
        method:"get",
        url:"pos/search/"+searchphrase,
        dataType:"json",
        success:function(data){
           
            $(".item_link").hide();
            var star_rating ="";
            data.forEach(element => {
                var rating = element.rating;
                            for(var i=1;i<=rating;i++){
                                star_rating = '<span class = "fa fa-star checked"></span>';
                            }
                            for(var j=1;j<=(5-rating);+j++){
                                star_rating += '<span class = "fa fa-star unchecked"></span>';
                            }
                            var prod_image ="";
                    if(element.image){
                        prod_image =  '<img id="prod_image" src="public_uploads/'+element.image+'" alt="Image" >'
                    }
                    else{
                        prod_image =  '<img id="prod_image" src="public_uploads/box.png" alt="Image" >';
                    }
                var itemtile =  '<a href="pos/'+element.id+'" class="item_link">'+
                    '<div class="item-tile p-2 m-1">'+
                        '<div class="d-flex align-items-center justify-content-center" >'+
                           prod_image+
                        '</div>'+
                       
                        '<h5 class="item_title">'+element.title+'</h5>'+
                        '<h6>'+element.quantity+' units left</h6>'+
                        '<span class="item_cat">'+element.category.title+'</span>'+
                        '<h5 class="item-txt fw-bold"> KES. '+element.unit_price+'</h5>'+
                        '<div class="d-flex justify-content-center">'+
                            '<span class="stars" data-rating="'+element.rating+'" data-num-stars="5" ></span>'+
                        '</div>'+
                    '</div>'+
                '</a>';
                $("#products_list").append(itemtile);
            });
        
        }
    });
}
});


/**
 * Apply star rating to products view in POS
 */
$(document).ready(function(){
    $(function() {
        $('span.stars').stars();
    });
});



/**
 * Set Product Image background in Products
 */
$(document).ready(function(){
    const filechooser = document.getElementById("image");
    if(filechooser){
        filechooser.addEventListener('change',readURL,true);
    }

function readURL(){
    var file = document.getElementById("image").files[0];
    var reader = new FileReader();
    reader.onloadend = function(){
        document.getElementById("productimage").style.backgroundImage = "url("+reader.result+")";
    }
    if(file){
        reader.readAsDataURL(file);
      }else{
      }
}});


/**
 * Search item by SKU in products page
 */
$("#sku").on("change paste keyup",function(){
    var sku = $(this).val();
    $.ajax({
        method:"get",
        url:"products/edit/"+sku,
        dataType:"json",
        success:function(data){
            if(data.length !=0){
                console.log(data);
                $("#title").val(data[0].title);
                $("select#category option:selected").val(data[0].category_id);
                $("select#category option:selected").text(data[0].category.title);
                $("#unitprice").val(data[0].unit_price);
                $("#discount").val(data[0].discount);
                $("select#tax_id option:selected").val(data[0].tax_id);
                $("select#tax_id option:selected").text(data[0].tax.title);
                $("#stock_notice").val(data[0].stock_notice);

                $("select#status option:selected").val(data[0].status);
                $("select#status option:selected").text(data[0].status ? "Active":"Locked");

                $("select#rating option:selected").val(data[0].rating);
                $("select#rating option:selected").text(data[0].rating+" Star");
                $("#productimage").css('background-image','url(public_uploads/'+data[0].image+')');
            }else{
                //$("input[type='text']").not(this).val('');
               // $("#product_form")[0].reset();
            }
           
        }
    });
});


/**
 * Submit product form
 */
$(document).ready(function(){
    $("#product_form").parsley();
    $("#product_form").on('submit',function(event){
       
        event.preventDefault();
        if($('#product_form').parsley().isValid()){
            var formData = new FormData(this);
           
            $.ajax({
                url:"products/store",
                method:'post',
                data:formData,
                dataType:"json",
                contentType:false,
                processData:false,
                beforeSend:function(){},
                success:function(data){
                                       
                    if(data.status=="success"){
                        $("#statusalert").removeClass("alert-danger");
                        $("#statusalert").addClass("alert-success");
                        $('#product_form')[0].reset();
                        $('#product_form').parsley().reset();
                        $("#productimage").css('background-image','url(public_uploads/box.png)');
                    }else{
                        $("#statusalert").addClass("alert-danger");
                        $("#statusalert").removeClass("alert-success");
                    }
                    $("#msg").text(data.message);
                     $("#statusalert").show().fadeOut(4000);
                    
                }
            });
        }
    });
});

/**
 * Stock addition search
 */
$("#search_item").on('change keyup paste',function(){
    var sku = $(this).val();
    $.ajax({
        method:"get",
        url:"products/edit/"+sku,
        dataType:"json",
        success:function(data){
            if(data.length>0){
                $("#stock_sku").val(data[0].sku);
                $("#stock_title").val(data[0].title);
            }
        }
    });
});



/**
 * Submit Add Stock form
 */
$(document).ready(function(){
    $("#addstockform").parsley();

    $("#addstockform").on('submit',function(event){
        event.preventDefault();
        var formData = new FormData(this);
        if($("#addstockform").parsley().isValid()){
        
          $.ajax({
                 url:"products/update",
                 method:'post',
                 data:formData,
                 dataType:"json",
                 contentType:false,
                 processData:false,
                 contentType:false,
                processData:false,
                beforeSend:function(){
                    $("#msg2").text("Updating. Please wait...");
                    $("#alert").removeClass("alert-danger");
                    $("#alert").addClass("alert-primary");
                     $("#alert").show();
                },
                success:function(data){
                //console.log(data);
                if(data.status=="success"){
                    $("#alert").removeClass("alert-danger");
                    $("#alert").addClass("alert-success");
                    $("#addstockform")[0].reset();
                    $("#addstockform").parsley().reset();
                   
                }else{
                    $("#alert").addClass("alert-danger");
                    $("#alert").removeClass("alert-success");
                }
                    $("#msg2").text(data.message);
                     $("#alert").show().fadeOut(4000);;
            }});
        }
    });
});
