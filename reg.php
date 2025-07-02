<?php
// Start session for displaying error messages after form submission
session_start();

// Initialize form variables
$username = $email = $password = $fitness_goal = $meal = $calories = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect input values
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $fitness_goal = $_POST['fitness_goal'];
    $meal = trim($_POST['meal']);
    $calories = trim($_POST['calories']);

    // Validate fields
    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($fitness_goal)) {
        $errors[] = "Fitness goal is required.";
    }

    if (empty($meal)) {
        $errors[] = "Meal is required.";
    }

    if (!empty($calories) && (!is_numeric($calories) || $calories <= 0)) {
        $errors[] = "Calories should be a positive integer.";
    }

    // If no errors, process form (e.g., save data to database or send confirmation)
    if (empty($errors)) {
        $_SESSION['success'] = "Registration successful!";
        // You can save the data to the database here.
        // For now, we'll redirect to a success page.
        header('Location: success.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Challenge Registration</title>
</head>
<body>
    <h1>Fitness Challenge Registration</h1>

    <?php
    // Display errors if any
    if (!empty($errors)) {
        echo '<div style="color: red;">';
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo '</div>';
    }
    ?>

    <form action="index.php" method="POST">
        <label for="username">Username: </label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br><br>

        <label for="email">Email: </label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>

        <label for="password">Password: </label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="fitness_goal">Fitness Goal: </label>
        <select id="fitness_goal" name="fitness_goal" required>
            <option value="">Select a goal</option>
            <option value="weight_loss" <?php echo ($fitness_goal == 'weight_loss') ? 'selected' : ''; ?>>Weight Loss</option>
            <option value="muscle_gain" <?php echo ($fitness_goal == 'muscle_gain') ? 'selected' : ''; ?>>Muscle Gain</option>
            <option value="maintain" <?php echo ($fitness_goal == 'maintain') ? 'selected' : ''; ?>>Maintain Weight</option>
        </select><br><br>

        <label for="meal">Meal: </label>
        <input type="text" id="meal" name="meal" value="<?php echo htmlspecialchars($meal); ?>" required><br><br>

        <label for="calories">Calories: </label>
        <input type="text" id="calories" name="calories" value="<?php echo htmlspecialchars($calories); ?>" required><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>