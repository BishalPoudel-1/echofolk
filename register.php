<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    header('Content-Type: application/json');

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $country = trim($_POST["country"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];
    $errors = [];

    if (empty($name)) $errors[] = "Full name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if (empty($country)) $errors[] = "Please select your country.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if ($password !== $confirm) $errors[] = "Passwords do not match.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Email is already registered.";
        }
    }

    if (!empty($errors)) {
        echo json_encode([
            'status' => 'error',
            'message' => implode("<br>", array_map('htmlspecialchars', $errors))
        ]);
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, country, password, role, created_at) VALUES (?, ?, ?, ?, 'user', NOW())");

    if ($stmt->execute([$name, $email, $country, $hashed_password])) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'text' => 'Account created successfully! Please log in.'
        ];
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Registration failed. Please try again.'
        ]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | EchoFolk</title>
  <link rel="stylesheet" href="register.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="register-container">
    <div class="register-box">
      <div class="logo-circle">
        <i class="fa-solid fa-book-open"></i>
      </div>
      <h2>Join EchoFolk</h2>
      <p class="subtitle">Start sharing your cultural stories</p>

      <form id="registerForm">
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

  <script>
  const form = document.getElementById("registerForm");
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("ajax", "1");

    fetch("register.php", {
      method: "POST",
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      const existing = document.querySelector(".popup");
      if (existing) existing.remove();

      if (data.status === "success") {
        // Redirect directly to login.php without showing popup
        window.location.href = "login.php";
      } else {
        // Show error popup
        const popup = document.createElement("div");
        popup.className = "popup error";
        popup.innerHTML = `
          <span class="popup-close" onclick="this.parentElement.style.display='none';">&times;</span>
          ${data.message}
        `;
        document.body.appendChild(popup);

        setTimeout(() => popup.style.display = 'none', 5000);
      }
    })
    .catch(() => {
      alert("Something went wrong. Please try again.");
    });
  });
</script>

</body>
</html>
