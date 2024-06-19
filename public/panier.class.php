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
}

