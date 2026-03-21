<?php

include("../config/database.php");
include("../includes/header.php");

$query = "SELECT * FROM posts";
$result = mysqli_query($conn,$query);

?>

<style>
.blog-container {
    max-width: 1000px;
    margin: 40px auto;
    font-family: Arial, sans-serif;
    padding-top: 30px;
}

.blog-title {
    text-align: center;
    font-size: 36px;
    margin-bottom: 30px;
    color: #6F4E37;
}

.blog-item {
    display: flex;
    gap: 20px;
    background: #fff;
    margin-bottom: 25px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: 0.3s;
}

.blog-item:hover {
    transform: translateY(-5px);
}

.blog-item img {
    width: 300px;
    height: 200px;
    object-fit: cover;
}

.blog-content {
    padding: 20px;
    flex: 1;
}

.blog-content h3 {
    margin-bottom: 10px;
    color: #3E2723;
    font-size: 24px;
}

.blog-content p {
    color: #555;
    line-height: 1.6;
}

.read-more {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 15px;
    background: #6F4E37;
    color: white;
    text-decoration: none;
    border-radius: 8px;
}

.read-more:hover {
    background: #D4AF37;
}
</style>

<div class="blog-container">

    <h1 class="blog-title"> Posts Coffee</h1>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>

    <div class="blog-item">
        <img src="../assets/images/<?php echo $row['image']; ?>" alt="">
        <div class="blog-content">
            <h3><?php echo $row['title']; ?></h3>
            <p>
                <?php echo substr($row['description'],0,150); ?>...
            </p>
            <a class="read-more" href="/webbanhang/pages/post_detail.php?id=<?php echo $row['id']; ?>">
                Read More →
            </a>
        </div>
    </div>
    <?php } ?>
</div>

<?php include("../includes/footer.php"); ?>