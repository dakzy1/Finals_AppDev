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
            width: 35px;
            height: 35px;
            background-color: #fff;
            border-radius: 50%;
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
        <div class="avatar"></div>
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

</body>
</html>
