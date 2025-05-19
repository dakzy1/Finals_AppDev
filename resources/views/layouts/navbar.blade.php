<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'FitZone')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="shortcut icon" href="{{ asset('images/Appdev_logo.png') }}" type="image/x-icon">
    <!-- Add Bootstrap CSS -->

    <style>
        /* Global styles */
        html {
            overflow-y: scroll; /* Prevents layout shift when pages have no scroll */
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0; /* Clean reset */
        }

        .container {
            margin-top: 80px;  /* enough spacing below the fixed navbar */
            padding: 0;        /* ensure no extra spacing */
            box-sizing: border-box;
        }
        
        table {
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #aaa;
        }
        th, td {
            padding: 10px;
        }
        a, button {
            margin-right: 5px;
        }

        /* Header and navigation styles */
        .header {
            height: 30px; /* define explicit height */
            background-color: #834c71;
            padding: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin: 0;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
        }
        .avatar {
            position: fixed;
            top: 10px;
            left: 15px;
            width: 40px;
            height: 35px;
            background-color: #fff;
            border-radius: 70%;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
        }
        .avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0,0,0,0.25);
        }

        /* Profile Overlay Styling */
        .profile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            backdrop-filter: blur(6px); /* background blur */
            background-color: rgba(0, 0, 0, 0.3); /* semi-transparent dark background */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        /* Modal container */
        .profile-modal {
            background-color: white;
            padding: 2rem;
            border-radius: 12px;
            width: 400px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .profile-overlay.hidden {
            display: none;
        }

        .profile-modal h2 {
            margin-top: 0;
            color: #9c27b0;
        }
        .profile-modal label {
            display: block;
            margin: 15px 0 5px;
        }
        .profile-modal input {
            width: 100%;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        .profile-actions {
            display: flex;
            flex-direction: row; /* Explicitly horizontal */
            justify-content: center; /* Center the buttons horizontally */
            gap: 90px; /* Space between buttons */
            margin-top: 20px;
            flex-wrap: nowrap; /* Prevent wrapping to a new line */
        }

        .btn-save, .btn-delete {
            flex: 0 1 auto; /* Allow buttons to shrink if needed, but not grow */
            width: 150px; /* Fixed width to ensure they fit side by side */
            padding: 8px 0; /* Adjusted padding for balance */
            border-radius: 6px;
            border: none;
            color: white;
            cursor: pointer;
            text-align: center;
            font-size: 14px;
            transition: background-color 0.2s ease-in-out;
            gap: 5px; /* Space between icon and text */
        }

        .btn-save {
            background-color: #9c27b0;
        }

        .btn-save:hover:not(:disabled) {
            background-color: #7b1fa2;
        }

        .btn-save:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-delete {
            background-color: #f44336;
        }

        .btn-delete:hover:not(:disabled) {
            background-color: #d32f2f;
        }

        .btn-delete:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Optional: blur background when overlay is active */
        .blurred {
            overflow: hidden;
        }

        .nav-links {
            color: #fbeec1;
            display: flex;
            gap: 30px;
            position: relative;
        }

        .logout-form {
            position: absolute;
            right: 50px;
        }

        .logout-btn {
            background: transparent;
            border: none;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            transition: transform 0.2s ease, color 0.3s ease;
        }

        .logout-btn:hover {
            transform: scale(1.2);
            color: #ddd;
        }

        .logout-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .icon-left-margin {
            margin-right: 5px;
        }

        /* Logout Modal Styling */
        #logoutModal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        #logoutModal .modal-dialog {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100%;
        }

        .logout-modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            position: relative;
        }

        /* Header */
        .logout-modal-header {
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 1px solid #dee2e6;
            color: #fff;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .logout-modal-header .modal-title {
            font-size: 1.25rem;
            color: black;
            font-weight: 600;
        }

        /* Body */
        .logout-modal-body {
            padding: 20px 0;
            text-align: center;
            font-size: 1rem;
            color: #333;
        }

        /* Footer */
        .logout-modal-footer {
            display: flex;
            justify-content: center;
            gap: 10px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
        }

        /* Buttons */
        .btn-purple {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-purple:hover:not(:disabled) {
            background-color: #c82333;
        }

        .btn-purple:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .cancel-btn {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .cancel-btn:hover:not(:disabled) {
            background-color: #5a6268;
        }

        .cancel-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Optional: Close button in top right corner */
        .logout-modal-header .btn-close {
            position: absolute;
            right: 15px;
            top: 15px;
            color: #666;
            font-size: 1.25rem;
        }

        .btn-close:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

    <!-- Fixed Header -->
    <div class="header">
        <button onclick="openProfile()" class="avatar" title="Profile">
            <i class="fas fa-user-circle" style="font-size: 50px; color:rgb(160, 100, 140);"></i>
        </button>

    <!-- Profile Overlay -->
    <div id="profileOverlay" class="profile-overlay">
        <div class="profile-modal">
            <button class="btn-close" onclick="closeProfile()">×</button>
            <h2>User Profile</h2>
            @if ($errors->any())
                <div style="color: red; margin-bottom: 10px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Update Form -->
            <form action="{{ route('profile.update') }}" method="POST" id="profileUpdateForm">
                @csrf
                @method('PUT')
                <label>Name:</label>
                <input type="text" name="first_name" maxlength="25" value="{{ Auth::user()->first_name }}" required>

                <label>Email:</label>
                <input type="email" name="email" maxlength="25" value="{{ Auth::user()->email }}" required>
            </form>
            <!-- Delete Form -->
            <form action="{{ route('profile.destroy') }}" method="POST" id="profileDeleteForm" style="display: inline;">
                @csrf
                @method('DELETE')
            </form>
            <!-- Combined Buttons -->
            <div class="profile-actions">
                <button type="submit" form="profileUpdateForm" class="btn-save">Save Changes</button>
                <button type="button" class="btn-delete" onclick="showDeleteConfirmModal()">Delete Account</button>
            </div>
        </div>
    </div>

        <div class="nav-links">
            <h2>FitZone</h2>
        </div>
        <!-- Logout Button with Modal Trigger -->
        @auth
        <form action="{{ route('logout') }}" method="POST" id="logoutForm" class="logout-form">
            @csrf
            <button type="button" class="logout-btn" data-bs-toggle="modal" data-bs-target="#logoutModal" title="Logout" onclick="disableThis(this)">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
        @endauth
    </div>

    <!-- Main Page Content -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content logout-modal-content">
                <div class="modal-header logout-modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="disableThis(this)"></button>
                </div>
                <div class="modal-body text-center logout-modal-body">
                    <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer justify-content-center logout-modal-footer">
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-purple" onclick="disableThis(this)">Yes, Logout</button>
                    </form>
                    <button type="button" class="btn cancel-btn" data-bs-dismiss="modal" onclick="disableThis(this)">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openProfile() {
            document.getElementById('profileOverlay').classList.remove('hidden');
            document.body.classList.add('blurred');
        }

        function closeProfile() {
            document.getElementById('profileOverlay').classList.add('hidden');
            document.body.classList.remove('blurred');
        }

        // Modified disableThis function
        function disableThis(button) {
            if (button.tagName === 'A') {
                // For anchor tags: disable and navigate
                button.classList.add('disabled');
                button.style.pointerEvents = 'none';
                button.style.opacity = '0.6';
            } else {
                // For buttons: check if it's a button that submits a form
                if (button.classList.contains('btn-delete') || button.classList.contains('btn-book') || button.classList.contains('btn-purple')) {
                    // Delay disabling to allow form submission
                    setTimeout(() => {
                        button.disabled = true;
                    }, 100); // Small delay to allow form submission
                } else {
                    // For other buttons (like cancel or modal close), disable immediately
                    button.disabled = true;
                }
            }

            // For buttons opening modals, restore them after a while (if not overridden by modal close)
            if (button.getAttribute('data-bs-toggle') === 'modal') {
                setTimeout(() => {
                    button.disabled = false;
                }, 3000); // re-enable after 3 seconds if needed
            }
        }

        // Re-enable modal buttons when the logout modal closes
        document.addEventListener('DOMContentLoaded', function () {
            const logoutModal = document.getElementById('logoutModal');
            logoutModal.addEventListener('hidden.bs.modal', function () {
                document.querySelectorAll('.logout-btn, .btn-purple, .cancel-btn, .btn-close').forEach(button => {
                    button.disabled = false;
                });
            });
        });
    </script>
</body>
</html>