<?php
session_start();
include("../config/database.php");

$id = (int)$_GET['id'];
$qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;

$query = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if(!$product){
    die("Product not found");
}

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

if(isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id]['quantity'] += $qty;
} else {
    $_SESSION['cart'][$id] = [
        "name" => $product['name'],
        "price" => (float)$product['price'],
        "image" => $product['image'],
        "quantity" => $qty
    ];
}

header("Location: cart.php");
exit;