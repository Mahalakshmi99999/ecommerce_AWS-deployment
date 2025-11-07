<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ---------- PLACE ORDER LOGIC STARTS HERE ----------
if (isset($_POST['place_order'])) {
    // Fetch cart items for this user
    $stmt = $conn->prepare("
        SELECT p.id, p.name, p.price, c.quantity 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($items) {
        // Calculate total
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Insert into orders
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status, created_at) VALUES (?, ?, 'Pending', NOW())");
        $stmt->execute([$user_id, $total]);
        $order_id = $conn->lastInsertId();

        // Insert into order_items
        $stmt_items = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($items as $item) {
            $stmt_items->execute([$order_id, $item['id'], $item['quantity'], $item['price']]);
        }

        // Clear cart
        $conn->prepare("DELETE FROM cart WHERE user_id = ?")->execute([$user_id]);

        // Redirect to payment
        header("Location: payment.php?order_id=" . $order_id);
        exit();
    } else {
        echo "<p>Your cart is empty.</p>";
    }
}
// ---------- PLACE ORDER LOGIC ENDS HERE ----------

// Fetch cart items for display (your existing code below)
echo "<h2>Checkout</h2>";

$stmt = $conn->prepare("
    SELECT p.name, p.price, c.quantity 
    FROM cart c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = ?
");
$stmt->execute([$user_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($items) {
    $total = 0;
    foreach ($items as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
        echo "<p>{$item['name']} - \${$item['price']} x {$item['quantity']} = \${$subtotal}</p>";
    }
    echo "<h3>Total: \${$total}</h3>";

    // Place order form
    echo '<form method="POST">
            <button type="submit" name="place_order">Place Order</button>
          </form>';
} else {
    echo "<p>Your cart is empty.</p>";
}
?>