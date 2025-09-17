<?php
require 'db.php'; // include your DB connection

// Fetch orders and items
$sql = "SELECT o.id, o.customer_name, o.customer_address, o.payment_method, 
               o.total, o.status, o.order_date,
               GROUP_CONCAT(CONCAT(oi.product_name, ' (x', oi.quantity, ')') SEPARATOR ', ') AS items
        FROM orders o
        LEFT JOIN order_items oi ON o.id = oi.order_id
        GROUP BY o.id
        ORDER BY o.order_date DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Orders</title>
  <link rel="stylesheet" href="css/adminpanel.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <button class="action-btn back-btn" onclick="window.location.href='index.html'">
    <i class="fas fa-arrow-left"></i> Back
  </button>

  <h1><i class="fas fa-cogs"></i> All Orders</h1>

  <table>
    <thead>
      <tr>
        <th><i class="fas fa-receipt"></i> Order ID</th>
        <th><i class="fas fa-user"></i> Customer</th>
        <th><i class="fas fa-map-marker-alt"></i> Address</th>
        <th><i class="fas fa-credit-card"></i> Payment</th>
        <th><i class="fas fa-box"></i> Items</th>
        <th><i class="fas fa-money-bill-wave"></i> Total (₱)</th>
        <th><i class="fas fa-calendar-day"></i> Date</th>
        <th><i class="fas fa-cogs"></i> Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['customer_name']) ?></td>
          <td><?= htmlspecialchars($row['customer_address']) ?></td>
          <td><?= $row['payment_method'] ?></td>
          <td><?= $row['items'] ?></td>
          <td>₱<?= number_format($row['total'], 2) ?></td>
          <td><?= date("M d, Y", strtotime($row['order_date'])) ?></td>
          <td>
            <form action="update_order.php" method="POST" style="display:inline-block;">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <select name="status" onchange="this.form.submit()">
                <option value="pending" <?= $row['status']=='pending'?'selected':'' ?>>Pending</option>
                <option value="delivered" <?= $row['status']=='delivered'?'selected':'' ?>>Delivered</option>
                <option value="cancelled" <?= $row['status']=='cancelled'?'selected':'' ?>>Cancelled</option>
              </select>
            </form>
            <form action="delete_order.php" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this order?');">
              <input type="hidden" name="id" value="<?= $row['id'] ?>">
              <button class="action-btn delete-btn"><i class="fas fa-trash"></i> Delete</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
