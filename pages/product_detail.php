<?php
session_start();
include("../config/database.php");

if(!isset($_GET['id'])){
    die("Thiếu ID sản phẩm");
}

$id = (int)$_GET['id'];

$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id = $id"));

if(!$product){
    die("Sản phẩm không tồn tại");
}

// submit review
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

// rating
$avg = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT AVG(rating) as avg_rating, COUNT(*) as total FROM reviews WHERE product_id = $id"));

$avg_rating = round($avg['avg_rating'] ?? 0);
$total_review = $avg['total'] ?? 0;

$reviews = mysqli_query($conn,
"SELECT * FROM reviews WHERE product_id = $id ORDER BY id DESC");
?>

<style>
body {
    background: #f5f5f5;
    margin: 0;
    padding-top: 70px;
    font-family: Arial, sans-serif;
    color: #222;
}

/* MAIN BOX */
.product-container {
    width: 85%;
    margin: auto;
    display: flex;
    gap: 40px;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* IMAGE */
.product-image {
    flex: 1;
    display: flex;
    justify-content: center;
}

.product-image img {
    width: 75%;
    height: 320px;
    object-fit: cover;
    border-radius: 12px;
}

/* INFO */
.product-info {
    flex: 1;
}

.product-title {
    font-size: 26px;
    font-weight: 600;
    color: #1f1f1f;
}

.product-price {
    font-size: 28px;
    color: #d4380d;
    font-weight: bold;
    margin: 10px 0;
}

/* RATING */
.rating {
    color: #faad14;
    font-size: 18px;
    margin: 10px 0;
}

/* DESCRIPTION */
.product-info p {
    color: #555;
    line-height: 1.7;
}

/* QTY */
.qty-box {
    display: flex;
    width: 240px;
    margin: 20px 0;
}

.qty-btn {
    flex: 1;
    padding: 10px;
    text-align: center;
    border: 1px solid #ddd;
    cursor: pointer;
    background: #fafafa;
}

.qty-input {
    flex: 2;
    text-align: center;
    border: 1px solid #ddd;
}

/* BUTTON */
.add-cart-btn {
    background: #ee4d2d;
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
}

.add-cart-btn:hover {
    background: #d73211;
}

/* REVIEW */
.review-box {
    width: 85%;
    margin: 30px auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
}

.review-box h3,
.review-box h4 {
    color: #1f1f1f;
}

.review-item {
    border-bottom: 1px solid #eee;
    padding: 10px 0;
}

.review-item b {
    color: #333;
}

.review-item p {
    color: #555;
}
</style>

<div class="product-container">

    <div class="product-image">
        <img src="../assets/images/<?php echo $product['image']; ?>">
    </div>

    <div class="product-info">

        <div class="product-title"><?php echo $product['name']; ?></div>

        <!-- rating -->
        <div class="rating">
            <?php
            for($i=1;$i<=5;$i++){
                echo $i <= $avg_rating ? "⭐" : "☆";
            }
            ?>
            (<?php echo $total_review; ?> đánh giá)
        </div>

        <div class="product-price">
            <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ
        </div>

        <p><?php echo $product['description']; ?></p>

        <!-- CART -->
        <form action="add_cart.php" method="GET">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

            <div class="qty-box">
                <div class="qty-btn" onclick="changeQty(-1)">-</div>
                <input type="number" name="qty" id="qty" value="1" min="1" class="qty-input">
                <div class="qty-btn" onclick="changeQty(1)">+</div>
            </div>

            <button class="add-cart-btn">🛒 Thêm vào giỏ</button>
        </form>

    </div>

</div>

<!-- REVIEW -->
<div class="review-box">

<h3>⭐ Đánh giá sản phẩm</h3>

<?php
if(mysqli_num_rows($reviews) == 0){
    echo "<p style='color:#777'>Chưa có đánh giá nào</p>";
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
    <textarea name="comment" required style="width:100%;height:80px;"></textarea><br><br>
    <button name="submit_review" class="add-cart-btn">Gửi</button>
</form>
<?php } else { ?>
    <p><a href="login.php">Đăng nhập</a> để viết đánh giá</p>
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