<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");
include("../includes/header_admin.php");

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($result);
$categories = mysqli_query($conn, "SELECT * FROM categories");

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];

    if(!empty($_FILES['image']['name'])){

        if(!empty($product['image'])){
            $oldPath = "../assets/images/" . $product['image'];
            if(file_exists($oldPath)){
                unlink($oldPath);
            }
        }

        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        $image_name = time() . "_" . basename($image);
        $target = "../assets/images/" . $image_name;

        move_uploaded_file($tmp, $target);

    } else {
        $image_name = $product['image'];
    }

    $query = "UPDATE products 
        SET name='$name',
            price='$price',
            description='$description',
            image='$image_name',
            category_id='$category_id'
        WHERE id=$id";

    mysqli_query($conn,$query);
    header("Location: products.php");
    exit();
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

/* IMAGE */
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

.upload-box img{
    width: 100px;
    border-radius: 8px;
    margin-bottom: 10px;
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
        <h2>Sửa sản phẩm</h2>
    </div>

    <div class="card">

        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label>Tên sản phẩm</label>
                <input type="text" name="name"
                    value="<?php echo htmlspecialchars($product['name']); ?>">
            </div>

            <div class="form-group">
                <label>Giá (VNĐ)</label>
                <input type="text" name="price"
                    value="<?php echo htmlspecialchars($product['price']); ?>">
            </div>

            <div class="form-group">
                <label>Danh mục</label>
                <select name="category_id">
                    <?php while($row = mysqli_fetch_assoc($categories)) { ?>
                        <option value="<?php echo $row['id']; ?>"
                            <?php if($row['id'] == $product['category_id']) echo "selected"; ?>>
                            <?php echo $row['name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label>Ảnh sản phẩm</label>

                <label class="upload-box">
                    <?php if(!empty($product['image'])){ ?>
                        <img src="../assets/images/<?php echo $product['image']; ?>">
                    <?php } else { ?>
                        No image
                    <?php } ?>

                    <br>Click để đổi ảnh
                    <input type="file" name="image" hidden>
                </label>
            </div>

            <div class="actions">
                <button class="btn btn-save" name="update">Cập nhật</button>
                <a href="products.php" class="btn btn-cancel">Hủy</a>
            </div>

        </form>

    </div>

</div>

<?php include("../includes/footer_admin.php"); ?>