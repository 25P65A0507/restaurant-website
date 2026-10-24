
<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit;
}

include "../config/db.php";

$message = "";
$message_type = "";

/* Update Reservation Status */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $reservation_id = (int)($_POST["reservation_id"] ?? 0);
    $new_status = $_POST["status"] ?? "";

    $allowed_statuses = ["Pending", "Confirmed", "Cancelled"];

    if ($reservation_id > 0 && in_array($new_status, $allowed_statuses, true)) {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE reservations SET status = ? WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $new_status,
            $reservation_id
        );

        if (mysqli_stmt_execute($stmt)) {
            $message = "Reservation status updated successfully!";
            $message_type = "success";
        } else {
            $message = "Failed to update reservation status.";
            $message_type = "error";
        }

        mysqli_stmt_close($stmt);

    } else {
        $message = "Invalid reservation status.";
        $message_type = "error";
    }
}

/* Get Reservations */
$sql = "SELECT * FROM reservations ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

function safe($value) {
    return htmlspecialchars((string)($value ?? ""), ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Reservations | TasteHub Admin</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #222;
        }

        header {
            background: #222;
            color: white;
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        header a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }

        .container {
            padding: 25px;
        }

        h2 {
            color: #e85d04;
        }

        .table-wrap {
            overflow-x: auto;
            background: white;
            padding: 12px;
            border-radius: 10px;
        }

        table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #e85d04;
            color: white;
        }

        .empty {
            padding: 20px;
            background: white;
            border-radius: 8px;
        }
        .message {
    padding: 12px 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-weight: bold;
}

.success {
    background: #d4edda;
    color: #155724;
}

.error {
    background: #f8d7da;
    color: #721c24;
}

.status-form {
    display: flex;
    gap: 8px;
    align-items: center;
}

.status-form select {
    padding: 7px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.status-form button {
    padding: 7px 12px;
    background: #e85d04;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.status-form button:hover {
    background: #c94d00;
}
    </style>
</head>

<body>
<header>
    <h2 style="color:white;">TasteHub Admin</h2>
    <nav>
        <a href="dashboard.php">Orders Dashboard</a>
        <a href="reservations.php">Reservations</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
    <h2>Table Reservations</h2>
    <p>View customer table booking requests here.</p>

    <?php if ($message != ""): ?>
    <div class="message <?php echo $message_type; ?>">
        <?php echo safe($message); ?>
    </div>
<?php endif; ?>
    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Guests</th>
                        <th>Message</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo (int)$row["id"]; ?></td>
                            <td><?php echo safe($row["name"]); ?></td>
                            <td><?php echo safe($row["email"]); ?></td>
                            <td><?php echo safe($row["phone"]); ?></td>
                            <td><?php echo safe($row["reservation_date"]); ?></td>
                            <td><?php echo safe($row["reservation_time"]); ?></td>
                            <td><?php echo (int)$row["guests"]; ?></td>
                            <td><?php echo safe($row["message"]); ?></td>
                            <td>
    <form method="POST" class="status-form">

        <input
            type="hidden"
            name="reservation_id"
            value="<?php echo (int)$row["id"]; ?>"
        >

        <select name="status">
            <option value="Pending"
                <?php echo ($row["status"] === "Pending") ? "selected" : ""; ?>>
                Pending
            </option>

            <option value="Confirmed"
                <?php echo ($row["status"] === "Confirmed") ? "selected" : ""; ?>>
                Confirmed
            </option>

            <option value="Cancelled"
                <?php echo ($row["status"] === "Cancelled") ? "selected" : ""; ?>>
                Cancelled
            </option>
        </select>

        <button type="submit">Update</button>

    </form>
</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="empty">No table reservations found.</div>
    <?php endif; ?>
</div>

</body>
</html>

