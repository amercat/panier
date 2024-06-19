<?php
require 'header.php';?>
    <section class="min-h-screen bg-gray-100 flex flex-wrap items-center justify-center gap-10 p-5">
        <?php $products = $DB->query('SELECT * FROM `products`');?>
        <?php foreach ($products as $product): ?>
            <div class="card bg-white shadow-lg rounded-lg overflow-hidden flex flex-col w-full sm:w-64">
                <div class="relative">

                    <img class="w-full h-48 object-cover" src="<?= $product->img; ?>" alt="<?= $product->product_name; ?>" id="productImage-<?= $product->product_id; ?>">
                    <div class="absolute top-2 right-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded" id="badge-<?= $product->product_id; ?>">
                        In Stock
                    </div>
                </div>

                <div class="p-4 flex flex-col gap-2">

                    <div class="flex items-center gap-2">
                        <span class="badge">stock ready</span>
                        <span class="badge">official store</span>
                    </div>

                    <h2 class="product-title text-lg font-semibold text-gray-900 truncate" title="<?= $product->product_name; ?>" id="productTitle-<?= $product->product_id; ?>">
                        <?= $product->product_name; ?>
                    </h2>

                    <div>


                        <div class="text-xl font-bold text-green-600" id="productPrice-<?= $product->product_id; ?>">
                            €<?= number_format($product->price, 2, ',', ' '); ?>
                        </div>
                        <!-- Discount and original price -->
                        <div class="flex items-center gap-2">
                <span class="text-sm line-through text-gray-500">
                    €50.00
                </span>

                            <span class="discount-percent text-sm text-red-500 font-semibold" id="discount-<?= $product->product_id; ?>">
                    Save 20%
                </span>

                        </div>
                        <!-- Star rating -->
                        <div class="flex items-center mt-1" id="productRating-<?= $product->product_id; ?>">
                            <?php
                            $rating = 4.5; // Example rating value, replace with actual data
                            for ($i = 0; $i < 5; $i++) {
                                if ($i < floor($rating)) {
                                    echo '<svg class="star" viewBox="0 0 576 512" width="20" fill="gold" title="star"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>';
                                } elseif ($i < $rating) {
                                    echo '<svg class="star" viewBox="0 0 576 512" width="20" fill="gold" title="star"><defs><clipPath id="half-star-'. $product->product_id .'"><rect width="50%" height="100%" /></clipPath></defs><path fill="lightgray" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/><path fill="gold" clip-path="url(#half-star-'. $product->product_id .')" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>';
                                } else {
                                    echo '<svg class="star" viewBox="0 0 576 512" width="20" fill="lightgray" title="star"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>';
                                }
                            }
                            ?>
                            <span class="text-xs ml-2 text-gray-500" id="reviewCount-<?= $product->product_id; ?>">
                    20k reviews
                </span>
                        </div>


                        <div class="mt-5 flex gap-2">
                            <button class="button-primary" id="addCart">
                                <a href="addpanier.php?product_id=<?= $product->product_id; ?>">Add To Cart</a>
                            </button>

                            <button class="button-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                </svg>
                            </button>

                            <button class="button-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </button>

                        </div>

                    </div>

                </div>
            </div>
        <?php endforeach ?>
    </section>
<?php require 'footer.php'; ?>