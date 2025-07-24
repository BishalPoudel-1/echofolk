<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$storyId = $_POST['story_id'] ?? null;

if (!$storyId || !is_numeric($storyId)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid story ID']);
    exit;
}

if (!isset($_SESSION['liked_stories'])) {
    $_SESSION['liked_stories'] = [];
}

$liked = in_array($storyId, $_SESSION['liked_stories']);

if ($liked) {
    // Unlike: remove from session and decrement
    $_SESSION['liked_stories'] = array_diff($_SESSION['liked_stories'], [$storyId]);
    $pdo->prepare("UPDATE stories SET likes = likes - 1 WHERE id = ?")->execute([$storyId]);
    $action = 'unliked';
} else {
    // Like: add to session and increment
    $_SESSION['liked_stories'][] = $storyId;
    $pdo->prepare("UPDATE stories SET likes = likes + 1 WHERE id = ?")->execute([$storyId]);
    $action = 'liked';
}

// Get updated like count
$stmt = $pdo->prepare("SELECT likes FROM stories WHERE id = ?");
$stmt->execute([$storyId]);
$likes = $stmt->fetchColumn();

echo json_encode(['likes' => $likes, 'status' => $action]);
?>
