<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'fitness_app');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $fitness_goal = $_POST['fitness_goal'];

    if (!empty($username) && !empty($email) && !empty($_POST['password']) && !empty($fitness_goal)) {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, fitness_goal) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password, $fitness_goal);
        $stmt->execute();
        echo "Registration successful!";
        $stmt->close();
    } else {
        echo "Please fill in all fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fitness Challenge Registration</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <select name="fitness_goal" required>
            <option value="">Select Fitness Goal</option>
            <option value="Lose Weight">Lose Weight</option>
            <option value="Build Muscle">Build Muscle</option>
            <option value="Maintain">Maintain</option>
        </select><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
