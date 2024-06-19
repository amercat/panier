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
})(jQuery);
