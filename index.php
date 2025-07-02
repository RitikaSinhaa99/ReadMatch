<?php 
// Start the session to access logged-in user data 
session_start();  

// Redirect to login.php if the user is not logged in 
if (!isset($_SESSION['user_id'])) {     
    header("Location: login.php");     
    exit(); 
}  

// Retrieve user details from the session 
$user_id = $_SESSION['user_id']; 
$username = $_SESSION['username']; 
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Book Recommendation Quiz</title> 
    <link href="URL_TO_FIONA_FONT_CSS" rel="stylesheet"> 
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS -->
</head> 
<body> 

<!-- Header with User Info and Logout -->
<header>
    <p>Welcome, <strong><?php echo htmlspecialchars($username); ?></strong> (User ID: <?php echo htmlspecialchars($user_id); ?>)</p>
    <a href="logout.php">Logout</a>
</header>

<!-- Main Content Container -->
<div class="container">
    <h1>Discover Your Next Read</h1>
    <form action="process_quiz.php" method="post">
        <!-- Mood Preference -->
        <div class="form-group">
            <label for="mood" class="form-label">Mood Preference:</label>
            <div class="form-options">
                <input type="radio" name="mood" value="Lighthearted" id="mood-lighthearted" required>
                <label for="mood-lighthearted">Lighthearted</label>
                <input type="radio" name="mood" value="Serious" id="mood-serious">
                <label for="mood-serious">Serious</label>
            </div>
        </div>

        <!-- Preferred Setting -->
        <div class="form-group">
            <label for="setting" class="form-label">Preferred Setting:</label>
            <div class="form-options">
                <input type="radio" name="setting" value="Fantasy" id="setting-fantasy" required>
                <label for="setting-fantasy">Fantasy</label>
                <input type="radio" name="setting" value="Mystery" id="setting-mystery">
                <label for="setting-mystery">Mystery</label>
                <input type="radio" name="setting" value="Science Fiction" id="setting-scifi">
                <label for="setting-scifi">Science Fiction</label>
            </div>
        </div>

        <!-- Favorite Themes -->
        <div class="form-group">
            <label for="theme" class="form-label">Favorite Themes:</label>
            <div class="form-options">
                <input type="radio" name="theme" value="Adventure" id="theme-adventure" required>
                <label for="theme-adventure">Adventure</label>
                <input type="radio" name="theme" value="Friendship" id="theme-friendship">
                <label for="theme-friendship">Friendship</label>
                <input type="radio" name="theme" value="Love" id="theme-love">
                <label for="theme-love">Love</label>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-button">Get Recommendations</button>
    </form>
</div>

</body> 
</html>
