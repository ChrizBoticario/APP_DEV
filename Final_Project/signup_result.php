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
    <title>Account Created</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Congratulations!</h2>
    <p>You have an account now!</p>
    <form action="login.php">
        <button class="btn" id="btnLoginRedirect">Login</button>
    </form>
</div>
</body>
</html>
