@extends('layouts.app')

@section('header')
<header class="top-nav">
    <div class="nav-links">
        <a href="{{ route('landingpage') }}" class="nav-link">Home</a>
        <a href="{{ route('dashboard') }}" class="nav-link active">Class</a>
        <a href="{{ route('about') }}" class="nav-link">About</a>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</header>
@endsection

@section('content')
<div class="custom-container">
    <div class="main-content">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Schedule</h2>
            <div class="schedule-items">
                @if (session('success'))
                    <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
                @endif
                @if($schedules->isEmpty())
                    <p>No schedules booked yet.</p>
                @else
                    @foreach($schedules as $schedule)
                        <div class="class-box">
                            <h4>{{ $schedule->fitnessClass->name }}</h4>
                            <p>{{ \Carbon\Carbon::parse($schedule->date)->format('m/d/y') }}</p>
                            <p>{{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }}</p>
                            <p>{{ $schedule->trainer }}</p>
                            <button class="edit-btn">Edit</button>
                        </div>
                    @endforeach
                @endif
            </div>
        </aside>

        <!-- Classes Section -->
        <section class="class-details">
            <h2>Classes</h2>
            <div class="class-cards">
                @if($classes->isEmpty())
                    <p>No classes available.</p>
                @else
                    @foreach($classes as $class)
                    <div class="class-card">
                        <div class="class-info">
                            <h3>{{ $class->name }}</h3>
                            <p><strong>Level:</strong> {{ $class->level }}</p>
                            <p><strong>Duration:</strong> {{ $class->duration }}</p>
                            <p><strong>Trainer:</strong> {{ $class->trainer }}</p>
                        </div>
                        <a href="{{ route('viewclass', $class->id) }}" class="btn-book">View</a>
                    </div>
                    @endforeach
                @endif
            </div>
        </section>
    </div>
</div>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f5eaf3;
    margin: 0;
    padding: 0;
}

.top-nav {
    background-color: #834c71;
    padding: 15px;
    text-align: center;
}

.nav-links {
    display: flex;
    justify-content: center;
    gap: 30px;
}

.nav-link {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    font-size: 1rem;
}

.nav-link.active {
    text-decoration: underline;
}

.logout-btn {
    background-color: #fff;
    color: #834c71;
    padding: 5px 15px;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
}

.custom-container {
    max-width: 1200px;
    margin: auto;
    padding: 0;
}

.main-content {
    display: flex;
    gap: 20px;
    padding: 40px;
}

.sidebar {
    width: 25%;
    background-color: #fff;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.class-box {
    background-color: #d87384;
    color: white;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
}

.edit-btn {
    margin-top: 10px;
    background-color: #a84f61;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
}

.secondary-class-btn {
    margin-top: 15px;
    background-color: #d87384;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 15px;
    width: 100%;
    font-weight: bold;
    cursor: pointer;
}

.class-details {
    width: 75%;
    background-color: #f7d9eb;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}

.class-cards {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.class-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #d87384;
    padding: 20px;
    border-radius: 12px;
    color: white;
}

.class-info h3 {
    margin-bottom: 10px;
    font-size: 1.25rem;
}

.class-info p {
    margin: 3px 0;
    font-size: 0.95rem;
}

.btn-book {
    background-color: #fff;
    color: #d87384;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s;
}

.btn-book:hover {
    background-color: #f0f0f0;
}
</style>
@endsection
