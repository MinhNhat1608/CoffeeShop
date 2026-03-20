<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop Website</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair:ital,opsz,wght@0,5..1200,300..900;1,5..1200,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/webbanhang/assets/css/style.css">
</head>

<body>
    <header>
        <div class="container header-container">
            <a href="/webbanhang/index.php" class="logo">
                <i class="fa-solid fa-mug-hot logo-icon"></i>
                <div class="logo-text">Cof<span>Fee</span></div>

            </a>
            <nav>
                <ul>
                    <li><a href="/webbanhang/index.php">Home</a></li>
                    <li><a href="/webbanhang/pages/products.php">Products</a></li>
                    <li><a href="/webbanhang/pages/cart.php">Cart</a></li>
                    <li><a href="/webbanhang/pages/posts.php">Posts</a></li>
                    <li><a href="/webbanhang/pages/about.php">About Us</a></li>
                </ul>
            </nav>

            <div class="nav-buttons">
                <?php if (isset($_SESSION['user'])) { ?>
                    <a href="/webbanhang/logout.php" class="btn btn-primary">Logout</a>
                <?php } else { ?>
                    <a href="/webbanhang/login.php" class="btn btn-primary">Sign In</a>
                <?php } ?>
                <a href="/webbanhang/pages/order.php" class="btn btn-primary">Order Online</a>
            </div>
        </div>
    </header>