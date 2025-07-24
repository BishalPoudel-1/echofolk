<?php
session_start();
require_once 'config.php';

// --- 1. Determine which User to Display ---
$user_id = 0;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = (int)$_GET['id'];
} elseif (isset($_SESSION['user']['id'])) {
    $user_id = (int)$_SESSION['user']['id'];
}

if ($user_id === 0) {
    header("Location: login.php");
    exit;
}

// --- 2. Check user's relationship to the profile ---
$is_own_profile = (isset($_SESSION['user']['id']) && $user_id === (int)$_SESSION['user']['id']);
$is_admin_viewing = (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin');

// --- 3. Fetch User Data and Post Count ---
try {
    $stmt_user = $pdo->prepare("SELECT id, name, email, country, created_at, role FROM users WHERE id = ?");
    $stmt_user->execute([$user_id]);
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if (!$user) { die("User not found."); }

    $stmt_stories = $pdo->prepare("SELECT COUNT(*) FROM stories WHERE user_id = ? AND verified = 1");
    $stmt_stories->execute([$user_id]);
    $post_count = $stmt_stories->fetchColumn();

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

$loggedInUserName = $_SESSION['user']['name'] ?? 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Profile of <?= htmlspecialchars($user['name']) ?></title>
    <link rel="stylesheet" href="dashboard.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        .profile-card-container{max-width:600px;margin:40px auto;animation:fadeIn .7s ease-in-out}
        .profile-card{background:#fff;border:1px solid #eee;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.07);text-align:center;padding:40px 30px;position:relative}
        .profile-avatar{width:120px;height:120px;background:linear-gradient(to bottom right,#f97316,#ef4444);border-radius:50%;margin:0 auto 20px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:50px;font-weight:700;border:4px solid #fff;box-shadow:0 4px 15px rgba(0,0,0,.1)}
        .profile-name{font-size:1.8rem;font-weight:700;margin-bottom:5px}
        .profile-role{display:inline-block;padding:4px 12px;font-size:.8rem;font-weight:700;border-radius:15px;color:#fff;text-transform:capitalize;margin-bottom:20px}
        .profile-role.role-admin{background-color:#e53935}
        .profile-role.role-user{background-color:#1E88E5}
        .profile-details{color:#666;line-height:1.8;margin-bottom:30px}
        .profile-details i{margin-right:10px;width:20px;text-align:center}
        .profile-stats-container{display:flex;justify-content:center;gap:20px;border-top:1px solid #eee;padding-top:30px}
        .stat-item{flex:1;max-width:150px}
        .stat-item .stat-number{font-size:1.75rem;font-weight:700;color:#f97316}
        .stat-item .stat-label{font-size:.9rem;color:#888}
        .profile-edit-button{position:absolute;top:15px;right:15px;width:40px;height:40px;background-color:#f0f2f5;border:1px solid #ddd;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#555;cursor:pointer;transition:all .3s ease}
        .profile-edit-button:hover{background-color:#e4e6eb;color:#000;transform:scale(1.1)}
        .modal-overlay{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.6);z-index:1000;display:none;align-items:center;justify-content:center;animation:fadeIn .3s ease}
        .modal-content{background:#fff;padding:30px;border-radius:12px;width:90%;max-width:500px;box-shadow:0 5px 20px rgba(0,0,0,.2);position:relative}
        .modal-header{display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #eee;padding-bottom:15px;margin-bottom:20px}
        .modal-header h2{font-size:1.5rem;margin:0}
        .close-button{font-size:2rem;font-weight:300;cursor:pointer;background:0 0;border:none;color:#aaa;line-height:1}
        .close-button:hover{color:#333}
        .form-group{margin-bottom:15px}
        .form-group label{display:block;font-weight:600;margin-bottom:8px}
        .form-group input{width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;box-sizing:border-box}
        .modal-footer{text-align:right;margin-top:25px}
        .form-button{background:#f97316;color:#fff;border:none;padding:10px 20px;font-weight:600;border-radius:6px;cursor:pointer;transition:background .3s}
        .form-button:hover{background:#ea580c}
        .modal-message{padding:10px;margin-bottom:15px;border-radius:6px;text-align:center;display:none}
        .modal-message.success{background-color:#d4edda;color:#155724}
        .modal-message.error{background-color:#f8d7da;color:#721c24}
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
        <a href="message.php">Community</a>
    </nav>
    <div class="user-info">
        <a href="profile.php" class="logout" style="text-decoration: none;">
            <i class="fa-solid fa-user"></i> <?= htmlspecialchars($loggedInUserName) ?>
        </a>
        <form method="POST" action="logout.php" style="display: inline;">
            <button type="submit" class="logout">Logout</button>
        </form>
    </div>
</header>

<main class="profile-card-container">
    <div class="profile-card">

        <?php if ($is_own_profile): ?>
            <button id="editProfileBtn" class="profile-edit-button" title="Edit Profile">
                <i class="fa-solid fa-pencil"></i>
            </button>
        <?php endif; ?>

        <div class="profile-avatar">
            <?php
                $nameParts = explode(' ', trim($user['name']));
                $initials = (strtoupper(substr($nameParts[0], 0, 1))) . (count($nameParts) > 1 ? strtoupper(substr(end($nameParts), 0, 1)) : '');
                echo htmlspecialchars($initials);
            ?>
        </div>
        <h1 class="profile-name" id="profileNameDisplay"><?= htmlspecialchars($user['name']) ?></h1>
        <div class="profile-role role-<?= strtolower(htmlspecialchars($user['role'])) ?>"><?= htmlspecialchars($user['role']) ?></div>
        <div class="profile-details">
            <?php if ($is_own_profile || $is_admin_viewing): ?>
                <div id="profileEmailDisplay"><i class="fa-solid fa-envelope"></i><?= htmlspecialchars($user['email']) ?></div>
            <?php endif; ?>
            <div><i class="fa-solid fa-location-dot"></i>From <?= htmlspecialchars($user['country']) ?></div>
            <div><i class="fa-solid fa-calendar-alt"></i>Joined on <?= date("F j, Y", strtotime($user['created_at'])) ?></div>
        </div>
        <div class="profile-stats-container">
            <div class="stat-item"><div class="stat-number"><?= $post_count ?></div><div class="stat-label">Verified Stories Shared</div></div>
        </div>
    </div>
</main>

<div id="editProfileModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Profile</h2>
            <button id="closeModalBtn" class="close-button">&times;</button>
        </div>
        <div class="modal-body">
            <div id="modalMessage" class="modal-message"></div>
            <form id="detailsForm">
                <h3>Personal Details</h3>
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="form-button">Save Details</button>
                </div>
            </form>
            <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">
            <form id="passwordForm">
                <h3>Change Password</h3>
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password (min. 8 characters)</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="form-button">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('editProfileModal');
    const openBtn = document.getElementById('editProfileBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const detailsForm = document.getElementById('detailsForm');
    const passwordForm = document.getElementById('passwordForm');
    const modalMessage = document.getElementById('modalMessage');

    const showMessage = (message, type) => {
        modalMessage.textContent = message;
        modalMessage.className = `modal-message ${type}`;
        modalMessage.style.display = 'block';
    };

    if (openBtn) {
        openBtn.addEventListener('click', () => {
            modalMessage.style.display = 'none'; // Hide old messages when opening
            modal.style.display = 'flex';
        });
    }
    
    if(closeBtn) {
        closeBtn.addEventListener('click', () => modal.style.display = 'none');
    }
    
    if(modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    }

    if(detailsForm) {
        detailsForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(detailsForm);
            
            fetch('update_profile_details.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Details updated successfully!', 'success');
                    document.getElementById('profileNameDisplay').textContent = data.newName;
                    document.getElementById('profileEmailDisplay').innerHTML = `<i class="fa-solid fa-envelope"></i> ${data.newEmail}`;
                    setTimeout(() => { modal.style.display = 'none'; }, 2000);
                } else {
                    showMessage(data.message, 'error');
                }
            })
            .catch(() => showMessage('An error occurred. Please try again.', 'error'));
        });
    }

    if(passwordForm) {
        passwordForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(passwordForm);

            fetch('update_profile_password.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Password changed successfully!', 'success');
                    passwordForm.reset();
                } else {
                    showMessage(data.message, 'error');
                }
            })
            .catch(() => showMessage('An error occurred. Please try again.', 'error'));
        });
    }
});
</script>

</body>
</html>