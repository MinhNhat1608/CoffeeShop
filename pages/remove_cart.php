<?php
include("../includes/header.php");
session_start();

if(isset($_GET['id'])){

    $id = $_GET['id'];
    if(isset($_SESSION['cart'][$id])){

        unset($_SESSION['cart'][$id]); 
    }
}
header("Location: pages/cart.php");
exit();

?>
<?php include("../includes/footer.php"); ?>