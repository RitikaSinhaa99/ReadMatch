<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user details from the session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Check if quiz data exists in the session
if (!isset($_SESSION['quiz_data'])) {
    header("Location: index.php"); // Redirect to the quiz page
    exit();
}

// Retrieve quiz data
$quiz_data = $_SESSION['quiz_data'];
$mood = $quiz_data['mood'];
$setting = $quiz_data['setting'];
$theme = $quiz_data['theme'];

// Database connection
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "book_recommendations";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch books based on preferences using a prepared statement
$sql = $conn->prepare("SELECT * FROM books WHERE mood = ? AND setting = ? AND theme = ?");
$sql->bind_param("sss", $mood, $setting, $theme);
$sql->execute();
$result = $sql->get_result();

$books = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Book Recommendations</title>
<link rel="stylesheet" href="styles.css">
<style>
/* Add background image and styles */
body {
    background-image: url('image.webp');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    font-family: Arial, sans-serif;
    color: #fff;
    margin: 0;
    padding: 0;
}

/* Header styles */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background-color: rgba(0, 0, 0, 0.7);
}

header div a {
    color: #ffeb3b;
    text-decoration: none;
    font-weight: bold;
    margin-right: 15px;
}

header div a:hover {
    text-decoration: underline;
}

.container {
    background-color: rgba(0, 0, 0, 0.6);
    max-width: 900px;
    padding: 40px;
    margin: 50px auto;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    text-align: center;
}

h1 {
    font-size: 2.5rem;
    color: #fdfdfb;
    margin-bottom: 30px;
}

.book {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    padding: 15px;
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    transition: all 0.3s ease;
}

.book:hover {
    transform: scale(1.05);
}

.book img {
    width: 180px;
    height: auto;
    margin-right: 20px;
    border-radius: 8px;
    border: 2px solid #fff;
}

.book-info h3, .book-info p {
    color: #fdfdfb;
}

.add-to-cart {
    background-color: #4caf50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.add-to-cart:hover {
    background-color: #45a049;
}
</style>
</head>
<body>
<header>
<p>Welcome, <strong><?php echo htmlspecialchars($username); ?></strong> (User ID: <?php echo htmlspecialchars($user_id); ?>)</p>
<div>
    <a href="cart.php">Cart (<?php echo count($_SESSION['cart'] ?? []); ?>)</a>
    <a href="your_orders.php">Your Orders</a>
    <a href="logout.php">Logout</a>
</div>
</header>

<div class="container">
<h1>Your Book Recommendations</h1>
<?php if (!empty($books)): ?>
    <?php foreach ($books as $book): ?>
        <div class="book">
            <img src="<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
            <div class="book-info">
                <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($book['price']); ?></p>
                <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['id']); ?>">
                    <button type="submit" class="add-to-cart">Add to Cart</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No recommendations found for your preferences.</p>
<?php endif; ?>
</div>
</body>
</html>
