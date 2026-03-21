<?php
session_start();
include("../config/database.php");

// nếu chưa đăng nhập thì bắt login
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

// nếu có lưu user_id trong session thì lọc theo user đó
if (isset($_SESSION['user_id'])) {
    $user_id = (int)$_SESSION['user_id'];
    $query = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY id DESC";
} else {
    // fallback nếu chưa có user_id thì vẫn lấy toàn bộ
    $query = "SELECT * FROM orders ORDER BY id DESC";
}

$result = mysqli_query($conn, $query);

include("../includes/header.php");
?>

<style>
body {
    background: #f6f6f6;
}

.orders-container {
    width: 90%;
    max-width: 1100px;
    margin: 40px auto;
}

.orders-title {
    font-size: 32px;
    font-weight: 700;
    color: #2d1b12;
    margin-bottom: 24px;
}

.order-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    padding: 22px;
    margin-bottom: 18px;
    transition: 0.2s;
}

.order-card:hover {
    transform: translateY(-3px);
}

.order-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 14px;
    flex-wrap: wrap;
}

.order-id {
    font-size: 22px;
    font-weight: 700;
    color: #3b2418;
}

.order-status {
    padding: 8px 14px;
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

.order-info {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
    margin-top: 10px;
}

.info-box {
    background: #faf7f4;
    border-radius: 12px;
    padding: 14px;
}

.info-label {
    font-size: 13px;
    color: #777;
    margin-bottom: 6px;
}

.info-value {
    font-size: 18px;
    font-weight: 600;
    color: #2d1b12;
}

.order-actions {
    margin-top: 18px;
    display: flex;
    justify-content: flex-end;
}

.view-btn {
    display: inline-block;
    padding: 10px 18px;
    background: #8b5e3c;
    color: #fff;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    transition: 0.2s;
}

.view-btn:hover {
    background: #6f4b2f;
}

.empty-box {
    background: #fff;
    border-radius: 16px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    color: #666;
}

.shop-btn {
    display: inline-block;
    margin-top: 16px;
    padding: 10px 18px;
    border: 2px solid #8b5e3c;
    color: #8b5e3c;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
}

.shop-btn:hover {
    background: #8b5e3c;
    color: #fff;
}

@media (max-width: 768px) {
    .order-info {
        grid-template-columns: 1fr;
    }

    .order-top {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<div class="orders-container">
    <div class="orders-title">Đơn hàng của bạn</div>

    <?php if (!$result || mysqli_num_rows($result) == 0) { ?>
        <div class="empty-box">
            <p>Bạn chưa có đơn hàng nào.</p>
            <a href="products.php" class="shop-btn">Tiếp tục mua sắm</a>
        </div>
    <?php } else { ?>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <?php
                $status = isset($row['status']) ? $row['status'] : 'pending';
                $status_class = 'status-default';

                if ($status == 'pending') {
                    $status_class = 'status-pending';
                } elseif ($status == 'paid') {
                    $status_class = 'status-paid';
                }
            ?>

            <div class="order-card">
                <div class="order-top">
                    <div class="order-id">Đơn hàng #<?php echo $row['id']; ?></div>
                    <div class="order-status <?php echo $status_class; ?>">
                        <?php echo htmlspecialchars($status); ?>
                    </div>
                </div>

                <div class="order-info">
                    <div class="info-box">
                        <div class="info-label">Tổng tiền</div>
                        <div class="info-value">
                            <?php echo number_format((float)$row['total'], 0, ',', '.'); ?> đ
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">Ngày đặt</div>
                        <div class="info-value">
                            <?php echo !empty($row['created_at']) ? htmlspecialchars($row['created_at']) : '---'; ?>
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">Hình thức nhận</div>
                        <div class="info-value">
                            <?php echo !empty($row['receive_method']) ? htmlspecialchars($row['receive_method']) : '---'; ?>
                        </div>
                    </div>
                </div>

                <div class="order-actions">
                    <a href="/webbanhang/pages/order_detail.php?id=<?php echo $row['id']; ?>" class="view-btn">
                        Xem chi tiết
                    </a>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

<?php include("../includes/footer.php"); ?>