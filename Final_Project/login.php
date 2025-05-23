<?php
// Start session to track user
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<!-- buttons size,shape,color -->
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
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
	<h1>Welcome to Store name</h1>
    <h2>Login to Your Account</h2>
    <form method="post" action="home.php">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <!-- Login redirects to Home -->
        <button class="btn" id="btnLogin">Login</button>

        <!-- Sign In redirects to Signup - formnovalidate allows clicking without filling form -->
        <button class="btn" id="btnSignIn" formaction="signup.php" formnovalidate>Sign In</button>
    </form>
</div>
</body>
</html>