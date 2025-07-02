<!-- order_confirmation.php -->
<?php
session_start();

// Check if the order details are in the session
if (!isset($_SESSION['order_details'])) {
    header("Location: checkout.php");
    exit();
}

$order_details = $_SESSION['order_details'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Thank you for your order!</p>
    <p><strong>Shipping Address:</strong></p>
    <p><?php echo htmlspecialchars($order_details['address']); ?></p>
    <p><?php echo htmlspecialchars($order_details['city']); ?>, <?php echo htmlspecialchars($order_details['state']); ?> - <?php echo htmlspecialchars($order_details['zip']); ?></p>
    <p><?php echo htmlspecialchars($order_details['country']); ?></p>
    
    <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order_details['payment_method']); ?></p>

    <p>Your order will be processed soon. You will receive an update via email.</p>
</body>
</html>
