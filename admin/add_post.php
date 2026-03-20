<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("../config/database.php");
include("../includes/header_admin.php");

if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "../assets/images/" . $image
    );

    $query = "INSERT INTO posts(title,content,description,image)
VALUES('$title','$content','$description','$image')";

    mysqli_query($conn, $query);
    header("Location: posts.php");
    exit();
}

?>
<style>
    .post-card {
        max-width: 1200px;
        width: 50%;
        margin: 40px auto;
        margin-left: 550px;
        padding: 20px;
        border-radius: 20px;
        background: rgba(44, 30, 20, 0.6);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(200, 155, 109, 0.2);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
        color: #f3e5d8;
    }

    .post-card h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        color: #c89b6d;
        font-weight: bold;
        font-size: 28px;
    }

    .form-group {
        margin-bottom: 25px;
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
        padding: 12px 15px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        outline: none;
        background: rgba(0, 0, 0, 0.2);
        color: #fff;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .form-group textarea {
        height: 80px;
        resize: none;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border: 1px solid #c89b6d;
        background: rgba(0, 0, 0, 0.3);
        box-shadow: 0 0 8px rgba(200, 155, 109, 0.3);
    }

    .upload-box {
        border: 2px dashed rgba(200, 155, 109, 0.5);
        padding: 30px;
        text-align: center;
        border-radius: 15px;
        cursor: pointer;
        background: rgba(255, 255, 255, 0.03);
        transition: 0.3s;
        display: block;
    }

    .upload-box:hover {
        background: rgba(200, 155, 109, 0.1);
        border-color: #c89b6d;
    }

    .upload-box input {
        display: none;
    }

    .upload-box i {
        display: block;
        font-size: 24px;
        margin-bottom: 10px;
    }

    .preview {
        margin-top: 15px;
    }

    .preview img {
        max-width: 120px;
        border-radius: 8px;
        border: 2px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .btn-submit {
        width: 100%;
        padding: 10px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #8b5e3c, #c89b6d);
        color: white;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: transform 0.2s, box-shadow 0.2s;
        margin-top: 10px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
    }

    .back-container {
        text-align: center;
        margin-top: 20px;
    }

    .btn-back {
        color: #c89b6d;
        text-decoration: none;
        font-size: 14px;
        transition: 0.3s;
    }

    .btn-back:hover {
        text-decoration: underline;
        opacity: 0.8;
    }
</style>
<div class="post-card">
    <h2> Add New Post</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" required>
        </div>

        <div class="form-group">
            <label>Content</label>
            <textarea name="content" required></textarea>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" required></textarea>
        </div>

        <div class="form-group">
            <label>Image</label>
            <label class="upload-box">
                <span> Click to upload image</span>
                <input type="file" name="image" id="imageInput" required>
            </label>
            <div class="preview" id="preview">
            </div>
        </div>

        <button type="submit" class="btn-submit" name="add"> Publish Post</button>
    </form>

    <div class="back-container">
        <a href="posts.php" class="btn-back">← Back to Posts</a>
    </div>
</div>
<?php include("../includes/footer_admin.php"); ?>