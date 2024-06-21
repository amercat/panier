<?php
require '../vendor/autoload.php';

use Stripe\Stripe;
use Stripe\Checkout\Session;

// Load your Stripe secret key
$STRIPE_SECRET_KEY = 'sk_test_51P8m082LU5ioWwchSHn7MymaDbnHk2bI252tWGfGaka7CqspiOjvuVebBJ8p3j6RVh1aGzKnh8FInqAqx9QyaigB00JvEfQVG4';

// Set the API key
Stripe::setApiKey($STRIPE_SECRET_KEY);

// Retrieve the session ID from the query string
$sessionId = $_GET['session_id'] ?? '';

if (!$sessionId) {
    echo 'Invalid session ID.';
    exit();
}

try {
    // Retrieve the session details from Stripe
    $session = Session::retrieve($sessionId);

    // Retrieve the customer details
    $customerDetails = $session->customer_details;
    $lineItems = $session->line_items->data;

    // Output the session details
    $paymentIntent = $session->payment_intent;
    $paymentIntentDetails = \Stripe\PaymentIntent::retrieve($paymentIntent);

} catch (\Exception $e) {
    echo 'Error retrieving session details: ' . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4CAF50;
        }
        .details {
            margin-top: 20px;
        }
        .details h2 {
            color: #333;
        }
        .details p {
            margin: 5px 0;
        }
        .line-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .line-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Payment Réussi!</h1>
    <p>Merci pour votre paiement, voici le détail de votre transaction :</p>

    <div class="details">
        <h2>Détail de la Transaction</h2>
        <p><strong>Session ID:</strong> <?= htmlspecialchars($session->id) ?></p>
        <p><strong>Payment Intent ID:</strong> <?= htmlspecialchars($paymentIntentDetails->id) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($paymentIntentDetails->status) ?></p>
        <p><strong>Montant Payé:</strong> <?= number_format($paymentIntentDetails->amount_received / 100, 2) ?> <?= htmlspecialchars($paymentIntentDetails->currency) ?></p>
        <p><strong>Méthode de paiement:</strong> <?= htmlspecialchars($paymentIntentDetails->charges->data[0]->payment_method_details->type) ?></p>

        <h2>Customer Details</h2>
        <p><strong>Email:</strong> <?= htmlspecialchars($customerDetails->email) ?></p>
        <p><strong>Nom:</strong> <?= htmlspecialchars($customerDetails->name) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($customerDetails->phone) ?></p>
        <p><strong>Addresse:</strong></p>
        <p>
            <?= htmlspecialchars($customerDetails->address->line1) ?><br>
            <?= htmlspecialchars($customerDetails->address->line2) ?><br>
            <?= htmlspecialchars($customerDetails->address->city) ?>,
            <?= htmlspecialchars($customerDetails->address->state) ?>,
            <?= htmlspecialchars($customerDetails->address->postal_code) ?><br>
            <?= htmlspecialchars($customerDetails->address->country) ?>
        </p>

        <h2>Order Details</h2>
        <?php foreach ($lineItems as $item): ?>
            <div class="line-item">
                <p><strong>Product:</strong> <?= htmlspecialchars($item->description) ?></p>
                <p><strong>Quantity:</strong> <?= htmlspecialchars($item->quantity) ?></p>
                <p><strong>Price:</strong> <?= number_format($item->amount_total / 100, 2) ?> <?= htmlspecialchars($item->currency) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
