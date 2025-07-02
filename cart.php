

<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database credentials
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "book_recommendations";

// Create a connection to the database
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the cart items from the session
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Query to fetch the books that are in the cart
$books_in_cart = [];
if (!empty($cart_items)) {
    $ids = implode(",", array_map('intval', $cart_items));
    $sql = "SELECT * FROM books WHERE id IN ($ids)";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $books_in_cart[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #222;
            color: #fff;
            padding: 10px 20px;
        }

        header a {
            color: #ffeb3b;
            text-decoration: none;
            font-weight: bold;
        }

        header a:hover {
            text-decoration: underline;
        }

        #cart-icon {
            position: relative;
        }

        #cart-count {
            position: absolute;
            top: 0;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 0.9rem;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .cart-item img {
            width: 100px;
            height: auto;
            border-radius: 5px;
        }

        .cart-item-info {
            flex: 1;
            margin-left: 20px;
        }

        .cart-item-info h3 {
            margin: 0;
            font-size: 1.2rem;
        }

        .cart-item-info p {
            margin: 5px 0;
            font-size: 1rem;
        }

        .remove-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .remove-button:hover {
            background-color: #d32f2f;
        }

        .checkout-button {
            background-color: #4caf50;
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            font-size: 1rem;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }

        .checkout-button:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>
<header>
    <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
    <div id="cart-icon">
        <a href="cart.php">
            🛒 <span id="cart-count"><?php echo count($cart_items); ?></span>
        </a>
    </div>
    <a href="logout.php">Logout</a>
</header>

<div class="container">
    <h1>Your Cart</h1>
    <?php if (!empty($books_in_cart)): ?>
        <?php foreach ($books_in_cart as $book): ?>
            <div class="cart-item">
                <img src="<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
                <div class="cart-item-info">
                    <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                    <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                    <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($book['price']); ?></p>
                </div>
                <button class="remove-button" data-book-id="<?php echo htmlspecialchars($book['id']); ?>">Remove</button>
            </div>
        <?php endforeach; ?>
        <a href="checkout.php" class="checkout-button">Proceed to Checkout</a>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>

<script>
    document.querySelectorAll('.remove-button').forEach(button => {
        button.addEventListener('click', function() {
            const bookId = this.getAttribute('data-book-id');

            fetch('remove_from_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ book_id: bookId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Failed to remove item from cart.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>
</body>
</html>
