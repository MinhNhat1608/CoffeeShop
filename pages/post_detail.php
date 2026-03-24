<?php
include("../config/database.php");
include("../includes/header.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $error = "Không tìm thấy bài viết!";
} else {
    $id = (int)$_GET['id'];
    $query = "SELECT * FROM posts WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        $error = "Bài viết không tồn tại!";
    } else {
        $post = mysqli_fetch_assoc($result);
        $newPosts = mysqli_query($conn, "SELECT id, title FROM posts ORDER BY id DESC LIMIT 5");
    }
}
?>

<style>
body {
    padding-top: 120px;
    background: #f5f0dc;
}

.error-box {
    max-width: 700px;
    margin: 60px auto;
    background: #fff;
    padding: 30px;
    border-radius: 14px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.error-box h2 {
    color: #3E2723;
    margin-bottom: 15px;
}

.error-box a {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 18px;
    background: #6F4E37;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
}
.post-container {
    max-width: 90%;
    margin: 40px auto;
    font-family: Arial, sans-serif;
    padding-top: 50px;
    display: flex;
    gap: 30px;
}

.post-title {
    font-size: 36px;
    color: #3E2723;
    margin-bottom: 20px;
}

.post-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 15px;
    margin-bottom: 20px;
    height: 400px;
    width: 100%;
}

.post-content {
    font-size: 18px;
    line-height: 1.8;
    color: #444;
}

.sidebar h3 {
    margin-bottom: 15px;
    color: #3E2723;
    font-size: 28px;
    text-align: center;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    margin-bottom: 10px;
}

.sidebar ul li a {
    text-decoration: none;
    color: #333;
    transition: 0.3s;
}

.sidebar ul li a:hover {
    color: #D4AF37;
}

.main-post {
    flex: 5;
}

.sidebar {
    flex: 1;
    background: #f7dda9;
    padding: 20px;
    border-radius: 15px;
    height: fit-content;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    padding-top: 30px;
}

.back-btn {
    display: inline-block;
    margin-top: 30px;
    padding: 10px 18px;
    background: #6F4E37;
    color: white;
    text-decoration: none;
    border-radius: 8px;
}

.back-btn:hover {
    background: #D4AF37;
}
</style>

<?php if (isset($error)) { ?>
    <div class="error-box">
        <h2><?php echo $error; ?></h2>
        <a href="/webbanhang/pages/posts.php">Quay lại danh sách bài viết</a>
    </div>
<?php } else { ?>
    <div class="post-container">

    <div class="main-post">
        <img class="post-image" src="../assets/images/<?php echo $post['image']; ?>" alt="">
        <h1 class="post-title"><?php echo $post['title']; ?></h1>
        <div class="post-content">
            <?php echo nl2br($post['content']); ?>
        </div>
        <a class="back-btn" href="/webbanhang/pages/posts.php">
            ← Quay lại Post
        </a>
    </div>

    <div class="sidebar">
        <h3>Bài viết mới</h3>
        <ul>
            <?php while($row = mysqli_fetch_assoc($newPosts)){ ?>
                <li>
                    <a href="/webbanhang/pages/post_detail.php?id=<?php echo $row['id']; ?>">
                        <?php echo $row['title']; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>

</div>
<?php } ?>

<?php include("../includes/footer.php"); ?>