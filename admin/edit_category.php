<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
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

    $query = "UPDATE categories SET name='$name' WHERE id=$id";
    mysqli_query($conn, $query);

    header("Location: categories.php");
    exit();
}
?>

<style>
body {
    background: #0d0d0d;
    font-family: Arial;
}

/* CONTAINER CENTER */
.container {
    display: flex;
    justify-content: center;
    padding: 30px;
}

.edit-card {
    width: 100%;
    max-width: 600px;
    padding: 30px;
}

/* TITLE */
.edit-card h2 {
    text-align: center;
    margin-bottom: 25px;
    font-size: 26px;
    color: #f1c40f;
}

/* INPUT */
.input-group {
    margin-bottom: 20px;
}

.input-group label {
    display: block;
    margin-bottom: 8px;
    font-size: 16px;
    color: #d2b48c;
}

.input-group input {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #444;
    background: #111;
    color: white;
    font-size: 16px;
    transition: 0.3s;
}

.input-group input:focus {
    border-color: #c89b6d;
    box-shadow: 0 0 8px rgba(200,155,109,0.3);
}

/* BUTTON */
.btn-submit {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, #c89b6d, #8b5e3c);
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.btn-submit:hover {
    transform: translateY(-2px);
}

/* BACK */
.btn-back {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #c89b6d;
    text-decoration: none;
}

.btn-back:hover {
    text-decoration: underline;
}
</style>

<div class="container">
    <div class="edit-card">

        <h2>Edit Category</h2>

        <form method="POST">

            <div class="input-group">
                <label>Category Name</label>
                <input type="text" name="name"
                    value="<?php echo htmlspecialchars($cat['name']); ?>" required>
            </div>

            <button class="btn-submit" name="update">
                Update Category
            </button>

        </form>

        <a href="categories.php" class="btn-back">
            ← Back to Categories
        </a>

    </div>
</div>

<?php include("../includes/footer_admin.php"); ?>