<?php
session_start();

// ===== XỬ LÝ ACTION TRƯỚC (QUAN TRỌNG) =====
if (isset($_GET['action']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    if (isset($_SESSION['cart'][$id])) {

        if ($_GET['action'] == "plus") {
            $_SESSION['cart'][$id]['quantity']++;
        }

        if ($_GET['action'] == "minus") {
            $_SESSION['cart'][$id]['quantity']--;

            if ($_SESSION['cart'][$id]['quantity'] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }

        if ($_GET['action'] == "remove") {
            unset($_SESSION['cart'][$id]);
        }
    }

    header("Location: cart.php");
    exit();
}

// ===== HIỂN THỊ =====
include("../includes/header.php");

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<style>
body {
    background: #f5f5f5;
    padding-top: 120px;
}

.cart-container {
    width: 85%;
    margin: 40px auto 60px;
}

.cart-title {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 25px;
    color: #222;
}

.empty-cart {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    font-size: 18px;
}

.cart-item {
    display: flex;
    align-items: center;
    gap: 20px;
    background: #fff;
    padding: 18px;
    margin-bottom: 18px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

.cart-item img {
    width: 150px;
    height: 100px;
    border-radius: 10px;
    object-fit: cover;
}

.cart-info {
    flex: 1;
}

.cart-info h4 {
    font-size: 22px;
    margin-bottom: 10px;
}

.price {
    color: #ee4d2d;
    font-weight: bold;
    margin-bottom: 10px;
}

.qty-box {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.qty-btn {
    padding: 6px 14px;
    border: 1px solid #ddd;
    text-decoration: none;
    font-weight: bold;
    color: #222;
}

.qty-btn:hover {
    background: #ee4d2d;
    color: white;
}

.qty-number {
    padding: 6px 16px;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
}

.remove {
    color: red;
    font-weight: 600;
    text-decoration: none;
}

.cart-summary {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    margin-top: 25px;
    text-align: right;
}

.summary-total {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 20px;
}

.btn-row {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.continue-btn,
.checkout-btn {
    padding: 12px 22px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
}

.continue-btn {
    border: 2px solid #ee4d2d;
    color: #ee4d2d;
}

.continue-btn:hover {
    background: #ee4d2d;
    color: #fff;
}

.checkout-btn {
    background: #ee4d2d;
    color: white;
}

.checkout-btn:hover {
    background: #d73211;
}
</style>

<div class="cart-container">
    <div class="cart-title">🛒 Giỏ hàng</div>

    <?php if (empty($cart)) { ?>
        <div class="empty-cart">Giỏ hàng trống</div>
    <?php } else { ?>

        <?php
        $total = 0;

        foreach ($cart as $id => $item):
            $price = (float)$item['price'];
            $qty = (int)$item['quantity'];
            $subtotal = $price * $qty;
            $total += $subtotal;
        ?>

        <div class="cart-item">
            <img src="../assets/images/<?php echo $item['image']; ?>">

            <div class="cart-info">
                <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                <div class="price"><?php echo number_format($price, 0, ',', '.'); ?>VNĐ</div>

                <div class="qty-box">
                    <a href="cart.php?action=minus&id=<?php echo $id; ?>" class="qty-btn">-</a>
                    <div class="qty-number"><?php echo $qty; ?></div>
                    <a href="cart.php?action=plus&id=<?php echo $id; ?>" class="qty-btn">+</a>
                </div>

                <p>Thành tiền: <b><?php echo number_format($subtotal, 0, ',', '.'); ?>VNĐ</b></p>
            </div>

            <a href="cart.php?action=remove&id=<?php echo $id; ?>" class="remove">Xóa</a>
        </div>

        <?php endforeach; ?>

        <div class="cart-summary">
            <div class="summary-total">
                Tổng cộng: <?php echo number_format($total, 0, ',', '.'); ?>đ
            </div>

            <div class="btn-row">
                <a href="products.php" class="continue-btn">Tiếp tục mua</a>

                <?php if (isset($_SESSION['user'])) { ?>
                    <a href="checkout.php" class="checkout-btn">Thanh toán</a>
                <?php } else { ?>
                    <a href="../login.php" class="checkout-btn">Đăng nhập để thanh toán</a>
                <?php } ?>
            </div>
        </div>

    <?php } ?>
</div>

<?php include("../includes/footer.php"); ?>