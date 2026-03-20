<?php
include("../includes/header.php");

session_start();

$id = $_GET['id'];

if(isset($_SESSION['cart'][$id])){
    
    $_SESSION['cart'][$id]++;

}else{

    $_SESSION['cart'][$id] = 1;

}

header("Location: pages/cart.php");

?>
<?php include("../includes/footer.php"); ?>