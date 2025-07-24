<?php
// /admin/update_user.php

session_start();
require_once '../config.php';

header('Content-Type: application/json');

// 1. Security Check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

// 2. Validate incoming data
if (!isset($_POST['id'], $_POST['name'], $_POST['email'], $_POST['role']) || 
    !is_numeric($_POST['id']) || 
    empty(trim($_POST['name'])) || 
    !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid data provided. Please check all fields.']);
    exit;
}

$userIdToUpdate = (int)$_POST['id'];
$name = trim($_POST['name']);
$email = $_POST['email'];
$role = strtolower($_POST['role']);
$adminUserId = (int)$_SESSION['user']['id'];

// 3. Role validation
if (!in_array($role, ['user', 'admin'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid role specified.']);
    exit;
}

// 4. Prevent last admin from demoting themselves
if ($userIdToUpdate === $adminUserId && $role !== 'admin') {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = 'admin'");
    $stmt->execute();
    $adminCount = $stmt->fetchColumn();
    if ($adminCount <= 1) {
        echo json_encode(['success' => false, 'message' => 'Cannot demote the last remaining admin.']);
        exit;
    }
}

// 5. Update the database
try {
    $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, role = :role WHERE id = :id");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'role' => $role,
        'id' => $userIdToUpdate
    ]);

    // Update session if current admin modified themselves
    if ($userIdToUpdate === $adminUserId) {
        $_SESSION['user']['name'] = $name;
    }




    echo json_encode(['success' => true, 'message' => 'User updated successfully.']);

} catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        echo json_encode(['success' => false, 'message' => 'This email is already in use.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error.']);
    }
}
