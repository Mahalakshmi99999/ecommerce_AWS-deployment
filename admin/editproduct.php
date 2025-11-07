<?php
include '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=? WHERE id=?");
    $stmt->execute([$name, $price, $description, $_GET['id']]);

    header("Location: manageproducts.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Product</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    form { width: 300px; margin: auto; }
    input, textarea { width: 100%; margin: 8px 0; padding: 8px; }
    button { padding: 8px 16px; background-color: #007bff; color: white; border: none; }
  </style>
</head>
<body>
  <h2>Edit Product</h2>
  <form method="post">
    <label>Name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
    
    <label>Price</label>
    <input type="text" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
    
    <label>Description</label>
    <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
    
    <button type="submit" name="update">Update</button>
  </form>
</body>
</html>