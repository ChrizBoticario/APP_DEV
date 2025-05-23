<?php
// buy_result.php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the order here (e.g., save to database)

    // For demonstration, we'll just set an estimated delivery date
    $estimated_delivery = date('F j, Y', strtotime('+5 days'));
} else {
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Confirmation</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f9fc;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            background: white;
            max-width: 600px;
            margin: 3rem auto;
            padding: 2rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            text-align: center;
        }
        h1 {
            color: #2d3748;
        }
        p {
            font-size: 1.1rem;
            color: #4a5568;
        }
        a#homeButton {
            display: inline-block;
            margin-top: 1.5rem;
            padding: 0.6rem 1.2rem;
            background-color: #3182ce;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s;
        }
        a#homeButton:hover {
            background-color: #2b6cb0;
        }
        footer {
            margin-top: auto;
            padding: 1rem;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thank You for Your Purchase!</h1>
        <p>Your order has been placed successfully.</p>
        <p>Estimated arrival of product is: <?php echo $estimated_delivery; ?></p>
        <a href="home.php" id="homeButton">Back to Home Page</a>
    </div>
    <footer style="background-color: #007bff">
        <p>Need help? Contact us at: store-email@gmail.com</p>
    </footer>
</body>
</html>

