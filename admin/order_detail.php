<?php
session_start();
include("../config/database.php");
include("../includes/header_admin.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $query = "SELECT od.*, p.name 
              FROM order_details od
              JOIN products p ON od.product_id = p.id
              WHERE od.order_id = $id";

    $result = mysqli_query($conn, $query);
} else {
    header("Location: orders.php");
    exit();
}
?>
<style>
    body {
        background: radial-gradient(circle at top, #1a1a1a, #0d0d0d);
        color: #fff;
        font-family: 'Segoe UI', sans-serif;
    }

    .order-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 25px;
        backdrop-filter: blur(12px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        overflow: hidden;
        border-radius: 15px;
    }

    .table-custom th {
        background: linear-gradient(135deg, #8b5e3c, #c89b6d);
        color: white;
        padding: 12px;
    }

    .table-custom td {
        padding: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .table-custom tr:hover {
        background: rgba(255, 255, 255, 0.05);
        transition: 0.3s;
    }

    .total-box {
        margin-top: 20px;
        padding: 20px;
        border-radius: 15px;
        background: linear-gradient(135deg, #8b5e3c, #c89b6d);
        text-align: center;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
    }

    .total-box h3 {
        margin: 0;
        font-size: 18px;
    }

    .total-box h1 {
        font-size: 40px;
        margin: 10px 0 0;
    }

    .btn-back {
        border: 1px solid #c89b6d;
        color: #c89b6d;
        padding: 8px 18px;
        border-radius: 10px;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-back:hover {
        background: #c89b6d;
        color: #000;
    }
</style>

<div class="container" style="max-width: 700px; margin: auto; margin-top: 50px;">
    <h1 style="text-align:center; margin-bottom:20px;">
        Order Detail #<?php echo $id; ?>
    </h1>
    <div style="text-align:center; margin-bottom:20px;">
        <a href="orders.php" class="btn-back">⬅ Back to Orders</a>
    </div>

    <div class="order-card">
        <table class="table-custom text-center">
            <tr>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>

            <?php
            $grand_total = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $total = $row['quantity'] * $row['price'];
                $grand_total += $total;
            ?>
                <tr>
                    <td><?php echo $row['product_id']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo number_format($row['price']); ?> đ</td>
                    <td><?php echo number_format($total); ?> đ</td>
                </tr>
            <?php } ?>
        </table>

        <div class="total-box">
            <h3>Grand Total</h3>
            <h1><?php echo number_format($grand_total); ?> đ</h1>
        </div>
    </div>
</div>
<?php include("../includes/footer_admin.php"); ?>