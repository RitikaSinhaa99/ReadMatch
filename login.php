<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_recommendations";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Save user info in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to index.php
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<!-- Your login form HTML with error display goes here -->


<?php
// Database connection and login logic here...
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-image: url('image.webp'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            font-family: Arial, sans-serif;
            color: #fff;
        }

        .container {
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
            max-width: 400px;
            padding: 30px;
            margin: 100px auto;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #fdfdfb; /* Gold color */
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            background-color: #2196f3; /* Blue button */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #1976d2;
        }

        p {
            margin-top: 15px;
        }

        a {
            color: #fdfdfb; /* Gold link color */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Log In</h1>
        <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>

        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Log In</button>
        </form>

        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
</body>
</html>
