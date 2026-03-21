<?php
session_start();
include("../includes/header.php");

// xử lý + - / remove
if(isset($_GET['action']) && isset($_GET['id'])){
    $id = (int)$_GET['id'];

    if(isset($_SESSION['cart'][$id])){

        if($_GET['action'] == "plus"){
            $_SESSION['cart'][$id]['quantity']++;
        }

        if($_GET['action'] == "minus"){
            $_SESSION['cart'][$id]['quantity']--;

            if($_SESSION['cart'][$id]['quantity'] <= 0){
                unset($_SESSION['cart'][$id]);
            }
        }

        if($_GET['action'] == "remove"){
            unset($_SESSION['cart'][$id]);
        }
    }

    header("Location: cart.php");
    exit;
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<style>
body { background:#f5f5f5; }

.cart-container {
    width:85%;
    margin:40px auto;
}

.cart-title {
    font-size:26px;
    margin-bottom:20px;
}

/* CARD */
.cart-item {
    display:flex;
    align-items:center;
    background:#fff;
    padding:15px;
    margin-bottom:15px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
    transition:0.2s;
}

.cart-item:hover {
    transform: translateY(-3px);
}

/* IMAGE */
.cart-item img {
    width:150px;
    height:90px;
    border-radius:10px;
    object-fit:cover;
}

/* INFO */
.cart-info {
    flex:2;
    margin-left:35px;
    
}
.cart-info h4 {
    font-size:26px;  
    font-weight:600; 
    margin-bottom:10px;
}

.price {
    color:#ee4d2d;
    font-weight:bold;
}

/* QUANTITY */
.qty-box {
    display:flex;
    align-items:center;
    margin-top:8px;
    width: 220px;
}

.qty-btn {
    padding:5px 12px;
    border:1px solid #ddd;
    background:#fff;
    text-decoration:none;
    transition:0.2s;
}

.qty-btn:hover {
    background:#ee4d2d;
    color:white;
}

.qty-number {
    padding:5px 15px;
    border-top:1px solid #ddd;
    border-bottom:1px solid #ddd;
}

/* REMOVE */
.remove {
    color:red;
    text-decoration:none;
}

/* SUMMARY */
.cart-summary {
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
    text-align:right;
    margin-top:20px;
}

/* BUTTONS */
.continue-btn {
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 18px;
    background:#fff;
    border:2px solid #ee4d2d;
    color:#ee4d2d;
    border-radius:8px;
    text-decoration:none;
    font-weight:500;
    transition:0.2s;
}

.continue-btn:hover {
    background:#ee4d2d;
    color:white;
}

.checkout-btn {
    background:#ee4d2d;
    color:white;
    padding:10px 25px;
    border-radius:8px;
    text-decoration:none;
    display:inline-block;
    margin-top:10px;
    transition:0.2s;
}

.checkout-btn:hover {
    background:#d73211;
}
</style>

<div class="cart-container">
<div class="cart-title">🛒 Giỏ hàng</div>

<?php if(empty($cart)){ ?>
    <p>Giỏ hàng trống</p>
<?php } else { ?>

<?php 
$total = 0;

foreach($cart as $id => $item):
if(!is_array($item)) continue;

$price = (float)$item['price'];
$qty = (int)$item['quantity'];
$subtotal = $price * $qty;
$total += $subtotal;
?>

<div class="cart-item">
    <img src="../uploads/<?php echo $item['image']; ?>">

    <div class="cart-info">
        <h4><?php echo $item['name']; ?></h4>
        <div class="price">$<?php echo $price; ?></div>

        <div class="qty-box">
            <a href="cart.php?action=minus&id=<?php echo $id; ?>" class="qty-btn">-</a>
            <div class="qty-number"><?php echo $qty; ?></div>
            <a href="cart.php?action=plus&id=<?php echo $id; ?>" class="qty-btn">+</a>
        </div>

        <p>Subtotal: <b>$<?php echo $subtotal; ?></b></p>
    </div>

    <a href="cart.php?action=remove&id=<?php echo $id; ?>" class="remove">
        Remove
    </a>
</div>

<?php endforeach; ?>

<div class="cart-summary">
    <h2>Total: $<?php echo $total; ?></h2>

    <!-- NÚT ĐẸP -->
    <a href="products.php" class="continue-btn">
        Tiếp Tục Mua Sắm
    </a>

    <br>

    <!-- CHECK LOGIN -->
    <?php if(isset($_SESSION['user'])){ ?>
        <a href="checkout.php" class="checkout-btn">Thanh toán</a>
    <?php } else { ?>
        <a href="login.php" class="checkout-btn">Thanh toán</a>
    <?php } ?>
</div>

<?php } ?>
</div>

<?php include("../includes/footer.php"); ?>