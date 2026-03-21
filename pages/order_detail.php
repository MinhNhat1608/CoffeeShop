<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("Đơn hàng không hợp lệ");
}

// lấy thông tin đơn hàng
$order_query = "SELECT * FROM orders WHERE id = $id";
$order_result = mysqli_query($conn, $order_query);
$order = mysqli_fetch_assoc($order_result);

if (!$order) {
    die("Không tìm thấy đơn hàng");
}

// lấy chi tiết đơn hàng + tên sản phẩm + ảnh
$detail_query = "
    SELECT od.*, p.name, p.image
    FROM order_details od
    LEFT JOIN products p ON od.product_id = p.id
    WHERE od.order_id = $id
    ORDER BY od.id DESC
";
$detail_result = mysqli_query($conn, $detail_query);

include("../includes/header.php");
?>

<style>
body {
    background: #f6f6f6;
}

.detail-container {
    width: 90%;
    max-width: 1100px;
    margin: 40px auto;
}

.detail-title {
    font-size: 32px;
    font-weight: 700;
    color: #2d1b12;
    margin-bottom: 24px;
}

.detail-grid {
    display: grid;
    grid-template-columns: 0.95fr 1.05fr;
    gap: 24px;
    margin-bottom: 24px;
}

.info-card,
.items-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    padding: 24px;
}

.card-title {
    font-size: 22px;
    font-weight: 700;
    color: #3b2418;
    margin-bottom: 18px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    color: #777;
    font-weight: 500;
}

.info-value {
    color: #2d1b12;
    font-weight: 600;
    text-align: right;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    display: inline-block;
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
    padding: 16px 0;
    border-bottom: 1px solid #f0f0f0;
}

.product-item:last-child {
    border-bottom: none;
}

.product-item img {
    width: 92px;
    height: 92px;
    object-fit: cover;
    border-radius: 12px;
    background: #fafafa;
}

.product-info {
    flex: 1;
}

.product-name {
    font-size: 18px;
    font-weight: 700;
    color: #2d1b12;
    margin-bottom: 6px;
}

.product-meta {
    color: #777;
    margin-bottom: 6px;
}

.product-price {
    color: #d35400;
    font-weight: 700;
}

.total-box {
    margin-top: 18px;
    padding-top: 16px;
    border-top: 2px dashed #eee;
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    color: #555;
}

.total-final {
    display: flex;
    justify-content: space-between;
    font-size: 22px;
    font-weight: 700;
    color: #d35400;
}

.back-btn {
    display: inline-block;
    padding: 10px 18px;
    background: #8b5e3c;
    color: #fff;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    transition: 0.2s;
}

.back-btn:hover {
    background: #6f4b2f;
}

@media (max-width: 900px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }

    .info-row {
        flex-direction: column;
    }

    .info-value {
        text-align: left;
    }
}
</style>

<div class="detail-container">
    <div class="detail-title">Chi tiết đơn hàng #<?php echo $order['id']; ?></div>

    <div class="detail-grid">
        <div class="info-card">
            <div class="card-title">Thông tin đơn hàng</div>

            <?php
                $status = isset($order['status']) ? $order['status'] : 'pending';
                $status_class = 'status-default';

                if ($status == 'pending') {
                    $status_class = 'status-pending';
                } elseif ($status == 'paid') {
                    $status_class = 'status-paid';
                }
            ?>

            <div class="info-row">
                <div class="info-label">Mã đơn hàng</div>
                <div class="info-value">#<?php echo $order['id']; ?></div>
            </div>

            <div class="info-row">
                <div class="info-label">Trạng thái</div>
                <div class="info-value">
                    <span class="status-badge <?php echo $status_class; ?>">
                        <?php echo htmlspecialchars($status); ?>
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

        <div class="items-card">
            <div class="card-title">Sản phẩm trong đơn</div>

            <?php
            $grand_total = 0;
            if ($detail_result && mysqli_num_rows($detail_result) > 0) {
                while($row = mysqli_fetch_assoc($detail_result)) {
                    $qty = (int)$row['quantity'];
                    $price = (float)$row['price'];
                    $subtotal = $qty * $price;
                    $grand_total += $subtotal;
            ?>
                <div class="product-item">
                    <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="">

                    <div class="product-info">
                        <div class="product-name"><?php echo htmlspecialchars($row['name']); ?></div>
                        <div class="product-meta">Số lượng: <?php echo $qty; ?></div>
                        <div class="product-meta">Đơn giá: <?php echo number_format($price, 0, ',', '.'); ?> đ</div>
                        <div class="product-price">Tạm tính: <?php echo number_format($subtotal, 0, ',', '.'); ?> đ</div>
                    </div>
                </div>
            <?php
                }
            } else {
                echo "<p>Không có sản phẩm nào trong đơn hàng này.</p>";
            }
            ?>

            <div class="total-box">
                <div class="total-row">
                    <span>Tạm tính</span>
                    <span><?php echo number_format($grand_total, 0, ',', '.'); ?> đ</span>
                </div>
                <div class="total-row">
                    <span>Phí vận chuyển</span>
                    <span>0 đ</span>
                </div>
                <div class="total-final">
                    <span>Tổng cộng</span>
                    <span><?php echo number_format((float)$order['total'], 0, ',', '.'); ?> đ</span>
                </div>
            </div>
        </div>
    </div>

    <a href="/webbanhang/pages/orders.php" class="back-btn">← Quay lại đơn hàng</a>
</div>

<?php include("../includes/footer.php"); ?>