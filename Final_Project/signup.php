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
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Create an Account</h2>
    <form method="post" action="signup_result.php">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="text" name="address" placeholder="Address" required><br><br>
        <input type="text" name="contact" placeholder="Contact Number" required><br><br>
        <input type="date" name="birthday" required><br><br>
        <div class="button-container">
            <button class="btn" id="btnCreateAccount">Create Account</button>
            <button class="btn" id="btnBack" formaction="login.php" formnovalidate>Back</button>
        </div>
    </form>
</div>
</body>
</html>
