<?php
// Database credentials
$host = 'localhost';
$database_name = 'your_database_name';
$username = 'your_username';
$password = 'your_password'; 

// Or user environment variables
// Load configuration from a secure location
// $config = require_once __DIR__ . '/../config/database.php';

try {
    // Changed $connection to $pdo to match what index.php expects
    $pdo = new PDO(
        "mysql:host=$host;dbname=$database_name", 
        $username, 
        $password
    );
    
    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // echo "Connected successfully!";
    
} catch (PDOException $error) {
    // Log error
    error_log("Database connection failed: " . $error->getMessage());
    // Display generic error
    die('A database error occurred. Please try again later.');
}
?>