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
    <link rel="stylesheet" href="../public/tailwind.css">

</head>
<body>
<section class="py-24 relative mt-8">
<div class="w-full max-w-7xl px-4 md:px-5 lg-6 mx-auto">

    <svg viewBox="0 0 24 24" class="text-green-600 w-8 h-8  mx-auto my-6">
        <path fill="currentColor"
              d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z">
        </path>
    </svg>
    <hr class="mt-4">

    <h2 class="font-manrope font-bold text-4xl leading-10 text-black text-center">
        Your Order Confirmed
    </h2>

    <div class="flex items-start flex-col gap-6 xl:flex-row">
    <h6 class="font-manrope font-bold text-4xl leading-10 text-black text-center">Bonjour <?= htmlspecialchars($customerDetails->name) ?></h6>

        <h1 class="font-manrope font-bold text-4xl leading-10 text-black text-center">Payment Réussi!</h1>
        <p class="mt-4 font-normal text-lg leading-8 text-gray-500 mb-11 text-center">Merci pour votre paiement, voici le détail de votre transaction :</p>

    <div class="p-6 border border-gray-200 rounded-3xl w-full group transition-all duration-500 hover:border-gray-400 ">

        <div class="p-6 border border-gray-200 rounded-3xl w-full group transition-all duration-500 hover:border-gray-400">
            <h2 class="text-xl font-semibold text-gray-800 border-b pb-2">Détail de la Transaction</h2>
            <p><strong>Session ID:</strong> <?= htmlspecialchars($session->id) ?></p>
            <p><strong>Payment Intent ID:</strong> <?= htmlspecialchars($paymentIntentDetails->id) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($paymentIntentDetails->status) ?></p>
            <p><strong>Montant Payé:</strong> <?= number_format($paymentIntentDetails->amount_received / 100, 2) ?> <?= htmlspecialchars($paymentIntentDetails->currency) ?></p>
            <p><strong>Méthode de paiement:</strong> <?= htmlspecialchars($paymentIntentDetails->charges->data[0]->payment_method_details->type) ?></p>

            <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mt-6">Customer Details</h2>
            <p><strong>Email:</strong> <?= htmlspecialchars($customerDetails->email) ?></p>
            <p><strong>Nom:</strong> <?= htmlspecialchars($customerDetails->name) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($customerDetails->phone) ?></p>
            <p><strong>Adresse:</strong></p>
            <p class="ml-4">
                <?= htmlspecialchars($customerDetails->address->line1) ?><br>
                <?= htmlspecialchars($customerDetails->address->line2) ?><br>
                <?= htmlspecialchars($customerDetails->address->city) ?>,
                <?= htmlspecialchars($customerDetails->address->state) ?>,
                <?= htmlspecialchars($customerDetails->address->postal_code) ?><br>
                <?= htmlspecialchars($customerDetails->address->country) ?>
            </p>

            <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mt-6">Order Details</h2>
            <?php foreach ($lineItems as $item): ?>
                <div class="line-item bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
                    <p><strong>Product:</strong> <?= htmlspecialchars($item->description) ?></p>
                    <p><strong>Quantity:</strong> <?= htmlspecialchars($item->quantity) ?></p>
                    <p><strong>Price:</strong> <?= number_format($item->amount_total / 100, 2) ?> <?= htmlspecialchars($item->currency) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
</div>
    </div>
</section>


</body>

</html>