<?php
session_start();
include '../includes/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Validate order_id
if (!isset($_GET['order_id'])) {
    echo "<h2>Invalid Order</h2>";
    exit();
}

$order_id = $_GET['order_id'];

// Fetch order
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "<h2>Order not found.</h2>";
    exit();
}

// When demo payment is confirmed
if (isset($_POST['confirm_payment'])) {
    $payment_method = 'Demo Payment';
    $payment_reference = 'DEMO-' . strtoupper(uniqid());

    // Update order with demo data (status Demo, no paid_at)
    $stmt = $conn->prepare("
        UPDATE orders 
        SET status = 'Demo',
            payment_method = ?,
            payment_reference = ?
        WHERE id = ?
    ");
    $stmt->execute([$payment_method, $payment_reference, $order_id]);

    header("Location: payment.php?order_id=$order_id&success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 40px;
        }
        h2 { text-align: center; }
        .payment-box {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        p { line-height: 1.6; }
        form { text-align: center; margin-top: 20px; }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover { background: #0056b3; }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="payment-box">
<?php if (!isset($_GET['success'])): ?>
    <h2>Payment Page</h2>
    <p><strong>Order ID:</strong> <?php echo $order['id']; ?></p>
    <p><strong>Total:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>

    <form method="post">
        <button type="submit" name="confirm_payment">Record Demo Payment</button>
    </form>

<?php else: ?>
    <h2>Demo Payment Recorded</h2>
    <p>This is a <strong>simulated payment</strong> for Order ID <strong><?php echo $order_id; ?></strong>.</p>
    <p>No real money was charged.</p>

    <?php
    // Fetch updated order data
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute([$order_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

    <p><strong>Payment Method:</strong> <?php echo $order['payment_method']; ?></p>
    <p><strong>Payment Reference:</strong> <?php echo $order['payment_reference']; ?></p>
    <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
    <p><strong>Paid At:</strong> -</p>

    <p><a href="my_orders.php">Back to My Orders</a> | <a href="index.php">Back to Home</a></p>
<?php endif; ?>
</div>

</body>
</html>