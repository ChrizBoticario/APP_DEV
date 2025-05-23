<?php
// buy.php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Assuming product details are stored in session or retrieved from database
$product = $_SESSION['buy_now'] ?? null;
if (!$product) {
    header("Location: home.php");
    exit();
}

// Calculate total price
$productName = $product['product'] ?? 'Unknown Product';
$base_price = $product['price'];
$quantity = $product['quantity'];
$productId = $product['id'] ?? null;
$shipping_fee = 50; // Example shipping fee
$total_price = ($base_price * $quantity) + $shipping_fee;

// product image array for slideshow
$productImages = [
    'images/sample1.jpg',
    'images/sample2.jpg',
    'images/sample3.jpg'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Product</title>
    <link rel="stylesheet" href="style.css">
    <style>
		.slideshow-container {
            position: relative;
            max-width: 100%;
            margin-bottom: 1rem;
        }

        .slides {
            display: none;
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0,0,0,0.5);
            color: white;
            font-size: 24px;
            padding: 0.5rem;
            cursor: pointer;
            border-radius: 50%;
            user-select: none;
        }

		.controls {
			text-align: center;
		}

		.controls button {
			margin: 0 4px; /* Adds spacing between buttons */
		}

        .left-arrow {
            left: 0;
        }

        .right-arrow {
            right: 0;
        }
	
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header, footer {
            background-color: #007bff;
            color: white;
            padding: 1rem;
            text-align: center;
        }

        main {
            max-width: 600px;
            margin: 2rem auto;
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 1rem 0 0.3rem;
            font-weight: bold;
        }

        input, textarea, select {
            width: 100%;
            padding: 0.6rem;
            margin-top: 0.3rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        h2 {
            margin-top: 2rem;
        }

        p {
            margin: 0.5rem 0;
        }

        button, a#backButton {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            margin-top: 1rem;
			cursor: pointer;
        }

        a#backButton {
            margin-left: 1rem;
        }

        footer {
            margin-top: 3rem;
        }
    </style>
</head>
<body>
    <header>
        <h1>Checkout</h1>
    </header>
	
    <main>
		<!-- Slideshow above product name -->
        <div class="slideshow-container">
            <?php foreach ($productImages as $index => $imgPath): ?>
                <img src="<?php echo htmlspecialchars($imgPath); ?>" class="slides" style="<?php echo $index === 0 ? 'display:block;' : ''; ?>">
            <?php endforeach; ?>
        </div>
		
		<div class="controls">
			<button>&lt;</button>
			<button>&gt;</button>
		</div>

        <!-- product name -->
		<p><strong>Product:</strong> <?php echo htmlspecialchars($productName); ?></p>
		
        <form action="buy_result.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="address">Address:</label>
            <textarea name="address" id="address" required></textarea>

            <label for="contact">Contact Number:</label>
            <input type="tel" name="contact" id="contact" pattern="[0-9]{11}" required>

            <label for="payment">Payment Method:</label>
            <select name="payment" id="payment" required>
                <option value="credit_card">Credit Card</option>
                <option value="cod">Cash on Delivery</option>
            </select>

            <h2>Order Summary</h2>
            <p>Product: <?php echo htmlspecialchars($productName); ?></p>
            <p>Quantity: <?php echo $quantity; ?></p>
            <p>Price per item: ₱<?php echo number_format($base_price, 2); ?></p>
            <p>Shipping Fee: ₱<?php echo number_format($shipping_fee, 2); ?></p>
            <p><strong>Total: ₱<?php echo number_format($total_price, 2); ?></strong></p>

			<!-- buy and back button -->
			<input type="hidden" name="size" value="<?php echo htmlspecialchars($product['size'] ?? ''); ?>">
			<input type="hidden" name="quantity" value="<?php echo htmlspecialchars($product['quantity'] ?? 1); ?>">

            <div style="display: flex; gap: 1rem; align-items: center;">
				<button type="submit" id="buyButton">Buy</button>
				<button id="backButton" formaction="product.php" formnovalidate>Back</button>
			</div>
        </form>
    </main>
    <footer>
        <p>Need help? Contact us at: store-email@gmail.com</p>
    </footer>
	
	<!-- slideshow script -->
    <script>
        let slideIndex = 0;
        const slides = document.getElementsByClassName("slides");

        function showSlide(index) {
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slides[index].style.display = "block";
        }

        function plusSlides(n) {
            slideIndex = (slideIndex + n + slides.length) % slides.length;
            showSlide(slideIndex);
        }
		showSlide(slideIndex);
    </script>
</body>
</html>
