<?php
// Start the session to check for login status
session_start();

// Check if a user is logged in and store their data
$loggedInUser = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EchoFolk</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

 <style>
      /* Add styles for the logged-in user info to match your other pages */
      .user-info { display: flex; align-items: center; gap: 15px; }
      .logout { background: #fff; border: 1px solid #ff5722; padding: 6px 12px; border-radius: 6px; color: #ff5722; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.3s ease; }
      .logout:hover { background: #ff5722; color: white;  transform: scale(1.05); }
   </style>


</head>
<body>
  <header>

    <a href="index.php" class="logo-container">
      <div class="logo-icon">
        <i class="fa-solid fa-book-open"></i>
      </div>
      <span class="logo-text">EchoFolk</span>
    </a>

    <nav>
      <a href="dashboard.php">Dashboard</a>
      <a href="explore.php">Explore</a>
      <a href="post.php">Share Story</a>
       <a href="message.php">Community</a>
    </nav>
    
    <div class="user-info">
        <?php if ($loggedInUser): ?>
            <a href="profile.php" class="logout" style="text-decoration: none;">
                <i class="fa-solid fa-user"></i> <?= htmlspecialchars($loggedInUser['name']) ?>
            </a>
            <form method="POST" action="logout.php" style="display: inline;">
                <button type="submit" class="logout">Logout</button>
            </form>
        <?php else: ?>
            <a href="login.php" class="logout">Login</a>
            <a href="register.php" class="join" style="background-color: #f97316; color: white; padding: 7px 13px; border-radius: 6px; text-decoration: none; font-weight: 600;">Join Now</a>
        <?php endif; ?>
    </div>
  </header>

  <section class="hero">
    <div class="badge">🌍 Global Cultural Exchange Platform</div>
    <h1><span>Share Your Culture,</span> <br><strong>Discover the World</strong></h1>
    <p>EchoFolk connects cultures across continents. Share your traditions, festivals, and stories while discovering the rich heritage of communities worldwide.</p>
    <div class="hero-buttons">
       <a href="post.php" > <button class="start">Start Sharing Today</button> </a>
      <a href="explore.php" >  <button class="explore">Explore Stories</button></a>
    </div>
    <div class="icons">
      <div><i class="fa-solid fa-masks-theater"></i><br>Festivals</div>
      <div><i class="fa-solid fa-bowl-food"></i><br>Cuisine</div>
      <div><i class="fa-solid fa-music"></i><br>Music & Dance</div>
      <div><i class="fa-solid fa-landmark"></i><br>Traditions</div>
    </div>
  </section>

  <section class="actions">
    <div class="card">
      <i class="fa-solid fa-book-open"></i>
      <h3>Share Your Culture</h3>
      <p>Tell the world about your traditions, festivals, and cultural experiences</p>
      <button class="orange">Post Your Story</button>
    </div>
    <div class="card">
      <i class="fa-solid fa-magnifying-glass"></i>
      <h3>Explore Stories</h3>
      <p>Discover fascinating cultural stories from around the world</p>
      <button class="red">Explore Now</button>
    </div>
    <div class="card">
      <i class="fa-solid fa-book-open-reader"></i>
      <h3>Random Culture</h3>
      <p>Let serendipity guide you to unexpected cultural discoveries</p>
      <button class="yellow">Surprise Me</button>
    </div>
  </section>

  <section class="featured">
    <h2>Featured Cultural Stories</h2>
    <p>Discover authentic stories from our global community of cultural ambassadors</p>
    <div class="story-cards">
      <div class="story">
        <div class="tag">India</div>
        <h4>Diwali Celebrations in Mumbai</h4>
        <p>Experience the vibrant Festival of Lights through the eyes of a local family...</p>
        <span>by Priya Sharma</span>
        <button class="read-more">Read More</button>
      </div>
      <div class="story">
        <div class="tag">Japan</div>
        <h4>Cherry Blossom Festival in Kyoto</h4>
        <p>Join thousands as they celebrate the ephemeral beauty of sakura season...</p>
        <span>by Takeshi Yamamoto</span>
        <button class="read-more">Read More</button>
      </div>
      <div class="story">
        <div class="tag">Mexico</div>
        <h4>Day of the Dead in Oaxaca</h4>
        <p>A profound celebration where life and death dance together in harmony...</p>
        <span>by María González</span>
        <button class="read-more">Read More</button>
      </div>
    </div>
  </section>

  <footer>
    <h3>Join Our Global Community</h3>
    <div class="stats">
      <div><strong>150+</strong><br>Countries Represented</div>
      <div><strong>2,500+</strong><br>Cultural Stories</div>
      <div><strong>10,000+</strong><br>Community Members</div>
    </div>
  </footer>
</body>
</html>
