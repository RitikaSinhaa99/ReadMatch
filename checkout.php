

<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        /* General styles for the page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('image.webp'); /* Replace with your image */
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background: rgba(0, 0, 0, 0.8); /* Semi-transparent background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        h1, h2 {
            color: #ffeb3b;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
        }

        input[type="text"] {
            background: #fff;
            color: #000;
        }

        button {
            background-color: #ff5722;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #e64a19;
        }

        .payment-options {
            display: flex;
            justify-content: space-between;
        }

        .payment-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s ease;
            flex: 1;
            margin: 0 10px;
        }

        .payment-card:hover {
            transform: scale(1.05);
            background-color: rgba(255, 255, 255, 0.2);
        }

        .payment-card img {
            width: 50px;
            margin-bottom: 10px;
        }

        .payment-card input {
            display: none;
        }

        .payment-card.selected {
            border: 2px solid #ffeb3b;
            background-color: rgba(255, 255, 255, 0.3);
        }
    </style>
    <script>
        // Add selection effect for payment options
        document.addEventListener("DOMContentLoaded", () => {
            const paymentCards = document.querySelectorAll(".payment-card");
            paymentCards.forEach(card => {
                card.addEventListener("click", () => {
                    paymentCards.forEach(c => c.classList.remove("selected"));
                    card.classList.add("selected");
                    card.querySelector("input").checked = true;
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <form action="process_checkout.php" method="POST">
            <!-- Shipping Address Section -->
            <h2>Shipping Address</h2>
            <label for="address">Street Address</label>
            <input type="text" name="address" id="address" required>

            <label for="city">City</label>
            <input type="text" name="city" id="city" required>

            <label for="state">State</label>
            <input type="text" name="state" id="state" required>

            <label for="zip">ZIP Code</label>
            <input type="text" name="zip" id="zip" required>

            <label for="country">Country</label>
            <input type="text" name="country" id="country" required>

            <!-- Payment Options Section -->
            <h2>Payment Options</h2>
            <div class="payment-options">
                <label class="payment-card">
                    <input type="radio" name="payment_method" value="cod" required>
                    <img src="cod.jpeg" alt="COD">
                    <p>Cash on Delivery</p>
                </label>

                <label class="payment-card">
                    <input type="radio" name="payment_method" value="credit_card">
                    <img src="c.jpeg" alt="Credit Card">
                    <p>Credit/Debit Card</p>
                </label>

                <label class="payment-card">
                    <input type="radio" name="payment_method" value="upi">
                    <img src="qr.png" alt="UPI">
                    <p>UPI (Google Pay, PhonePe)</p>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit">Place Order</button>
        </form>
    </div>
</body>
</html>
