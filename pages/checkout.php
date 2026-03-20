<?php

session_start();
include("../config/database.php");
include("../includes/header.php");

?>

<h1>Checkout</h1>

<form method="POST">

<input type="text" name="name" placeholder="Your name">

<input type="text" name="phone" placeholder="Phone">

<button type="submit" name="order">Order</button>

</form>

<?php

if(isset($_POST['order'])){
echo "Order success!";
unset($_SESSION['cart']);

}

?>

<?php include("../includes/footer.php"); ?>