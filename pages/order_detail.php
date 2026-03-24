<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['user']) || !isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /webbanhang/pages/orders.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$order_id = (int)$_GET['id'];

$order_query = "SELECT * FROM orders WHERE id = $order_id AND user_id = $user_id LIMIT 1";
$order_result = mysqli_query($conn, $order_query);

if (!$order_result || mysqli_num_rows($order_result) == 0) {
    header("Location: /webbanhang/pages/orders.php");
    exit();
}

$order = mysqli_fetch_assoc($order_result);

$order_items_query = "
    SELECT od.*, p.name AS product_name, p.image AS product_image
    FROM order_details od
    LEFT JOIN products p ON od.product_id = p.id
    WHERE od.order_id = $order_id
";
$order_items_result = mysqli_query($conn, $order_items_query);

include("../includes/header.php");
?>

<style>
body {
    background: #f6f6f6;
    padding-top: 120px;
}

.order-detail-container {
    width: 90%;
    max-width: 1200px;
    margin: 40px auto;
}

.page-title {
    font-size: 40px;
    font-weight: 800;
    color: #2d1b12;
    margin-bottom: 28px;
}

.order-layout {
    display: grid;
    grid-template-columns: 1fr 1.1fr;
    gap: 22px;
}

.order-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    padding: 22px;
}

.card-title {
    font-size: 22px;
    font-weight: 800;
    color: #2d1b12;
    margin-bottom: 22px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    padding: 14px 0;
    border-bottom: 1px solid #eee;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    color: #777;
    font-size: 15px;
}

.info-value {
    color: #2d1b12;
    font-size: 15px;
    font-weight: 700;
    text-align: right;
}

.status-badge {
    display: inline-block;
    padding: 8px 14px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-paid {
    background: #d4edda;
    color: #155724;
}

.status-default {
    background: #e9ecef;
    color: #495057;
}

.product-item {
    display: flex;
    gap: 16px;
    padding: 12px 0;
    border-bottom: 1px solid #eee;
}

.product-item:last-child {
    border-bottom: none;
}

.product-item img {
    width: 82px;
    height: 82px;
    object-fit: cover;
    border-radius: 12px;
    flex-shrink: 0;
}

.product-info {
    flex: 1;
}

.product-name {
    font-size: 18px;
    font-weight: 800;
    color: #2d1b12;
    margin-bottom: 10px;
}

.product-meta {
    color: #777;
    font-size: 15px;
    margin-bottom: 8px;
}

.product-subtotal {
    color: #e36414;
    font-size: 18px;
    font-weight: 800;
}

.summary-box {
    margin-top: 18px;
    padding-top: 14px;
    border-top: 2px dashed #e6ddd5;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    color: #666;
    font-size: 15px;
}

.summary-total {
    display: flex;
    justify-content: space-between;
    margin-top: 8px;
    font-size: 20px;
    font-weight: 800;
    color: #e36414;
}

.back-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 18px;
    background: #8b5e3c;
    color: #fff;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 700;
}

.back-btn:hover {
    background: #6f4b2f;
}

@media (max-width: 900px) {
    .order-layout {
        grid-template-columns: 1fr;
    }

    .page-title {
        font-size: 30px;
    }
}
</style>

<?php
$status = isset($order['status']) ? $order['status'] : 'pending';
$status_class = 'status-default';
$status_text = 'Đang xử lý';

if ($status == 'pending') {
    $status_class = 'status-pending';
    $status_text = 'Chờ xử lý';
} elseif ($status == 'paid') {
    $status_class = 'status-paid';
    $status_text = 'Đã thanh toán';
}
?>

<div class="order-detail-container">
    <div class="page-title">Chi tiết đơn hàng #<?php echo (int)$order['id']; ?></div>

    <div class="order-layout">
        <div class="order-card">
            <div class="card-title">Thông tin đơn hàng</div>

            <div class="info-row">
                <div class="info-label">Mã đơn hàng</div>
                <div class="info-value">#<?php echo (int)$order['id']; ?></div>
            </div>

            <div class="info-row">
                <div class="info-label">Trạng thái</div>
                <div class="info-value">
                    <span class="status-badge <?php echo $status_class; ?>">
                        <?php echo $status_text; ?>
                    </span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Ngày đặt</div>
                <div class="info-value">
                    <?php echo !empty($order['created_at']) ? htmlspecialchars($order['created_at']) : '---'; ?>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Khách hàng</div>
                <div class="info-value">
                    <?php echo !empty($order['customer_name']) ? htmlspecialchars($order['customer_name']) : '---'; ?>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Số điện thoại</div>
                <div class="info-value">
                    <?php echo !empty($order['phone']) ? htmlspecialchars($order['phone']) : '---'; ?>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Địa chỉ</div>
                <div class="info-value">
                    <?php echo !empty($order['address']) ? htmlspecialchars($order['address']) : '---'; ?>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Hình thức nhận</div>
                <div class="info-value">
                    <?php echo !empty($order['receive_method']) ? htmlspecialchars($order['receive_method']) : '---'; ?>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Thanh toán</div>
                <div class="info-value">
                    <?php echo !empty($order['payment_method']) ? htmlspecialchars($order['payment_method']) : '---'; ?>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Mức đá</div>
                <div class="info-value">
                    <?php echo !empty($order['ice_level']) ? htmlspecialchars($order['ice_level']) : '---'; ?>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Mức đường</div>
                <div class="info-value">
                    <?php echo !empty($order['sugar_level']) ? htmlspecialchars($order['sugar_level']) : '---'; ?>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Ghi chú</div>
                <div class="info-value">
                    <?php echo !empty($order['note']) ? htmlspecialchars($order['note']) : '---'; ?>
                </div>
            </div>
        </div>

        <div class="order-card">
            <div class="card-title">Sản phẩm trong đơn</div>

            <?php
            $subtotal = 0;
            if ($order_items_result && mysqli_num_rows($order_items_result) > 0) {
                while ($item = mysqli_fetch_assoc($order_items_result)) {
                    $qty = isset($item['quantity']) ? (int)$item['quantity'] : 0;
                    $price = isset($item['price']) ? (float)$item['price'] : 0;
                    $line_total = $qty * $price;
                    $subtotal += $line_total;
            ?>
                <div class="product-item">
                    <img src="../assets/images/<?php echo htmlspecialchars($item['product_image']); ?>" alt="">
                    <div class="product-info">
                        <div class="product-name"><?php echo htmlspecialchars($item['product_name']); ?></div>
                        <div class="product-meta">Số lượng: <?php echo $qty; ?></div>
                        <div class="product-meta">Đơn giá: <?php echo number_format($price, 0, ',', '.'); ?> đ</div>
                        <div class="product-subtotal">Tạm tính: <?php echo number_format($line_total, 0, ',', '.'); ?> đ</div>
                    </div>
                </div>
            <?php
                }
            } else {
                echo "<p>Không có sản phẩm nào trong đơn.</p>";
            }
            ?>

            <div class="summary-box">
                <div class="summary-row">
                    <span>Tạm tính</span>
                    <span><?php echo number_format($subtotal, 0, ',', '.'); ?> đ</span>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển</span>
                    <span>0 đ</span>
                </div>
                <div class="summary-total">
                    <span>Tổng cộng</span>
                    <span><?php echo number_format((float)$order['total'], 0, ',', '.'); ?> đ</span>
                </div>
            </div>
        </div>
    </div>

    <a href="/webbanhang/pages/orders.php" class="back-btn">← Quay lại đơn hàng</a>
</div>

<?php include("../includes/footer.php"); ?>