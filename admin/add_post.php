<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");
include("../includes/header_admin.php");

if (isset($_POST['add'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $description = $_POST['description'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    $image_name = time() . "_" . basename($image);
    $target = "../assets/images/" . $image_name;

    if (move_uploaded_file($tmp, $target)) {

        $query = "INSERT INTO posts(title,content,description,image)
                  VALUES('$title','$content','$description','$image_name')";

        if (mysqli_query($conn, $query)) {
            header("Location: posts.php");
            exit();
        } else {
            echo "<p style='color:red'>Lỗi database</p>";
        }

    } else {
        echo "<p style='color:red'>Upload ảnh thất bại!</p>";
    }
}
?>

<style>
.main-content{
    max-width: 1120px;
    margin-top: 10px;
    margin-left: 150px ;
    padding: 0 16px 24px;
}


/* TOPBAR */
.topbar{
    background: #111827;
    color: #fff;
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
}

.topbar h2{
    margin: 0;
}

/* CARD */
.post-card{
    background: #ffffff;
    padding: 24px;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
}

/* FORM */
.form-group{
    margin-bottom: 18px;
}

.form-group label{
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #111827;
}

.form-group input,
.form-group textarea{
    width: 100%;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.form-group textarea{
    min-height: 100px;
}

/* UPLOAD */
.upload-box{
    border: 2px dashed #ccc;
    padding: 15px;
    text-align: center;
    border-radius: 10px;
    cursor: pointer;
    background: #f9fafb;
}

.upload-box:hover{
    background: #f1f5f9;
}

.upload-box input{
    display: none;
}

.preview img{
    max-width: 120px;
    margin-top: 10px;
    border-radius: 8px;
}

/* BUTTON */
.btn-submit{
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    border: none;
    background: #2563eb;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
}

.btn-submit:hover{
    background: #1d4ed8;
}
</style>

<div class="main-content">

    <div class="topbar">
        <h2>Thêm bài viết</h2>
    </div>

    <div class="post-card">

        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label>Tiêu đề</label>
                <input type="text" name="title" required>
            </div>

            <div class="form-group">
                <label>Nội dung</label>
                <textarea name="content" required></textarea>
            </div>

            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="description" required></textarea>
            </div>

            <div class="form-group">
                <label>Hình ảnh</label>

                <label class="upload-box">
                    Click để chọn ảnh
                    <input type="file" name="image" id="imageInput" required>
                </label>

                <div class="preview" id="preview"></div>
            </div>

            <button type="submit" class="btn-submit" name="add">
                Đăng bài
            </button>

        </form>

    </div>

</div>

<?php include("../includes/footer_admin.php"); ?>

<script>
document.getElementById("imageInput").addEventListener("change", function () {
    const file = this.files[0];
    const preview = document.getElementById("preview");

    preview.innerHTML = "";

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.innerHTML = `<img src="${e.target.result}">`;
        };
        reader.readAsDataURL(file);
    }
});
</script>