<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | EchoFolk</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #f97316;
      --primary-color-dark: #ea580c;
      --primary-light: #fff7ed;
      --green: #22c55e;
      --green-light: #dcfce7;
      --red: #ef4444;
      --red-light: #fee2e2;
      --blue: #3b82f6;
      --blue-light: #dbeafe;
      --purple: #a855f7;
      --purple-light: #f3e8ff;
      --text-dark: #1f2937;
      --text-light: #6b7280;
      --bg-color: #f8f9fa;
      --white: #ffffff;
      --border-color: #e5e7eb;
      --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
      --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
      --radius-md: 8px;
      --radius-lg: 12px;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg-color);
      color: var(--text-dark);
      line-height: 1.6;
    }

    /* Header/Nav */
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px 40px;
      background: var(--white);
      border-bottom: 1px solid var(--border-color);
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    .logo-container {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
    }
    .logo-icon {
      width: 40px;
      height: 40px;
      background: linear-gradient(to bottom right, var(--primary-color), var(--primary-color-dark));
      border-radius: var(--radius-md);
      display: flex;
      justify-content: center;
      align-items: center;
      transition: transform 0.3s ease;
    }
    .logo-container:hover .logo-icon {
        transform: rotate(-10deg) scale(1.1);
    }
    .logo-icon svg { color: var(--white); width: 20px; height: 20px;}
    .logo-text {
      font-size: 1.6rem;
      font-weight: 700;
      background: linear-gradient(to right, var(--primary-color-dark), #dc2626);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .user-info {
        display: flex;
        align-items: center;
        gap: 16px;
        font-weight: 600;
    }
    .logout {
      background: transparent;
      border: 2px solid var(--primary-color);
      padding: 8px 16px;
      border-radius: var(--radius-md);
      color: var(--primary-color);
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .logout:hover {
      background: var(--primary-color);
      color: var(--white);
    }

    .main-content {
        padding: 30px 40px;
    }

    /* Dashboard Cards */
    .dashboard-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 24px;
      animation: fadeUp 0.5s ease-out;
    }
    .card {
      background: var(--white);
      border-radius: var(--radius-lg);
      padding: 24px;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--border-color);
      display: flex;
      align-items: flex-start;
      gap: 16px;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }
    .card .icon-wrapper {
        flex-shrink: 0;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: grid;
        place-items: center;
    }
    .card .icon-wrapper svg {
        width: 24px;
        height: 24px;
    }
    .card .text-content h2 {
      font-size: 2.25rem;
      font-weight: 700;
      line-height: 1.2;
      color: var(--text-dark);
    }
    .card .text-content span {
      font-weight: 500;
      font-size: 0.9rem;
      color: var(--text-light);
    }

    .blue .icon-wrapper { background: var(--blue-light); color: var(--blue); }
    .green .icon-wrapper { background: var(--green-light); color: var(--green); }
    .orange .icon-wrapper { background: var(--primary-light); color: var(--primary-color); }
    .purple .icon-wrapper { background: var(--purple-light); color: var(--purple); }

    /* Tabs & Content Area */
    .content-area {
        margin-top: 40px;
        animation: fadeUp 0.5s ease-out 0.2s;
        animation-fill-mode: both;
    }
    .tabs {
      display: flex;
      gap: 8px;
      border-bottom: 1px solid var(--border-color);
      margin-bottom: 24px;
      flex-wrap: wrap;
    }
    .tab {
      padding: 12px 24px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s ease;
      border-bottom: 3px solid transparent;
      color: var(--text-light);
    }
    .tab:hover {
      color: var(--text-dark);
      background-color: var(--bg-color);
    }
    .tab.active {
      color: var(--primary-color);
      border-bottom-color: var(--primary-color);
    }
    
    .tab-content {
        display: none;
        animation: fadeUp 0.4s ease-out;
    }
    .tab-content.active {
        display: block;
    }

    /* Section Header */
    .section-header {
        margin-bottom: 24px;
    }
    .section-title {
      font-size: 1.5rem;
      font-weight: 700;
    }
    .section-subtitle {
        color: var(--text-light);
        margin-top: 4px;
    }

    /* Moderate Posts Section */
    .pending-posts {
      display: grid;
      grid-template-columns: 1fr;
      gap: 20px;
    }
    .post-card {
      background: var(--white);
      padding: 24px;
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--border-color);
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 16px;
      transition: box-shadow 0.2s ease;
    }
    .post-card:hover {
        box-shadow: var(--shadow-md);
    }
    .post-content {
        grid-column: 1 / 2;
    }
    .post-title {
      font-weight: 600;
      font-size: 1.1rem;
      color: var(--text-dark);
      margin-bottom: 8px;
    }
    .post-description {
      font-size: 0.95rem;
      color: var(--text-light);
      margin-bottom: 16px;
    }
    .post-meta {
      font-size: 0.85rem;
      color: var(--text-light);
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      align-items: center;
    }
    .post-meta span {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .post-meta svg {
        width: 16px;
        height: 16px;
    }
    .post-tags {
      font-size: 0.8rem;
      font-weight: 500;
      padding: 4px 12px;
      border-radius: 20px;
      background: #f3f4f6;
      display: inline-block;
      margin-top: 16px;
    }
    .post-card .actions {
      display: flex;
      flex-direction: column;
      gap: 12px;
      justify-content: center;
      grid-column: 2 / 3;
      grid-row: 1 / 3;
    }
    .post-card .actions button {
      padding: 10px 20px;
      border-radius: var(--radius-md);
      border: none;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .post-card .actions button svg {
        width: 16px;
        height: 16px;
    }
    .approve {
      background: var(--green-light);
      color: var(--green);
    }
    .approve:hover {
        background: var(--green);
        color: var(--white);
    }
    .reject {
      background: var(--red-light);
      color: var(--red);
    }
    .reject:hover {
        background: var(--red);
        color: var(--white);
    }
    
    /* Manage Users Section */
    .user-management-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .search-bar {
        position: relative;
        width: 100%;
        max-width: 400px;
    }
    .search-bar svg {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
        width: 20px;
        height: 20px;
    }
    .search-bar input {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        font-size: 1rem;
    }
    .search-bar input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
    }
    .user-count {
        font-weight: 500;
        color: var(--text-light);
    }
    .user-table {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        overflow-x: auto;
    }
    .user-table-inner {
        min-width: 900px;
        width: 100%;
    }
    .user-table-header, .user-row {
        display: grid;
        grid-template-columns: 2fr 2fr 1.5fr 1fr 1fr 1.5fr 1.5fr;
        align-items: center;
        padding: 16px 24px;
        gap: 16px;
    }
    .user-table-header {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--text-light);
        text-transform: uppercase;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-color);
    }
    .user-row {
        border-bottom: 1px solid var(--border-color);
    }
    .user-row:last-child {
        border-bottom: none;
    }
    .user-info-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--blue-light);
        color: var(--blue);
        display: grid;
        place-items: center;
        font-weight: 600;
        flex-shrink: 0;
    }
    .user-name {
        font-weight: 600;
    }
    .user-id {
        font-size: 0.85rem;
        color: var(--text-light);
    }
    .role-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        text-align: center;
        display: inline-block;
    }
    .role-user {
        background: var(--blue-light);
        color: var(--blue);
    }
    .role-admin {
        background: var(--purple-light);
        color: var(--purple);
    }
    .user-actions button {
        padding: 6px 12px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        background: var(--white);
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }
     .user-actions button:hover {
        background: var(--bg-color);
        border-color: #ccc;
    }
    .user-actions .delete-btn {
        color: var(--red);
    }
     .user-actions .delete-btn:hover {
        background: var(--red);
        color: var(--white);
        border-color: var(--red);
    }
    .user-actions .edit-btn {
        color: var(--purple);
    }
     .user-actions .edit-btn:hover {
        background: var(--purple);
        color: var(--white);
        border-color: var(--purple);
    }
    .user-actions {
        display: flex;
        gap: 8px;
    }

    /* Export Data Section */
    .export-panel {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 24px;
        margin-bottom: 24px;
    }
    .export-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        align-items: flex-end;
    }
    .export-form label {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 8px;
        display: block;
    }
    .custom-select-wrapper {
        position: relative;
    }
    .custom-select-wrapper::after {
        content: '▼';
        font-size: 0.7rem;
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: var(--text-light);
    }
    .custom-select {
        width: 100%;
        padding: 12px 16px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        font-size: 1rem;
        background: var(--white);
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        cursor: pointer;
    }
    .generate-btn {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #f97316;
        border-radius: 8px;
        background: #f97316;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .generate-btn:hover {
        background: white;
        color: #f97316;
        box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
    }

    .export-info {
        background: var(--bg-color);
        border-radius: var(--radius-md);
        padding: 16px;
        margin-top: 24px;
    }
    .export-info ul {
        list-style-position: inside;
        padding-left: 5px;
        color: var(--text-light);
        font-size: 0.9rem;
    }
    .export-info li {
        margin-bottom: 8px;
    }
    .export-history .user-table-inner {
        min-width: 700px;
    }
    .export-history .user-table-header, .export-history .user-row {
        grid-template-columns: 3fr 1fr 1.5fr 1.5fr 1fr 1.5fr;
    }
    .format-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        text-align: center;
        display: inline-block;
        text-transform: uppercase;
    }
    .format-xml { background: var(--blue-light); color: var(--blue); }
    .format-json { background: var(--green-light); color: var(--green); }
    .download-btn {
        padding: 6px 12px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        background: var(--white);
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .download-btn:hover {
        background: var(--primary-light);
        color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    /* Activity Log Section */
    .activity-log-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .activity-log-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 12px;
        background: var(--white);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
    }
    .activity-log-item .icon-wrapper {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: grid;
        place-items: center;
    }
    .activity-log-item .icon-wrapper svg { width: 20px; height: 20px; }
    .activity-log-item .log-text {
        flex-grow: 1;
    }
    .activity-log-item .log-text strong {
        font-weight: 600;
    }
    .activity-log-item .log-time {
        font-size: 0.85rem;
        color: var(--text-light);
        flex-shrink: 0;
    }

    /* Edit User Modal */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }
    .modal-overlay.active {
        opacity: 1;
        pointer-events: auto;
    }
    .modal-content {
        background: var(--white);
        padding: 32px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        width: 100%;
        max-width: 500px;
        transform: scale(0.95);
        transition: transform 0.3s ease;
    }
    .modal-overlay.active .modal-content {
        transform: scale(1);
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border-color);
    }
    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
    }
    .close-modal {
        background: transparent;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--text-light);
    }
    .modal-form .form-group {
        margin-bottom: 20px;
    }
    .modal-form label {
        display: block;
        font-weight: 500;
        margin-bottom: 8px;
    }
    .modal-form input, .modal-form select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 1rem;
    }
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 32px;
    }
    .modal-footer button {
        padding: 10px 20px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        font-weight: 600;
        cursor: pointer;
    }
    .btn-cancel {
        background: var(--white);
        color: var(--text-dark);
    }
    .btn-save {
        background: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
    }


    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
      header, .main-content { padding-left: 20px; padding-right: 20px; }
      .post-card { grid-template-columns: 1fr; }
      .post-card .actions { 
        flex-direction: row; 
        grid-column: 1 / 2;
        grid-row: 3 / 4;
        margin-top: 16px;
      }
      .post-card .actions button { flex-grow: 1; }
      .export-form {
          grid-template-columns: 1fr;
      }
      .user-table-inner {
          min-width: 600px;
      }
      .user-table-header, .user-row {
          grid-template-columns: 3fr 3fr;
          gap: 12px;
      }
      .user-table-header > div:not(:nth-child(1)):not(:nth-child(7)),
      .user-row > div:not(:nth-child(1)):not(:nth-child(7)) {
          display: none;
      }
    }
  </style>
</head>
<body>

  <header>
    <a href="#" class="logo-container">
      <div class="logo-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
      </div>
      <span class="logo-text">EchoFolk</span>
    </a>
    <div class="user-info">
      <span>Admin</span>
      <button class="logout">Logout</button>
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
