<?php
// /admin/delete_user.php

session_start();
require_once '../config.php'; // Also loads log_activity() function

header('Content-Type: application/json');

// 1. Security Check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

// 2. Validate incoming user ID
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid user ID specified.']);
    exit;
}

$userIdToDelete = (int)$_POST['id'];
$adminUserId = (int)$_SESSION['user']['id'];

// 3. Prevent self-deletion
if ($userIdToDelete === $adminUserId) {
    echo json_encode(['success' => false, 'message' => 'You cannot delete your own account.']);
    exit;
}

// 4. Delete the user and log the action
try {
    // Get user info BEFORE deleting for the log
    $stmt_user_info = $pdo->prepare("SELECT name FROM users WHERE id = ?");
    $stmt_user_info->execute([$userIdToDelete]);
    $userName = $stmt_user_info->fetchColumn();
    
    if (!$userName) {
        echo json_encode(['success' => false, 'message' => 'User not found.']);
        exit;
    }

    $pdo->beginTransaction();

    // Delete user's stories
    $stmt_stories = $pdo->prepare("DELETE FROM stories WHERE user_id = :id");
    $stmt_stories->execute(['id' => $userIdToDelete]);

    // Delete the user
    $stmt_user = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt_user->execute(['id' => $userIdToDelete]);
    
    $pdo->commit();

    if ($stmt_user->rowCount() > 0) {
        // Log this activity
        log_activity($pdo, 'user_deleted', "Admin deleted user '{$userName}' (ID: {$userIdToDelete}).");
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User could not be deleted.']);
    }

} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Deletion Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'A database error occurred during deletion.']);
}