<?php
// Database credentials
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate inputs
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into the database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            $success = "Sign up successful! You can now log in.";
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<?php
// Database connection code here...

// Add your sign-up logic from the previous example...
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
            background-color: #4caf50; /* Green button */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
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
        <h1>Sign Up</h1>
        <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <?php if (!empty($success)) echo "<p style='color: green;'>$success</p>"; ?>

        <form action="signup.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <button type="submit">Sign Up</button>
        </form>

        <p>Already have an account? <a href="login.php">Log In</a></p>
    </div>
</body>
</html>
