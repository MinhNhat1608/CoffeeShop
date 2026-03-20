<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("../config/database.php");
include("../includes/header_admin.php");

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM orders WHERE id = $id";

    mysqli_query($conn, $query);
    header("Location: orders.php");
    exit();
}

$query = "SELECT * FROM orders";
$result = mysqli_query($conn, $query);

?>
<style>
    .order-box {
        background: linear-gradient(145deg, #2c1b14, #1a120d);
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

    .table-section {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #5a3b2e;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
    }

    tbody tr {
        border-bottom: 1px solid #444;
    }

    .status {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 13px;
        color: #fff;
    }

    .pending {
        background: orange;
    }

    .completed {
        background: green;
    }

    .cancelled {
        background: red;
    }

    .btn {
        padding: 6px 10px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 13px;
    }

    .btn.view {
        background: #3498db;
        color: #fff;
    }

    .btn.delete {
        background: #e74c3c;
        color: #fff;
    }
</style>

<div class="main-content">
    <div class="order-box">
        <div class="topbar">
            <h2>Manage Orders</h2>
        </div>

        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td>$<?php echo $row['total']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <a href="order_detail.php?id=<?php echo $row['id']; ?>" class="btn view">View</a>
                                <a href="orders.php?delete=<?php echo $row['id']; ?>" class="btn delete"
                                    onclick="return confirm('Delete this order?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../includes/footer_admin.php"); ?>