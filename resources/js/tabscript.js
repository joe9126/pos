$(document).ready(function () {

  $(".tablinks").on('click', function () {
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

    $("#" + clickedtab).show();
    $(this).addClass('active');

    switch (clickedtab) {
      case "low_stock":
        getLowstockproducts();
        break;
      case "restock_request":
        getRestockrequests();
        break;
      case "product_settings":
        $("#low_stock_limit").focus();
        break;
      case "today_sales":
        getCashiertodaysales();
        break;
      case "sales_history":
        getCashierhistory();

    }
  });


});

/**
 * get Low stock products. Function called when tab low stock products on products page is clicked. 
 * JS Script on tabscript.js
 */
function getLowstockproducts() {
  $.ajax({
    method: "get",
    url: "products/low_stock",
    dataType: "html",
    success: (data) => {
      if (data.length > 0) {
        $("#low_stock_list").html(data);
      } else {
        var msg = "<h5 class='text-success'>No record found. All's good!</h5>";
        $("#low_stock_list").html(msg);
      }

    }
  });
}

function getRestockrequests() {
  $.ajax({
    method: "get",
    url: "products/restock_requests",
    dataType: "html",
    success: (data) => {
      if (data.length > 0) {
        $("#requests_table_tbody").html(data);
      } else {
        var msg = "<h5 class='text-success'>No record found.</h5>";
        $("#requests_table_tbody").html(msg);
      }

    }
  });
}

// fetch cashier today's sales for datatable
function getCashiertodaysales() {
  $.ajax({
    method: "GET",
    url: "cashier/sales",
    dataType: "html",
    success: (data) => {
      if (data.length > 0) {
        $("#cashiersalesinfo").html(data);
        
        $("#cashier_todaysales_table").DataTable({
          processing: true,
          serverSide: true,
          ajax: {
            url: "cashier/today_sales_data",
            type: "GET",
            dataType: "json"
          },
          columns: [
            { data: 'id', name: 'id' },
            { data: 'created_at', type: 'num', render: { _: 'display', sort: 'timestamp' } },
            { data: 'subtotal', name: 'subtotal' },
            { data: 'discount', name: 'discount' },
            { data: 'taxrate', name: 'taxrate' },
            { data: 'grandtotal', name: 'grandtotal' },
            { data: 'payment_mode', name: 'payment_mode' },

          ]

        });
      } 

    }
  });
}

// fetch cashier sales for datatable
function getCashierhistory() {
  $.ajax({
    method: "get",
    url: "cashier/history",
    dataType: "html",
    success: (data) => {
      if (data.length > 0) {
        $("#sales_history").html(data);
       
        $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
            url: "cashier/history_data",
            type: "GET",
            dataType: "json"
          },
          columns: [
            { data: 'id', name: 'id', width:"12%" },
            { data: 'created_at', type: 'num', render: { _: 'display', sort: 'timestamp' } },
            { data: 'subtotal', name: 'subtotal' },
            { data: 'discount', name: 'discount' },
            { data: 'taxrate', name: 'taxrate' },
            { data: 'grandtotal', name: 'grandtotal' },
            { data: 'payment_mode', name: 'payment_mode', width:'15%' },

          ]
        });
      } else {
        var msg = "<h5 class='text-success'>No record found.</h5>";
        $("#sales_history").html(msg);
      }

    }
  });
}


//number formatter
function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, ',');
} 