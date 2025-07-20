<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$userName = htmlspecialchars($_SESSION['user']['name']);
$userId = $_SESSION['user']['id'];
$popupMessage = '';
$popupClass = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title     = trim($_POST['title']);
    $body      = trim($_POST['body']);
    $country   = trim($_POST['country']);
    $eventDate = !empty($_POST['event_date']) ? $_POST['event_date'] : null;
    $tags      = trim($_POST['tags']);

    $imagePath = null;

    // Image upload with validation
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        $fileSize = $_FILES['image']['size'];

        if (!in_array($fileType, $allowedTypes)) {
            $popupMessage = "Only JPG and PNG files are allowed.";
            $popupClass = "error";
        } elseif ($fileSize > $maxSize) {
            $popupMessage = "Image exceeds 5MB limit.";
            $popupClass = "error";
        } else {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $filename = time() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = $targetPath;
            } else {
                $popupMessage = "Failed to move uploaded file.";
                $popupClass = "error";
            }
        }
    }

    // Only insert if no upload errors
    if (!$popupMessage) {
        $stmt = $pdo->prepare("
            INSERT INTO stories (user_id, title, body, country, event_date, image_path, tags)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $success = $stmt->execute([
            $userId, $title, $body, $country, $eventDate, $imagePath, $tags
        ]);

        if ($success) {
            $popupMessage = 'Your story has been published!';
            $popupClass = 'success';
        } else {
            $popupMessage = 'Something went wrong while submitting your story.';
            $popupClass = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Share Your Cultural Story | EchoFolk</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
  <link rel="stylesheet" href="post.css">
  <style>
    .popup {
      position: fixed;
      top: 20px;
      right: 20px;
      background-color: #fff;
      border-left: 5px solid;
      padding: 15px 20px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      z-index: 1000;
      animation: fadeInUp 0.5s ease;
      min-width: 250px;
      font-family: 'Inter', sans-serif;
    }
    .popup.success { border-color: #4caf50; }
    .popup.error   { border-color: #f44336; }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <?php if ($popupMessage): ?>
    <div class="popup <?= $popupClass ?>">
      <?= htmlspecialchars($popupMessage) ?>
    </div>
    <script>
      setTimeout(() => {
        document.querySelector('.popup').style.display = 'none';
      }, 5000);
    </script>
  <?php endif; ?>

  <header>
    <a href="index.php" class="logo-container">
      <div class="logo-icon"><i class="fa-solid fa-book-open"></i></div>
      <span class="logo-text">EchoFolk</span>
    </a>
    <nav>
      <a href="dashboard.php">Dashboard</a>
      <a href="explore.php">Explore</a>
      <a href="post.php">Share Story</a>
      <a href="message.php">Community</a>
    </nav>
    <div class="user-info">
     <button class="logout"><i class="fa-solid fa-user"></i> <?= $userName ?></button>
      <form method="POST" action="logout.php" style="display:inline;">
        <button class="logout">Logout</button>
      </form>
    </div>
  </header>

  <h1 class="fade-in-up">Share Your Cultural Story</h1>
  <p class="subtitle fade-in-up">Tell the world about your traditions, festivals, and cultural experiences</p>

  <div class="form-container fade-in-up">
    <h2><i class="fa-regular fa-bookmark"></i> Create New Story</h2>
    <form method="post" enctype="multipart/form-data">
      <label>Story Title *</label>
      <input type="text" name="title" required placeholder="e.g., Diwali Celebrations in My Village">

      <label>Tell Your Story *</label>
      <textarea name="body" required placeholder="What makes it special? How is it celebrated? What does it mean to you?"></textarea>

      <div style="display: flex; gap: 20px;">
        <div style="flex: 1;">
          <label>Country *</label>
          <select name="country" required>
            <option value="">Select country</option>
            <option>Nepal</option>
            <option>India</option>
            <option>Japan</option>
            <option>Mexico</option>
          </select>
        </div>
        <div style="flex: 1;">
          <label>Event Date (Optional)</label>
          <input type="date" name="event_date">
        </div>
      </div>

      <label>Upload Image (Optional)</label>
    <div class="upload-box">
  <input type="file" name="image" accept=".jpg,.jpeg,.png" style="display:none;" id="upload-input">
  <label for="upload-input">📤 Click to upload an image<br><small>PNG, JPG up to 5MB</small></label>
  <div id="image-preview" style="margin-top: 10px;">
    <img id="preview-img" src="" alt="Image preview" style="max-width: 100%; display: none; border: 1px solid #ccc; padding: 5px;">
  </div>
</div>


      <label>Tags</label>
      <input type="text" id="tag-input" name="tags" placeholder="Add a tag...">
      <div class="tags">
        <div class="tag" data-value="Festival">+ Festival</div>
        <div class="tag" data-value="Tradition">+ Tradition</div>
        <div class="tag" data-value="Food">+ Food</div>
        <div class="tag" data-value="Music">+ Music</div>
        <div class="tag" data-value="Dance">+ Dance</div>
      </div>

      <div class="buttons">
        <button type="submit" class="publish">Publish Story</button>
        <button type="reset" class="cancel">Cancel</button>
      </div>
    </form>
  </div>

  <script>
    const tagInput = document.getElementById('tag-input');
    const tags = document.querySelectorAll('.tag');

    tags.forEach(tag => {
      tag.addEventListener('click', () => {
        const value = tag.getAttribute('data-value');
        let currentTags = tagInput.value.split(',').map(t => t.trim()).filter(t => t);

        if (currentTags.includes(value)) {
          currentTags = currentTags.filter(t => t !== value);
          tag.classList.remove('active');
        } else {
          currentTags.push(value);
          tag.classList.add('active');
          tag.style.transform = 'scale(1.15)';
          setTimeout(() => tag.style.transform = 'scale(1.05)', 150);
        }

        tagInput.value = currentTags.join(', ');
      });
    });
  </script>

<script>
  const uploadInput = document.getElementById('upload-input');
  const previewImg = document.getElementById('preview-img');

  uploadInput.addEventListener('change', function () {
    const file = this.files[0];

    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        previewImg.src = e.target.result;
        previewImg.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      previewImg.src = '';
      previewImg.style.display = 'none';
    }
  });
</script>


</body>
</html>
