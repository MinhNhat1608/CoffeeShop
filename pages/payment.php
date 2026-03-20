<?php

session_start();

include("../includes/header.php");

?>

<h1>Payment</h1>

<p>Choose payment method</p>

<form action="/webbanhang/pages/checkout.php" method="POST">
<input type="radio" name="payment" value="cod"> Cash on Delivery
<br>
<input type="radio" name="payment" value="bank"> Bank Transfer
<br><br>
<button type="submit">Pay</button>
</form>

<?php include("../includes/footer.php"); ?>