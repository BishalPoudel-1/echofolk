<?php
session_start();
require_once 'config.php'; // Make sure this connects with your DB via PDO

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$userName = $_SESSION['user']['name'];
?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Explore Cultural Stories | EchoFolk</title>
  <link rel="stylesheet" href="explore.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
   
      <a href="profile.php" class="logout" style="text-decoration: none;">
            <i class="fa-solid fa-user"></i> <?= htmlspecialchars($userName) ?>
        </a>
    <form method="POST" action="logout.php" style="display: inline;">
      <button type="submit" class="logout">Logout</button>
    </form>
  </div>
</header>

<section class="explore-hero">
  <h1>Explore Cultural Stories</h1>
  <p>Discover fascinating traditions and festivals from around the world</p>

  <div class="search-bar">
    <input type="text" placeholder="Search stories, festivals, traditions...">
    <select>
      <option>All Countries</option>
      <option>India</option>
      <option>Japan</option>
      <option>Mexico</option>
    </select>
    <button class="filter-btn"><i class="fa-solid fa-filter"></i> More Filters</button>
  </div>
</section>

<section class="story-grid">
<?php
$stmt = $pdo->prepare("SELECT s.*, u.name AS author_name FROM stories s JOIN users u ON s.user_id = u.id ORDER BY s.event_date DESC");
$stmt->execute();
$stories = $stmt->fetchAll();

if ($stories):
  foreach ($stories as $story):
    $image = $story['image_path'] ?? 'https://via.placeholder.com/320x160?text=Image';
    $tags = array_filter(array_map('trim', explode(',', $story['tags'])));
    $isVerified = $story['verified'] == 1;
?>
  <div class="story-card">
    <div class="image-placeholder" style="background-image: url('<?= htmlspecialchars($image) ?>');"></div>
    <div class="story-content">
      <div class="meta">
        <span><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($story['country']) ?></span>
        <span><i class="fa-solid fa-calendar"></i> <?= htmlspecialchars($story['event_date']) ?: 'N/A' ?></span>
      </div>

<h3>
  <?= htmlspecialchars($story['title']) ?>
  <?php if ($isVerified): ?>
    <span class="verified-badge verified">✔ Verified</span>
  <?php else: ?>
    <span class="verified-badge not-verified">✖ Not Verified</span>
  <?php endif; ?>
</h3>


      <p><?= htmlspecialchars(substr($story['body'], 0, 100)) ?>...</p>
      <div class="tags">
        <?php foreach ($tags as $tag): ?>
          <span><?= htmlspecialchars($tag) ?></span>
        <?php endforeach; ?>
      </div>
      <div class="footer">
        <span>by <?= htmlspecialchars($story['author_name']) ?></span>
       <?php
$liked = isset($_SESSION['liked_stories']) && in_array($story['id'], $_SESSION['liked_stories']);
?>
<span class="like-btn <?= $liked ? 'liked' : '' ?>" data-id="<?= $story['id'] ?>">
  <i class="<?= $liked ? 'fa-solid' : 'fa-regular' ?> fa-heart"></i>
  <span class="like-count"><?= $story['likes'] ?></span>
</span>


      </div>
    </div>
  </div>
<?php
  endforeach;
else:
  echo "<p>No stories submitted yet.</p>";
endif;
?>
</section>



<script>
document.querySelectorAll('.like-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const storyId = btn.getAttribute('data-id');

    fetch('like_story.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'story_id=' + encodeURIComponent(storyId)
    })
    .then(res => res.json())
    .then(data => {
      if (data.likes !== undefined) {
        btn.querySelector('.like-count').textContent = data.likes;

        const icon = btn.querySelector('i');
        btn.classList.toggle('liked');

        if (data.status === 'liked') {
          icon.classList.remove('fa-regular');
          icon.classList.add('fa-solid');
        } else {
          icon.classList.remove('fa-solid');
          icon.classList.add('fa-regular');
        }
      } else {
        alert(data.error || 'Failed to update like');
      }
    })
    .catch(() => alert('Request failed'));
  });
});
</script>



</body>
</html>
