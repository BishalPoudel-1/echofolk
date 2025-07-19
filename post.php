<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Share Your Cultural Story | EchoFolk</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(to bottom right, #fff3ed, #ffe9df);
      color: #333;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      padding: 20px 40px;
      background: #fff;
      border-bottom: 1px solid #eee;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
      position: sticky;
      top: 0;
      z-index: 999;
    }

    .logo-container {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }

    .logo-icon {
      width: 36px;
      height: 36px;
      background: linear-gradient(to bottom right, #f97316, #ef4444);
      border-radius: 8px;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: transform 0.3s ease;
    }

    .logo-icon:hover {
      transform: rotate(10deg) scale(1.1);
    }

    .logo-icon i {
      color: white;
    }

    .logo-text {
      font-size: 1.5rem;
      font-weight: 700;
      background: linear-gradient(to right, #ea580c, #dc2626);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    nav {
      display: flex;
      align-items: center;
      gap: 25px;
      flex-wrap: wrap;
    }

    nav a {
      text-decoration: none;
      font-weight: 500;
      color: #333;
      position: relative;
      transition: color 0.3s ease;
    }

    nav a::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: -6px;
      height: 2px;
      width: 0%;
      background: #ff5722;
      transition: width 0.3s ease;
    }

    nav a:hover {
      color: #ff5722;
    }

    nav a:hover::after {
      width: 100%;
    }

    .logout {
      background: #fff;
      border: 1px solid #ff5722;
      padding: 6px 12px;
      border-radius: 6px;
      color: #ff5722;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .logout:hover {
      background: #ff5722;
      color: white;
    }

    /* --- Animation Definition & Flicker Fix --- */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in-up {
      /* Set initial state for animation */
      opacity: 0; 
      
      /* Apply the animation */
      animation: fadeUp 0.6s ease-out forwards;
      
      /* These two properties are the key to fixing the flicker */
      backface-visibility: hidden;
      will-change: transform, opacity;
    }

    /* Stagger the animation delays for a nice effect */
    h1.fade-in-up { animation-delay: 0.1s; }
    p.subtitle.fade-in-up { animation-delay: 0.2s; }
    .form-container.fade-in-up { animation-delay: 0.3s; }
    /* --- End of Animation Fix --- */


    h1 {
      text-align: center;
      margin: 40px 0 10px;
      font-size: 2rem;
    }

    p.subtitle {
      text-align: center;
      color: #666;
      margin-bottom: 30px;
    }

    .form-container {
      max-width: 700px;
      background: white;
      margin: 0 auto 60px;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }

    .form-container h2 {
      font-size: 1.2rem;
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: 600;
      margin: 20px 0 8px;
    }

    input[type="text"],
    input[type="date"],
    select,
    textarea {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 0.95rem;
      font-family: 'Inter', sans-serif;
    }

    textarea {
      resize: vertical;
      height: 100px;
    }

    .upload-box {
      border: 2px dashed #ccc;
      padding: 20px;
      text-align: center;
      color: #777;
      border-radius: 10px;
      cursor: pointer;
      transition: border-color 0.3s;
    }

    .upload-box:hover {
      border-color: #ff5722;
      background: #fff9f5;
    }

    .tags {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 10px;
    }

    .tag {
      background: #f1f1f1;
      border-radius: 20px;
      padding: 6px 14px;
      font-size: 0.85rem;
      color: #555;
      cursor: pointer;
      transition: all 0.3s ease;
      border: 1px solid transparent;
    }

    .tag:hover {
      background: #ffece5;
      color: #ff5722;
      transform: scale(1.05);
      border-color: #ff5722;
      box-shadow: 0 4px 10px rgba(255, 87, 34, 0.1);
    }

    .tag.active {
      background: linear-gradient(to right, #f97316, #ef4444);
      color: white;
      border-color: transparent;
      transform: scale(1.1);
    }

    .buttons {
      margin-top: 30px;
      display: flex;
      gap: 10px;
      justify-content: flex-end;
    }

    .buttons button {
      padding: 10px 18px;
      font-weight: 600;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .publish {
      background: linear-gradient(to right, #f97316, #ef4444);
      color: white;
    }

    .publish:hover {
      transform: scale(1.05);
      box-shadow: 0 8px 18px rgba(255, 87, 34, 0.2);
    }

    .cancel {
      background: #eee;
      color: #333;
    }

    .cancel:hover {
      background: #ddd;
    }

    @media (max-width: 768px) {
      header {
        flex-direction: column;
        align-items: flex-start;
      }

      nav {
        margin: 10px 0;
      }

      .buttons {
        flex-direction: column;
        align-items: stretch;
      }
    }
  </style>
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
    </nav>
    <div class="user-info">
      Welcome, Demo User <button class="logout">Logout</button>
    </div>
  </header>
  
  <!-- Applying the animation class to the elements -->
  <h1 class="fade-in-up">Share Your Cultural Story</h1>
  <p class="subtitle fade-in-up">Tell the world about your traditions, festivals, and cultural experiences</p>

  <div class="form-container fade-in-up">
    <h2><i class="fa-regular fa-bookmark"></i> Create New Story</h2>
    <form method="post" action="submit_story.php" enctype="multipart/form-data">
      <label>Story Title *</label>
      <input type="text" name="title" placeholder="e.g., Diwali Celebrations in My Village" required>

      <label>Tell Your Story *</label>
      <textarea name="body" placeholder="What makes it special? How is it celebrated? What does it mean to you?" required></textarea>

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
      </div>

      <label>Tags</label>
      <input type="text" id="tag-input" name="tags" placeholder="Add a tag...">
      <div class="tags">
        <div class="tag" data-value="festival">+ festival</div>
        <div class="tag" data-value="tradition">+ tradition</div>
        <div class="tag" data-value="food">+ food</div>
        <div class="tag" data-value="music">+ music</div>
        <div class="tag" data-value="dance">+ dance</div>
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
          setTimeout(() => {
            tag.style.transform = 'scale(1.05)';
          }, 150);
        }

        tagInput.value = currentTags.join(', ');
      });
    });
  </script>

</body>
</html>
