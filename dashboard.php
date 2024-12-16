<?php
session_start();  
date_default_timezone_set('America/New_York');
// Include database connection
include 'db_conn.php';
// If user isn't logged in, send them back to login page
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
// Check if user has admin rights
if (!$_SESSION['user']['is_admin']) {
    echo "Access denied. You do not have permission to view this page.";
    exit;
}
// Get all users
$stmt = $pdo->query('SELECT id, full_name, birthday FROM users');
$users = $stmt->fetchAll();

// Function to calculate days until someone's birthday
function daysUntilBirthday($birthday) {
    $today = new DateTime('today midnight');  // Changed this line
    $birthDate = new DateTime($birthday);
    
    // Debug information
    echo "<!-- Starting date check for birthday: $birthday\n";
    echo "Today's date (Y-m-d): " . $today->format('Y-m-d') . "\n";
    echo "Today's format (m-d): " . $today->format('m-d') . "\n";
    echo "Birthday format (m-d): " . $birthDate->format('m-d') . "\n";
    
    // Check if today is their birthday
    if ($today->format('m-d') === $birthDate->format('m-d')) {
        echo "It's their birthday!\n-->";
        return "Happy Birthday!";
    }
    echo "Not their birthday\n-->";
    
    $currentYear = (int)$today->format('Y');
    $birthdayThisYear = new DateTime(
        $currentYear . '-' . 
        $birthDate->format('m') . '-' . 
        $birthDate->format('d')
    );
    
    if ($today > $birthdayThisYear) {
        $birthdayThisYear->modify('+1 year');
    }
    
    $diff = $today->diff($birthdayThisYear);
    return $diff->days;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['user']['full_name']) ?></h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Birthday</th>
            <th>Days Until Birthday</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td class='data'><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['full_name']) ?></td>
                <td class='data'><?= htmlspecialchars($user['birthday']) ?></td>
                <td class='data'>
                    <?php
                        $days = daysUntilBirthday($user['birthday']);
                        echo $days;
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="logout.php">Logout</a>
</body>
</html>