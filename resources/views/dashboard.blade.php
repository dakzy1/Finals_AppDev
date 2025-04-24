@extends('layouts.app')

@section('header')
    <header class="header">
        <div class="nav-content">
            <div class="avatar"></div>
            <nav class="nav-links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('dashboard') }}">Class</a>
                <a href="{{ route('about') }}">About</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </nav>
        </div>
    </header>

    <style>
        .header {
            background-color: #8A4AF3;
            padding: 15px 15px;
            display: flex;
            justify-content: center;
            width: 100%;
            margin: 0;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .nav-content {
            max-width: 1200px;
            width: 100%;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .avatar {
            width: 35px;
            height: 35px;
            background-color: #FFFFFF;
            border-radius: 50%;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-links a {
            color: #FFFFFF;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        .logout-btn {
            background-color: #FFFFFF;
            color: #8A4AF3;
            padding: 5px 15px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #F0F0F0;
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-container">
        <!-- Sidebar (Schedule) -->
        <aside class="sidebar">
            <h2 class="sidebar-title">Schedule</h2>
            <div class="schedule-items">
                @if($schedules->isEmpty())
                    <p>No schedules available.</p>
                @else
                    @foreach($schedules as $schedule)
                        <div class="schedule-item">
                            <h3>{{ $schedule->class_name }}</h3>
                            <p>{{ \Carbon\Carbon::parse($schedule->date)->format('d/m/y') }}</p>
                            <p>{{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }}</p>
                            <p>{{ $schedule->trainer }}</p>
                            <button class="edit-btn">Edit</button>
                        </div>
                    @endforeach
                @endif
            </div>
        </aside>

        <!-- Main Section (Classes) -->
        <main class="main-content">
            <h2 class="main-title">Classes</h2>
            <div class="class-cards">
                @if($classes->isEmpty())
                    <p>No classes available.</p>
                @else
                    @foreach($classes as $class)
                        <div class="class-card">
                            <div class="class-name">{{ $class->name }}</div>
                            <div class="class-details">
                                <p>Level: {{ $class->level }}</p>
                                <p>Duration: {{ $class->duration }}</p>
                                <p>Trainer: {{ $class->trainer }}</p>
                                <button class="view-btn">View</button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </main>
    </div>

    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 60px auto 20px auto; /* Adjusted for fixed header */
            display: flex;
            background-color: #F5E6F5;
            border: 2px solid #0000FF;
            border-radius: 15px;
            font-family: 'Roboto', sans-serif;
        }

        .sidebar {
            width: 20%;
            padding: 20px;
            border-right: 2px solid #0000FF;
        }

        .sidebar-title, .main-title {
            font-size: 24px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 20px;
        }

        .schedule-items {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .schedule-item {
            background-color: #FFCCCC;
            padding: 15px;
            border-radius: 10px;
        }

        .schedule-item h3 {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 5px;
        }

        .schedule-item p {
            font-size: 14px;
            margin: 5px 0;
        }

        .edit-btn {
            background-color: #D3D3D3;
            color: #333333;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .main-content {
            width: 70%;
            padding: 20px;
        }

        .class-cards {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .class-card {
            display: flex;
            background-color: #FF6666;
            border-radius: 10px;
            overflow: hidden;
        }

        .class-name {
            width: 40%;
            padding: 20px;
            font-size: 20px;
            font-weight: bold;
            color: #FFFFFF;
            display: flex;
            align-items: center;
        }

        .class-details {
            width: 60%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .class-details p {
            font-size: 14px;
            color: #FFFFFF;
            margin: 0;
        }

        .view-btn {
            background-color: #FFFFFF;
            color: #FF6666;
            padding: 5px 15px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            align-self: flex-start;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }

            .sidebar, .main-content {
                width: 100%;
            }

            .sidebar {
                border-right: none;
                border-bottom: 2px solid #0000FF;
            }
        }
    </style>
@endsection