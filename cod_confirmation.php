<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash on Delivery Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('background.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
        }
        .container {
            max-width: 600px;
            margin: 100px auto;
            background: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        h1 {
            color: #ffeb3b;
        }
        p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        a {
            color: #ff5722;
            text-decoration: none;
            font-size: 16px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Confirmation</h1>
        <p>Your order has been placed successfully with the selected payment method: Cash on Delivery (COD).</p>
        <p>Your order status is: <strong><?php echo $_SESSION['order_details']['order_status']; ?></strong></p>
        <p>Your tracking status is: <strong><?php echo $_SESSION['order_details']['tracking_status']; ?></strong></p>
        <p>Your tracking number is: <strong><?php echo $_SESSION['order_details']['tracking_number']; ?></strong></p>
        <a href="index.php">Go to Homepage</a>
    </div>
</body>
</html>
