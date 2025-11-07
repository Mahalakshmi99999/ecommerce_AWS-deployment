<?php
session_start();
include '../includes/db.php';

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Validate order_id from URL
if (!isset($_GET['order_id'])) {
    echo "<h2>Invalid Order</h2>";
    exit();
}

$order_id = $_GET['order_id'];

// Fetch order info (make sure this order belongs to the logged-in user)
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "<h2>Order not found or access denied.</h2>";
    exit();
}

// Fetch ordered items
$stmt_items = $conn->prepare("
    SELECT p.name, p.price, oi.quantity 
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt_items->execute([$order_id]);
$items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - #<?php echo $order_id; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 40px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 70%;
            margin: 0 auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        .summary {
            width: 70%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Order Details - #<?php echo $order['id']; ?></h2>

<div class="summary">
    <p><strong>Total Amount:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>
    <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
    <p><strong>Payment Method:</strong> <?php echo $order['payment_method'] ?: '-'; ?></p>
    <p><strong>Payment Reference:</strong> <?php echo $order['payment_reference'] ?: '-'; ?></p>
    <p><strong>Ordered On:</strong> <?php echo $order['created_at']; ?></p>
    <p><strong>Paid At:</strong> <?php echo $order['paid_at'] ?: '-'; ?></p>
</div>

<?php if ($items): ?>
<table>
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
    </tr>
    <?php 
    $total = 0;
    foreach ($items as $item): 
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    ?>
    <tr>
        <td><?php echo $item['name']; ?></td>
        <td>$<?php echo number_format($item['price'], 2); ?></td>
        <td><?php echo $item['quantity']; ?></td>
        <td>$<?php echo number_format($subtotal, 2); ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="3" style="text-align:right;"><strong>Total:</strong></td>
        <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
    </tr>
</table>
<?php else: ?>
    <p style="text-align:center;">No items found for this order.</p>
<?php endif; ?>

<p style="text-align:center; margin-top:20px;">
    <a href="my_orders.php">← Back to My Orders</a>
</p>

</body>
</html>