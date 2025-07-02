<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 15px 30px;
            color: #fff;
        }

        .navbar a {
            color: #ffeb3b;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .navbar .user-info {
            font-size: 16px;
        }

        .navbar .menu-links {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="user-info">
            Welcome, <strong><?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?></strong>
        </div>
        <div class="menu-links">
            <a href="index.php">Home</a>
            <a href="your_orders.php">Your Orders</a>
            <a href="cart.php">Cart</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
