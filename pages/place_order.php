<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

if (!isset($_SESSION['checkout_data'])) {
    header("Location: checkout.php");
    exit;
}

$cart = $_SESSION['cart'];
$data = $_SESSION['checkout_data'];

$total = 0;
foreach ($cart as $item) {
    if (!is_array($item)) continue;
    $total += (float)$item['price'] * (int)$item['quantity'];
}

$user_id = 1;
if (isset($_SESSION['user_id'])) {
    $user_id = (int)$_SESSION['user_id'];
}

$customer_name = mysqli_real_escape_string($conn, $data['name']);
$phone = mysqli_real_escape_string($conn, $data['phone']);
$address = mysqli_real_escape_string($conn, $data['address']);
$note = mysqli_real_escape_string($conn, $data['note']);
$receive_method = mysqli_real_escape_string($conn, $data['receive_method']);
$ice_level = mysqli_real_escape_string($conn, $data['ice_level']);
$sugar_level = mysqli_real_escape_string($conn, $data['sugar_level']);
$payment_method = mysqli_real_escape_string($conn, $data['payment_method']);

$status = "pending";
if ($payment_method == "online" && isset($_GET['paid']) && $_GET['paid'] == 1) {
    $status = "paid";
}

$sql = "INSERT INTO orders (
    user_id, customer_name, phone, address, total, status, note,
    receive_method, ice_level, sugar_level, payment_method
) VALUES (
    $user_id, '$customer_name', '$phone', '$address', $total, '$status', '$note',
    '$receive_method', '$ice_level', '$sugar_level', '$payment_method'
)";

mysqli_query($conn, $sql);
$order_id = mysqli_insert_id($conn);

foreach ($cart as $product_id => $item) {
    if (!is_array($item)) continue;

    $qty = (int)$item['quantity'];
    $price = (float)$item['price'];

    $detail_sql = "INSERT INTO order_details (order_id, product_id, quantity, price)
                   VALUES ($order_id, $product_id, $qty, $price)";
    mysqli_query($conn, $detail_sql);
}

unset($_SESSION['cart']);
unset($_SESSION['checkout_data']);

include("../includes/header.php");
?>

<style>
body { background:#f6f6f6; }
.success-wrap {
    width: 90%;
    max-width: 700px;
    margin: 50px auto;
    background: #fff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    text-align: center;
}
.success-wrap h2 {
    color: #1e8449;
    margin-bottom: 12px;
}
.success-wrap a {
    display: inline-block;
    margin-top: 16px;
    padding: 12px 24px;
    background: #8b5e3c;
    color: #fff;
    text-decoration: none;
    border-radius: 10px;
}
</style>

<div class="success-wrap">
    <h2>Đặt hàng thành công</h2>
    <p>Mã đơn hàng của bạn là: <b>#<?php echo $order_id; ?></b></p>
    <p>Trạng thái thanh toán: <b><?php echo $status; ?></b></p>
    <a href="products.php">Tiếp tục mua sắm</a>
</div>

<?php include("../includes/footer.php"); ?>