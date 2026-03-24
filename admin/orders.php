<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include("../config/database.php");
include("../includes/header_admin.php");

// XÓA ORDER
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM orders WHERE id=$id");
    header("Location: orders.php");
    exit();
}

// LẤY DANH SÁCH
$query = "SELECT * FROM orders ORDER BY id DESC";
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

.order-card{
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

.table-wrap{
    width: 100%;
    overflow-x: auto;
}

table{
    width: 100%;
    border-collapse: collapse;
    min-width: 760px;
}

thead{
    background: #7c4f2c;
    color: #fff;
}

th, td{
    padding: 14px 12px;
    text-align: center;
}

tbody tr{
    border-bottom: 1px solid #e5e7eb;
}

tbody tr:hover{
    background: #f9fafb;
}

.order-id{
    font-weight: 700;
    color: #111827;
}

.order-total{
    font-weight: 700;
    color: #2563eb;
}

.status{
    display: inline-block;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    text-transform: capitalize;
}

.pending{
    background: #fef3c7;
    color: #92400e;
}

.completed{
    background: #dcfce7;
    color: #166534;
}

.cancelled{
    background: #fee2e2;
    color: #991b1b;
}

.action-group{
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
}

.btn{
    display: inline-block;
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: 0.2s;
}

.view{
    background: #2563eb;
    color: #fff;
}

.view:hover{
    background: #1d4ed8;
}

.delete{
    background: #ef4444;
    color: #fff;
}

.delete:hover{
    background: #dc2626;
}

@media (max-width: 768px){
    .main-content{
        margin: 18px auto;
        padding: 0 12px 18px;
    }

    .topbar h2{
        font-size: 22px;
    }

    .card-title{
        font-size: 20px;
    }

    .order-card{
        padding: 16px;
    }
}
</style>

<div class="main-content">

    <div class="topbar">
        <h2>Quản lý đơn hàng</h2>
    </div>

    <div class="order-card">
        <div class="card-title">Danh sách đơn hàng</div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <?php
                        $statusClass = "";
                        if ($row['status'] == "pending") $statusClass = "pending";
                        if ($row['status'] == "completed") $statusClass = "completed";
                        if ($row['status'] == "cancelled") $statusClass = "cancelled";
                        ?>
                        <tr>
                            <td class="order-id"><?php echo $row['id']; ?></td>
                            <td class="order-total"><?php echo number_format($row['total']); ?> đ</td>
                            <td>
                                <span class="status <?php echo $statusClass; ?>">
                                    <?php echo $row['status']; ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="order_detail.php?id=<?php echo $row['id']; ?>" class="btn view">Xem</a>
                                    <a href="orders.php?delete=<?php echo $row['id']; ?>"
                                       class="btn delete"
                                       onclick="return confirm('Xóa đơn này?')">
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