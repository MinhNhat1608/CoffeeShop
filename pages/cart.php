<?php

session_start();

include("../config/database.php");
include("../includes/header.php");

$total = 0;

if(isset($_SESSION['cart'])){
foreach($_SESSION['cart'] as $id => $qty){
$query = "SELECT * FROM products WHERE id=$id";
$result = mysqli_query($conn,$query);
$product = mysqli_fetch_assoc($result);
$subtotal = $product['price'] * $qty;
$total += $subtotal;

?>

<div>

<h3><?php echo $product['name']; ?></h3>
<p>Quantity: <?php echo $qty; ?></p>
<p>Subtotal: <?php echo $subtotal; ?></p>
<a href="/webbanhang/pages/remove_cart.php?id=<?php echo $id; ?>"
onclick="return confirm('Remove this product?')">
Remove
</a>

</div>

<?php } } ?>

<h2>Total: <?php echo $total; ?></h2>

<a href="/webbanhang/pages/payment.php">Checkout</a>

<?php include("../includes/footer.php"); ?>