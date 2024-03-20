$(document).ready(function(){

  $(".tablinks").on('click',function(){
      var current_class = $(this).attr('class');
      
      var str = current_class.split(" ");
      var clickedtab = str[1];
    
       // Declare all variables
    var i, tabcontent, tablinks;
  
    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
  
      // Show the current tab, and add an "active" class to the button that opened the tab
    
     $("#"+clickedtab).show();
      $(this).addClass('active');
   
      switch(clickedtab){
        case "low_stock":
          getLowstockproducts();
          break;
        case "restock_request":
          getRestockrequests();
          break;
        case "product_settings":
          $("#low_stock_limit").focus();
          break;
      }
  });


});

/**
 * get Low stock products. Function called when tab low stock products on products page is clicked. 
 * JS Script on tabscript.js
 */
function getLowstockproducts(){
  $.ajax({
      method:"get",
      url:"products/low_stock",
      dataType:"html",
      success:(data)=>{
          if(data.length>0){
              $("#low_stock_list").html(data);
          }else{
              var msg = "<h5 class='text-success'>No record found. All's good!</h5>";
              $("#low_stock_list").html(msg);
          }
        
      }
  });
}

function getRestockrequests(){
  $.ajax({
    method:"get",
    url:"products/restock_requests",
    dataType:"html",
    success:(data)=>{
        if(data.length>0){
            $("#requests_table_tbody").html(data);
        }else{
            var msg = "<h5 class='text-success'>No record found.</h5>";
            $("#requests_table_tbody").html(msg);
        }
      
    }
});
}