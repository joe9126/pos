

$(".login-control").on("change keyup paste", function () {
    $(".login-control").val() ? $("#loginbtn").prop('disabled', false) : $("#loginbtn").prop('disabled', true);
});