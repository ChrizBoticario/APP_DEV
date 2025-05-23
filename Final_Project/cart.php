<?php
session_start();
//user redirected here
$cart = $_SESSION['cart'] ?? [];

// Handle remove item request
if (isset($_POST['remove_item'])) {
    $indexToRemove = (int)$_POST['remove_item'];
    if (isset($_SESSION['cart'][$indexToRemove])) {
        unset($_SESSION['cart'][$indexToRemove]);
        // Re-index the array to maintain consecutive indices
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    // Redirect to prevent form resubmission on page refresh
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .cart-container { max-width: 800px; margin: 40px auto; background: #fff; padding: 20px; border-radius: 16px; box-shadow: 0 8px 16px rgba(0,0,0,0.1); }
    .cart-item { display: flex; align-items: center; border-bottom: 1px solid #eee; padding: 10px 0; }
    .cart-item img { width: 80px; height: 80px; background: #ccc; border-radius: 8px; }
    .cart-item-info { margin-left: 20px; flex-grow: 1; }
	.remove-button { 
      background-color: #dc3545; 
      color: white; 
      border: none; 
      padding: 8px 12px; 
      border-radius: 6px; 
      cursor: pointer; 
      font-size: 12px;
      margin-left: 15px;
      transition: background-color 0.3s;
    }
    .remove-button:hover { 
      background-color: #c82333; 
    }
    .remove-form {
      display: inline-block;
      margin: 0;
    }
    .footer { margin-top: 50px; text-align: center; font-size: 14px; color: #888; }
    .searchbar { width: 96.5%; padding: 10px; margin-bottom: 20px; }
	.no-items { text-align: center; font-style: italic; color: #999; margin-top: 10px; }
    .back-button-container { text-align: center; margin-top: 20px; }
    .back-button { padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 8px; cursor: pointer; text-decoration: none; }
    .back-button:hover { background-color: #0056b3; }
	.cart-total { 
      text-align: right; 
      font-size: 18px; 
      font-weight: bold; 
      margin-top: 20px; 
      padding-top: 15px; 
      border-top: 2px solid #007bff; 
    }
  </style>
</head>
<body>
  <h2 style="text-align:center;">Your Cart</h2>

  <div class="cart-container">
    <!-- Search bar -->
    <input type="text" class="searchbar" placeholder="Search in your cart..." onkeyup="filterCart(this.value)">
	
	<!-- No items message -->
    <?php if (empty($cart)): ?>
      <p class="no-items">You do not have items in your cart for now.</p>
    <?php endif; ?>

    <!-- Cart items list -->
    <div id="cart-list">
      <?php foreach ($cart as $index => $item): ?>
        <div class="cart-item" data-name="<?= strtolower($item['product']) ?>">
          <img src="#" alt="<?= $item['product'] ?>">
          <div class="cart-item-info">
            <a href="product.php?product=<?= $item['product'] ?>"><strong><?= ucfirst($item['product']) ?></strong></a><br>
            Size: <?= $item['size'] ?> | Quantity: <?= $item['quantity'] ?><br>
            Price: ₱<?= number_format($item['price'], 2) ?>
          </div>
		  <form method="POST" class="remove-form" onsubmit="return confirm('Are you sure you want to remove this item from your cart?')">
              <input type="hidden" name="remove_item" value="<?= $index ?>">
              <button type="submit" class="remove-button">Remove</button>
            </form>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  
  <!-- Back to home page button -->
  <div class="back-button-container">
    <a href="home.php" class="back-button">Back to Home Page</a>
  </div>
 </div>

  <div class="footer">Need help? Contact us at: store-email@gmail.com</div>

  <script>
    function filterCart(query) {
      const items = document.querySelectorAll('.cart-item');
      items.forEach(item => {
        item.style.display = item.getAttribute('data-name').includes(query.toLowerCase()) ? 'flex' : 'none';
      });
    }
  </script>
</body>
</html>
