<?php

session_start();

include("../config/database.php");
include("../includes/header.php");

$query = "SELECT * FROM orders";

$result = mysqli_query($conn,$query);

?>

<h1>Your Orders</h1>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<div>
Order ID: <?php echo $row['id']; ?>
Total: <?php echo $row['total']; ?>
<a href="/webbanhang/pages/order_detail.php?id=<?php echo $row['id']; ?>">
View Detail
</a>

</div>

<?php } ?>

<?php include("../includes/footer.php"); ?>