<?php
session_start();
require_once 'config.php';

// Handle session flash message (e.g., from registration)
$flash = $_SESSION['flash_message'] ?? null;
unset($_SESSION['flash_message']);

// Handle AJAX login request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    header('Content-Type: application/json');

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id, name, country, created_at, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id'         => $user['id'],
            'name'       => $user['name'],
            'country'    => $user['country'],
            'email'      => $email,
            'role'       => $user['role'],
            'created_at' => $user['created_at']
        ];

        $redirectUrl = ($user['role'] === 'admin') ? 'admin/index.php' : 'dashboard.php';
 $_SESSION['flash_message'] = [
            'type' => 'success',
            'text' => 'Login successfully.'
        ];
        echo json_encode(['status' => 'success', 'redirect' => $redirectUrl]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect email or password.']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | EchoFolk</title>
  <link rel="stylesheet" href="login.css">
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

<?php if ($flash): ?>
  <div class="popup <?= htmlspecialchars($flash['type']) ?>">
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

<div class="login-container">
  <div class="login-box">
    <div class="logo-circle">
      <i class="fa-solid fa-book-open"></i>
    </div>
    <h2>Welcome Back to EchoFolk</h2>
    <p class="subtitle">Sign in to share and discover cultures</p>

    <form id="loginForm">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="your@email.com" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="●●●●●●●" required>

      <button type="submit">Sign In</button>
    </form>

    <p class="signup-text">Don't have an account? <a href="register.php">Join EchoFolk</a></p>
  </div>
</div>

<script>
document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const formData = new FormData(this);
  formData.append("ajax", "1");

  fetch("login.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === "success") {
      window.location.href = data.redirect;
    } else {
      const existing = document.querySelector(".popup");
      if (existing) existing.remove();

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
