<?php 
include("../config/database.php"); 
include("../includes/header.php");

$cat_id = isset($_GET['category']) ? $_GET['category'] : '';

if($cat_id != ''){
    $query = "
        SELECT p.*, AVG(r.rating) AS avg_rating, COUNT(r.id) AS total_reviews
        FROM products p
        LEFT JOIN reviews r ON p.id = r.product_id
        WHERE p.category_id = $cat_id
        GROUP BY p.id
    ";
} else {
    $query = "
        SELECT p.*, AVG(r.rating) AS avg_rating, COUNT(r.id) AS total_reviews
        FROM products p
        LEFT JOIN reviews r ON p.id = r.product_id
        GROUP BY p.id
    ";
}
$result = mysqli_query($conn, $query);

$cat_query = "SELECT * FROM categories";
$categories = mysqli_query($conn, $cat_query);
?>

<section class="products">
    <div class="container">

        <div class="section-header">
            <div class="section-subtitle">Coffee Shop</div>
            <h2 class="section-title">Sản Phẩm Của Chúng Tôi</h2>
        </div>

        <!-- FILTER -->
        <div style="margin-bottom:20px;">
            <a href="products.php" class="btn btn-secondary">All</a>
            <?php while($cat = mysqli_fetch_assoc($categories)){ ?>
                <a href="products.php?category=<?php echo $cat['id']; ?>" class="btn btn-primary">
                    <?php echo $cat['name']; ?>
                </a>
            <?php } ?>
        </div>

        <div class="product-grid">

            <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <?php
    $avg_rating = ($row['avg_rating'] !== null) ? round($row['avg_rating']) : 0;
    $total_reviews = (int)$row['total_reviews'];
?>

            <div class="product-card">
                <div class="product-img">
                    <img src="../uploads/<?php echo $row['image']; ?>">
                </div>

                <div class="product-info">

                    <?php if($row['id'] % 2 == 0){ ?>
                        <div class="product-tag">NEW</div>
                    <?php } ?>

                    <h3 class="product-title"><?php echo $row['name']; ?></h3>

                    <p class="product-desc">
                        <?php echo $row['description']; ?>
                    </p>

                    <div class="product-footer">
                    <div class="product-price">
                        <?php echo number_format((float)$row['price'], 0, ',', '.'); ?> VNĐ
                    </div>

                    <div class="rating">
                    <?php
                    if($total_reviews > 0){
                        for($i = 1; $i <= 5; $i++){
                            echo ($i <= $avg_rating) ? "⭐" : "☆";
                        }
                        echo " (" . $total_reviews . ")";
                    } else {
                        echo "Chưa có đánh giá";
                    }
                    ?>
                </div>
                </div>

                    <!-- BUTTON -->
                    <div style="margin-top:10px; display:flex; gap:10px;">
                        
                        <a href="product_detail.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-secondary">
                            View
                        </a>

                        <a href="add_cart.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-primary">
                            🛒 Add
                        </a>

                    </div>

                </div>
            </div>

            <?php } ?>

        </div>
    </div>
</section>

<?php include("../includes/footer.php"); ?>