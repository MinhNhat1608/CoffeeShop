<?php

include("../config/database.php");
include("../includes/header.php");

$query = "SELECT * FROM posts";

$result = mysqli_query($conn,$query);

?>

<h1>Blog</h1>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<div>

<h3><?php echo $row['title']; ?></h3>
<p><?php echo substr($row['content'],0,100); ?>...</p>
<a href="/webbanhang/pages/post_detail.php?id=<?php echo $row['id']; ?>">
Read More
</a>

</div>

<?php } ?>

<?php include("../includes/footer.php"); ?>