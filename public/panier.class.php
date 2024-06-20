<?php
class Panier
{
    private $DB;
    private $VAT_RATE = 0.2; // 20% VAT rate

    public function __construct($DB) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = array();
        }
        $this->DB = $DB;

        if (isset($_GET['removeItems'])) {
            $this->remove($_GET['removeItems']);
        }
    }

    // Calculate the subtotal (without VAT)
    public function getSubtotal() {
        $subtotal = 0;
        $ids = array_keys($_SESSION['panier']);
        if (!empty($ids)) {
            $products = $this->DB->query('SELECT product_id, price FROM products WHERE product_id IN (' . implode(',', $ids) . ')');
            foreach ($products as $product) {
                $subtotal += $product->price * $_SESSION['panier'][$product->product_id];
            }
        }
        return $subtotal;
    }

    // Calculate the VAT amount
    public function getVatAmount() {
        return $this->getSubtotal() * $this->VAT_RATE;
    }

    // Calculate the grand total including VAT
    public function getGrandTotal() {
        return $this->getSubtotal() + $this->getVatAmount();
    }

    public function add($product_id) {
        if (isset($_SESSION['panier'][$product_id])) {
            $_SESSION['panier'][$product_id]++;
        } else {
            $_SESSION['panier'][$product_id] = 1;
        }
    }

    public function remove($product_id) {
        unset($_SESSION['panier'][$product_id]);
    }

    // Method to get a unique ID for the cart session
    public function getId() {
        return session_id();
    }

    // panier.class.php

    // panier.class.php

    public function getProducts() {
        $ids = array_keys($_SESSION['panier']);
        if (empty($ids)) {
            return [];
        }

        // Fetch product details from the database
        $products = $this->DB->query('SELECT product_id, product_name AS name, price FROM products WHERE product_id IN (' . implode(',', $ids) . ')');

        $result = [];
        foreach ($products as $product) {
            // Ensure $product is an object or array with expected keys
            if (isset($_SESSION['panier'][$product['product_id']])) { // Check if product_id exists in session
                $result[] = [
                    'price_data' => [
                        'currency' => 'eur', // Adjust as per your product's currency
                        'product_data' => [
                            'name' => $product['name'], // Access as array key
                        ],
                        'unit_amount' => $product['price'] * 100, // Amount in cents
                    ],
                    'quantity' => $_SESSION['panier'][$product['product_id']],
                ];
            }
        }

        return $result;
    }
    // Method to set the Stripe session ID in the cart
    public function setSessionId($sessionId) {
        $_SESSION['stripe_session_id'] = $sessionId;
    }


}
