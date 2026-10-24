
<?php
include "config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["customer_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $date = $_POST["reservation_date"];
    $time = $_POST["reservation_time"];
    $guests = (int) $_POST["guests"];
    $requests = trim($_POST["special_requests"]);

    if (
        $name === "" || $email === "" || $phone === "" ||
        $date === "" || $time === "" || $guests < 1
    ) {
        $message = "Please fill all required fields.";
    } elseif ($date < date("Y-m-d")) {
        $message = "Please select today or a future date.";
    } else {
        $sql = "INSERT INTO reservations
        (name, email, phone, reservation_date,
         reservation_time, guests, message)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt, "sssssis",
                $name, $email, $phone, $date,
                $time, $guests, $requests
            );

            if (mysqli_stmt_execute($stmt)) {
                $message = "Your table reservation request was submitted successfully!";
            } else {
                $message = "Unable to save reservation. Please check the database table columns.";
            }

            mysqli_stmt_close($stmt);
        } else {
            $message = "Unable to prepare reservation. Please check your database table structure.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Reservation | TasteHub</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #fff7f0;
            margin: 0;
            padding: 20px;
        }

        .reservation-box {
            max-width: 650px;
            margin: 30px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px #00000015;
        }

        h1 {
            text-align: center;
            color: #e85d04;
        }

        .intro {
            text-align: center;
            color: #555;
            margin-bottom: 25px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        label {
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        textarea {
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #e85d04;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #c94d00;
        }

        .message {
            padding: 12px;
            margin-bottom: 20px;
            background: #e8f7e9;
            border-radius: 6px;
            color: #205b29;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #e85d04;
        }

        @media (max-width: 550px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .full-width {
                grid-column: auto;
            }

            .reservation-box {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="reservation-box">
        <h1>Reserve Your Table</h1>
        <p class="intro">Book your table at TasteHub Restaurant.</p>

        <?php if ($message !== ""): ?>
            <div class="message">
                <?php echo htmlspecialchars($message, ENT_QUOTES, "UTF-8"); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-grid">

                <div class="field">
                    <label for="customer_name">Full Name *</label>
                    <input type="text" id="customer_name"
                           name="customer_name" required>
                </div>

                <div class="field">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="field">
                    <label for="phone">Phone Number *</label>
                    <input type="tel" id="phone" name="phone"
                           pattern="[0-9]{10}" maxlength="10"
                           title="Enter a 10-digit phone number" required>
                </div>

                <div class="field">
                    <label for="guests">Number of Guests *</label>
                    <select id="guests" name="guests" required>
                        <option value="">Select guests</option>
                        <option value="1">1 Guest</option>
                        <option value="2">2 Guests</option>
                        <option value="3">3 Guests</option>
                        <option value="4">4 Guests</option>
                        <option value="5">5 Guests</option>
                        <option value="6">6 Guests</option>
                        <option value="7">7 Guests</option>
                        <option value="8">8 Guests</option>
                    </select>
                </div>

                <div class="field">
                    <label for="reservation_date">Date *</label>
                    <input type="date" id="reservation_date"
                           name="reservation_date"
                           min="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <div class="field">
                    <label for="reservation_time">Time *</label>
                    <input type="time" id="reservation_time"
                           name="reservation_time" required>
                </div>

                <div class="field full-width">
                    <label for="special_requests">Special Requests</label>
                    <textarea id="special_requests"
                              name="special_requests" rows="3"
                              placeholder="Any special requests? (Optional)"></textarea>
                </div>

                <div class="full-width">
                    <button type="submit">Request Table Reservation</button>
                </div>

            </div>
        </form>

        <a class="back-link" href="index.php">Back to Home</a>
    </div>
</body>
</html>
