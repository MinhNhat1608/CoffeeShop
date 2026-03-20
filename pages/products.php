<?php

include("../config/database.php");
include("../includes/header.php");

$query = "SELECT * FROM products";

$result = mysqli_query($conn,$query);

?>

<h1>Products</h1>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<div>

<img src="../uploads/<?php echo $row['image']; ?>" width="200">

<h3><?php echo $row['name']; ?></h3>

<p><?php echo $row['price']; ?> $</p>

<a href="/webbanhang/pages/product_detail.php?id=<?php echo $row['id']; ?>">
View
</a>

</div>

<?php } ?>

<?php include("../includes/footer.php"); ?>