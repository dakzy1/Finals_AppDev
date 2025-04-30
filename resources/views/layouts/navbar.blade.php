<!-- resources/views/layout.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'FitZone')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        /* Global styles */
        html {
        overflow-y: scroll; /* Prevents layout shift when pages have no scroll */
        }
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
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
            display: flex;
            gap: 30px;
            position: relative;
        }

        .nav-links a {
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            position: relative;
            padding: 8px 16px;
            border-radius: 20px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .nav-links a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .nav-links a.active {
            background-color: #fff;
            color: #834c71;
            text-decoration: none;
        }

        /* Optional: subtle shadow when active */
        .nav-links a.active:hover {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
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

        .container {
            margin-top: 30px; /* Adjust as needed depending on your header height */
            padding: 20px 10px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

    <!-- Fixed Header -->
    <div class="header">
        <button onclick="openProfile()" class="avatar" title="Profile">
        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Profile" style="width: 40px; height: 40px; border-radius: 30%;">
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
                        <a href="{{ route('profile.destroy') }}" class="btn-delete"
                        onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</a>
                    </div>
                </form>
                <button onclick="closeProfile()" class="btn-close">&times;</button>
            </div>
        </div>


        <div class="nav-links">
            <a href="{{ url('/landingpage') }}" class="{{ Request::is('/landingpage') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">Class</a>
            <a href="{{ url('/about') }}" class="{{ Request::is('about') ? 'active' : '' }}">About</a>
        </div>
    <!-- Logout Button -->
        @auth
        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
        @endauth
    </div>

    <!-- Main Page Content -->
    <div class="container">
        @yield('content')
    </div>

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
