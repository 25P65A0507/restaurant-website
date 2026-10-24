
<?php
session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit;
}

require_once "../config/db.php";
function safe($value) {
    return htmlspecialchars(
        (string)($value ?? ""),
        ENT_QUOTES,
        "UTF-8"
    );
}
$message = "";
$allowed_statuses = [
    "Order Placed",
    "Preparing",
    "Out for Delivery",
    "Delivered",
    "Cancelled"
];

// Update order status
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $order_id = filter_input(INPUT_POST, "order_id", FILTER_VALIDATE_INT);
    $new_status = $_POST["order_status"] ?? "";

    if ($order_id && in_array($new_status, $allowed_statuses, true)) {
        $stmt = mysqli_prepare(
            $conn,
            "UPDATE orders SET order_status = ? WHERE id = ?"
        );

        mysqli_stmt_bind_param($stmt, "si", $new_status, $order_id);

        if (mysqli_stmt_execute($stmt)) {
            $message = "Order #" . $order_id . " status updated!";
        } else {
            $message = "Unable to update order status.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $message = "Invalid order details.";
    }
}

// Get all orders
$sql = "SELECT id, customer_name, phone, address,
               total_amount, order_status, created_at
        FROM orders
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

// Dashboard statistics
$stats_sql = "
    SELECT
        COUNT(*) AS total_orders,
        COALESCE(SUM(
            CASE
                WHEN order_status != 'Cancelled'
                THEN total_amount
                ELSE 0
            END
        ), 0) AS total_sales,
        COALESCE(SUM(
            CASE
                WHEN order_status = 'Order Placed'
                THEN 1
                ELSE 0
            END
        ), 0) AS pending_orders
    FROM orders
";

$stats_result = mysqli_query($conn, $stats_sql);
$stats = mysqli_fetch_assoc($stats_result);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | TasteHub</title>
    <link rel="stylesheet" href="../css/style.css">
   
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f5f5f5;
        margin: 0;
    }

    header {
        background: #222;
        color: white;
        padding: 18px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    header a {
        color: white;
        margin-left: 12px;
    }

    .container {
        padding: 20px;
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
        margin: 25px 0;
    }

    .stat-card {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 3px 12px #00000012;
        border-left: 5px solid #e85d04;
    }

    .stat-card h3 {
        margin: 0 0 12px;
        color: #555;
        font-size: 16px;
    }

    .stat-card p {
        margin: 0;
        font-size: 28px;
        font-weight: bold;
        color: #222;
    }

    .table-wrap {
        width: 100%;
        overflow-x: auto;
        background: white;
        border-radius: 10px;
        padding: 12px;
        box-sizing: border-box;
    }

    table {
        width: 100%;
        min-width: 1000px;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: left;
        vertical-align: top;
    }

    th {
        background: #e85d04;
        color: white;
    }

    td form {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-width: 150px;
    }

    td select,
    td button {
        width: 100%;
        box-sizing: border-box;
        padding: 9px;
    }

    td select {
        border: 1px solid #ccc;
        border-radius: 5px;
        background: white;
    }

    td button {
        background: #e85d04;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .message {
        background: #e5f7e8;
        padding: 12px;
        border-radius: 5px;
    }

    @media (max-width: 700px) {
        .stats-container {
            grid-template-columns: 1fr;
        }

        .container {
            padding: 10px;
        }
    }
</style>

</head>
<body>
<header>
    <h2>🍽️ TasteHub Admin</h2>
    <nav>
        <a href="../index.php">View Website</a>
<a href="reservations.php">Reservations</a>
<a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
    <h1>Orders Dashboard</h1>
    
<div class="stats-container">
    <div class="stat-card">
        <h3>📦 Total Orders</h3>
        <p><?php echo (int)$stats["total_orders"]; ?></p>
    </div>

    <div class="stat-card">
        <h3>💰 Total Sales</h3>
        <p>₹<?php echo number_format((float)$stats["total_sales"], 2); ?></p>
    </div>

    <div class="stat-card">
        <h3>⏳ Pending Orders</h3>
        <p><?php echo (int)$stats["pending_orders"]; ?></p>
    </div>
</div>

    <p>You can manage customer orders and delivery statuses here.</p>

    <?php if ($message !== ""): ?>
        <p class="message"><?php echo safe($message); ?></p>
    <?php endif; ?>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Total</th>
                    <th>Order Status</th>
                    <th>Date</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($order = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>#<?php echo (int)$order["id"]; ?></td>
                        <td><?php echo safe($order["customer_name"]); ?></td>
                        <td><?php echo safe($order["phone"]); ?></td>
                        <td><?php echo safe($order["address"]); ?></td>
                        <td>₹<?php echo number_format((float)$order["total_amount"], 2); ?></td>
                        <td><?php echo safe($order["order_status"]); ?></td>
                        <td><?php echo safe($order["created_at"]); ?></td>
                        <td>
                            <form method="POST">
                                <input
                                    type="hidden"
                                    name="order_id"
                                    value="<?php echo (int)$order["id"]; ?>"
                                >

                                
<select name="order_status" required>
    <?php foreach ($allowed_statuses as $status): ?>
        <option
            value="<?php echo safe($status); ?>"
            <?php echo ($order["order_status"] === $status) ? "selected" : ""; ?>
        >
            <?php echo safe($status); ?>
        </option>
    <?php endforeach; ?>
</select>

                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No orders found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
