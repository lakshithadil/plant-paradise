$(document).ready(function(){
    $(".cart-qty-single").change(function(){
        let getItemID = $(this).data('item-id');
        let qty = $(this).val();
        $.ajax({
            type:'POST',
            url:'ajax_calls.php',
            dataType: 'json',
            data: {action:'update-qty', itemID: getItemID, qty: qty},
            success:function(data){
                if (data.msg == 'success')
                {
                    window.location.href='cart.php';
                }
            }
        });
    });

    $('#emptyCart').click(function(){
        $.ajax({
            type: 'POST',
            url: 'ajax_calls.php',
            dataType: 'json',
            data: {action:'empty',empty_cart:true},
            success:function(data){
                if (data.msg == 'success') {
                    window.location.href = 'cart.php';
                }
            }
        });
    });
});