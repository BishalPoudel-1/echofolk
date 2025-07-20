<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
$user = $_SESSION['user'];
$userName = $user['name'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | EchoFolk</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  
</head>
<body>

  <header>
    <a href="../index.php" class="logo-container">
      <div class="logo-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
      </div>
      <span class="logo-text">EchoFolk</span>
    </a>
     <nav>
    <a href="index.php">Dashboard</a>
  
  </nav>
    <div class="user-info">
      <button class="logout-button"><i class="fa-solid fa-user"></i> <?= htmlspecialchars($userName) ?></button>
      <form method="POST" action="../logout.php" >
  <button type="submit" class="logout-button">Logout</button>
</form>
    </div>
  </header>

  <main class="main-content">
    <div class="dashboard-grid">
      <div class="card blue">
        <div class="icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline></svg></div>
        <div class="text-content"><h2>247</h2><span>Total Posts</span></div>
      </div>
      <div class="card green">
        <div class="icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><path d="m9 12 2 2 4-4"></path></svg></div>
        <div class="text-content"><h2>189</h2><span>Approved</span></div>
      </div>
      <div class="card orange">
        <div class="icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><path d="M12 6v6l4 2"></path></svg></div>
        <div class="text-content"><h2>32</h2><span>Pending Review</span></div>
      </div>
      <div class="card purple">
        <div class="icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div>
        <div class="text-content"><h2>1,847</h2><span>Total Users</span></div>
      </div>
    </div>

    <div class="content-area">
      <div class="tabs">
        <div class="tab active" data-target="moderate-posts-content">Moderate Posts</div>
        <div class="tab" data-target="manage-users-content">Manage Users</div>
        <div class="tab" data-target="export-data-content">Export Data</div>
        <div class="tab" data-target="activity-log-content">Activity Log</div>
      </div>

      <!-- Moderate Posts Content -->
      <div id="moderate-posts-content" class="tab-content active">
        <div class="section-header">
          <div class="section-title">Content Moderation</div>
          <p class="section-subtitle">Review and moderate cultural posts submitted by users.</p>
        </div>
        <div class="pending-posts">
          <!-- Post Card 1 -->
          <div class="post-card">
            <div class="post-content">
              <div class="post-title">Traditional Brazilian Carnival Masks</div>
              <div class="post-description">Exploring the intricate artistry and cultural significance of handcrafted carnival masks from Rio de Janeiro...</div>
              <div class="post-meta">
                <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 20a6 6 0 0 0-12 0"></path><circle cx="12" cy="10" r="4"></circle><circle cx="12" cy="12" r="10"></circle></svg> Maria Santos</span>
                <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20z"></path><path d="M2 12h20"></path></svg> Brazil</span>
                <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect><line x1="16" x2="16" y1="2" y2="6"></line><line x1="8" x2="8" y1="2" y2="6"></line><line x1="3" x2="21" y1="10" y2="10"></line></svg> 7/15/2024</span>
              </div>
              <div class="post-tags">Art & Crafts</div>
            </div>
            <div class="actions">
              <button class="approve"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg> Approve</button>
              <button class="reject"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> Reject</button>
            </div>
          </div>
           <!-- Post Card 2 -->
          <div class="post-card">
            <div class="post-content">
              <div class="post-title">Ancient Egyptian Hieroglyphic Traditions</div>
              <div class="post-description">A deep dive into the preservation techniques of hieroglyphic writing and its modern cultural impact...</div>
              <div class="post-meta">
                <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 20a6 6 0 0 0-12 0"></path><circle cx="12" cy="10" r="4"></circle><circle cx="12" cy="12" r="10"></circle></svg> Ahmed Hassan</span>
                <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20z"></path><path d="M2 12h20"></path></svg> Egypt</span>
                <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect><line x1="16" x2="16" y1="2" y2="6"></line><line x1="8" x2="8" y1="2" y2="6"></line><line x1="3" x2="21" y1="10" y2="10"></line></svg> 7/14/2024</span>
              </div>
              <div class="post-tags">Language & Writing</div>
            </div>
            <div class="actions">
              <button class="approve"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg> Approve</button>
              <button class="reject"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> Reject</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Manage Users Content -->
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
            <div class="user-count">4 of 1,847 users</div>
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
                <!-- User Row 1 -->
                <div class="user-row" data-user-id="1">
                    <div class="user-info-cell">
                        <div class="user-avatar" style="background-color: #fee2e2; color: #ef4444;">MS</div>
                        <div>
                            <div class="user-name">Maria Santos</div>
                            <div class="user-id">ID: 1</div>
                        </div>
                    </div>
                    <div class="user-email">maria@example.com</div>
                    <div class="col-location">Brazil</div>
                    <div class="user-contributions">15 posts</div>
                    <div class="user-role"><span class="role-badge role-user">User</span></div>
                    <div class="col-since">7/15/2024</div>
                    <div class="user-actions">
                        <button><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="12" x2="12" y1="18" y2="12"/><line x1="9" x2="15" y1="15" y2="15"/></svg> Posts</button>
                        <button class="edit-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg></button>
                        <button class="delete-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></button>
                    </div>
                </div>
                <!-- User Row 2 -->
                <div class="user-row" data-user-id="2">
                    <div class="user-info-cell">
                        <div class="user-avatar" style="background-color: #dcfce7; color: #22c55e;">AH</div>
                        <div>
                            <div class="user-name">Ahmed Hassan</div>
                            <div class="user-id">ID: 2</div>
                        </div>
                    </div>
                    <div class="user-email">ahmed@example.com</div>
                    <div class="col-location">Egypt</div>
                    <div class="user-contributions">8 posts</div>
                    <div class="user-role"><span class="role-badge role-user">User</span></div>
                    <div class="col-since">2/20/2024</div>
                    <div class="user-actions">
                        <button><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="12" x2="12" y1="18" y2="12"/><line x1="9" x2="15" y1="15" y2="15"/></svg> Posts</button>
                         <button class="edit-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg></button>
                        <button class="delete-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></button>
                    </div>
                </div>
                <!-- User Row 3 -->
                <div class="user-row" data-user-id="3">
                    <div class="user-info-cell">
                        <div class="user-avatar" style="background-color: #e0e7ff; color: #4f46e5;">YT</div>
                        <div>
                            <div class="user-name">Yuki Tanaka</div>
                            <div class="user-id">ID: 3</div>
                        </div>
                    </div>
                    <div class="user-email">yuki@example.com</div>
                    <div class="col-location">Japan</div>
                    <div class="user-contributions">22 posts</div>
                    <div class="user-role"><span class="role-badge role-user">User</span></div>
                    <div class="col-since">1/8/2024</div>
                    <div class="user-actions">
                        <button><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="12" x2="12" y1="18" y2="12"/><line x1="9" x2="15" y1="15" y2="15"/></svg> Posts</button>
                         <button class="edit-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg></button>
                        <button class="delete-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></button>
                    </div>
                </div>
                 <!-- User Row 4 -->
                <div class="user-row" data-user-id="4">
                    <div class="user-info-cell">
                        <div class="user-avatar" style="background-color: var(--purple-light); color: var(--purple);">AU</div>
                        <div>
                            <div class="user-name">Admin User</div>
                            <div class="user-id">ID: 4</div>
                        </div>
                    </div>
                    <div class="user-email">admin@echofolk.com</div>
                    <div class="col-location">USA</div>
                    <div class="user-contributions">0 posts</div>
                    <div class="user-role"><span class="role-badge role-admin">Admin</span></div>
                    <div class="col-since">12/1/2023</div>
                    <div class="user-actions">
                        <button><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="12" x2="12" y1="18" y2="12"/><line x1="9" x2="15" y1="15" y2="15"/></svg> Posts</button>
                     <button class="edit-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg></button>
                        <button class="delete-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></button>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <!-- Export Data Content -->
      <div id="export-data-content" class="tab-content">
        <div class="section-header">
          <div class="section-title">Export Data</div>
          <p class="section-subtitle">Generate and download data exports.</p>
        </div>
        <div class="export-panel">
            <form class="export-form">
                <div>
                    <label for="export-format">Export Format</label>
                    <div class="custom-select-wrapper">
                        <select id="export-format" class="custom-select">
                            <option>JSON Format</option>
                            <option>XML Format</option>
                            <option>CSV Format</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="data-filter">Data Filter</label>
                    <div class="custom-select-wrapper">
                        <select id="data-filter" class="custom-select">
                            <option>All Approved Posts</option>
                            <option>All Pending Posts</option>
                            <option>All Users</option>
                            <option>Custom Filter...</option>
                        </select>
                    </div>
                </div>
                <div class="action-col">
                    <label>&nbsp;</label>
                    <button type="submit" class="generate-btn">Generate Export</button>
                </div>
            </form>
            <div class="export-info">
                <ul>
                    <li>XML exports use PHP DOMDocument structure.</li>
                    <li>JSON exports include complete post metadata.</li>
                    <li>Export records are saved to the export history table.</li>
                    <li>Files are stored in a secure export directory.</li>
                </ul>
            </div>
        </div>
        <div class="section-header">
            <div class="section-title">Export History</div>
        </div>
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
                <div class="user-row">
                    <div>brazil_posts_2024-07-19.xml</div>
                    <div><span class="format-badge format-xml">XML</span></div>
                    <div>Country Filter</div>
                    <div>7/19/2024</div>
                    <div>2.3 MB</div>
                    <div><button class="download-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg> Download</button></div>
                </div>
                <div class="user-row">
                    <div>all_approved_posts_2024-07-18.json</div>
                    <div><span class="format-badge format-json">JSON</span></div>
                    <div>All Data</div>
                    <div>7/18/2024</div>
                    <div>5.7 MB</div>
                    <div><button class="download-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg> Download</button></div>
                </div>
                <div class="user-row">
                    <div>japan_posts_2024-07-17.xml</div>
                    <div><span class="format-badge format-xml">XML</span></div>
                    <div>Country Filter</div>
                    <div>7/17/2024</div>
                    <div>1.8 MB</div>
                    <div><button class="download-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg> Download</button></div>
                </div>
            </div>
        </div>
      </div>

      <!-- Activity Log Content -->
      <div id="activity-log-content" class="tab-content">
        <div class="section-header">
          <div class="section-title">Activity Log</div>
          <p class="section-subtitle">Track recent administrative actions and system events.</p>
        </div>
        <div class="activity-log-list">
            <div class="activity-log-item">
                <div class="icon-wrapper green"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                <div class="log-text">Admin <strong>Admin User</strong> approved post "Traditional Brazilian Carnival Masks" (ID: 101).</div>
                <div class="log-time">2 hours ago</div>
            </div>
            <div class="activity-log-item">
                <div class="icon-wrapper red"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></div>
                <div class="log-text">User <strong>Yuki Tanaka</strong> (ID: 3) was deleted by <strong>Admin User</strong>.</div>
                <div class="log-time">5 hours ago</div>
            </div>
            <div class="activity-log-item">
                <div class="icon-wrapper purple"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg></div>
                <div class="log-text">Admin <strong>Admin User</strong> generated a new data export: <strong>brazil_posts_2024-07-19.xml</strong>.</div>
                <div class="log-time">1 day ago</div>
            </div>
             <div class="activity-log-item">
                <div class="icon-wrapper blue"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/></svg></div>
                <div class="log-text">A new user, <strong>John Doe</strong> (ID: 1848), registered.</div>
                <div class="log-time">2 days ago</div>
            </div>
        </div>
      </div>

    </div>
  </main>
  
  <!-- Edit User Modal -->
  <div id="edit-user-modal" class="modal-overlay">
      <div class="modal-content">
          <div class="modal-header">
              <h2 class="modal-title">Edit User Information</h2>
              <button class="close-modal">&times;</button>
          </div>
          <form class="modal-form">
              <input type="hidden" id="edit-user-id">
              <div class="form-group">
                  <label for="edit-user-name">Full Name</label>
                  <input type="text" id="edit-user-name" required>
              </div>
              <div class="form-group">
                  <label for="edit-user-email">Email Address</label>
                  <input type="email" id="edit-user-email" required>
              </div>
              <div class="form-group">
                  <label for="edit-user-role">Role</label>
                  <select id="edit-user-role">
                      <option value="User">User</option>
                      <option value="Admin">Admin</option>
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
            const role = row.querySelector('.user-role .role-badge').textContent;
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

        document.querySelector('.user-table-inner').addEventListener('click', function(e) {
            const editButton = e.target.closest('.edit-btn');
            if (editButton) {
                const row = editButton.closest('.user-row');
                openModal(row);
            }
        });

        closeModalButtons.forEach(button => {
            button.addEventListener('click', closeModal);
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

        editForm.addEventListener('submit', (e) => {
            e.preventDefault();
            if (!activeRow) return;

            const newName = document.getElementById('edit-user-name').value;
            const newEmail = document.getElementById('edit-user-email').value;
            const newRole = document.getElementById('edit-user-role').value;

            activeRow.querySelector('.user-name').textContent = newName;
            activeRow.querySelector('.user-email').textContent = newEmail;
            
            const roleBadge = activeRow.querySelector('.user-role .role-badge');
            roleBadge.textContent = newRole;
            roleBadge.className = `role-badge role-${newRole.toLowerCase()}`;
            
            closeModal();
        });
    });
  </script>

</body>
</html>
