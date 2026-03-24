<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
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
    exit();
}

$query = "SELECT * FROM categories ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>

<style>
.main-content{
    max-width: 1120px;
    margin-top: 10px;
    margin-left: 150px ;
    padding: 0 16px 24px;
}


.topbar{
    background: #111827;
    color: #fff;
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 20px;
}

.topbar h2{
    margin: 0;
    font-size: 26px;
    font-weight: 700;
}

.category-card{
    background: #ffffff;
    padding: 22px;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
}

.card-title{
    font-size: 22px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 18px;
}

/* FORM */
.form-add{
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.form-add input{
    flex: 1;
    min-width: 220px;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.form-add button{
    padding: 10px 16px;
    border-radius: 8px;
    border: none;
    background: #2563eb;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
}

.form-add button:hover{
    background: #1d4ed8;
}

/* TABLE */
.table-wrap{
    overflow-x: auto;
}

table{
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
}

thead{
    background: #7c4f2c;
    color: #fff;
}

th, td{
    padding: 14px 12px;
    text-align: left;
}

tbody tr{
    border-bottom: 1px solid #e5e7eb;
}

tbody tr:hover{
    background: #f9fafb;
}

/* BUTTON */
.btn{
    padding: 6px 12px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
}

.edit{
    background: #2563eb;
    color: #fff;
}

.edit:hover{
    background: #1d4ed8;
}

.delete{
    background: #ef4444;
    color: #fff;
}

.delete:hover{
    background: #dc2626;
}

.action-group{
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

@media (max-width: 768px){
    .topbar h2{
        font-size: 22px;
    }

    .card-title{
        font-size: 20px;
    }

    .category-card{
        padding: 16px;
    }
}
</style>

<div class="main-content">

    <div class="topbar">
        <h2>Quản lý danh mục</h2>
    </div>

    <div class="category-card">

        <div class="card-title">Danh sách danh mục</div>

        <!-- FORM -->
        <form method="POST" class="form-add">
            <input type="text" name="name" placeholder="Nhập tên danh mục..." required>
            <button name="add">+ Thêm</button>
        </form>

        <!-- TABLE -->
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><strong><?php echo $row['id']; ?></strong></td>

                            <td><?php echo htmlspecialchars($row['name']); ?></td>

                            <td>
                                <div class="action-group">
                                    <a href="edit_category.php?id=<?php echo $row['id']; ?>" class="btn edit">Sửa</a>

                                    <a href="categories.php?delete=<?php echo $row['id']; ?>"
                                       class="btn delete"
                                       onclick="return confirm('Xóa danh mục này?')">
                                       Xóa
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>

    </div>

</div>

<?php include("../includes/footer_admin.php"); ?>