<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;

foreach ($cart as $item) {
    if (!is_array($item)) continue;
    $price = (float)$item['price'];
    $qty = (int)$item['quantity'];
    $total += $price * $qty;
}

if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

$error = "";

if (isset($_POST['order'])) {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $note = trim($_POST['note']);
    $receive_method = isset($_POST['receive_method']) ? $_POST['receive_method'] : '';
    $ice_level = isset($_POST['ice_level']) ? $_POST['ice_level'] : '';
    $sugar_level = isset($_POST['sugar_level']) ? $_POST['sugar_level'] : '';
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

    if ($name == "" || $phone == "" || $receive_method == "" || $ice_level == "" || $sugar_level == "" || $payment_method == "") {
        $error = "Vui lòng nhập đầy đủ thông tin.";
    } elseif ($receive_method == "delivery" && $address == "") {
        $error = "Vui lòng nhập địa chỉ nhận hàng.";
    } else {
        $_SESSION['checkout_data'] = [
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'note' => $note,
            'receive_method' => $receive_method,
            'ice_level' => $ice_level,
            'sugar_level' => $sugar_level,
            'payment_method' => $payment_method
        ];

        if ($payment_method == "online") {
            header("Location: payment.php");
            exit;
        } else {
            header("Location: place_order.php");
            exit;
        }
    }
}

include("../includes/header.php");
?>

<style>
body { background:#f6f6f6; }

.checkout-wrapper {
    width: 90%;
    max-width: 1200px;
    margin: 40px auto;
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 25px;
}

.checkout-card, .summary-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    padding: 24px;
}

.checkout-title {
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #2d1b12;
}

.section-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 16px;
    color: #3b2418;
}

.form-group { margin-bottom: 16px; }

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #4b3327;
}

.form-control {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #ddd;
    border-radius: 10px;
    outline: none;
    font-size: 15px;
    box-sizing: border-box;
}

.form-control:focus {
    border-color: #c27c4a;
    box-shadow: 0 0 0 3px rgba(194,124,74,0.12);
}

textarea.form-control {
    min-height: 100px;
    resize: vertical;
}

.option-group {
    display: grid;
    gap: 10px;
}

