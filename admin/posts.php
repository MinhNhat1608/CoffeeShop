<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");
include("../includes/header_admin.php");

// XÓA BÀI VIẾT
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $getImg = mysqli_query($conn, "SELECT image FROM posts WHERE id='$id'");
    $imgRow = mysqli_fetch_assoc($getImg);

    if ($imgRow && $imgRow['image']) {
        $filePath = "../assets/images/" . $imgRow['image'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    mysqli_query($conn, "DELETE FROM posts WHERE id='$id'");
    header("Location: posts.php");
    exit();
}

// LẤY DANH SÁCH
$query = "SELECT * FROM posts ORDER BY id DESC";
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

.post-card{
    background: #ffffff;
    padding: 22px;
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
}

.card-title{
    font-size: 22px;
    font-weight: 700;
    color: #111827;
}

/* HEADER */
.top-actions{
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    flex-wrap: wrap;
    gap: 10px;
}

/* BUTTON */
.btn{
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
}

.add-btn{
    background: #2563eb;
    color: #fff;
}

.add-btn:hover{
    background: #1d4ed8;
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

/* TABLE */
.table-wrap{
    overflow-x: auto;
}

table{
    width: 100%;
    border-collapse: collapse;
    min-width: 850px;
}

thead{
    background: #7c4f2c;
    color: #fff;
}

th, td{
    padding: 14px 12px;
    text-align: left;
    vertical-align: middle;
}

tbody tr{
    border-bottom: 1px solid #e5e7eb;
}

tbody tr:hover{
    background: #f9fafb;
}

/* IMAGE */
.post-img{
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
}

.no-image{
    width: 80px;
    height: 80px;
    background: #f1f5f9;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    color: #666;
}

/* TEXT LIMIT */
.desc{
    max-width: 250px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* ACTION */
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

    .post-card{
        padding: 16px;
    }
}
</style>

<div class="main-content">

    <div class="topbar">
        <h2>Quản lý bài viết</h2>
    </div>

    <div class="post-card">

        <div class="top-actions">
            <div class="card-title">Danh sách bài viết</div>
            <a href="add_post.php" class="btn add-btn">+ Thêm bài viết</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Mô tả</th>
                        <th>Ảnh</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><strong><?php echo $row['id']; ?></strong></td>

                            <td><?php echo htmlspecialchars($row['title']); ?></td>

                            <td class="desc">
                                <?php echo htmlspecialchars($row['description']); ?>
                            </td>

                            <td>
                                <?php if (!empty($row['image'])) { ?>
                                    <img src="../assets/images/<?php echo $row['image']; ?>" class="post-img">
                                <?php } else { ?>
                                    <div class="no-image">No image</div>
                                <?php } ?>
                            </td>

                            <td>
                                <div class="action-group">
                                    <a href="edit_post.php?id=<?php echo $row['id']; ?>" class="btn edit">Sửa</a>

                                    <a href="posts.php?delete_id=<?php echo $row['id']; ?>"
                                       class="btn delete"
                                       onclick="return confirm('Xóa bài viết này?')">
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