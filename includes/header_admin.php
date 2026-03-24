<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin</title>

<link rel="stylesheet" href="/webbanhang/assets/css/admin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="admin-container">

<!-- SIDEBAR -->
<aside class="sidebar">

    <a href="../admin/index.php" style="text-decoration: none;">
    <div class="logo">
        <i class="fa-solid fa-mug-hot"></i> Brewza Coffee
    </div>
</a>

    <ul class="menu">
        <li><a href="index.php"><i class="fa fa-chart-line"></i> Dashboard</a></li>
        <li><a href="products.php"><i class="fa fa-box"></i> Products</a></li>
        <li><a href="orders.php"><i class="fa fa-shopping-cart"></i> Orders</a></li>
        <li><a href="categories.php"><i class="fa fa-list"></i> Categories</a></li>
        <li><a href="posts.php"><i class="fa fa-newspaper"></i> Posts</a></li>
        <li><a href="/webbanhang/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
    </ul>

</aside>

<main class="main-content">