<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Quán Cà Phê</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair:ital,opsz,wght@0,5..1200,300..900;1,5..1200,300..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="/webbanhang/assets/css/style.css">

    <style>
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            position: relative;
        }
        nav ul li.dropdown {
            position: relative;
            padding-bottom: 12px;
        }

        nav ul li.dropdown>a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            line-height: 1;
            vertical-align: middle;
        }

        nav ul li.dropdown>a .fa-angle-down {
            position: relative;
            top: 1px;
            font-size: 0.82rem;
            transition: transform 0.35s ease;
        }

        nav ul.dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            list-style: none;
            margin:0;
            padding: 8px 0;
            min-width: 220px;
            background: #141116;
            border: 1px solid rgba(184, 138, 88, 0.18);
            border-radius: 16px;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.28);

            opacity: 0;
            visibility: hidden;
            transform: translateY(12px);
            pointer-events: none;
            z-index: 999;

            display: flex;
            flex-direction: column;
            gap: 0;

            transition: opacity 0.35s ease, transform 0.35s ease, visibility 0.35s ease;
        }

        nav ul li.dropdown:hover>ul.dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }

        nav ul li.dropdown:hover>a .fa-angle-down {
            transform: rotate(180deg);
        }

        nav ul.dropdown-menu>li {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        nav ul.dropdown-menu>li>a {
            display: block;
            width: 100%;
            box-sizing: border-box;
            padding: 12px 18px;
            color: #b88a58;
            text-decoration: none;
            white-space: nowrap;
            font-weight: 600;
            transition: background 0.5s ease, color 0.5s ease, padding-left 0.5s ease;
        }

        nav ul.dropdown-menu>li>a:hover {
            background: rgba(184, 138, 88, 0.10);
            color: #d6a46d;
            padding-left: 24px;
        }
    </style>
</head>

<body>
    <header>
        <div class="container header-container">
            <a href="/webbanhang/index.php" class="logo">
                <i class="fa-solid fa-mug-hot logo-icon"></i>
                <div class="logo-text">CoF<span>Fee</span></div>
            </a>

            <nav>
                <ul>
                    <li><a href="/webbanhang/index.php">Trang chủ</a></li>

                    <li class="dropdown">
                        <a href="/webbanhang/pages/products.php">
                            Sản phẩm <i class="fa-solid fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/webbanhang/pages/products.php?category=1">Coffee</a></li>
                            <li><a href="/webbanhang/pages/products.php?category=2">Tea</a></li>
                            <li><a href="/webbanhang/pages/products.php?category=3">Cold Brew</a></li>
                            <li><a href="/webbanhang/pages/products.php?category=4">Pastry</a></li>
                        </ul>
                    </li>

                    <li><a href="/webbanhang/pages/cart.php">Giỏ hàng</a></li>
                    <li><a href="/webbanhang/pages/posts.php">Bài viết</a></li>
                    <li><a href="/webbanhang/pages/about.php">Về chúng tôi</a></li>
                </ul>
            </nav>

            <div class="nav-buttons">
                <?php if (isset($_SESSION['user'])) { ?>
                    <a href="/webbanhang/logout.php" class="btn btn-primary">Đăng xuất</a>
                <?php } else { ?>
                    <a href="/webbanhang/login.php" class="btn btn-primary">Đăng nhập</a>
                <?php } ?>

                <a href="/webbanhang/pages/orders.php" class="btn btn-primary">Đặt hàng online</a>
            </div>
        </div>
    </header>