<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");
include("../includes/header_admin.php");

$id = $_GET['id'];
$query = "SELECT * FROM posts WHERE id=$id";
$result = mysqli_query($conn, $query);
$post = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $description = $_POST['description'];

    // ===== XỬ LÝ ẢNH =====
    if (!empty($_FILES['image']['name'])) {

        // xóa ảnh cũ
        if (!empty($post['image'])) {
            $oldPath = "../assets/images/" . $post['image'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // upload ảnh mới
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        $image_name = time() . "_" . basename($image);
        $target = "../assets/images/" . $image_name;

        move_uploaded_file($tmp, $target);

    } else {
        $image_name = $post['image']; // giữ ảnh cũ
    }

    // UPDATE DB
    $query = "UPDATE posts 
              SET title='$title',
                  content='$content',
                  description='$description',
                  image='$image_name'
              WHERE id=$id";

    mysqli_query($conn, $query);
    header("Location: posts.php");
    exit();
}
?>

<style>
body {
    background: #0c0805;
}

.edit-card {
    width: 50%;
    margin: 40px auto;
    padding: 20px;
    border-radius: 20px;
    background: #1e150e;
    color: #fff;
}

.form-group {
    margin-bottom: 15px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #444;
    background: #111;
    color: #fff;
}

.image-section {
    display: flex;
    gap: 20px;
    align-items: center;
}

.current-img img {
    width: 120px;
    border-radius: 8px;
}

.upload-box {
    cursor: pointer;
    color: #c89b6d;
}

.upload-box input {
    display: none;
}

.btn-update {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    background: #c89b6d;
    border: none;
    font-weight: bold;
    cursor: pointer;
}
</style>

<div class="edit-card">
    <h2>Edit Post</h2>

    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title"
                value="<?php echo htmlspecialchars($post['title']); ?>" required>
        </div>

        <div class="form-group">
            <label>Content</label>
            <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" required><?php echo htmlspecialchars($post['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Image</label>

            <div class="image-section">

                <!-- ẢNH HIỆN TẠI -->
                <div class="current-img">
                    <?php if (!empty($post['image'])) { ?>
                        <img src="../assets/images/<?php echo $post['image']; ?>">
                    <?php } else { ?>
                        No image
                    <?php } ?>
                </div>

                <!-- UPLOAD -->
                <label class="upload-box">
                    Change image
                    <input type="file" name="image" id="imageInput">
                </label>

            </div>

            <div id="preview"></div>
        </div>

        <button type="submit" name="update" class="btn-update">
            Update Post
        </button>
    </form>

    <br>
    <a href="posts.php" style="color:#ccc;">← Back</a>
</div>

<script>
document.getElementById("imageInput").addEventListener("change", function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById("preview");

    preview.innerHTML = "";

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" style="width:100px">`;
        }
        reader.readAsDataURL(file);
    }
});
</script>

<?php include("../includes/footer_admin.php"); ?>