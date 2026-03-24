<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("../config/database.php");
include("../includes/header_admin.php");

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $delete = "DELETE FROM posts WHERE id = '$id'";
    mysqli_query($conn, $delete);
    header("Location: posts.php");
    exit();
}

$query = "SELECT * FROM posts";
$result = mysqli_query($conn, $query);
?>
<style>
    .post-box {
        background: linear-gradient(145deg, #9c593b, #8a4e29);
        padding: 25px;
        border-radius: 15px;
        margin: 20px;
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

    .add-btn {
        background: #d4a017;
        color: #000;
        padding: 10px 15px;
        border-radius: 20px;
        text-decoration: none;
    }

    .table-section table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-section th {
        background: #5a3b2e;
        padding: 12px;
    }

    .table-section td {
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
    <div class="post-box">
        <div class="topbar">
            <h2>Post Management</h2>
            <a href="add_post.php" class="add-btn">
                + Add Post
            </a>
        </div>

        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td>
                                <a href="edit_post.php?id=<?php echo $row['id']; ?>" class="btn edit">Edit</a>
                                <a href="posts.php?delete_id=<?php echo $row['id']; ?>"
                                    class="btn delete"
                                    onclick="return confirm('Xóa bài viết này?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php include("../includes/footer_admin.php"); ?>