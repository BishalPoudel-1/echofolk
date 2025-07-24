<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authorized.']);
    exit;
}

$user_id = $_SESSION['user']['id'];
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');

if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid name or email.']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$name, $email, $user_id]);

    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;

    echo json_encode(['success' => true, 'newName' => $name, 'newEmail' => $email]);

} catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        echo json_encode(['success' => false, 'message' => 'This email is already in use.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error.']);
    }
}