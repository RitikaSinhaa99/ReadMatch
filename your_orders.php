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

$user_id = $_SESSION['user_id'];

// Fetch all orders for the logged-in user
$sql = "SELECT id, total_price, address, payment_method, order_date, tracking_status 
        FROM orders 
        WHERE user_id = ? 
        ORDER BY order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all orders into an array
$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
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
            max-width: 900px;
            margin: 50px auto;
            background: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        h1 {
            color: #ffeb3b;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #fff;
        }

        table th {
            background-color: #444;
        }

        .track-link {
            color: #ff5722;
            text-decoration: none;
            font-weight: bold;
        }

        .track-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Orders</h1>
        <?php if (!empty($orders)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Total Price</th>
                        <th>Payment Method</th>
                        <th>Order Date</th>
                        <th>Tracking Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($order['id']); ?></td>
                            <td>₹<?php echo htmlspecialchars($order['total_price']); ?></td>
                            <td><?php echo htmlspecialchars(ucwords($order['payment_method'])); ?></td>
                            <td><?php echo htmlspecialchars(date("F j, Y, g:i a", strtotime($order['order_date']))); ?></td>
                            <td><?php echo htmlspecialchars($order['tracking_status']); ?></td>
                            <td>
                                <a href="track_order.php?order_id=<?php echo htmlspecialchars($order['id']); ?>" class="track-link">Track</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
