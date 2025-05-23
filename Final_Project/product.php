<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

	// Dummy product data
	$products = [
		"shirt" => ["price" => 500],
		"socks" => ["price" => 200],
		"short" => ["price" => 400],
		"jeans" => ["price" => 800],
		"trousers" => ["price" => 700]
	];

	// Get product name from query
	$product_name = $_GET['product'] ?? 'shirt';
	$base_price = $products[$product_name]['price'] ?? 0;

	// Adjustment array in PHP for server side
	$adjustment = [
    "XS" => -100, "S" => -50, "M" => 0,
    "L" => 150, "XL" => 200, "XXL" => 250, "XXXL" => 300
	];

	// Get product from GET parameter or default to 'shirt'
	$product_name = $_GET['product'] ?? 'shirt';
	// Get base price or 0 if product not found
	$base_price = $products[$product_name]['price'] ?? 0;

	// Initialize variables
	$size = $_GET['size'] ?? 'M'; // Default size from GET (page load)
	$quantity = 1;                // Default quantity
	$total_price = 0;
	$success_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get size and quantity from POST, fallback to safe defaults
    $size = $_POST['size'] ?? 'M';
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    if ($quantity < 1) $quantity = 1; // sanitize quantity

    // Calculate total price with size adjustment and quantity
    $size_adjustment = $adjustment[$size] ?? 0;
    $total_price = ($base_price + $size_adjustment) * $quantity;

    // Add to cart action
    if (isset($_POST['add_to_cart'])) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][] = [
            "product" => $product_name,
            "size" => $size,
            "quantity" => $quantity,
            "price" => $total_price
        ];
        $success_message = "Successfully added to cart!";
    }

    // Buy now action - redirect to buy.php
    if (isset($_POST['buy'])) {
        $_SESSION['buy_now'] = [
            "product" => ucfirst($product_name),
            "size" => $size,
            "quantity" => $quantity,
            "price" => $total_price
        ];
        header("Location: buy.php");
        exit();
    }
} else {
    // If no form submission, calculate default total price for initial page load
    $size_adjustment = $adjustment[$size] ?? 0;
    $total_price = ($base_price + $size_adjustment) * $quantity;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= ucfirst($product_name) ?> - Details</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .slideshow { width: 300px; height: 300px; margin: auto; background: #eee; display: flex; align-items: center; justify-content: center; font-size: 24px; }
    .controls { text-align: center; margin-top: 10px; }
    .description-box { max-width: 600px; margin: 30px auto; padding: 20px; background: #fff; border-radius: 16px; box-shadow: 0 8px 16px rgba(0,0,0,0.1); }
    .description-box select, .description-box input { width: 100%; padding: 10px; margin-top: 10px; }
    .description-box .btn {
      margin-top: 15px;
      padding: 10px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.2s ease;
      width: 100%;
    }
    .description-box .btn:hover {
      background-color: #0056b3;
    }
    .popup {
      background-color: #d4edda;
      padding: 10px;
      border: 1px solid #c3e6cb;
      margin: 20px auto;
      width: 400px;
      color: green;
      text-align: center;
    }
	
	/* Make quantity input container same width as size select 
    label[for="quantity"], input[name="quantity"], 
	label[for="size"], select[name="size"] {
      display: block;
      width: 100%;
      margin-top: 10px;
    }*/
	
	.slideshow-controls { 
		display: flex;
		justify-content: center;
		gap: 10px;
		margin-top: 10px;
	}

	.nav-btn { 
		padding: 5px 12px;
		font-size: 18px;
		cursor: pointer;
		border-radius: 4px;
		border: 1px solid #ccc;
		background-color: white;
		transition: background-color 0.2s ease;
	}

	.nav-btn:hover { 
		background-color: #f0f0f0;
	}
	
  </style>
</head>
<body>
  <h2 style="text-align:center;">Product Details: <?= ucfirst($product_name) ?></h2>

  <div class="slideshow">
    <!-- Placeholder for slideshow image -->
    Image of <?= $product_name ?>
  </div>

  <!-- Image Navigation Buttons -->
  <div class="slideshow-controls"> 
	<button class="nav-btn"><</button> 
	<button class="nav-btn">></button>
  </div>

  <div class="description-box">
    <form method="POST" action="product.php?product=<?= $product_name ?>">
	
     <!-- Select size -->
	 <!-- Size and Quantity Container Side-by-Side -->
      <div>
        <label for="size">Size:</label>
        <select name="size" id="sizeSelect" required>
          <option value="XS">XS (-100)</option>
          <option value="S">S (-50)</option>
          <option value="M" selected>M (base)</option>
          <option value="L">L (+150)</option>
          <option value="XL">XL (+200)</option>
          <option value="XXL">XXL (+250)</option>
          <option value="XXXL">XXXL (+300)</option>
        </select>
      </div>

      <div style="display: flex; align-items: end; gap: 10px;">
        <div style="flex: 0 0 150px;">
          <label for="quantity">Quantity:</label>
          <input type="number" name="quantity" id="quantityInput" min="1" value="1" required style="width: 385%;">
        </div>
        <div style="color: #666; font-size: 14px; padding-bottom: 10px;">
        </div>
      </div>

      <!-- Price calculation -->
      <?php
        $total_price = 0;
        $success_message = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $size = $_POST['size'];
            $quantity = intval($_POST['quantity']);
            $total_price = ($base_price + $adjustment[$size]) * $quantity;

            if (isset($_POST['add_to_cart'])) {
                $_SESSION['cart'][] = [
                    "product" => $product_name,
                    "size" => $size,
                    "quantity" => $quantity,
                    "price" => $total_price
                ];
                $success_message = "Successfully added to cart!";
            }

            if (isset($_POST['buy'])) {
                $_SESSION['buy_now'] = [
                    "product" => ucfirst($product_name),
                    "size" => $size,
                    "quantity" => $quantity,
                    "price" => $total_price
                ];
                header("Location: buy.php");
                exit();
            }
        }
      ?>

      <?php if ($success_message): ?>
        <div class="popup"><?= $success_message ?></div>
      <?php endif; ?>

      <p><strong>Total Price:</strong> ₱<span id="totalPrice"><?= number_format($total_price, 2) ?></span></p>

      <!-- ACTION BUTTONS: Add to Cart / Buy / Home / Your Cart -->
      <div style="display: flex; flex-wrap: wrap; gap: 10px;">
        <button class="btn" type="submit" name="add_to_cart" style="flex: 1;">Add to Cart</button>
		
        <button class="btn" type="submit" name="buy" style="flex: 1;">Buy</button>
		
        <a href="home.php" class="btn" style="flex: 1; text-align: center; text-decoration: none; display: inline-block;"> Back </a>
		
        <a href="cart.php" class="btn" style="flex: 1; text-align: center; text-decoration: none; display: inline-block;">Your Cart</a>
      </div>
    </form>
  </div>
  
  <script>
  // Price adjustment mapping in JS, keep in sync with PHP $adjustment
    const adjustment = {
      "XS": -100, "S": -50, "M": 0,
      "L": 150, "XL": 200, "XXL": 250, "XXXL": 300
    };

    const basePrice = <?= $base_price ?>;
    const sizeSelect = document.getElementById('sizeSelect');
    const quantityInput = document.getElementById('quantityInput');
    const totalPriceElem = document.getElementById('totalPrice');

    function updateTotalPrice() {
      const size = sizeSelect.value;
      let quantity = parseInt(quantityInput.value);
      if (isNaN(quantity) || quantity < 1) {
        quantity = 1;
        quantityInput.value = 1; // Reset invalid quantity
      }
      const total = (basePrice + adjustment[size]) * quantity;
      totalPriceElem.textContent = total.toFixed(2);
    }

    // Attach event listeners to update price instantly
    sizeSelect.addEventListener('change', updateTotalPrice);
    quantityInput.addEventListener('input', updateTotalPrice);
    // Initial price calculation on page load
    updateTotalPrice();
  </script>

</body>
</html>
