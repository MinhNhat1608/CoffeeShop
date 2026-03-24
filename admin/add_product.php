<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");
include("../includes/header_admin.php");

$categories = mysqli_query($conn, "SELECT * FROM categories");

if (isset($_POST['add'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        $image_name = time() . "_" . basename($image);
        $target = "../assets/images/" . $image_name;

        if (move_uploaded_file($tmp, $target)) {

            $query = "INSERT INTO products(name,price,description,image,category_id)
                      VALUES('$name','$price','$description','$image_name','$category_id')";

            mysqli_query($conn, $query);
            header("Location: products.php");
            exit();

        } else {
            echo "<p style='color:red'>Upload ảnh thất bại!</p>";
        }

    } else {
        echo "<p style='color:red'>Bạn chưa chọn ảnh!</p>";
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
.card{
    background: #ffffff;
    padding: 24px;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
}

/* FORM */
.form-group{
    margin-bottom: 16px;
    color: #111827;
}

label{
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
}

input, select, textarea{
    width: 100%;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

textarea{
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

.preview img{
    width: 100px;
    border-radius: 8px;
    margin-top: 10px;
}

/* BUTTON */
.actions{
    margin-top: 20px;
}

.btn{
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    display: inline-block;
}

.btn-save{
    background: #2563eb;
    color: #fff;
}

.btn-save:hover{
    background: #1d4ed8;
}

.btn-cancel{
    background: #ef4444;
    color: #fff;
}

.btn-cancel:hover{
    background: #dc2626;
}
</style>

<div class="main-content">

    <div class="topbar">
        <h2>Thêm sản phẩm</h2>
    </div>

    <div class="card">

        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label>Tên sản phẩm</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Giá (VNĐ)</label>
                <input type="text" name="price" required>
            </div>

            <div class="form-group">
                <label>Danh mục</label>
                <select name="category_id" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php while ($row = mysqli_fetch_assoc($categories)) { ?>
                        <option value="<?php echo $row['id']; ?>">
                            <?php echo $row['name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="description"></textarea>
            </div>

            <div class="form-group">
                <label>Ảnh sản phẩm</label>

                <label class="upload-box">
                    Click để chọn ảnh
                    <input type="file" name="image" id="imageInput" hidden>
                </label>

                <div class="preview" id="preview"></div>
            </div>

            <div class="actions">
                <button class="btn btn-save" name="add">Lưu sản phẩm</button>
                <a href="products.php" class="btn btn-cancel">Hủy</a>
            </div>

        </form>

    </div>

</div>

<script>
document.getElementById("imageInput").addEventListener("change", function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById("preview");

    preview.innerHTML = "";

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}">`;
        }
        reader.readAsDataURL(file);
    }
});
</script>

<?php include("../includes/footer_admin.php"); ?>