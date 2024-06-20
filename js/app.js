(function($){
    $(document).on('click', '#addCart', function(event){
        event.preventDefault();
        var url = $(this).find('a').attr('href'); // Get the href attribute of the <a> tag inside the button
        $.get(url, {}, function(data){
            console.log(data);
            // Handle the response data
            if (!data.error) {
                // Update cart quantity and total amount
                $('#upCartQty').text(data.upCartQty);
                $('#upCartTotal').text('Total : ' + data.upCartTotal + ' €');

                // Show the cart icon and quantity indicator if it was hidden
                $('#cartIcon').css('display', 'block');
                $('#upCartQty').css('display', 'block');
                $('#upCartTotal').css('display', 'block');

            } else {
                alert('Error: ' + data.message);
            }
        }, 'json');
        return false;
    });

    $(document).ready(function() {
        $('.quantity-increase').on('click', function() {
            var container = $(this).closest('[data-product-id]');
            var productId = container.data('product-id');
            updateCart(productId, 'increase');
        });

        $('.quantity-decrease').on('click', function() {
            var container = $(this).closest('[data-product-id]');
            var productId = container.data('product-id');
            updateCart(productId, 'decrease');
        });

        function updateCart(productId, action) {
            $.ajax({
                url: 'update_cart.php',
                type: 'POST',
                data: {
                    product_id: productId,
                    action: action
                },
                dataType: 'json',
                success: function(data) {
                    if (!data.error) {
                        // Update the displayed quantity
                        var quantityDisplay = $('[data-product-id="' + productId + '"]').find('.quantity-display');
                        quantityDisplay.text(data.newQuantity);

                        // Update the cart totals (quantity and total amount)
                        $('#upCartQty').text(data.upCartQty);
                        $('#upCartTotal').text('Total : ' + data.upCartTotal + ' €');
                    } else {
                        alert('Error: ' + data.message);
                    }
                },
                error: function() {
                    alert('Error updating cart.');
                }
            });
        }
    });
})(jQuery);
