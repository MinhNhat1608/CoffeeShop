<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");
include("../includes/header_admin.php");
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: products.php");
    exit();
}

// Lấy danh sách sản phẩm
$sql = "SELECT * FROM products ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
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

.product-card{
    background: #ffffff;
    padding: 22px;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
}

.card-title{
    font-size: 22px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 18px;
}

.top-actions{
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    flex-wrap: wrap;
    gap: 10px;
}

.btn{
    display: inline-block;
    padding: 8px 14px;
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

.table-wrap{
    width: 100%;
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
}

tbody tr{
    border-bottom: 1px solid #e5e7eb;
}

tbody tr:hover{
    background: #f9fafb;
}

.product-thumb{
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 10px;
}

.no-image{
    width: 70px;
    height: 70px;
    background: #f1f5f9;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    color: #666;
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

    .card-title{
        font-size: 20px;
    }

    .product-card{
        padding: 16px;
    }
}
</style>

<div class="main-content">

    <div class="topbar">
        <h2>Quản lý sản phẩm</h2>
    </div>

    <div class="product-card">

        <div class="top-actions">
            <div class="card-title">Danh sách sản phẩm</div>
            <a href="add_product.php" class="btn btn-primary">+ Thêm sản phẩm</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Hình ảnh</th>
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

                                <td class="price">
                                    <?php echo number_format($row['price']); ?> đ
                                </td>

                                <td>
                                    <?php if (!empty($imageName) && file_exists($imagePath)) { ?>
                                        <img src="<?php echo $imagePath; ?>" class="product-thumb">
                                    <?php } else { ?>
                                        <div class="no-image">No image</div>
                                    <?php } ?>
                                </td>

                                <td>
                                    <div class="action-group">
                                        <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Sửa</a>

                                        <a href="products.php?delete=<?php echo $row['id']; ?>"
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
                            <td colspan="5" style="text-align:center; padding:20px;">
                                Chưa có sản phẩm nào
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>

    </div>

</div>

<?php include("../includes/footer_admin.php"); ?>