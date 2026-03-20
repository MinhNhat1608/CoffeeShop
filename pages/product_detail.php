<?php

include("../config/database.php");
include("../includes/header.php");

$id = $_GET['id'];
$query = "SELECT * FROM products WHERE id=$id";
$result = mysqli_query($conn,$query);
$product = mysqli_fetch_assoc($result);

?>

<h1><?php echo $product['name']; ?></h1>
<img src="/webbanhang/uploads/<?php echo $product['image']; ?>" width="300">
<p><?php echo $product['description']; ?></p>
<p>Price: <?php echo $product['price']; ?> $</p>
<a href="/webbanhang/pages/add_cart.php?id=<?php echo $product['id']; ?>">
Add to Cart
</a>

<?php include("../includes/footer.php"); ?>