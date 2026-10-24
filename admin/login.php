
<?php
session_start();

if (isset($_SESSION["admin_logged_in"])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    // Demo login for your college project
    if ($username === "admin" && $password === "Admin@123") {
        session_regenerate_id(true);
        $_SESSION["admin_logged_in"] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | TasteHub</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .login-box {
            max-width: 400px;
            margin: 70px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px #0002;
        }
        input, button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            box-sizing: border-box;
        }
        button {
            background: #e85d04;
            color: white;
            border: 0;
            border-radius: 5px;
            cursor: pointer;
        }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>🍽️ TasteHub Admin</h1>
        <h3>Login to continue</h3>

        <?php if ($error !== ""): ?>
            <p class="error">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <a href="../index.php">Back to Website</a>
    </div>
</body>
</html>
