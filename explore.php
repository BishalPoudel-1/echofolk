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
    <div class="logo-icon"><i class="fa-solid fa-book-open"></i></div>
    <span class="logo-text">EchoFolk</span>
  </a>
 <nav>
      <a href="dashboard.php">Dashboard</a>
      <a href="explore.php">Explore</a>
      <a href="post.php">Share Story</a>
           <a href="message.php">Community</a>
     
    </nav>
  <div class="buttons">
      <a href="login.php"><button class="login">Login</button></a>
      <a href="register.php"><button class="join">Join Now</button></a>
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
  <div class="story-card">
    <div class="image-placeholder"></div>
    <div class="story-content">
      <div class="meta">
        <span><i class="fa-solid fa-location-dot"></i> India</span>
        <span><i class="fa-solid fa-calendar"></i> 1/15/2024</span>
      </div>
      <h3>Diwali: Festival of Lights in India</h3>
      <p>Experience the joy and warmth of Diwali, one of India's most celebrated festivals. From lighting diyas to shari...</p>
      <div class="tags">
        <span>festival</span><span>lights</span><span>tradition</span>
      </div>
      <div class="footer">
        <span>by Priya Sharma</span>
        <span><i class="fa-regular fa-heart"></i> 45</span>
      </div>
    </div>
  </div>

  <div class="story-card">
    <div class="image-placeholder"></div>
    <div class="story-content">
      <div class="meta">
        <span><i class="fa-solid fa-location-dot"></i> Japan</span>
        <span><i class="fa-solid fa-calendar"></i> 1/10/2024</span>
      </div>
      <h3>Cherry Blossom Season in Japan</h3>
      <p>The magical time of Sakura blooming across Japan. Join families and friends as they gather under the pink petals...</p>
      <div class="tags">
        <span>nature</span><span>tradition</span><span>spring</span>
      </div>
      <div class="footer">
        <span>by Yuki Tanaka</span>
        <span><i class="fa-regular fa-heart"></i> 62</span>
      </div>
    </div>
  </div>

  <div class="story-card">
    <div class="image-placeholder"></div>
    <div class="story-content">
      <div class="meta">
        <span><i class="fa-solid fa-location-dot"></i> Mexico</span>
        <span><i class="fa-solid fa-calendar"></i> 1/8/2024</span>
      </div>
      <h3>Day of the Dead Celebrations in Mexico</h3>
      <p>Día de los Muertos is a beautiful tradition where we honor and remember our departed loved ones...</p>
      <div class="tags">
        <span>festival</span><span>family</span><span>remembrance</span>
      </div>
      <div class="footer">
        <span>by Carlos Rodriguez</span>
        <span><i class="fa-regular fa-heart"></i> 38</span>
      </div>
    </div>
  </div>
</section>

</body>
</html>
