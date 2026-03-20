<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("../config/database.php");
include("../includes/header_admin.php");

if (isset($_POST['add'])) {

    $name = $_POST['name'];
    $query = "INSERT INTO categories(name) VALUES('$name')";

    mysqli_query($conn, $query);
    header("Location: categories.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM categories WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: categories.php");
}

$query = "SELECT * FROM categories";
$result = mysqli_query($conn, $query);
?>

<style>
    .category-box {
        background: linear-gradient(145deg, #2c1b14, #1a120d);
        padding: 25px;
        border-radius: 15px;
        margin: 20px auto;
        color: #fff;
    }

    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .topbar h2 {
        color: #f1c40f;
    }

    .form-add {
        margin-bottom: 20px;
    }

    .form-add input {
        padding: 10px;
        border-radius: 20px;
        border: none;
        outline: none;
        width: 250px;
    }

    .form-add button {
        padding: 10px 15px;
        border-radius: 20px;
        border: none;
        background: #d4a017;
        cursor: pointer;
        margin-left: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #5a3b2e;
        padding: 12px;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #444;
    }

    .btn {
        padding: 6px 10px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 13px;
    }

    .btn.edit {
        background: #f1c40f;
        color: #000;
    }

    .btn.delete {
        background: #e74c3c;
        color: #fff;
    }
</style>
<main class="main-content">

    <div class="category-box">
        <div class="topbar">
            <h2>Category Management</h2>
        </div>

        <form method="POST" class="form-add">
            <input type="text" name="name" placeholder="Category name" required>
            <button name="add">+ Add</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>
                            <a href="edit_category.php?id=<?php echo $row['id']; ?>" class="btn edit">Edit</a>
                            <a href="categories.php?delete=<?php echo $row['id']; ?>"
                                class="btn delete"
                                onclick="return confirm('Delete this category?')">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</main>
<?php include("../includes/footer_admin.php"); ?>