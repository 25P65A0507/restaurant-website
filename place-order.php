
<?php
require_once "config/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: menu.php");
    exit;
}

$name = trim($_POST["customer_name"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$address = trim($_POST["address"] ?? "");
$food_id = filter_input(INPUT_POST, "food_id", FILTER_VALIDATE_INT);
$quantity = filter_input(INPUT_POST, "quantity", FILTER_VALIDATE_INT);

if ($name === "" || $phone === "" || $address === "" ||
    !$food_id || !$quantity || $quantity < 1 || $quantity > 50) {
    exit("Please enter valid order details and try again.");
}

// Get food price from database
$stmt = mysqli_prepare(
    $conn,
    "SELECT id, name, price FROM food_items
     WHERE id = ? AND availability = 1"
);

mysqli_stmt_bind_param($stmt, "i", $food_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$food = mysqli_fetch_assoc($result);

if (!$food) {
    exit("Food item not found or unavailable.");
}

$price = (float)$food["price"];
$total = $price * $quantity;

mysqli_begin_transaction($conn);

try {
    // Save the order
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO orders
        (customer_name, phone, address, total_amount, status, order_status)
        VALUES (?, ?, ?, ?, 'Pending', 'Order Placed')"
    );

    mysqli_stmt_bind_param(
        $stmt, "sssd", $name, $phone, $address, $total
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(mysqli_error($conn));
    }

    $order_id = mysqli_insert_id($conn);

    // Save the food and quantity
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO order_items
        (order_id, food_item_id, quantity, price)
        VALUES (?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt, "iiid", $order_id, $food_id, $quantity, $price
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(mysqli_error($conn));
    }

    mysqli_commit($conn);

} catch (Throwable $e) {
    mysqli_rollback($conn);

    echo "<h2>Order Save Error</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful | TasteHub</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include "includes/navbar.php"; ?>

<section class="section">
    <div style="max-width:600px;margin:auto;text-align:center;padding:30px;">
        <h1>🎉 Order Successful!</h1>
        <p>Your order has been saved successfully.</p>

        <h2>Order ID: #<?php echo (int)$order_id; ?></h2>
        <p>Food: <?php echo htmlspecialchars($food["name"]); ?></p>
        <p>Quantity: <?php echo (int)$quantity; ?></p>
        <h3>Total: ₹<?php echo number_format($total, 2); ?></h3>
        <p>Status: Order Placed</p>

        <a href="menu.php" class="btn btn-primary">Back to Menu</a>
    </div>
</section>

<?php include "includes/footer.php"; ?>

</body>
</html>
