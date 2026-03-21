<?php
session_start();
include("../config/database.php");

$id = (int)$_GET['id'];

// lấy sản phẩm
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id = $id"));

// 🔥 xử lý submit review (KHÔNG LỖI HEADER)
if(isset($_POST['submit_review'])){

    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit;
    }

    $rating = (int)$_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $username = $_SESSION['user'];

    mysqli_query($conn, "INSERT INTO reviews(product_id,username,rating,comment)
    VALUES($id,'$username',$rating,'$comment')");

    header("Location: product_detail.php?id=$id");
    exit;
}

include("../includes/header.php");

// ⭐ tính rating
$avg = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT AVG(rating) as avg_rating, COUNT(*) as total FROM reviews WHERE product_id = $id"));

$avg_rating = round($avg['avg_rating']);
$total_review = $avg['total'];

// lấy review
$reviews = mysqli_query($conn,
"SELECT * FROM reviews WHERE product_id = $id ORDER BY id DESC");
?>

<style>
body { background:#f5f5f5; }

.product-container {
    width:85%;
    margin:40px auto;
    display:flex;
    gap:40px;
}

.product-image {
    flex:1;
    display:flex;
    justify-content:center;
}

.product-image img {
    width:75%;
    height:280px;
    object-fit:cover;
    border-radius:12px;
}

.product-info { flex:1; }

.product-title { font-size:30px; font-weight:600; }

.product-price { font-size:26px; color:#ee4d2d; }

.rating { color:gold; font-size:18px; margin:10px 0; }

.qty-box { display:flex; width:240px; margin:15px 0; }

.qty-btn {
    flex:1;
    padding:10px;
    text-align:center;
    border:1px solid #ddd;
    cursor:pointer;
}

.qty-input {
    flex:2;
    text-align:center;
    border:1px solid #ddd;
}

.add-cart-btn {
    background:#ee4d2d;
    color:white;
    padding:12px 25px;
    border:none;
    border-radius:8px;
}

/* REVIEW */
.review-box {
    width:85%;
    margin:40px auto;
    background:#fff;
    padding:20px;
    border-radius:10px;
}

.review-item {
    border-bottom:1px solid #eee;
    padding:10px 0;
}
</style>

<div class="product-container">

    <div class="product-image">
        <img src="../uploads/<?php echo $product['image']; ?>">
    </div>

    <div class="product-info">

        <div class="product-title"><?php echo $product['name']; ?></div>

        <!-- ⭐ rating -->
        <div class="rating">
            <?php
            for($i=1;$i<=5;$i++){
                echo $i <= $avg_rating ? "⭐" : "☆";
            }
            ?>
            (<?php echo $total_review; ?> đánh giá)
        </div>

        <div class="product-price">$<?php echo $product['price']; ?></div>

        <p><?php echo $product['description']; ?></p>

        <!-- ADD CART -->
        <form action="add_cart.php" method="GET">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

            <div class="qty-box">
                <div class="qty-btn" onclick="changeQty(-1)">-</div>
                <input type="number" name="qty" id="qty" value="1" min="1" class="qty-input">
                <div class="qty-btn" onclick="changeQty(1)">+</div>
            </div>

            <button class="add-cart-btn">🛒 Add to cart</button>
        </form>

    </div>

</div>

<!-- REVIEW -->
<div class="review-box">

<h3>⭐ Đánh giá sản phẩm</h3>

<?php
if(mysqli_num_rows($reviews) == 0){
    echo "<p>Chưa có đánh giá nào</p>";
} else {
    while($r = mysqli_fetch_assoc($reviews)){
?>

<div class="review-item">
    <b><?php echo $r['username']; ?></b>

    <div>
        <?php
        for($i=1;$i<=5;$i++){
            echo $i <= $r['rating'] ? "⭐" : "☆";
        }
        ?>
    </div>

    <p><?php echo $r['comment']; ?></p>
</div>

<?php }} ?>

<hr>

<h4>Viết đánh giá</h4>

<?php if(isset($_SESSION['user'])){ ?>
<form method="POST">
    <input type="number" name="rating" min="1" max="5" required><br><br>
    <textarea name="comment" required></textarea><br><br>
    <button name="submit_review">Gửi</button>
</form>
<?php } else { ?>
    <p> <a href="login.php">Đăng nhập</a> để viết đánh giá</p>
<?php } ?>

</div>

<script>
function changeQty(num){
    let input = document.getElementById("qty");
    let value = parseInt(input.value);
    value += num;
    if(value < 1) value = 1;
    input.value = value;
}
</script>

<?php include("../includes/footer.php"); ?>