.option-item {
    border: 1px solid #e6e2df;
    border-radius: 12px;
    padding: 12px 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.summary-item {
    display: flex;
    gap: 14px;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}

.summary-item img {
    width: 72px;
    height: 72px;
    object-fit: cover;
    border-radius: 12px;
}

.summary-info { flex: 1; }

.summary-name {
    font-weight: 600;
    color: #2d1b12;
    margin-bottom: 6px;
}

.summary-meta {
    color: #777;
    font-size: 14px;
}

.summary-price {
    color: #d35400;
    font-weight: 700;
    margin-top: 6px;
}

.total-box {
    margin-top: 18px;
    padding-top: 18px;
    border-top: 2px dashed #eee;
}

.total-row, .total-final {
    display: flex;
    justify-content: space-between;
}

.total-row {
    margin-bottom: 10px;
    color: #555;
}

.total-final {
    font-size: 22px;
    font-weight: 700;
    color: #d35400;
    margin-top: 8px;
}

.checkout-btn {
    width: 100%;
    padding: 14px;
    background: #8b5e3c;
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: 0.2s;
    margin-top: 18px;
}

.checkout-btn:hover {
    background: #6f4b2f;
}

.message-error {
    background: #ffe8e8;
    color: #c0392b;
    padding: 12px 14px;
    border-radius: 10px;
    margin-bottom: 16px;
    font-weight: 600;
}

.hidden { display: none; }

@media (max-width: 900px) {
    .checkout-wrapper {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="checkout-wrapper">
    <div class="checkout-card">
        <div class="checkout-title">Thanh toán</div>

        <?php if ($error != "") { ?>
            <div class="message-error"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <div class="section-title">Thông tin khách hàng</div>

            <div class="form-group">
                <label class="form-label">Họ và tên</label>
                <input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
            </div>

            <div class="section-title">Hình thức nhận hàng</div>
            <div class="option-group">
                <label class="option-item">
                    <input type="radio" name="receive_method" value="delivery" <?php echo (isset($_POST['receive_method']) && $_POST['receive_method'] == 'delivery') ? 'checked' : ''; ?>>
                    Giao tận nơi
                </label>

                <label class="option-item">
                    <input type="radio" name="receive_method" value="pickup" <?php echo (isset($_POST['receive_method']) && $_POST['receive_method'] == 'pickup') ? 'checked' : ''; ?>>
                    Tự đến lấy
                </label>
            </div>

            <div class="form-group" id="address-box">
                <label class="form-label">Địa chỉ nhận hàng</label>
                <input type="text" name="address" class="form-control" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
            </div>

            <div class="section-title">Tuỳ chọn đồ uống</div>

            <div class="form-group">
                <label class="form-label">Mức đá</label>
                <select name="ice_level" class="form-control">
                    <option value="">-- Chọn mức đá --</option>
                    <option value="Ít đá" <?php echo (isset($_POST['ice_level']) && $_POST['ice_level'] == 'Ít đá') ? 'selected' : ''; ?>>Ít đá</option>
                    <option value="Đá vừa" <?php echo (isset($_POST['ice_level']) && $_POST['ice_level'] == 'Đá vừa') ? 'selected' : ''; ?>>Đá vừa</option>
                    <option value="Nhiều đá" <?php echo (isset($_POST['ice_level']) && $_POST['ice_level'] == 'Nhiều đá') ? 'selected' : ''; ?>>Nhiều đá</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Mức đường</label>
                <select name="sugar_level" class="form-control">
                    <option value="">-- Chọn mức đường --</option>
                    <option value="Ít đường" <?php echo (isset($_POST['sugar_level']) && $_POST['sugar_level'] == 'Ít đường') ? 'selected' : ''; ?>>Ít đường</option>
                    <option value="Đường vừa" <?php echo (isset($_POST['sugar_level']) && $_POST['sugar_level'] == 'Đường vừa') ? 'selected' : ''; ?>>Đường vừa</option>
                    <option value="Nhiều đường" <?php echo (isset($_POST['sugar_level']) && $_POST['sugar_level'] == 'Nhiều đường') ? 'selected' : ''; ?>>Nhiều đường</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Ghi chú cho quán</label>
                <textarea name="note" class="form-control" placeholder="Ví dụ: ít ngọt hơn bình thường, giao nhanh giúp mình..."><?php echo isset($_POST['note']) ? htmlspecialchars($_POST['note']) : ''; ?></textarea>
            </div>

            <div class="section-title">Phương thức thanh toán</div>
            <div class="option-group">
                <label class="option-item">
                    <input type="radio" name="payment_method" value="cod" <?php echo (isset($_POST['payment_method']) && $_POST['payment_method'] == 'cod') ? 'checked' : ''; ?>>
                    Thanh toán khi nhận hàng
                </label>

                <label class="option-item">
                    <input type="radio" name="payment_method" value="online" <?php echo (isset($_POST['payment_method']) && $_POST['payment_method'] == 'online') ? 'checked' : ''; ?>>
                    Thanh toán online
                </label>
            </div>

            <button type="submit" name="order" class="checkout-btn">Tiếp tục thanh toán</button>
        </form>
    </div>

    <div class="summary-card">
        <div class="section-title">Đơn hàng của bạn</div>

        <?php foreach ($cart as $item) { ?>
            <?php
            if (!is_array($item)) continue;
            $price = (float)$item['price'];
            $qty = (int)$item['quantity'];
            $subtotal = $price * $qty;
            ?>
            <div class="summary-item">
                <img src="../uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="">
                <div class="summary-info">
                    <div class="summary-name"><?php echo htmlspecialchars($item['name']); ?></div>
                    <div class="summary-meta">Số lượng: <?php echo $qty; ?></div>
                    <div class="summary-price"><?php echo number_format($subtotal, 0, ',', '.'); ?> đ</div>
                </div>
            </div>
        <?php } ?>

        <div class="total-box">
            <div class="total-row">
                <span>Tạm tính</span>
                <span><?php echo number_format($total, 0, ',', '.'); ?> đ</span>
            </div>
            <div class="total-row">
                <span>Phí vận chuyển</span>
                <span>0 đ</span>
            </div>
            <div class="total-final">
                <span>Tổng cộng</span>
                <span><?php echo number_format($total, 0, ',', '.'); ?> đ</span>
            </div>
        </div>
    </div>
</div>

<script>
const deliveryRadio = document.querySelector('input[value="delivery"]');
const pickupRadio = document.querySelector('input[value="pickup"]');
const addressBox = document.getElementById('address-box');

function toggleAddress() {
    if (pickupRadio && pickupRadio.checked) {
        addressBox.style.display = 'none';
    } else {
        addressBox.style.display = 'block';
    }
}

toggleAddress();

if (deliveryRadio) deliveryRadio.addEventListener('change', toggleAddress);
if (pickupRadio) pickupRadio.addEventListener('change', toggleAddress);
</script>

<?php include("../includes/footer.php"); ?>