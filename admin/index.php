<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");
include("../includes/header_admin.php");

// DATA
$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM products"))['total'];
$total_orders   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders"))['total'];
$total_posts    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM posts"))['total'];

$query = "SELECT * FROM products ORDER BY id DESC LIMIT 5";
$result = mysqli_query($conn, $query);
?>

<style>
.main-content{
    max-width: 1120px;
    margin-top: 10px;
    margin-left: 150px ;
    padding: 0 16px 24px;
}

.topbar{
    background: #111827;
    color: #fff;
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
}

.topbar h2{
    margin: 0;
    font-size: 26px;
    font-weight: 700;
}

.quick-actions{
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.btn{
    display: inline-block;
    padding: 9px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: 0.2s;
}

.btn-primary{
    background: #2563eb;
    color: #fff;
}

.btn-primary:hover{
    background: #1d4ed8;
}

.btn-danger{
    background: #ef4444;
    color: #fff;
}

.btn-danger:hover{
    background: #dc2626;
}

.btn-dark{
    background: #111827;
    color: #fff;
}

.btn-dark:hover{
    background: #1f2937;
}

.stats{
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.stat-card{
    flex: 1;
    min-width: 200px;
    background: #ffffff;
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    text-align: center;
}

.stat-card h4{
    margin: 0;
    font-size: 16px;
    color: #6b7280;
}

.stat-card p{
    margin-top: 10px;
    font-size: 28px;
    font-weight: 700;
    color: #111827;
}

.table-card{
    background: #ffffff;
    padding: 22px;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
}

.table-header{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 16px;
}

.table-title{
    font-size: 22px;
    font-weight: 700;
    color: #111827;
}

.table-wrap{
    overflow-x: auto;
}

table{
    width: 100%;
    border-collapse: collapse;
    min-width: 760px;
}

thead{
    background: #7c4f2c;
    color: #fff;
}

th, td{
    padding: 14px 12px;
    text-align: left;
    vertical-align: middle;
}

tbody tr{
    border-bottom: 1px solid #e5e7eb;
}

tbody tr:hover{
    background: #f9fafb;
}

.product-img{
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    display: block;
}

.no-image{
    width: 60px;
    height: 60px;
    background: #f1f5f9;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #666;
    font-size: 12px;
}

.price{
    font-weight: 700;
    color: #2563eb;
}

.action-group{
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

@media (max-width: 768px){
    .topbar h2{
        font-size: 22px;
    }

    .table-title{
        font-size: 20px;
    }
}
</style>

<div class="main-content">

    <div class="topbar">
        <h2>Dashboard</h2>
    </div>

    <div class="quick-actions">
        <a href="add_product.php" class="btn btn-primary">+ Thêm sản phẩm</a>
        <a href="orders.php" class="btn btn-dark">Quản lý đơn hàng</a>
        <a href="add_post.php" class="btn btn-primary">+ Thêm bài viết</a>
        <a href="categories.php" class="btn btn-dark">Quản lý danh mục</a>
    </div>

    <div class="stats">
        <div class="stat-card">
            <h4>Sản phẩm</h4>
            <p><?php echo $total_products; ?></p>
        </div>

        <div class="stat-card">
            <h4>Đơn hàng</h4>
            <p><?php echo $total_orders; ?></p>
        </div>

        <div class="stat-card">
            <h4>Bài viết</h4>
            <p><?php echo $total_posts; ?></p>
        </div>
    </div>

    <div class="table-card">
        <div class="table-header">
            <div class="table-title">Sản phẩm mới</div>
            <a href="products.php" class="btn btn-dark">Xem tất cả</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Ảnh</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0) { ?>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <?php
                                $imageName = $row['image'];
                                $imagePath = "../assets/images/" . $imageName;
                            ?>
                            <tr>
                                <td><strong><?php echo $row['id']; ?></strong></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td class="price"><?php echo number_format($row['price']); ?> đ</td>
                                <td>
                                    <?php if (!empty($imageName) && file_exists($imagePath)) { ?>
                                        <img src="<?php echo $imagePath; ?>" class="product-img" alt="">
                                    <?php } else { ?>
                                        <div class="no-image">No image</div>
                                    <?php } ?>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Sửa</a>
                                        <a href="delete_product.php?id=<?php echo $row['id']; ?>"
                                           class="btn btn-danger"
                                           onclick="return confirm('Xóa sản phẩm này?')">
                                           Xóa
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">Chưa có sản phẩm nào.</td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>

</div>

<?php include("../includes/footer_admin.php"); ?>