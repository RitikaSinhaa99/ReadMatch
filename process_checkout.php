<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Collect the form data
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$country = $_POST['country'];
$payment_method = $_POST['payment_method'];

// Store the order in the session or database
$_SESSION['order_details'] = [
    'address' => $address,
    'city' => $city,
    'state' => $state,
    'zip' => $zip,
    'country' => $country,
    'payment_method' => $payment_method
];

// Example: Store the order details in the database
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "book_recommendations";
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert order into the database
$sql = "INSERT INTO orders (user_id, address, city, state, zip, country, payment_method, order_status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issssss", $_SESSION['user_id'], $address, $city, $state, $zip, $country, $payment_method);

if ($stmt->execute()) {
    // Get the last inserted order ID
    $order_id = $conn->insert_id;

    // Handle payment method and update order status
    if ($payment_method == 'cod') {
        // For Cash on Delivery, mark as pending, and don't need tracking
        $update_sql = "UPDATE orders SET order_status = 'pending', tracking_status = 'Processing' WHERE order_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("i", $order_id);
        $update_stmt->execute();

        header("Location: cod_confirmation.php"); // Redirect to COD confirmation page
    } elseif ($payment_method == 'credit_card') {
        // For Credit Card, update status to 'processing' and generate a dummy tracking number
        $tracking_number = "CC" . rand(1000, 9999); // Example tracking number
        $update_sql = "UPDATE orders SET order_status = 'processing', tracking_number = ?, tracking_status = 'Processing' WHERE order_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $tracking_number, $order_id);
        $update_stmt->execute();

        header("Location: credit_card_payment.php"); // Redirect to Credit Card payment page
    } elseif ($payment_method == 'upi') {
        // For UPI, generate a tracking number and mark status as 'processing'
        $tracking_number = "UPI" . rand(1000, 9999); // Example tracking number
        $update_sql = "UPDATE orders SET order_status = 'processing', tracking_number = ?, tracking_status = 'Processing' WHERE order_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $tracking_number, $order_id);
        $update_stmt->execute();

        header("Location: upi_payment.php"); // Redirect to UPI payment page
    }
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
