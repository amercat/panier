<?php
require '_header.php';
header('Content-Type: application/json'); // Set JSON header

$json = array('error' => true);

if(isset($_GET['product_id'])){
    $product_id = $_GET['product_id'];
    $product = $DB->query('SELECT product_id FROM products WHERE product_id = :product_id', array('product_id' => $product_id));
    if(!empty($product)){
        $panier->add($product_id);
        $json['error'] = false;
        $json['message'] = 'Product added to the cart successfully';

        // Calculate total quantity
        $totalQuantity = 0;
        foreach ($_SESSION['panier'] as $productId => $quantity) {
            $totalQuantity += $quantity;
        }

        // Fetch updated grand total
        $grandTotal = $panier->getGrandTotal();
        $grandTotalFormatted = number_format($grandTotal, 2, ',', ',');

        // Update JSON response with cart summary values
        $json['upCartQty'] = $totalQuantity;
        $json['upCartTotal'] = $grandTotalFormatted;
    } else {
        $json['message'] = 'Product not found';
    }
} else {
    $json['message'] = 'No product ID provided';
}

echo json_encode($json);
