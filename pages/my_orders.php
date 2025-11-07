<?php
session_start();
include '../includes/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all orders for this user
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 40px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        .status-paid {
            color: green;
            font-weight: bold;
        }
        .status-pending {
            color: orange;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>My Orders</h2>

<?php if ($orders): ?>
<table>
    <tr>
        <th>Order ID</th>
        <th>Total Amount</th>
        <th>Status</th>
        <th>Payment Method</th>
        <th>Reference</th>
        <th>Ordered On</th>
        <th>Paid On</th>
        <th>Action</th>
    </tr>
    <?php foreach ($orders as $order): ?>
    <tr>
        <td><?php echo $order['id']; ?></td>
        <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
        <td class="status-<?php echo strtolower($order['status']); ?>">
            <?php echo $order['status']; ?>
        </td>
        <td><?php echo $order['payment_method'] ?: '-'; ?></td>
        <td><?php echo $order['payment_reference'] ?: '-'; ?></td>
        <td><?php echo $order['created_at']; ?></td>
        <td><?php echo $order['paid_at'] ?: '-'; ?></td>
        <td>
            <a href="order_details.php?order_id=<?php echo $order['id']; ?>">View</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <p style="text-align:center;">No orders found.</p>
<?php endif; ?>

</body>
</html>