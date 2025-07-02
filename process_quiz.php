<?php
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_recommendations";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data from POST request
$mood = $_POST['mood'];
$setting = $_POST['setting'];
$theme = $_POST['theme'];

// Insert the user's response into the quiz_responses table using prepared statements
$stmt = $conn->prepare("INSERT INTO quiz_responses (mood, setting, theme) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $mood, $setting, $theme);  // "sss" means 3 string parameters

if ($stmt->execute()) {
    // Store the form data in the session for later use in the result page
    $_SESSION['quiz_data'] = [
        'mood' => $mood,
        'setting' => $setting,
        'theme' => $theme
    ];

    // Redirect to result.php
    header("Location: result.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close the database connection
$stmt->close();
$conn->close();
?>
