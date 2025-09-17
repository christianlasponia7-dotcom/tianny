<?php
session_start();
require 'db.php';

// Restrict access to admin only
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Fetch all orders from database
$sql = "SELECT o.id, o.customer_name, o.customer_address, o.payment_method, o.total, o.status, o.order_date,
               GROUP_CONCAT(CONCAT(p.name, ' (x', oi.quantity, ')') SEPARATOR ', ') AS items
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN products p ON oi.product_id = p.id
        GROUP BY o.id
        ORDER BY o.order_date DESC";
$result = $conn->query($sql);

// Handle status updates
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
    $stmt->bind_param("si", $new_status, $order_id);
    $stmt->execute();
    header("Location: adminpanel.php");
    exit;
}

// Handle order deletion
if (isset($_POST['delete_order'])) {
    $order_id = intval($_POST['order_id']);
    $stmt = $conn->prepare("DELETE FROM orders WHERE id=?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    header("Location: adminpanel.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel - Orders</title>
<link rel="stylesheet" href="css/adminpanel.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: left;
}
th {
    background-color: #007BFF;
    color: white;
}
.status-select {
    padding: 5px;
}
.action-btn {
    padding: 5px 10px;
    margin-right: 5px;
    border: none;
    cursor: pointer;
    border-radius: 4px;
}
.update-btn { background-color: #28a745; color: white; }
.delete-btn { background-color: #dc3545; color: white; }
</style>
</head>
<body>

<h1><i class="fas fa-cogs"></i> Admin Panel - Orders</h1>
<a href="logout.php" style="float:right; margin-bottom:10px;">Logout</a>

<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Address</th>
            <th>Payment Method</th>
            <th>Items</th>
            <th>Total (₱)</th>
            <th>Status</th>
            <th>Order Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['customer_name']) ?></td>
            <td><?= htmlspecialchars($row['customer_address']) ?></td>
            <td><?= htmlspecialchars($row['payment_method']) ?></td>
            <td><?= htmlspecialchars($row['items']) ?></td>
            <td>₱<?= number_format($row['total'], 2) ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                    <select name="status" class="status-select">
                        <option value="pending" <?= $row['status']=='pending'?'selected':'' ?>>Pending</option>
                        <option value="delivered" <?= $row['status']=='delivered'?'selected':'' ?>>Delivered</option>
                        <option value="cancelled" <?= $row['status']=='cancelled'?'selected':'' ?>>Cancelled</option>
                    </select>
                    <button type="submit" name="update_status" class="action-btn update-btn">Update</button>
                </form> 
            </td>
            <td><?= $row['order_date'] ?></td>
            <td>
                <form method="post" onsubmit="return confirm('Delete this order?');">
                    <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                    <button type="submit" name="delete_order" class="action-btn delete-btn">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="9" style="text-align:center;">No orders found</td></tr>
    <?php endif; ?>
    </tbody>
</table>

</body>
</html>
