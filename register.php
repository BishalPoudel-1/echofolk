<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | EchoFolk</title>
  <link rel="stylesheet" href="register.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="register-container">
    <div class="register-box">
      <div class="logo-circle">
        <i class="fa-solid fa-book-open"></i>
      </div>
      <h2>Join EchoFolk</h2>
      <p class="subtitle">Start sharing your cultural stories</p>
      <form method="POST" action="dashboard.php">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" placeholder="Your full name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="your@email.com" required>

        <label for="country">Country</label>
        <select id="country" name="country" required>
          <option value="">Select your country</option>
          <option>India</option>
          <option>Japan</option>
          <option>Mexico</option>
          <option>USA</option>
          <option>Other</option>
        </select>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm">Confirm Password</label>
        <input type="password" id="confirm" name="confirm" required>

        <button type="submit">Create Account</button>
      </form>
      <p class="signin-text">Already have an account? <a href="login.php">Sign in</a></p>
    </div>
  </div>
</body>
</html>
