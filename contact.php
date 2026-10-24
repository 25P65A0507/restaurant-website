
<?php
include 'config/db.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    if ($name != "" && $email != "" && $subject != "" && $message != "") {
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO contact_messages (name, email, subject, message)
             VALUES (?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt, "ssss", $name, $email, $subject, $message
        );

        if (mysqli_stmt_execute($stmt)) {
            $success = "Thank you! Your message has been sent.";
        } else {
            $error = "Message could not be sent. Please try again.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - TasteHub</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        header {
            background: #8b0000;
            color: white;
            text-align: center;
            padding: 25px 15px;
        }

        nav {
            background: #333;
            padding: 14px;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 12px;
        }

        .container {
            width: 90%;
            max-width: 650px;
            margin: 35px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px #ddd;
        }

        h2 {
            text-align: center;
            color: #8b0000;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 7px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            min-height: 130px;
            resize: vertical;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 13px;
            background: #8b0000;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #600000;
        }

        .success {
            color: green;
            text-align: center;
        }

        .error {
            color: red;
            text-align: center;
        }

        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 15px;
        }

        @media (max-width: 480px) {
            nav a {
                display: inline-block;
                margin: 7px;
            }

            .container {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

<header>
    <h1>TasteHub Restaurant</h1>
    <p>We would love to hear from you!</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="menu.php">Menu</a>
    <a href="reservation.php">Reservation</a>
    <a href="contact.php">Contact</a>
</nav>

<div class="container">
    <h2>Contact Us</h2>
    <p style="text-align:center;">
        Have a question or suggestion? Send us a message.
    </p>

    <?php if ($success != ""): ?>
        <p class="success">
            <?php echo htmlspecialchars($success); ?>
        </p>
    <?php endif; ?>

    <?php if ($error != ""): ?>
        <p class="error">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="contact.php">
        <label>Your Name</label>
        <input type="text" name="name" required>

        <label>Email Address</label>
        <input type="email" name="email" required>

        <label>Subject</label>
        <input type="text" name="subject" required>

        <label>Your Message</label>
        <textarea name="message" required></textarea>

        <button type="submit">Send Message</button>
    </form>
</div>

<footer>
    <p>&copy; 2026 TasteHub Restaurant. All rights reserved.</p>
</footer>

</body>
</html>
