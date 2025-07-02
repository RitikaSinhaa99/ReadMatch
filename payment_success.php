<?php 
session_start(); 

// Check if an order exists in the session
if (!isset($_SESSION['order'])) {
    header("Location: index.php"); // Redirect to homepage if no order exists
    exit();
}

// Get order details from the session
$order = $_SESSION['order'];

// Example: Save order details to the database (mock implementation)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_recommendations";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL query to save the order
$stmt = $conn->prepare("INSERT INTO orders (user_id, address, city, state, zip, country, total_amount, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    "isssssss", 
    $_SESSION['user_id'], 
    $order['address'], 
    $order['city'], 
    $order['state'], 
    $order['zip'], 
    $order['country'], 
    $order['total_amount'], 
    $order['payment_method']
);

if ($stmt->execute()) {
    // Order saved successfully, clear session cart
    unset($_SESSION['cart']);
    unset($_SESSION['order']);
    $success_message = "Thank you for your order! Your payment was successful.";
} else {
    $success_message = "There was an error processing your order. Please contact support.";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4caf50;
        }
        p {
            font-size: 1.2em;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
        }
        a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Success</h1>
        <p><?php echo $success_message; ?></p>
        <p><strong>Order Total:</strong> ₹<?php echo htmlspecialchars($order['total_amount']); ?></p>
        <a href="index.php">Return to Homepage</a>
    </div>
</body>
</html>
