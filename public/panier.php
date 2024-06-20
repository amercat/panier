<?php
require 'header.php';

// Ensure session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Instantiate the Panier class
$panier = new Panier($DB);
?>

<section class="h-screen bg-gray-100 py-12 sm:py-16 lg:py-20">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-center">
            <h1 class="text-2xl font-semibold text-gray-900">Your Cart</h1>
        </div>

        <?php
        // Fetch products in the cart
        $ids = array_keys($_SESSION['panier'] ?? []); // Handle case where session key does not exist
        if (empty($ids)) {
            $products = [];
        } else {
            $products = $DB->query('SELECT * FROM products WHERE product_id IN (' . implode(',', array_map('intval', $ids)) . ')');
        }

        foreach ($products as $product):
            ?>

            <div class="mx-auto mt-8 max-w-2xl md:mt-12">
                <div class="bg-white shadow">
                    <div class="px-4 py-6 sm:px-8 sm:py-10">
                        <div class="flow-root">
                            <ul class="-my-8">
                                <li class="flex flex-col space-y-3 py-6 text-left sm:flex-row sm:space-x-5 sm:space-y-0 items-center">
                                    <div class="shrink-0">
                                        <img class="h-24 w-24 max-w-full rounded-lg object-cover" src="<?= htmlspecialchars($product->img); ?>" alt="" />
                                    </div>

                                    <div class="relative flex flex-1 flex-col justify-between">
                                        <div class="sm:col-gap-5 sm:grid sm:grid-cols-2">
                                            <div class="pr-8 sm:pr-5">
                                                <p class="text-base font-semibold text-gray-900"><?= htmlspecialchars($product->product_name); ?></p>
                                                <p class="mx-0 mt-1 mb-0 text-sm text-gray-400"></p>
                                            </div>

                                            <div class="mt-4 flex items-end justify-between sm:mt-0 sm:items-start sm:justify-end" data-product-id="<?= htmlspecialchars($product->product_id); ?>">
                                                <p class="shrink-0 w-20 text-base font-semibold text-gray-900 sm:order-2 sm:ml-8 sm:text-right"><?= number_format($product->price, 2); ?> €</p>
                                                <div class="sm:order-1 mt-2 sm:mt-0 flex items-center">
                                                    <div class="mx-auto flex h-8 items-stretch text-gray-600">
                                                        <button class="quantity-decrease flex items-center justify-center rounded-l-md bg-gray-200 px-4 transition hover:bg-black hover:text-white">-</button>
                                                        <div class="quantity-display flex w-full items-center justify-center bg-gray-100 px-4 text-xs uppercase transition"><?= $_SESSION['panier'][$product->product_id]; ?></div>
                                                        <button class="quantity-increase flex items-center justify-center rounded-r-md bg-gray-200 px-4 transition hover:bg-black hover:text-white">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="absolute right-16 mt-1 flex sm:bottom-0 sm:top-auto">
                                            <a href="panier.php?removeItems=<?= htmlspecialchars($product->product_id); ?>" class="flex rounded p-2 text-center text-gray-500 transition-all duration-200 ease-in-out focus:shadow hover:text-gray-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="mt-6 border-t border-b py-2">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-400">Total HT</p>
                <p class="text-lg font-semibold text-gray-900"><?= number_format($panier->getSubtotal(), 2); ?> €</p>
            </div>

            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-400">TVA (20%)</p>
                <p class="text-lg font-semibold text-gray-900"><?= number_format($panier->getVatAmount(), 2); ?> €</p>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-between">
            <p class="text-sm font-medium text-gray-900">Total (Avec TVA)</p>
            <p class="text-2xl font-semibold text-gray-900"><?= number_format($panier->getGrandTotal(), 2); ?> €</p>
        </div>

        <div class="mt-6 text-center">
            <button id="checkoutButton" type="button" class="group inline-flex w-full items-center justify-center rounded-md bg-gray-900 px-6 py-4 text-lg font-semibold text-white transition-all duration-200 ease-in-out focus:shadow hover:bg-gray-800">
                Checkout
                <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:ml-8 ml-4 h-6 w-6 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>
        </div>

    </div>
</section>
<script>
    // Wait until the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', (event) => {
        // Select the checkout button by its ID
        const checkoutButton = document.getElementById('checkoutButton');

        // Add a click event listener to the button
        checkoutButton.addEventListener('click', () => {
            // Redirect to /payout.php
            window.location.href = 'payout.php';
        });
    });
</script>
