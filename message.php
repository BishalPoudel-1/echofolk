<?php
session_start();
require_once 'config.php';

// Fallback session (for demo purposes)
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// AJAX: Send Message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'send') {
    header('Content-Type: application/json');
    $userName = $_SESSION['user']['name'];
    $message = trim($_POST['message'] ?? '');
    $imagePath = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('img_', true) . '.' . $ext;
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $target = $uploadDir . $filename;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $imagePath = $target;
    }

    $stmt = $pdo->prepare("INSERT INTO chat_messages (user_name, message, image_path) VALUES (?, ?, ?)");
    $stmt->execute([$userName, $message ?: null, $imagePath]);
    echo json_encode(['status' => 'success']);
    exit;
}

// AJAX: Fetch Messages
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'fetch') {
    header('Content-Type: application/json');
    $stmt = $pdo->query("SELECT user_name, message, image_path, created_at FROM chat_messages ORDER BY id ASC");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Global Group Chat</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="message.css" />
</head>
<body>

<header>
  <a href="index.php" class="logo-container">
    <div class="logo-container">
      <div class="logo-icon"><i class="fa-solid fa-book-open"></i></div>
      <span class="logo-text">EchoFolk</span>
    </div>
  </a>
  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="explore.php">Explore</a>
    <a href="post.php">Share Story</a>
    <a href="message.php">Community</a>
  </nav>
  <div class="user-info">
   
    <button class="logout"><i class="fa-solid fa-user"></i> <?= htmlspecialchars($_SESSION['user']['name']) ?></button>
    <form method="POST" action="logout.php" style="display: inline;">
      <button type="submit" class="logout">Logout</button>
    </form>
  </div>
</header>


  <div class="flex h-[calc(100vh-69px)] max-w-7xl mx-auto page-animate">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-1/3 max-w-xs bg-white border-r border-slate-200 flex flex-col p-6">
      <div class="flex items-center gap-3 mb-8">
        <div class="w-12 h-12 bg-theme-orange rounded-lg flex items-center justify-center">
          <i class="fas fa-users text-white text-2xl"></i>
        </div>
        <div>
          <h2 class="text-xl font-bold text-slate-800">Cultural Enthusiasts</h2>
          <p class="text-sm text-slate-500">Connect with fellow</p>
        </div>
      </div>
      <div class="mb-8">
        <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-3">Details</h3>
        <div class="space-y-3 text-sm text-slate-600">
          <div class="flex items-center gap-3"><i class="fas fa-globe w-4 text-center text-slate-400"></i><span>Public Group</span></div>
          <div class="flex items-center gap-3"><i class="fas fa-hashtag w-4 text-center text-slate-400"></i><span>#Cultural-Discussion</span></div>
          <div class="flex items-center gap-3"><i class="far fa-calendar w-4 text-center text-slate-400"></i><span>Created July 20, 2025</span></div>
        </div>
      </div>
      <div>
        <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-3">Shared Photos</h3>
        <div id="shared-photos-container" class="grid grid-cols-3 gap-2"></div>
        <p id="shared-photos-hint" class="text-xs text-slate-400 mt-2 text-center">No photos shared yet.</p>
      </div>
      <div class="mt-auto text-center text-xs text-slate-400">
        <p>Your ID: <span id="sidebar-user-id">DemoUser123</span></p>
      </div>
    </aside>

    <!-- Chat Area -->
    <div class="flex-1 flex flex-col bg-slate-50">
      <main id="messages-container" class="flex-1 p-6 overflow-y-auto space-y-6"></main>
      <footer class="p-4 bg-white border-t border-slate-200">
        <form id="message-form" class="flex items-center gap-3" enctype="multipart/form-data">
          <button type="button" id="image-upload-button" class="w-12 h-12 flex-shrink-0 bg-slate-100 text-slate-500 rounded-full flex items-center justify-center transition hover:bg-slate-200">
            <i class="fas fa-paperclip text-lg"></i>
          </button>
          <input type="file" id="image-upload-input" class="hidden" accept="image/*" name="image">
          <input type="text" id="message-input" name="message" placeholder="Type your message..." autocomplete="off" class="flex-1 w-full px-4 py-3 bg-slate-100 border border-slate-300 rounded-full focus:outline-none focus:ring-2 focus-ring-theme-orange transition">
          <button type="submit" class="w-12 h-12 bg-theme-orange text-white rounded-full flex items-center justify-center transition hover-bg-theme-orange transform hover:scale-105">
            <i class="fas fa-paper-plane text-lg"></i>
          </button>
        </form>
      </footer>
    </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const imageInput = document.getElementById('image-upload-input');
    const messages = document.getElementById('messages-container');
    const photos = document.getElementById('shared-photos-container');
    const photoHint = document.getElementById('shared-photos-hint');
    const username = <?= json_encode($_SESSION['user']['name']) ?>;

    function fetchMessages() {
        fetch('message.php?action=fetch')
            .then(res => res.json())
            .then(data => {
                messages.innerHTML = '';
                photos.innerHTML = '';
                let hasPhotos = false;

                data.forEach(msg => {
                    const isSelf = msg.user_name === username;
                    const align = isSelf ? 'justify-end items-end' : 'justify-start items-start';
                    const bubble = document.createElement('div');
                    bubble.className = `flex gap-2 ${align} message-animate`;

                    let html = `<div class="flex flex-col items-${isSelf ? 'end' : 'start'}">`;

                    if (msg.message) {
                        html += `<div class="px-4 py-3 rounded-2xl max-w-sm ${isSelf ? 'bg-theme-orange text-white rounded-br-none' : 'bg-white text-slate-800 rounded-bl-none'}">
                            <p class="break-words">${msg.message}</p>
                        </div>`;
                    }

                    if (msg.image_path) {
                        html += `<div class="p-2 rounded-2xl max-w-sm ${isSelf ? 'bg-theme-orange text-white rounded-br-none' : 'bg-white text-slate-800 rounded-bl-none'}">
                            <img src="${msg.image_path}" class="rounded-lg max-w-full h-auto" style="max-height: 200px;" />
                        </div>`;
                        const thumb = document.createElement('div');
                        thumb.className = 'aspect-square bg-cover bg-center rounded-md photo-animate';
                        thumb.style.backgroundImage = `url(${msg.image_path})`;
                        photos.appendChild(thumb);
                        hasPhotos = true;
                    }

                    html += `<div class="text-xs text-slate-400 mt-1.5 px-1"><span class="font-medium">${isSelf ? 'You' : msg.user_name}</span> &bull; ${new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</div></div>`;
                    bubble.innerHTML = html;
                    messages.appendChild(bubble);
                });

                photoHint.style.display = hasPhotos ? 'none' : 'block';
                messages.scrollTop = messages.scrollHeight;
            });
    }

    form.addEventListener('submit', e => {
        e.preventDefault();
        const text = messageInput.value.trim();
        const file = imageInput.files[0];
        if (!text && !file) return;

        const formData = new FormData(form);
        fetch('message.php?action=send', {
            method: 'POST',
            body: formData
        }).then(res => res.json())
          .then(() => {
              form.reset();
              fetchMessages();
          });
    });

    document.getElementById('image-upload-button').addEventListener('click', () => {
        imageInput.click();
    });

    fetchMessages();
    setInterval(fetchMessages, 5000);
});
</script>
</body>
</html>
