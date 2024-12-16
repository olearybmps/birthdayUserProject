<?php
session_start();   // Start a PHP session

// Include database connection
include 'db_conn.php';

// Check if the form was submitted
if ($_POST) {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Debug: Show what we received
    // echo "<pre>Attempting login with:";
    // echo "\nUsername: " . $username;
    // echo "\nPassword: " . $password . "</pre>";
    
    // Look for this user in our database
    $query = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $query->execute([$username]);
    $user = $query->fetch();
    
    // Debug: Show what we found
    // echo "<pre>Database returned:";
    // print_r($user);
    // echo "</pre>";
    
    // Debug: Test password verification
    // if ($user) {
    //     echo "User found in database<br>";
    //     echo "Stored hash: " . $user['password'] . "<br>";
    //     echo "Password verify result: " . (password_verify($password, $user['password']) ? 'true' : 'false') . "<br>";
    // } else {
    //     echo "No user found with that username<br>";
    // }
    
    // Check if user exists and password is correct
    if ($user && password_verify($password, $user['password'])) {
        // Success! Save user info in session
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');  // Go to dashboard
        exit;
    } else {
        // Wrong username or password
        $error = "Wrong username or password";
    }
}
?>

<!-- Simple login form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Please Log In</h1>
    <form method="POST">
        Username: <input type="text" name="username"><br>
        Password: <input type="password" name="password"><br>
        <button type="submit">Log In</button>
    </form>
    
    <!-- Show error message if login failed -->
    <?php if (isset($error)) echo "<p>$error</p>"; ?>

    <!-- Debug: Show current session data -->
    <!-- <h3>Current Session Data:</h3>
    <pre>
        <?php 
            // print_r($_SESSION); 
        ?>
    </pre> -->
</body>
</html>