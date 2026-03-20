<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("../config/database.php");
include("../includes/header_admin.php");

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $delete = "DELETE FROM products WHERE id = '$id'";
    mysqli_query($conn, $delete);
    header("Location: products.php");
    exit();
}

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
?>

<style>
    .product-box {
        background: linear-gradient(145deg, #2c1b14, #1a120d);
        padding: 25px;
        border-radius: 15px;
        margin: 20px;
        color: #fff;
    }

    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .topbar h2 {
        color: #f1c40f;
    }

    .add-btn {
        background: #d4a017;
        color: #000;
        padding: 10px 15px;
        border-radius: 20px;
        text-decoration: none;
    }

    .table-section {
        overflow-x: auto;
    }

    .table-section table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-section th {
        background: #5a3b2e;
        padding: 12px;
    }

    .table-section td {
        padding: 12px;
        border-bottom: 1px solid #444;
    }

    .table-section img {
        border-radius: 8px;
    }

    .btn {
        padding: 6px 10px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 13px;
    }

    .btn.edit {
        background: #f1c40f;
        color: #000;
    }

    .btn.delete {
        background: #e74c3c;
        color: #fff;
    }
</style>
<main class="main-content">
    <div class="product-box">
        <header class="topbar">
            <h2>Manage Products</h2>
            <a href="add_product.php" class="btn add-btn">
                <i class="fa fa-plus"></i> Add Product
            </a>
        </header>

        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td>$<?php echo $row['price']; ?></td>
                            <td>
                                <img src="/webbanhang/assets/images/<?php echo $row['image']; ?>" width="60">
                            </td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn edit">Edit</a>
                                <a href="?delete_id=<?php echo $row['id']; ?>"
                                    class="btn delete"
                                    onclick="return confirm('Bạn có chắc muốn xóa?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include("../includes/footer_admin.php"); ?>