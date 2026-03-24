<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
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
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$image);
    } else {
        $image = $product['image'];
    }

    $query = "UPDATE products 
    SET name='$name', price='$price', description='$description',
        image='$image', category_id='$category_id'
    WHERE id=$id";

    mysqli_query($conn,$query);
    header("Location: products.php");
    exit();
}

?>
<style>
body{
    color:white;
    font-family: Arial;
}

.container{
    margin-left:400px;
    padding:30px;
    display:flex;
    justify-content:center;
}

.card{
    background: linear-gradient(145deg, #9c593b, #8a4e29);
    padding:25px;
    border-radius:15px;
    box-shadow: 0 0 25px rgba(0,0,0,0.6);
}

.title{
    color:#ffcc00;
    font-size:22px;
    margin-bottom:20px;
    font-size: 28px;
}

.form-grid{
    display:grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap:15px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

label{
    margin-bottom:5px;
    font-size:14px;
    font-size: 20px;
}

input, select, textarea{
    padding:10px;
    border-radius:8px;
    border:1px solid rgba(255,255,255,0.2);
    background:#7f412a;
    color:white;
    font-size: 20px;
}

textarea{
    height:100px;
}

.upload-box{
    border:2px dashed rgba(255,255,255,0.3);
    border-radius:10px;
    padding:20px;
    text-align:center;
    cursor:pointer;
}

.upload-box img{
    width:80px;
    margin-bottom:10px;
}

.actions{
    margin-top:20px;
}

.btn{
    padding:10px 20px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    margin-right:10px;
    text-decoration:none;
    display:inline-block;
}

.btn-save{
    background:#ffcc00;
    color:black;
}

.btn-cancel{
    background:#e74c3c;
    color:white;
}
</style>

<div class="container">
    <div class="card">
        <div class="title">Edit Product</div>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-group">
                    <label>Product Name:</label>
                    <input type="text" name="name"
                    value="<?php echo $product['name']; ?>">
                </div>

                <div class="form-group">
                    <label>Price (VNĐ):</label>
                    <input type="text" name="price"
                    value="<?php echo $product['price']; ?>">
                </div>

                <div class="form-group">
                    <label>Category:</label>
                    <select name="category_id">
                        <?php while($row = mysqli_fetch_assoc($categories)) { ?>
                            <option value="<?php echo $row['id']; ?>"
                                <?php if($row['id'] == $product['category_id']) echo "selected"; ?>>
                                <?php echo $row['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label>Description:</label>
                    <textarea name="description"><?php echo $product['description']; ?></textarea>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label>Product Image:</label>
                    <label class="upload-box">
                        <img src="../uploads/<?php echo $product['image']; ?>">
                        Click to change image
                        <input type="file" name="image" hidden>
                    </label>
                </div>
            </div>

            <div class="actions">
                <button class="btn btn-save" name="update">Update</button>
                <a href="products.php" class="btn btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include("../includes/footer_admin.php"); ?>