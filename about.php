
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About Us - TasteHub Restaurant</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fffaf5;
            color: #333;
        }

        header {
            background: #8b0000;
            color: white;
            text-align: center;
            padding: 30px 15px;
        }

        header h1 {
            margin: 0 0 10px;
            font-size: 32px;
        }

        nav {
            background: #333;
            padding: 15px;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 12px;
            display: inline-block;
            padding: 5px 0;
        }

        nav a:hover {
            color: #ffcc80;
        }

        .hero {
            background: linear-gradient(
                rgba(0, 0, 0, 0.55),
                rgba(0, 0, 0, 0.55)
            ),
            url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4')
            center/cover no-repeat;

            color: white;
            text-align: center;
            padding: 90px 20px;
        }

        .hero h2 {
            font-size: 38px;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 18px;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 35px auto;
        }

        .about-box {
            background: white;
            padding: 28px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px #e5dcd3;
            line-height: 1.8;
        }

        h2 {
            color: #8b0000;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 35px;
        }

        .feature {
            background: white;
            padding: 22px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px #e5dcd3;
        }

        .feature .emoji {
            font-size: 38px;
        }

        .contact-link {
            display: inline-block;
            background: #8b0000;
            color: white;
            text-decoration: none;
            padding: 12px 22px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .contact-link:hover {
            background: #600000;
        }

        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 18px;
        }

        @media (max-width: 600px) {
            .features {
                grid-template-columns: 1fr;
            }

            .hero h2 {
                font-size: 28px;
            }

            .hero {
                padding: 60px 15px;
            }

            .about-box {
                padding: 20px;
            }

            nav a {
                margin: 5px 8px;
            }
        }
    </style>
</head>

<body>

<header>
    <h1>TasteHub Restaurant</h1>
    <p>Good Food, Great Memories!</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="menu.php">Menu</a>
    <a href="reservation.php">Reservation</a>
    <a href="about.php">About Us</a>
    <a href="contact.php">Contact</a>
</nav>

<section class="hero">
    <h2>About TasteHub</h2>
    <p>Serving delicious food and creating happy memories.</p>
</section>

<div class="container">

    <section class="about-box">
        <h2>Who We Are</h2>

        <p>
            Welcome to TasteHub Restaurant! We are passionate about
            serving delicious food in a friendly and welcoming
            environment. Our restaurant offers a variety of dishes
            to make every meal enjoyable.
        </p>

        <p>
            From tasty starters to satisfying main courses and
            delicious desserts, we aim to give every customer
            a pleasant dining experience.
        </p>
    </section>

    <section class="about-box">
        <h2>Our Mission</h2>

        <p>
            Our mission is to provide tasty food, friendly service,
            and a convenient experience for every customer.
            Through our website, customers can explore the menu,
            place food orders, reserve tables, and contact us easily.
        </p>
    </section>

    <h2 style="text-align:center;">Why Choose TasteHub?</h2>

    <section class="features">

        <div class="feature">
            <div class="emoji">🍽️</div>
            <h3>Delicious Food</h3>
            <p>A variety of dishes to suit different tastes.</p>
        </div>

        <div class="feature">
            <div class="emoji">🥗</div>
            <h3>Quality & Care</h3>
            <p>We aim to serve food with quality and care.</p>
        </div>

        <div class="feature">
            <div class="emoji">😊</div>
            <h3>Customer Satisfaction</h3>
            <p>We want every customer to have a happy experience.</p>
        </div>

    </section>

    <section class="about-box" style="text-align:center;">
        <h2>We'd Love to Hear From You!</h2>
        <p>Have a question or suggestion? Contact our restaurant.</p>

        <a href="contact.php" class="contact-link">
            Contact Us
        </a>
    </section>

</div>

<footer>
    <p>&copy; 2026 TasteHub Restaurant. All rights reserved.</p>
</footer>

</body>
</html>
