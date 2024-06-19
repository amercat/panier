<?php
require '_header.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../public/tailwind.css">
    <title>Panier</title>
    <style>
        #cartIcon, #upCartQty, #upCartTotal {
            display: none; /* Initially hide the cart elements */
        }
    </style>
</head>
<body>
<nav class="relative flex w-full flex-wrap items-center justify-between bg-zinc-50 py-2 shadow-dark-mild dark:bg-neutral-700 lg:py-4">
    <div class="flex w-full flex-wrap items-center justify-between px-3">
        <!-- Left elements -->
        <div class="flex">
            <!-- Brand -->
            <a class="mx-2 my-1 flex items-center lg:mb-0 lg:mt-0" href="index.php">
                <img class="me-2" src="https://tecdn.b-cdn.net/img/logo/te-transparent-noshadows.webp" style="height: 20px" alt="TE Logo" loading="lazy" />
            </a>
            <form class="hidden md:flex">
                <div class="flex w-[30%] items-center justify-between">
                    <input type="search" class="relative m-0 block flex-auto rounded border border-solid border-secondary-500 bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-surface transition duration-300 ease-in-out focus:border-primary focus:text-gray-700 focus:shadow-inset focus:outline-none motion-reduce:transition-none dark:border-white/10 dark:bg-body-dark dark:text-white dark:placeholder:text-neutral-300 dark:autofill:shadow-autofill" placeholder="Search" aria-label="Search" aria-describedby="button-addon2" />
                    <!--Search icon-->
                    <span class="flex items-center whitespace-nowrap rounded px-3 py-1.5 text-center text-base font-normal text-gray-600 dark:text-white [&>svg]:w-5" id="basic-addon2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>
            </form>
        </div>
        <!-- Left elements -->

        <!-- Right elements -->
        <ul class="list-style-none mx-auto hidden flex-row ps-0 md:flex" data-twe-navbar-nav-ref>
            <li class="px-2" data-twe-nav-item-ref>
                <a class="flex text-black/60 transition duration-200 hover:text-black/80 hover:ease-in-out focus:text-black/80 active:text-black/80 motion-reduce:transition-none dark:text-white/60 dark:hover:text-white/80 dark:focus:text-white/80 dark:active:text-white/80" href="#" data-twe-nav-link-ref>
                    <img src="https://tecdn.b-cdn.net/img/new/avatars/1.jpg" class="rounded-full" style="height: 25px; width: 25px" alt="TE Avatar" loading="lazy" />
                    <strong class="ms-1 hidden sm:block">John</strong>
                </a>
            </li>
            <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $totalQuantity = array_sum($_SESSION['panier']);
            ?>
            <li class="px-6" data-twe-nav-item-ref>
                <a class="text-black/60 transition duration-200 hover:text-black/80 hover:ease-in-out focus:text-black/80 active:text-black/80 motion-reduce:transition-none dark:text-white/60 dark:hover:text-white/80 dark:focus:text-white/80 dark:active:text-white/80" href="panier.php" data-twe-nav-link-ref>
                    <span class="[&>svg]:h-6 [&>svg]:w-6">
                        <svg id="cartIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" />
                        </svg>
                    </span>
                    <span class="absolute -mt-7 ms-4 rounded-full bg-danger px-[0.50em] py-[0.01em] text-xl font-bold leading-none text-red-500" id="upCartQty"><?= $totalQuantity; ?></span>
                    <span class="absolute -mt-6 ms-16 leading-none text-2xl font-semibold text-white" id="upCartTotal">Total : <?= number_format($panier->getGrandTotal(),2,',',','); ?> € </span>
                </a>
            </li>
        </ul>
        <!-- Right elements -->
    </div>
</nav>

<script>
    // Check initial cart status and show/hide elements
    document.addEventListener("DOMContentLoaded", function() {
        <?php if ($totalQuantity > 0): ?>
        document.getElementById("cartIcon").style.display = "block";
        document.getElementById("upCartQty").style.display = "block";
        document.getElementById("upCartTotal").style.display = "block";
        <?php endif; ?>
    });
</script>
