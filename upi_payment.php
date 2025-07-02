<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPI Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('image.webp'); /* Set your background image */
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
            background: rgba(0, 0, 0, 0.7); /* Semi-transparent background for better visibility */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        h1 {
            color: #ffeb3b;
        }

        img {
            max-width: 100%;
            margin: 20px 0;
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
        <h1>UPI Payment</h1>
        <p>To complete your payment, please open your UPI app (Google Pay, PhonePe, etc.) and scan the QR code below.</p>
        <img src="qr.png" alt="UPI QR Code">
        <p><strong>Amount:</strong> ₹<?php echo $_SESSION['order']['total_amount']; ?></p>
        <a href="index.php">Go to Homepage</a>
    </div>
</body>
</html>
