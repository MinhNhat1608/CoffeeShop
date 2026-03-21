<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}

include("../config/database.php");

$query = "SELECT * FROM products ORDER BY id DESC LIMIT 5";
$result = mysqli_query($conn, $query);

$product_query = "SELECT COUNT(*) AS total_products FROM products";
$product_result = mysqli_query($conn, $product_query);
$total_products = mysqli_fetch_assoc($product_result)['total_products'];

$order_query = "SELECT COUNT(*) AS total_orders FROM orders";
$order_result = mysqli_query($conn, $order_query);
$total_orders = mysqli_fetch_assoc($order_result)['total_orders'];

$post_query = "SELECT COUNT(*) AS total_posts FROM posts";
$post_result = mysqli_query($conn, $post_query);
$total_posts = mysqli_fetch_assoc($post_result)['total_posts'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BrewHaven</title>

    <link rel="stylesheet" href="/webbanhang/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: 0.3s;
        }

        .btn.edit {
            background: #3498db;
        }

        .btn.edit:hover {
            background: #2980b9;
        }

        .btn.delete {
            background: #e74c3c;
        }

        .btn.delete:hover {
            background: #c0392b;
        }
    </style>
</head>

<body>

    <div class="admin-container">
        <aside class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-mug-hot"></i>
                <span>CofFee</span>
            </div>

            <ul class="menu">
                <li><i class="fa-solid fa-chart-line"></i><a href="index.php"> Home</a></li>
                <li><i class="fa-solid fa-mug-saucer"></i><a href="products.php"> Products</a></li>
                <li><i class="fa-solid fa-cart-shopping"></i><a href="orders.php"> Orders</a></li>
                <li><i class="fa-solid fa-list"></i><a href="categories.php"> Categories</a></li>
                <li><i class="fa-solid fa-newspaper"></i><a href="posts.php"> Posts</a></li>
                <li><a href="/webbanhang/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <h2>Dashboard Overview</h2>
                <div class="admin-user">
                    <i class="fa-solid fa-user"></i>
                    Admin
                </div>
            </header>

            <div class="stats">

                <div class="card">
                    <h4>Products</h4>
                    <p><?php echo $total_products; ?></p>
                </div>

                <div class="card">
                    <h4>Orders</h4>
                    <p><?php echo $total_orders; ?></p>
                </div>

                <div class="card">
                    <h4>Posts</h4>
                    <p><?php echo $total_posts; ?></p>
                </div>
            </div>

            <div class="table-section">
                <h3>Recent Products</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo number_format($row['price']); ?> VNĐ</td>
                                <td>
                                    <img src="../assets/images/<?php echo $row['image']; ?>" width="60">
                                </td>
                                <td>
                                <td class="actions">
                                    <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn edit">
                                        <i></i> Edit
                                    </a>
                                    <a href="delete_product.php?id=<?php echo $row['id']; ?>"
                                        class="btn delete"
                                        onclick="return confirm('Xóa sản phẩm này?')">
                                        <i></i> Delete
                                    </a>
                                </td>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <script src="/webbanhang/assets/js/admin.js"></script>
</body>

</html>