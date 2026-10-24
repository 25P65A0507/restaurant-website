
<?php
require_once "config/db.php";

$category = isset($_GET['category'])
    ? trim($_GET['category'])
    : '';

$sql = "SELECT f.*, c.category_name
        FROM food_items f
        LEFT JOIN food_categories c
        ON f.category_id = c.id
        WHERE f.availability = 1";

if ($category !== '') {
    $sql .= " AND c.category_name = ?";
}

$sql .= " ORDER BY f.id DESC";

$stmt = mysqli_prepare($conn, $sql);

if ($category !== '') {
    mysqli_stmt_bind_param($stmt, "s", $category);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Menu | TasteHub</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include "includes/navbar.php"; ?>

<section class="section">
    <p class="eyebrow center">FRESHLY PREPARED</p>
    <h1 class="section-title">Explore Our Menu</h1>

    <div class="food-grid">
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while ($food = mysqli_fetch_assoc($result)): ?>
                <article class="food-card">
                    <img
                        src="<?php echo htmlspecialchars($food['image'] ?? ''); ?>"
                        alt="<?php echo htmlspecialchars($food['name']); ?>"
                        class="food-image"
                    >

                    <div class="food-info">
                        <span class="food-category">
                            <?php echo htmlspecialchars($food['category_name'] ?? 'Food'); ?>
                        </span>

                        <h2><?php echo htmlspecialchars($food['name']); ?></h2>

                        <p>
                            <?php echo htmlspecialchars($food['description'] ?? ''); ?>
                        </p>

                        <div class="food-bottom">
                            <strong>₹<?php echo number_format((float)$food['price'], 2); ?></strong>
                            
<a href="order.php?id=<?php echo (int)$food['id']; ?>"
   class="btn btn-primary">
    Order Now
</a>

                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No food items are available yet. Please add food items to the database.</p>
        <?php endif; ?>
    </div>
</section>

<?php include "includes/footer.php"; ?>

<script src="js/script.js"></script>
</body>
</html>
