<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Group Chat</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Basic Reset & Theming */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom right, #fff6f2, #ffeee7);
            color: #333;
        }

        /* Header from your provided styles */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 40px;
            background-color: #fff;
            border-bottom: 1px solid #eee;
            flex-wrap: wrap;
            margin-bottom:10px;
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
            transform: scale(1.1) rotate(-5deg);
        }

        .logo-icon i {
            color: white;
        }

        .logo-text {
            font-size: 1.4rem;
            font-weight: 700;
            background: linear-gradient(to right, #ea580c, #dc2626);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        header nav a {
            margin: 0 10px;
            text-decoration: none;
            font-weight: 500;
            color: #333;
            position: relative;
            transition: color 0.3s;
        }

        header nav a::after {
            content: "";
            position: absolute;
            width: 0;
            height: 2px;
            background-color: #ff5722;
            left: 0;
            bottom: -3px;
            transition: width 0.3s ease;
        }

        header nav a:hover::after {
            width: 100%;
        }

        header nav a:hover {
            color: #ff5722;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
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
            transform: scale(1.05);
        }

        /* Custom scrollbar */
        #messages-container::-webkit-scrollbar {
            width: 8px;
        }
        #messages-container::-webkit-scrollbar-track {
            background: #f8fafc; /* slate-50 */
        }
        #messages-container::-webkit-scrollbar-thumb {
            background-color: #fdba74; /* orange-300 */
            border-radius: 10px;
            border: 3px solid #f8fafc;
        }
        
        /* Custom theme colors */
        .bg-theme-orange { background-color: #f97316; }
        .text-theme-orange { color: #f97316; }
        .hover-bg-theme-orange:hover { background-color: #ea580c; }
        .focus-ring-theme-orange:focus { --tw-ring-color: #f97316; }

        /* Hide sidebar on small screens */
        @media (max-width: 768px) {
            #sidebar {
                display: none;
            }
            header {
                justify-content: center;
            }
        }

        /* Fade-in and slide for messages */
@keyframes messageFadeIn {
  0% {
    opacity: 0;
    transform: translateY(12px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.message-animate {
  animation: messageFadeIn 0.4s ease forwards;
}

/* Shared photo animation */
@keyframes photoPopIn {
  from {
    transform: scale(0.85);
    opacity: 0;
  }
  to {
    transform: scale(1);
    opacity: 1;
  }
}

.photo-animate {
  animation: photoPopIn 0.3s ease-out forwards;
}

@keyframes pageFadeIn {
  0% {
    opacity: 0;
    transform: translateY(30px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.page-animate {
  animation: pageFadeIn 0.6s ease-out both;
}


    </style>
</head>
<body >
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
          <span>Welcome, Demo User</span>
          <button class="logout">Logout</button>
        </div>
    </header>

    <div class="flex h-[calc(100vh-69px)] max-w-7xl mx-auto page-animate">
        <!-- Sidebar (Left Column) -->
        <aside id="sidebar" class="w-1/3 max-w-xs bg-white border-r border-slate-200 flex flex-col p-6">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-theme-orange rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800"> Cultural Enthusiasts</h2>
                    <p class="text-sm text-slate-500">Connect with fellow</p>
                </div>
            </div>

            <!-- Group Details -->
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-3">Details</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center gap-3 text-slate-600">
                        <i class="fas fa-globe w-4 text-center text-slate-400"></i>
                        <span>Public Group</span>
                    </div>
                     <div class="flex items-center gap-3 text-slate-600">
                        <i class="fas fa-hashtag w-4 text-center text-slate-400"></i>
                        <span>#Cultural-Discussion</span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-600">
                        <i class="far fa-calendar w-4 text-center text-slate-400"></i>
                        <span>Created July 20, 2025</span>
                    </div>
                </div>
            </div>

            <!-- Shared Photos -->
            <div>
                <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-3">Shared Photos</h3>
                <div id="shared-photos-container" class="grid grid-cols-3 gap-2">
                    <!-- Placeholder Images -->
                    <div class="aspect-square bg-slate-200 rounded-md flex items-center justify-center">
                        <i class="fas fa-image text-slate-400"></i>
                    </div>
                </div>
                 <p id="shared-photos-hint" class="text-xs text-slate-400 mt-2 text-center">No photos shared yet.</p>
            </div>
            
            <div class="mt-auto text-center text-xs text-slate-400">
                <p>Your ID: <span id="sidebar-user-id">DemoUser123</span></p>
            </div>
        </aside>

        <!-- Main Chat Area (Right Column) -->
        <div class="flex-1 flex flex-col bg-slate-50">
            <!-- Messages Container -->
            <main id="messages-container" class="flex-1 p-6 overflow-y-auto space-y-6">
                <!-- Static/Dummy Messages -->
                <div class="flex items-end gap-2 justify-start">
                    <div class="flex flex-col items-start">
                        <div class="px-4 py-3 rounded-2xl max-w-sm bg-white text-slate-800 rounded-bl-none shadow-sm">
                            <p class="break-words">Hey everyone! How's it going?</p>
                        </div>
                        <div class="text-xs text-slate-400 mt-1.5 px-1">
                            <span class="font-medium">User...aBcDe</span> &bull; 2:25 PM
                        </div>
                    </div>
                </div>
                <div class="flex items-end gap-2 justify-end">
                    <div class="flex flex-col items-end">
                        <div class="px-4 py-3 rounded-2xl max-w-sm bg-theme-orange text-white rounded-br-none">
                            <p class="break-words">Going great! Just checking out this new chat design.</p>
                        </div>
                        <div class="text-xs text-slate-400 mt-1.5 px-1">
                            <span class="font-medium">You</span> &bull; 2:26 PM
                        </div>
                    </div>
                </div>
            </main>

            <!-- Message Input Form -->
            <footer class="p-4 bg-white border-t border-slate-200">
                <form id="message-form" class="flex items-center gap-3">
                    <!-- Image Upload Button -->
                    <button type="button" id="image-upload-button" class="w-12 h-12 flex-shrink-0 bg-slate-100 text-slate-500 rounded-full flex items-center justify-center transition hover:bg-slate-200">
                        <i class="fas fa-paperclip text-lg"></i>
                    </button>
                    <input type="file" id="image-upload-input" class="hidden" accept="image/*">
                    
                    <!-- Text Input -->
                    <input type="text" id="message-input" placeholder="Type your message..." autocomplete="off" class="flex-1 w-full px-4 py-3 bg-slate-100 border border-slate-300 rounded-full focus:outline-none focus:ring-2 focus-ring-theme-orange transition">
                    
                    <!-- Send Button -->
                    <button type="submit" id="send-button" class="w-12 h-12 bg-theme-orange text-white rounded-full flex items-center justify-center transition hover-bg-theme-orange transform hover:scale-105">
                        <i class="fas fa-paper-plane text-lg"></i>
                    </button>
                </form>
            </footer>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const messagesContainer = document.getElementById('messages-container');
    const imageUploadButton = document.getElementById('image-upload-button');
    const imageUploadInput = document.getElementById('image-upload-input');
    const sharedPhotosContainer = document.getElementById('shared-photos-container');
    const sharedPhotosHint = document.getElementById('shared-photos-hint');

    let isFirstPhoto = true;

    // --- CSS Animations ---
    const style = document.createElement('style');
    style.innerHTML = `
        @keyframes messageFadeIn {
            0% { opacity: 0; transform: translateY(12px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .message-animate {
            animation: messageFadeIn 0.4s ease forwards;
        }

        @keyframes photoPopIn {
            from { transform: scale(0.85); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .photo-animate {
            animation: photoPopIn 0.3s ease-out forwards;
        }
    `;
    document.head.appendChild(style);

    // --- Event Listeners ---

    messageForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const messageText = messageInput.value.trim();
        if (messageText) {
            addTextMessage(messageText);
            messageInput.value = '';
            scrollToBottom();
        }
    });

    imageUploadButton.addEventListener('click', () => {
        imageUploadInput.click();
    });

    imageUploadInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                const imageUrl = event.target.result;
                addImageMessage(imageUrl);
                addPhotoToSidebar(imageUrl);
                scrollToBottom();
            };
            reader.readAsDataURL(file);
            imageUploadInput.value = '';
        }
    });

    // --- Helper Functions ---

    function getCurrentTime() {
        return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function addTextMessage(text) {
        const messageElement = document.createElement('div');
        messageElement.className = 'flex items-end gap-2 justify-end message-animate';
        messageElement.innerHTML = `
            <div class="flex flex-col items-end">
                <div class="px-4 py-3 rounded-2xl max-w-sm bg-theme-orange text-white rounded-br-none">
                    <p class="break-words">${text}</p>
                </div>
                <div class="text-xs text-slate-400 mt-1.5 px-1">
                    <span class="font-medium">You</span> &bull; ${getCurrentTime()}
                </div>
            </div>
        `;
        messagesContainer.appendChild(messageElement);
    }

    function addImageMessage(imageUrl) {
        const messageElement = document.createElement('div');
        messageElement.className = 'flex items-end gap-2 justify-end message-animate';
        messageElement.innerHTML = `
            <div class="flex flex-col items-end">
                <div class="p-2 rounded-2xl max-w-sm bg-theme-orange text-white rounded-br-none">
                    <img src="${imageUrl}" class="rounded-lg max-w-full h-auto" style="max-height: 200px;" alt="Shared image">
                </div>
                <div class="text-xs text-slate-400 mt-1.5 px-1">
                    <span class="font-medium">You</span> &bull; ${getCurrentTime()}
                </div>
            </div>
        `;
        messagesContainer.appendChild(messageElement);
    }

    function addPhotoToSidebar(imageUrl) {
        if (isFirstPhoto) {
            sharedPhotosContainer.innerHTML = '';
            sharedPhotosHint.style.display = 'none';
            isFirstPhoto = false;
        }
        const photoElement = document.createElement('div');
        photoElement.className = 'aspect-square bg-cover bg-center rounded-md photo-animate';
        photoElement.style.backgroundImage = `url(${imageUrl})`;
        sharedPhotosContainer.appendChild(photoElement);
    }
});
</script>

</body>
</html>
