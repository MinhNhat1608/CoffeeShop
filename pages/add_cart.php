<?php
session_start();
include("../config/database.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$id = (int)$_GET['id'];
$qty = (isset($_GET['qty']) && is_numeric($_GET['qty']) && $_GET['qty'] > 0) ? (int)$_GET['qty'] : 1;

$query = "SELECT id, name, price, image FROM products WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    header("Location: products.php");
    exit();
}

$product = mysqli_fetch_assoc($result);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantity'] += $qty;
} else {
    $_SESSION['cart'][$id] = [
        "id" => $product['id'],
        "name" => $product['name'],
        "price" => (float)$product['price'],
        "image" => $product['image'],
        "quantity" => $qty
    ];
}

header("Location: cart.php");
exit();