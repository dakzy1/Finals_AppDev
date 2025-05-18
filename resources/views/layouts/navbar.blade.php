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
            justify-content: space-between;
            margin-top: 20px;
        }
        .btn-save {
            background-color: #9c27b0;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-delete {
            background-color: #f44336;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
        }
        .btn-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: transparent;
            border: none;
            font-size: 1.5rem;
            color: #666;
            cursor: pointer;
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

        .btn-purple:hover {
            background-color: #5a6268;
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

        .cancel-btn:hover {
            background-color: #5a6268;
        }

        /* Optional: Close button in top right corner */
        .logout-modal-header .btn-close {
            position: absolute;
            right: 15px;
            top: 15px;
            color: white;
            font-size: 1.25rem;
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
        <div id="profileOverlay" class="profile-overlay hidden">
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
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label>Name:</label>
                    <input type="text" name="first_name" maxlength="25" value="{{ Auth::user()->first_name }}" required>

                    <label>Email:</label>
                    <input type="email" name="email" maxlength="25" value="{{ Auth::user()->email }}" required>

                    <div class="profile-actions">
                        <button type="submit" class="btn-save">Save</button>
                        <form action="{{ route('profile.destroy') }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete your account?');"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Delete Account</button>
                        </form>
                    </div>
                </form>
                <button onclick="closeProfile()" class="btn-close">×</button>
            </div>
        </div>

        <div class="nav-links">
            <h2>FitZone</h2>
        </div>
        <!-- Logout Button with Modal Trigger -->
        @auth
        <form action="{{ route('logout') }}" method="POST" id="logoutForm" class="logout-form">
            @csrf
            <button type="button" class="logout-btn" data-bs-toggle="modal" data-bs-target="#logoutModal" title="Logout">
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
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>Are you sure you want to logout?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-purple">Yes, Logout</button>
                </form>
                <button type="button" class="btn btn-light cancel-btn" data-bs-dismiss="modal">Cancel</button>
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
    </script>
</body>
</html>