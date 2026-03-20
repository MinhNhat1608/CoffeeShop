<?php

include("../config/database.php");
include("../includes/header.php");

$id = $_GET['id'];

$query = "SELECT * FROM products WHERE category_id=$id";
$result = mysqli_query($conn,$query);

?>

<h1>Category Products</h1>
<?php while($row = mysqli_fetch_assoc($result)){ ?>

<div>

<h3><?php echo $row['name']; ?></h3>
<p><?php echo $row['price']; ?> $</p>
<a href="/webbanhang/pages/product_detail.php?id=<?php echo $row['id']; ?>">
View
</a>

</div>

<?php } ?>

<?php include("../includes/footer.php"); ?>