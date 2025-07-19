<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | EchoFolk</title>
  <link rel="stylesheet" href="login.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="login-container">
    <div class="login-box">
      <div class="logo-circle">
        <i class="fa-solid fa-book-open"></i>
      </div>
      <h2>Welcome Back to EchoFolk</h2>
      <p class="subtitle">Sign in to share and discover cultures</p>
      <form method="POST" action="dashboard.php">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="your@email.com" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="●●●●●●●" required>

        <button type="submit">Sign In</button>
      </form>
      <p class="signup-text">Don't have an account? <a href="register.php">Join EchoFolk</a></p>
    </div>
  </div>
</body>
</html>
