<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

// Optional role check
if ($user['role'] !== 'user') {
    header("Location: admin/index.php");
    exit;
}

// Flash message (optional)
$flash = $_SESSION['flash_message'] ?? null;
unset($_SESSION['flash_message']);

$userName = $user['name'];
$userCountry = $user['country'];
$formattedDate = date("n/j/Y", strtotime($user['created_at']));
?>

<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
// Optional role-based restrictions
if ($user['role'] !== 'user') {
    header("Location: dashboard.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - EchoFolk</title>
  <link rel="stylesheet" href="dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<?php if ($flash): ?>
  <div class="popup <?= $flash['type'] ?>">
    <span class="popup-close" onclick="this.parentElement.style.display='none';">&times;</span>
    <?= htmlspecialchars($flash['text']) ?>
  </div>
  <script>
    setTimeout(() => {
      const popup = document.querySelector('.popup');
      if (popup) popup.style.display = 'none';
    }, 5000);
  </script>
<?php endif; ?>

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
   
    <button class="logout"><i class="fa-solid fa-user"></i> <?= htmlspecialchars($userName) ?></button>
    <form method="POST" action="logout.php" style="display: inline;">
      <button type="submit" class="logout">Logout</button>
    </form>
  </div>
</header>

<main class="dashboard">
  <h1>Welcome back, <strong><?= htmlspecialchars($userName) ?>!</strong></h1>
  <p class="location">From <?= htmlspecialchars($userCountry) ?> • Member since <?= $formattedDate ?></p>

  <section class="cards">
    <div class="card">
      <i class="fa-solid fa-plus"></i>
      <h3>Share Your Culture</h3>
      <p>Tell the world about your traditions and festivals</p>
      <a href="post.php"><button class="orange">Create Story</button> </a>
    </div>
    <div class="card">
      <i class="fa-solid fa-globe"></i>
      <h3>Explore Cultures</h3>
      <p>Discover amazing stories from around the world</p>
      <a href="explore.php"><button class="red">Start Exploring </button></a>
    </div>
    <div class="card">
      <i class="fa-solid fa-users"></i>
      <h3>Community</h3>
      <p>Connect with fellow cultural enthusiasts</p>
       <a href="message.php"> <button class="brown">View Community</button> </a>
    </div>
  </section>

  <section class="mystories">
    <h2><i class="fa-solid fa-book-open-reader"></i> My Cultural Stories</h2>
    <div class="empty">
      <i class="fa-regular fa-book-open"></i>
      <p class="empty-msg">No stories yet</p>
      <p class="hint">Start sharing your cultural experiences with the world!</p>
      <a href="post.php"><button class="red">Share Your First Story</button> </a>
    </div>
  </section>
</main>

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
.popup-close {
  float: right;
  cursor: pointer;
  color: #aaa;
  font-weight: bold;
}
.popup-close:hover { color: #000; }
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>

</body>
</html>
