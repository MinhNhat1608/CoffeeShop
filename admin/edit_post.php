<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
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
    $query = "UPDATE posts 
SET title='$title', content='$content'
WHERE id=$id";

    mysqli_query($conn, $query);
    header("Location: posts.php");
}
?>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
    }

    .edit-card {
        max-width: 1200px;
        width: 50%;
        margin: 40px auto;
        margin-left: 550px;
        padding: 20px 60px;
        border-radius: 30px;
        background: linear-gradient(145deg, #9c593b, #8a4e29);
        border: 1px solid rgba(200, 155, 109, 0.2);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8);
        color: #f3e5d8;
    }

    .edit-card h2 {
        text-align: center;
        margin-bottom: 15px;
        font-size: 30px;
        color: #c89b6d;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 28px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: 500;
        color: #d2b48c;
        font-size: 20px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 15px;
        border-radius: 12px;
        border: 1px solid rgba(200, 155, 109, 0.3);
        background: #7f412a;
        color: #fff;
        font-size: 16px;
        box-sizing: border-box;
        transition: all 0.3s ease;
    }

    .form-group textarea {
        height: 150px;
        resize: vertical;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #c89b6d;
        outline: none;
        box-shadow: 0 0 10px rgba(200, 155, 109, 0.2);
    }

    .image-section {
        display: flex;
        gap: 20px;
        align-items: center;
        background: rgba(0, 0, 0, 0.2);
        padding: 20px;
        border-radius: 15px;
        border: 1px dashed rgba(200, 155, 109, 0.4);
    }

    .current-img-box {
        text-align: center;
    }

    .current-img-box p {
        font-size: 12px;
        margin-bottom: 5px;
        color: #a08060;
    }

    .current-img-box img {
        width: 120px;
        height: 40px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #c89b6d;
    }

    .upload-box {
        flex-grow: 1;
        text-align: center;
        cursor: pointer;
        color: #c89b6d;
    }

    .upload-box input {
        display: none;
    }

    .btn-update {
        width: 100%;
        max-width: 350px;
        display: block;
        margin: 40px auto 0;
        padding: 16px;
        border-radius: 50px;
        border: none;
        background: linear-gradient(135deg, #a67c52, #704a2d);
        color: white;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        transition: 0.3s;
    }

    .btn-update:hover {
        transform: translateY(-3px);
        filter: brightness(1.2);
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 25px;
        color: #888;
        text-decoration: none;
        font-size: 14px;
    }

    .back-link:hover {
        color: #c89b6d;
    }
</style>

<div class="edit-card">
    <h2> Edit Post</h2>
    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        </div>

        <div class="form-group">
            <label>Content</label>
            <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Post Image</label>
            <div class="image-section">
                <label class="upload-box">
                    <span>Click here to change image</span>
                    <input type="file" name="image" id="imageInput">
                    <div id="preview" style="margin-top:10px"></div>
                </label>
            </div>
        </div>
        <button type="submit" class="btn-update" name="update">Update Post</button>
    </form>

    <a href="posts.php" class="back-link">← Cancel and go back</a>
</div>

<script>
    document.getElementById("imageInput").addEventListener("change", function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById("preview");
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" style="width:100px; border-radius:5px; border:1px solid #c89b6d;">`;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
<?php include("../includes/footer_admin.php"); ?>