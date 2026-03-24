<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("../config/database.php");
include("../includes/header_admin.php");

$categories = mysqli_query($conn, "SELECT * FROM categories");

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id']; // sửa ở đây
    $image = $_FILES['image']['name'];

    move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image);

    $query = "INSERT INTO products(name,price,description,image,category_id)
    VALUES('$name','$price','$description','$image','$category_id')";

    mysqli_query($conn, $query);
    header("Location: products.php");
    exit();
}
?>

<style>
    body {
        color: white;
        font-family: Arial;
    }

    .container {
        max-width: 1200px;
        width: 50%;
        margin: 40px auto;
        margin-left: 500px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        box-sizing: border-box;
 
    }

    .card {
        background: linear-gradient(145deg, #9c593b, #8a4e29);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 0 40px rgba(0, 0, 0, 0.8);
        width: 100%;
        max-width: 700px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .actions {
        margin-top: 30px;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .title {
        color: #ffcc00;
        font-size: 22px;
        margin-bottom: 20px;
        font-size: 28px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 15px;
    }

    .btn-cancel {
        text-decoration: none;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    label {
        margin-bottom: 5px;
        font-size: 14px;
        font-size: 20px;
    }

    input,
    select,
    textarea {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: #7f412a;
        color: white;
    }

    textarea {
        height: 100px;
    }

    .upload-box {
        border: 2px dashed rgba(255, 255, 255, 0.3);
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
    }

    .upload-box:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    .actions {
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        margin-right: 10px;
    }

    .btn-save {
        background: #ffcc00;
        color: black;
    }

    .btn-cancel {
        background: #e74c3c;
        color: white;
    }
</style>

<div class="container">
    <div class="card">
        <div class="title">Add New Product</div>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-group">
                    <label>Product Name:</label>
                    <input type="text" name="name">
                </div>

                <div class="form-group">
                    <label>Price (VNĐ):</label>
                    <input type="text" name="price">
                </div>

                <div class="form-group">
                    <label>Category:</label>
                    <select name="category_id">
                        <option value="">-- Select Category --</option>
                        <?php while ($row = mysqli_fetch_assoc($categories)) { ?>
                            <option value="<?php echo $row['id']; ?>">
                                <?php echo $row['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label>Description:</label>
                    <textarea name="description"></textarea>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label>Product Image:</label>
                    <label class="upload-box">
                        Click to upload image
                        <input type="file" name="image" hidden>
                    </label>
                </div>

            </div>

            <div class="actions">
                <button class="btn btn-save" name="add">Save Product</button>
                <a href="products.php" class="btn btn-cancel">Cancel</a>
            </div>

        </form>
    </div>
</div>

<?php include("../includes/footer_admin.php"); ?>