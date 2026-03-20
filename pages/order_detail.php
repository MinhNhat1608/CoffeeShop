<?php

include("../config/database.php");
include("../includes/header.php");

$id = $_GET['id'];

$query = "SELECT * FROM order_details WHERE order_id=$id";

$result = mysqli_query($conn,$query);

?>

<h1>Order Detail</h1>

<table border="1">

<tr>
<th>Product</th>
<th>Quantity</th>
<th>Price</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['product_id']; ?></td>
<td><?php echo $row['quantity']; ?></td>
<td><?php echo $row['price']; ?></td>
</tr>

<?php } ?>

</table>

<?php include("../includes/footer.php"); ?>