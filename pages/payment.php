<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['checkout_data']) || !isset($_SESSION['cart'])) {
    header("Location: checkout.php");
    exit;
}

include("../includes/header.php");

$cart = $_SESSION['cart'];
$total = 0;

foreach ($cart as $item) {
    if (!is_array($item)) continue;
    $total += (float)$item['price'] * (int)$item['quantity'];
}
?>

<style>
body { background:#f6f6f6; }
.payment-wrap {
    width: 90%;
    max-width: 700px;
    margin: 40px auto;
    background: #fff;
    padding: 28px;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    text-align: center;
}
.payment-title {
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 16px;
}
.payment-box {
    margin: 24px 0;
    padding: 20px;
    background: #faf7f4;
    border-radius: 14px;
}
.qr-demo {
    width: 220px;
    height: 220px;
    margin: 0 auto 16px;
    background: #eee;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-weight: 700;
    color: #666;
}
.pay-btn {
    display: inline-block;
    padding: 12px 24px;
    background: #8b5e3c;
    color: white;
    text-decoration: none;
    border-radius: 10px;
    margin-top: 14px;
}
.pay-btn:hover { background: #6f4b2f; }
</style>

<div class="payment-wrap">
    <div class="payment-title">Thanh toán online</div>
    <p>Tổng tiền cần thanh toán: <b><?php echo number_format($total, 0, ',', '.'); ?> đ</b></p>

    <div class="payment-box">
        <div class="qr-demo">QR Demo</div>
        <p>Ngân hàng: MB Bank</p>
        <p>Số tài khoản: 123456789</p>
        <p>Chủ tài khoản: COFFEE SHOP</p>
        <p>Nội dung CK: THANHTOAN_<?php echo session_id(); ?></p>
    </div>

    <a href="place_order.php?paid=1" class="pay-btn">Tôi đã thanh toán</a>
</div>

<?php include("../includes/footer.php"); ?>