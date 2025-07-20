<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - EchoFolk</title>
  <link rel="stylesheet" href="dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script>
</head>
<body>
  <header>
      <a href="index.php" class="logo-container"><div class="logo-container">
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
      <span>Welcome, Demo User</span>
      <button class="logout">Logout</button>
    </div>
  </header>

  <main class="dashboard">
    <h1>Welcome back, <strong>Demo User!</strong></h1>
    <p class="location">From Nepal • Member since 7/19/2025</p>

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
</body>
</html>
