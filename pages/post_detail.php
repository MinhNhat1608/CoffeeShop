<?php

include("../config/database.php");
include("../includes/header.php");

$id = $_GET['id'];

$query = "SELECT * FROM posts WHERE id=$id";

$result = mysqli_query($conn,$query);

$post = mysqli_fetch_assoc($result);

?>

<h1><?php echo $post['title']; ?></h1>

<p><?php echo $post['content']; ?></p>

<?php include("../includes/footer.php"); ?>