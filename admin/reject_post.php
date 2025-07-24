<?php
session_start();
require_once '../config.php'; // Also loads log_activity() function

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['story_id'])) {
    $id = $_POST['story_id'];

    // Get post title BEFORE deleting for the log
    $stmt_story = $pdo->prepare("SELECT title FROM stories WHERE id = ?");
    $stmt_story->execute([$id]);
    $storyTitle = $stmt_story->fetchColumn() ?: 'Untitled Post'; // Fallback title

    $stmt = $pdo->prepare("DELETE FROM stories WHERE id = ?");
    if ($stmt->execute([$id])) {
        // Log this activity
        log_activity($pdo, 'post_rejected', "Admin rejected post \"{$storyTitle}\" (ID: {$id}).");
        $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Post rejected successfully.'];
    } else {
        $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Failed to reject post.'];
    }
}

header("Location: index.php");
exit;