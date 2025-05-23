<?php 

session_start();
 if (isset($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<style>
	.btn { 
		padding: 10px;
		background-color: #007bff;
		color: white;
		border: none;
		border-radius: 8px;
		cursor: pointer;
		font-size: 16px;
		transition: background-color 0.2s ease;
	}

	.btn:hover { 
		background-color: #0056b3;
	}
	</style>
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
	<!-- search bar -->
    <input type="text" placeholder="Search product..." id="searchBar"><br><br>

	<!-- product item lists. Add more products in the future -->
    <a class="product-link" href="product.php?item=shirt">
        <img src="images/shirt.jpg" alt="Shirt">
        <span>Shirt</span>
    </a>
	
	<a class="product-link" href="product.php?item=socks">
        <img src="images/socks.jpg" alt="Socks">
        <span>Socks</span>
    </a>
	
	<a class="product-link" href="product.php?item=short">
        <img src="images/short.jpg" alt="Short">
        <span>Short</span>
    </a>
	
	<a class="product-link" href="product.php?item=jeans">
        <img src="images/jeans.jpg" alt="Jeans">
        <span>Jeans</span>
    </a>
	
	<a class="product-link" href="product.php?item=trousers">
        <img src="images/trousers.jpg" alt="Trousers">
        <span>Trousers</span>
    </a>

    <br><br>
    <button class="btn" id="btnCart" onclick="window.location.href='cart.php'">Your Cart</button> 
	<button class="btn" id="btnProfile" onclick="window.location.href='profile.php'">Profile</button> 
	<button class="btn" id="btnLogout" onclick="confirmLogout()">Log Out</button>
	
</div>
<script>
function confirmLogout() {
    if (confirm("Are you sure you want to log out?")) {
        window.location.href = "login.php";
    }
}
</script>
</body>
</html>
