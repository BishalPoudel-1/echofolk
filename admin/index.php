<?php
date_default_timezone_set('UTC');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$flash = $_SESSION['flash_message'] ?? null;
unset($_SESSION['flash_message']);

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
$user = $_SESSION['user'];
$userName = $user['name'];

require_once '../config.php';

// --- Fetch Dashboard Statistics ---
try {
    $totalPosts = $pdo->query('SELECT COUNT(*) FROM stories')->fetchColumn();
    $approvedPosts = $pdo->query('SELECT COUNT(*) FROM stories WHERE verified = 1')->fetchColumn();
    $pendingPosts = $pdo->query('SELECT COUNT(*) FROM stories WHERE verified = 0')->fetchColumn();
    $totalUsers = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();

    // --- Fetch All Users for Management Tab ---
    $stmt = $pdo->prepare('
        SELECT 
            u.id, 
            u.name, 
            u.email, 
            u.country, 
            u.role, 
            u.created_at, 
            COUNT(s.id) AS post_count 
        FROM users u 
        LEFT JOIN stories s ON u.id = s.user_id 
        GROUP BY u.id, u.name, u.email, u.country, u.role, u.created_at
        ORDER BY u.created_at DESC
    ');
    $stmt->execute();
    $allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // A simple error handler for the database queries
    die('Database error: ' . $e->getMessage());
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | EchoFolk</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="admindas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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



<div id="confirmPopup" class="confirm-popup" style="display: none;">
  <div class="confirm-box">
    <p id="confirmMessage">Are you sure?</p>
    <div class="buttons">
      <button id="confirmYes" class="yes">Yes</button>
      <button id="confirmNo" class="no">Cancel</button>
    </div>
  </div>
</div>

<style>
.confirm-popup {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
  display: flex; align-items: center; justify-content: center;
  z-index: 1001;
  font-family: 'Inter', sans-serif;
}

.confirm-box {
  background: white;
  padding: 20px 30px;
  border-radius: 10px;
  text-align: center;
  max-width: 400px;
  box-shadow: 0 8px 16px rgba(0,0,0,0.3);
}

.confirm-box p {
  font-size: 18px;
  margin-bottom: 20px;
}

.confirm-box .buttons button {
  margin: 0 10px;
  padding: 8px 16px;
  font-weight: 600;
  cursor: pointer;
}

.confirm-box .yes { background: #4CAF50; color: white; border: none; }
.confirm-box .no { background: #f44336; color: white; border: none; }
</style>


  <header>
    <a href="../index.php" class="logo-container">
    <div class="logo-container">
      <div class="logo-icon"><i class="fa-solid fa-book-open"></i></div>
      <span class="logo-text">EchoFolk</span>
    </div>
  </a>
     <nav>
    <a href="index.php">Dashboard</a>
     <a href="../explore.php">Explore</a>
      <a href="../post.php">Share Story</a>
       <a href="../message.php">Community</a>
  
  </nav>
    <div class="user-info">

        <a href="../profile.php" class="logout-button" style="text-decoration: none;">
            <i class="fa-solid fa-user"></i> <?= htmlspecialchars($userName) ?>
        </a>
      <form method="POST" action="../logout.php" >
  <button type="submit" class="logout-button">Logout</button>
</form>
    </div>
  </header>

  <main class="main-content">
    <div class="dashboard-grid">
      <div class="card blue">
        <div class="icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline></svg></div>
        <div class="text-content"><h2><?= $totalPosts ?></h2><span>Total Posts</span></div>
      </div>
      <div class="card green">
        <div class="icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><path d="m9 12 2 2 4-4"></path></svg></div>
        <div class="text-content"><h2><?= $approvedPosts ?></h2><span>Approved</span></div>
      </div>
      <div class="card orange">
        <div class="icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><path d="M12 6v6l4 2"></path></svg></div>
        <div class="text-content"><h2><?= $pendingPosts ?></h2><span>Pending Review</span></div>
      </div>
      <div class="card purple">
        <div class="icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div>
        <div class="text-content"><h2><?= number_format($totalUsers) ?></h2><span>Total Users</span></div>
      </div>
    </div>

    <div class="content-area">
      <div class="tabs">
        <div class="tab active" data-target="moderate-posts-content">Moderate Posts</div>
        <div class="tab" data-target="manage-users-content">Manage Users</div>
        <div class="tab" data-target="export-data-content">Export Data</div>
        <div class="tab" data-target="activity-log-content">Activity Log</div>
      </div>

      <div id="moderate-posts-content" class="tab-content active">
    <div class="section-header">
      <div class="section-title">Content Moderation</div>
      <p class="section-subtitle">Review and moderate cultural posts submitted by users.</p>
    </div>
    <div class="pending-posts">
      <?php
$stmt = $pdo->prepare('SELECT s.*, u.name AS author_name FROM stories s JOIN users u ON s.user_id = u.id WHERE s.verified = 0 ORDER BY s.created_at DESC');
$stmt->execute();
$stories = $stmt->fetchAll();

if (empty($stories)) {
    echo '<p>No pending posts for moderation.</p>';
} else {
    foreach ($stories as $story):
        ?>
          <div class="post-card">
            <div class="post-content">
              <div class="post-title"><?= htmlspecialchars($story['title']) ?></div>
              <div class="post-description"><?= htmlspecialchars(substr($story['body'], 0, 150)) ?>...</div>
              <div class="post-meta">
                <span><?= htmlspecialchars($story['author_name']) ?></span>
                <span><?= htmlspecialchars($story['country']) ?></span>
                <span><?= date('Y-m-d', strtotime($story['event_date'])) ?></span>
              </div>
              <div class="post-tags"><?= htmlspecialchars($story['tags']) ?></div>
            </div>
            <div class="actions">
              <form action="verify_post.php" method="POST" style="display:inline;">
                <input type="hidden" name="story_id" value="<?= $story['id'] ?>">
                <button class="approve" type="submit">✔ Verify</button>
              </form>
              <form action="reject_post.php" method="POST" style="display:inline;">
                <input type="hidden" name="story_id" value="<?= $story['id'] ?>">
                <button class="reject" type="submit">✖ Reject</button>
              </form>
            </div>
          </div>
      <?php endforeach;
} ?>
    </div>
  </div>






      <div id="manage-users-content" class="tab-content">
        <div class="section-header">
          <div class="section-title">User Management</div>
          <p class="section-subtitle">Manage registered users and their contributions.</p>
        </div>
        <div class="user-management-toolbar">
            <div class="search-bar">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" placeholder="Search users by name, email, or country...">
            </div>
            <div class="user-count"><?= count($allUsers) ?> of <?= number_format($totalUsers) ?> users</div>
        </div>
        <div class="user-table">
            <div class="user-table-inner">
                <div class="user-table-header">
                    <div class="col-user">User</div>
                    <div class="col-contact">Contact</div>
                    <div class="col-location">Location</div>
                    <div class="col-contributions">Contributions</div>
                    <div class="col-role">Role</div>
                    <div class="col-since">Member Since</div>
                    <div class="col-actions">Actions</div>
                </div>

                <?php foreach ($allUsers as $dbUser): ?>
                <?php
                // Create user initials for the avatar
                $nameParts = explode(' ', trim($dbUser['name']));
                $initials = '';
                if (count($nameParts) > 0) {
                    $initials .= strtoupper(substr($nameParts[0], 0, 1));
                    if (count($nameParts) > 1) {
                        $initials .= strtoupper(substr(end($nameParts), 0, 1));
                    }
                }
                ?>
                <div class="user-row" data-user-id="<?= $dbUser['id'] ?>">
                    <div class="user-info-cell">
                        <div class="user-avatar"><?= htmlspecialchars($initials) ?></div>
                        <div>
                            <div class="user-name"><?= htmlspecialchars($dbUser['name']) ?></div>
                            <div class="user-id">ID: <?= $dbUser['id'] ?></div>
                        </div>
                    </div>
                    <div class="user-email"><?= htmlspecialchars($dbUser['email']) ?></div>
                    <div class="col-location"><?= htmlspecialchars($dbUser['country']) ?></div>
                    <div class="user-contributions"><?= $dbUser['post_count'] ?> posts</div>
                    <div class="user-role">
                        <span class="role-badge role-<?= strtolower(htmlspecialchars($dbUser['role'])) ?>">
                            <?= htmlspecialchars($dbUser['role']) ?>
                        </span>
                    </div>
                    <div class="col-since"><?= date('n/j/Y', strtotime($dbUser['created_at'])) ?></div>
                    <div class="user-actions">
                        <button class="edit-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg></button>
                        <button class="delete-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></button>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
      </div>


      <!--export data section-->
      <div id="export-data-content" class="tab-content">
        <div class="section-header">
          <div class="section-title">Export Data</div>
          <p class="section-subtitle">Generate and download data exports.</p>
        </div>
        <div class="export-panel">
           <form class="export-form" method="POST" action="export_data.php">

                <div>
                    <label for="export-format">Export Format</label>
                    <div class="custom-select-wrapper">
                       <select id="export-format" name="format" class="custom-select">
    <option value="json">JSON Format</option>
    <option value="csv">CSV Format</option>
</select>
                    </div>
                </div>
                <div>
                    <label for="data-filter">Data Filter</label>
                    <div class="custom-select-wrapper">
                       <select id="data-filter" name="filter" class="custom-select">
    <option value="approved">All Approved Posts</option>
    <option value="pending">All Pending Posts</option>
    <option value="users">All Users</option>
</select>
                    </div>
                </div>
                <div class="action-col">
                    <label>&nbsp;</label>
                    <button type="submit" class="generate-btn">Generate Export</button>
                </div>
            </form>
          
        </div>
        <div class="section-header">
            <div class="section-title">Export History</div>
        </div>
       <?php
$exportLogs = $pdo->query("SELECT * FROM exports ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="user-table export-history">
    <div class="user-table-inner">
        <div class="user-table-header">
            <div>Export File</div>
            <div>Format</div>
            <div>Filter</div>
            <div>Date Created</div>
            <div>File Size</div>
            <div>Actions</div>
        </div>
        <?php foreach ($exportLogs as $log): ?>
        <div class="user-row">
            <div><?= htmlspecialchars($log['file_name']) ?></div>
            <div><span class="format-badge format-<?= strtolower($log['format']) ?>"><?= $log['format'] ?></span></div>
            <div><?= htmlspecialchars(ucwords(str_replace('_', ' ', $log['filter_used']))) ?></div>
            <div><?= date('n/j/Y', strtotime($log['created_at'])) ?></div>
            <div><?= round($log['file_size'] / 1048576, 2) ?> MB</div>
            <div>
                <a class="download-btn" href="exports/<?= urlencode($log['file_name']) ?>" download><i class="fa-solid fa-download"></i> Download</button>
                

                   
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

      </div>



      <!-- Activity log-->
      <div id="activity-log-content" class="tab-content">
    <div class="section-header">
        <div class="section-title">Activity Log</div>
        <p class="section-subtitle">Track recent administrative actions and system events.</p>
    </div>
    <div class="activity-log-list">
        <?php
        // Fetch the last 20 log entries
        $logStmt = $pdo->query("SELECT * FROM activity_log ORDER BY created_at DESC LIMIT 20");
        $logs = $logStmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($logs)) {
            echo '<p>No recent activity found.</p>';
        } else {
            foreach ($logs as $log) {
                // Determine icon and color based on the action
                $icon = '';
                $colorClass = '';
                switch ($log['action']) {
                    case 'post_approved':
                        $icon = '<i class="fa-solid fa-check"></i>';
                        $colorClass = 'green';
                        break;
                    case 'post_rejected':
                    case 'user_deleted':
                        $icon = '<i class="fa-solid fa-trash-can"></i>';
                        $colorClass = 'red';
                        break;
                    case 'user_modified':
                        $icon = '<i class="fa-solid fa-pencil"></i>';
                        $colorClass = 'blue';
                        break;
                    case 'export_generated':
                        $icon = '<i class="fa-solid fa-file-export"></i>';
                        $colorClass = 'purple';
                        break;
                    case 'user_created':
                        $icon = '<i class="fa-solid fa-user-plus"></i>';
                        $colorClass = 'blue';
                        break;
                    default:
                        $icon = '<i class="fa-solid fa-info-circle"></i>';
                        $colorClass = 'grey';
                }

                // Calculate time ago
                $logTime = new DateTime($log['created_at']);
                $now = new DateTime();
                $interval = $now->diff($logTime);
                $timeAgo = '';
                if ($interval->d > 1) {
                    $timeAgo = $interval->d . ' days ago';
                } elseif ($interval->d == 1) {
                    $timeAgo = '1 day ago';
                } elseif ($interval->h > 1) {
                    $timeAgo = $interval->h . ' hours ago';
                } elseif ($interval->h == 1) {
                    $timeAgo = '1 hour ago';
                } elseif ($interval->i > 1) {
                    $timeAgo = $interval->i . ' minutes ago';
                } else {
                    $timeAgo = 'Just now';
                }
        ?>
        <div class="activity-log-item">
            <div class="icon-wrapper <?= $colorClass ?>"><?= $icon ?></div>
            <div class="log-text"><?= htmlspecialchars($log['description']) ?></div>
            <div class="log-time" title="<?= $logTime->format('F j, Y, g:i a') ?>">
               UTC <?= $timeAgo ?> <span class="log-date">- <?= $logTime->format('M j, Y') ?></span>
            </div>
        </div>
        <?php
            } // end foreach
        } // end else
        ?>
    </div>
</div>



  </main>
  
<div id="edit-user-modal" class="modal-overlay">
      <div class="modal-content">
          <div class="modal-header">
              <h2 class="modal-title">Edit User Information</h2>
              <button class="close-modal">&times;</button>
          </div>
          <form class="modal-form">
              <input type="hidden" id="edit-user-id" **name="id"**>
              <div class="form-group">
                  <label for="edit-user-name">Full Name</label>
                  <input type="text" id="edit-user-name" **name="name"** required>
              </div>
              <div class="form-group">
                  <label for="edit-user-email">Email Address</label>
                  <input type="email" id="edit-user-email" **name="email"** required>
              </div>
              <div class="form-group">
                  <label for="edit-user-role">Role</label>
                  <select id="edit-user-role" **name="role"**>
                      <option value="user">user</option>
                      <option value="admin">admin</option>
                  </select>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn-cancel">Cancel</button>
                  <button type="submit" class="btn-save">Save Changes</button>
              </div>
          </form>
      </div>
  </div>


 <script>
 document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');

    // Tab switching logic
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            tab.classList.add('active');
            const targetId = tab.getAttribute('data-target');
            const targetContent = document.getElementById(targetId);
            if (targetContent) {
                targetContent.classList.add('active');
            }
        });
    });

    // --- Edit User Modal Logic ---
    const modal = document.getElementById('edit-user-modal');
    const closeModalButtons = document.querySelectorAll('.close-modal, .btn-cancel');
    const editForm = document.querySelector('.modal-form');
    let activeRow = null;

    const openModal = (row) => {
        activeRow = row;
        const name = row.querySelector('.user-name').textContent;
        const email = row.querySelector('.user-email').textContent;
        const role = row.querySelector('.user-role .role-badge').textContent.trim();
        const userId = row.dataset.userId;

        document.getElementById('edit-user-id').value = userId;
        document.getElementById('edit-user-name').value = name;
        document.getElementById('edit-user-email').value = email;
        document.getElementById('edit-user-role').value = role;

        modal.classList.add('active');
    };

    const closeModal = () => {
        modal.classList.remove('active');
        activeRow = null;
    };

    closeModalButtons.forEach(button => {
        button.addEventListener('click', closeModal);
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // --- User Management Actions (Edit and Delete) ---
    const userTable = document.querySelector('.user-table-inner');
    if (userTable) {
        userTable.addEventListener('click', function(e) {
            const editButton = e.target.closest('.edit-btn');
            const deleteButton = e.target.closest('.delete-btn');
            
            if (editButton) {
                const row = editButton.closest('.user-row');
                openModal(row);
            }

            if (deleteButton) {
                const row = deleteButton.closest('.user-row');
                const userId = row.dataset.userId;
                const userName = row.querySelector('.user-name').textContent;

                showConfirmation(`Are you sure you want to delete user "${userName}"? This will delete all their posts too.`, () => {
  const formData = new URLSearchParams();
  formData.append('id', userId);

  fetch('delete_user.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      row.style.transition = 'opacity 0.5s ease';
      row.style.opacity = '0';
      setTimeout(() => row.remove(), 500);
      showPopup("User deleted successfully.", "success");
    } else {
      showPopup(`Error: ${data.message}`, "error");
    }
  })
  .catch(error => {
    console.error('Fetch Error:', error);
    showPopup("An error occurred. Please try again.", "error");
  });
});

 
            }
        });
    }




    // Handle Edit Form Submission
    editForm.addEventListener('submit', (e) => {
        e.preventDefault();
        if (!activeRow) return;

     const formData = new FormData();
formData.append("id", document.getElementById("edit-user-id").value);
formData.append("name", document.getElementById("edit-user-name").value);
formData.append("email", document.getElementById("edit-user-email").value);
formData.append("role", document.getElementById("edit-user-role").value);


        fetch('update_user.php', {
            method: 'POST',
           body: formData
        })
        .then(response => response.json())
        .then(data => {
    if (data.success) {
        const newName = formData.get('name');
        const newEmail = formData.get('email');
        const roleValue = formData.get('role');
        const newRole = roleValue.charAt(0).toLowerCase() + roleValue.slice(1);

        activeRow.querySelector('.user-name').textContent = newName;
        activeRow.querySelector('.user-email').textContent = newEmail;

        const roleBadge = activeRow.querySelector('.user-role .role-badge');
        roleBadge.textContent = newRole;
        roleBadge.className = `role-badge role-${newRole}`;

        const loggedInUserId = <?= json_encode($_SESSION['user']['id']) ?>;
        const editedUserId = formData.get('id');

        if (parseInt(editedUserId) === loggedInUserId) {
            document.querySelector('header .user-info .logout-button i').nextSibling.textContent = ` ${newName}`;
        }

        showPopup("User updated successfully!", "success");
        closeModal();
    } else {
        showPopup(`Update failed: ${data.message}`, "error");
    }
})

    
    
        .catch(error => {
            console.error('Fetch Error:', error);
            alert('An error occurred. Please check the console and try again.');
        });
    });
});

function showConfirmation(message, onConfirm) {
  const popup = document.getElementById("confirmPopup");
  const msg = document.getElementById("confirmMessage");
  const yes = document.getElementById("confirmYes");
  const no = document.getElementById("confirmNo");

  msg.textContent = message;
  popup.style.display = "flex";

  yes.onclick = () => {
    popup.style.display = "none";
    onConfirm();
  };

  no.onclick = () => {
    popup.style.display = "none";
  };
}


function showPopup(message, type = "success") {
    const existing = document.querySelector(".popup");
    if (existing) existing.remove();

    const popup = document.createElement("div");
    popup.className = `popup ${type}`;
    popup.innerHTML = `
        <span class="popup-close" onclick="this.parentElement.style.display='none';">&times;</span>
        ${message}
    `;
    document.body.appendChild(popup);
    setTimeout(() => popup.style.display = 'none', 5000);
}

</script>

</body>
</html>