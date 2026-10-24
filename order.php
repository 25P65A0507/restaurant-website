
<?php
require_once "config/db.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    exit("Invalid food item. Please return to the menu.");
}

$stmt = mysqli_prepare(
    $conn,
    "SELECT id, name, price FROM food_items
     WHERE id = ? AND availability = 1"
);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$food = mysqli_fetch_assoc($result);

if (!$food) {
    exit("Food item not found. Please return to the menu.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Food | TasteHub</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include "includes/navbar.php"; ?>

<section class="section">
    <h1 class="section-title">Place Your Order</h1>

    <div style="max-width:550px;margin:auto;">
        <h2><?php echo htmlspecialchars($food["name"]); ?></h2>
        <p>Price: ₹<?php echo number_format((float)$food["price"], 2); ?></p>

        <form action="place-order.php" method="POST">
            <input type="hidden" name="food_id"
                   value="<?php echo (int)$food["id"]; ?>">

            <p>
                <label>Customer Name</label>
                <input name="customer_name" required maxlength="100"
                       style="width:100%;padding:12px;margin:8px 0;">
            </p>

            <p>
                <label>Phone Number</label>
                <input type="tel" name="phone" required maxlength="20"
                       style="width:100%;padding:12px;margin:8px 0;">
            </p>

            <p>
                <label>Delivery Address</label>
                <textarea name="address" required maxlength="1000"
                          style="width:100%;padding:12px;margin:8px 0;"></textarea>
            </p>

            <p>
                <label>Quantity</label>
                <input type="number" id="quantity" name="quantity"
                       min="1" max="50" value="1" required
                       style="width:100%;padding:12px;margin:8px 0;">
            </p>

            <h3>Total: ₹<span id="total"><?php
                echo number_format((float)$food["price"], 2);
            ?></span></h3>

            <button type="submit" class="btn btn-primary">
                Place Order
            </button>
        </form>
    </div>
</section>

<?php include "includes/footer.php"; ?>

<script>
const price = <?php echo json_encode((float)$food["price"]); ?>;
document.getElementById("quantity").addEventListener("input", function () {
    const quantity = Math.min(50, Math.max(1, Number(this.value) || 1));
    document.getElementById("total").textContent =
        (price * quantity).toFixed(2);
});
</script>
</body>
</html>
