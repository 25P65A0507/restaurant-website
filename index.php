
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TasteHub | Restaurant</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include "includes/navbar.php"; ?>

<header class="hero">
    <div class="hero-content">
        <p class="eyebrow">WELCOME TO TASTEHUB</p>
        <h1>Good Food.<br>Good Mood.</h1>
        <p>
            Discover delicious dishes made with fresh ingredients
            and served with love.
        </p>

        <div class="hero-buttons">
            <a href="menu.php" class="btn btn-primary">Explore Menu</a>
            <a href="reservation.php" class="btn btn-outline">Book a Table</a>
        </div>
    </div>
</header>

<section class="section">
    <p class="eyebrow center">WHAT WE OFFER</p>
    <h2 class="section-title">Explore Our Categories</h2>

    <div class="category-grid">
        <a href="menu.php" class="category-card">
            <div class="category-icon">🍕</div>
            <h3>Pizza</h3>
            <p>Cheesy and delicious</p>
        </a>

        <a href="menu.php" class="category-card">
            <div class="category-icon">🍔</div>
            <h3>Burgers</h3>
            <p>Fresh and flavourful</p>
        </a>

        <a href="menu.php" class="category-card">
            <div class="category-icon">🍛</div>
            <h3>Indian Food</h3>
            <p>Traditional favourites</p>
        </a>

        <a href="menu.php" class="category-card">
            <div class="category-icon">🍰</div>
            <h3>Desserts</h3>
            <p>Sweeten your day</p>
        </a>
    </div>
</section>

<section class="special-section">
    <div class="special-content">
        <p class="eyebrow">MADE WITH LOVE</p>
        <h2>Great food brings people together.</h2>
        <p>
            From quick bites to family meals, find something
            delicious for every occasion.
        </p>
        <a href="menu.php" class="btn btn-primary">View Our Menu</a>
    </div>
</section>

<section class="section about-preview">
    <p class="eyebrow center">OUR STORY</p>
    <h2 class="section-title">More Than Just Food</h2>
    <p>
        At TasteHub, we believe every meal should be memorable.
        We focus on great taste, quality ingredients and friendly service.
    </p>
    <a href="about.php" class="text-link">Discover Our Story →</a>
</section>

<section class="reservation-banner">
    <h2>Your Table Is Waiting!</h2>
    <p>Planning a special meal? Reserve your table today.</p>
    <a href="reservation.php" class="btn btn-light">Reserve Now</a>
</section>

<?php include "includes/footer.php"; ?>

<script src="js/script.js"></script>
</body>
</html>
