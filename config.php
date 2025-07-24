<?php
$host = 'localhost';
$db   = 'echofolk';
$user = 'root';
$pass = ''; // Change if you have a password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<?php
// Inside your config.php file... add this function at the end.

function log_activity($pdo, $action, $description) {
    // Check if an admin is logged in to get their details
    $admin_id = $_SESSION['user']['id'] ?? null;
    $admin_name = $_SESSION['user']['name'] ?? null;

    try {
        $stmt = $pdo->prepare(
            "INSERT INTO activity_log (admin_id, admin_name, action, description) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$admin_id, $admin_name, $action, $description]);
    } catch (PDOException $e) {
        // In a real application, you might handle this error more gracefully
        error_log("Failed to log activity: " . $e->getMessage());
    }
}