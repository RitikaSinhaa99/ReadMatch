<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_recommendations";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$order_id = $_GET['order_id'] ?? null;
$user_id = $_SESSION['user_id'];

// Fetch order details
$sql = "SELECT id, tracking_status, order_date 
        FROM orders 
        WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

$stmt->close();
$conn->close();

if (!$order) {
    die("Order not found or access denied.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('background.jpg'); /* Path to background image */
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
            background: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }

        h1 {
            color: #ffeb3b;
        }

        p {
            font-size: 18px;
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
        <h1>Track Order</h1>
        <p><strong>Order ID:</strong> #<?php echo htmlspecialchars($order['id']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($order['tracking_status']); ?></p>
        <p><strong>Order Date:</strong> <?php echo htmlspecialchars(date("F j, Y, g:i a", strtotime($order['order_date']))); ?></p>
        <a href="your_orders.php">Back to Orders</a>
    </div>
</body>
</html>
