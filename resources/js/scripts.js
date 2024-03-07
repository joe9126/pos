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
               let item = 
               "<tr>"+
               "<td>"+data.id+"</td>"+
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
 * Add item units
 */
$("#items_tbody").on('click',".addunit",function(event){
        event.preventDefault();
        var units  = $(this).closest('td').next('td').html();
        $(this).closest('td').next('td').html(parseInt(units)+1);
        getSalestotal();
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
      // var transaction_data = [];
       var subtotal = parseFloat(numeral($("#pos_cost_table tbody tr:nth-child(1) td:nth-child(2)").text()).format('0.00'));
       var discount = parseFloat(numeral($("#pos_cost_table tbody tr:nth-child(2) td:nth-child(3)").text()).format('0.00'));
       var taxrate = parseFloat($("#pos_cost_table tbody tr:nth-child(3) td:nth-child(2)").text());
       var grandtotal = parseFloat(numeral($("#pos_cost_table tbody tr:nth-child(4) td:nth-child(2)").text()).format('0.00'));
       
       let transaction = {
                subtotal:subtotal, discount:discount,taxrate:taxrate,grandtotal:grandtotal
            };
      // transaction_data.push(transaction);
           
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
 * SEARCH PRODUCT
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
            data.forEach(element => {
                var itemtile =  '<a href="pos/'+element.id+'" class="item_link">'+
                    '<div class="item-tile p-2 m-1">'+
                        '<div class="d-flex align-items-center justify-content-center" >'+
                            '<img id="prod_image" src="assets/images/box.png" alt="Image" >'+
                        '</div>'+
                       
                        '<h5 class="item_title">'+element.title+'</h5>'+
                        '<h6>'+element.quantity+' units left</h6>'+
                        '<span class="item_cat">'+element.category.title+'</span>'+
                        '<h5 class="item-txt fw-bold"> KES. '+element.unit_price+'</h5>'+
                    '</div>'+
                '</a>';
                $("#products_list").append(itemtile);
            });
        
        }
    });
}
});