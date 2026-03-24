<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("../config/database.php");
include("../includes/header_admin.php");

$id = $_GET['id'];
$query = "SELECT * FROM categories WHERE id=$id";
$result = mysqli_query($conn, $query);
$cat = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $query = "UPDATE categories 
SET name='$name'
WHERE id=$id";

    mysqli_query($conn, $query);
    header("Location: categories.php");
}
?>
<style>
    .edit-card {
        max-width: 1200px;
        width: 50%;
        margin: 40px auto;
        margin-left: 550px;
        padding: 80px;
        border-radius: 20px;
        background: linear-gradient(145deg, #9c593b, #8a4e29);
        backdrop-filter: blur(12px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
    }

    .edit-card h2 {
        text-align: center;
        margin-bottom: 25px;
        font-size: 30px;
    }

    .input-group {
        margin-bottom: 20px;
    }

    .input-group label {
        display: block;
        margin-bottom: 8px;
        color: #f8f6f6;
        font-size: 20px;
    }

    .input-group input {
        width: 100%;
        padding: 50px;
        border-radius: 10px;
        border: none;
        outline: none;
        background: rgba(255, 255, 255, 0.08);
        color: white;
        font-size: 28px;
    }

    .input-group input:focus {
        border: 1px solid #c89b6d;
    }

    .btn-submit {
        width: 100%;
        padding: 20px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #8b5e3c, #c89b6d);
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
        font-size: 22px;
    }

    .btn-submit:hover {
        opacity: 0.9;
    }

    .btn-back {
        display: inline-block;
        margin-top: 15px;
        text-decoration: none;
        color: #f2c83d;
    }
</style>

<div class="edit-card">
    <h2> Edit Category</h2>

    <form method="POST">
        <div class="input-group">
            <label>Category Name</label>
            <input type="text" name="name" value="<?php echo $cat['name']; ?>" required>
        </div>

        <button class="btn-submit" name="update"> Update Category</button>
    </form>

    <a href="categories.php" class="btn-back">⬅ Back to Categories</a>
</div>
<?php include("../includes/footer_admin.php"); ?>