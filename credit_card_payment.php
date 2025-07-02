<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Card Payment</title>
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
        }

        h1 {
            color: #ffeb3b;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #ff5722;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #e64a19;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Credit/Debit Card Payment</h1>
        <p>Please enter your credit or debit card details to complete the payment.</p>
        <form action="process_card_payment.php" method="POST">
            <label for="card_number">Card Number</label>
            <input type="text" name="card_number" id="card_number" required>

            <label for="expiry_date">Expiry Date</label>
            <input type="text" name="expiry_date" id="expiry_date" required>

            <label for="cvv">CVV</label>
            <input type="password" name="cvv" id="cvv" required>

            <button type="submit">Submit Payment</button>
        </form>
    </div>
</body>
</html>
