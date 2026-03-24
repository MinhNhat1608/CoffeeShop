<?php
include("../config/database.php");
include("../includes/header.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Danh mục không hợp lệ";
    exit();
}

$id = (int)$_GET['id'];

$query = "SELECT * FROM products WHERE category_id = $id";
$result = mysqli_query($conn, $query);
?>

<h1>Category Products</h1>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <div>
        <h3><?php echo $row['name']; ?></h3>
        <p><?php echo number_format($row['price'], 0, ',', '.'); ?> đ</p>
        <a href="/webbanhang/pages/product_detail.php?id=<?php echo $row['id']; ?>">
            View
        </a>
    </div>
<?php } ?>

<?php include("../includes/footer.php"); ?>