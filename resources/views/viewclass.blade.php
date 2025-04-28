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
            @if($schedules->isEmpty())
                <p>No schedules booked for this class yet.</p>
            @else
                @foreach($schedules as $schedule)
                    <div class="class-box">
                        <h4>{{ $schedule->fitnessClass->name }}</h4>
                        <p>{{ \Carbon\Carbon::parse($schedule->date)->format('m/d/y') }}</p>
                        <p>{{ \Carbon\Carbon::createFromFormat('H:i:s', $schedule->time)->format('h:i A') }}</p>
                        <p>{{ $schedule->trainer }}</p>
                        <button class="edit-btn">Edit</button>
                    </div>
                @endforeach
            @endif
        </aside>

        <!-- Class Details -->
        <section class="class-details">
            <h1>{{ $class->name }}</h1>
            <p class="description">
                Yoga is a physical, mental, and spiritual practice that originated in ancient India. It combines gentle physical postures (called asanas), breathing techniques (pranayama), and meditation to promote overall well-being.
            </p>

            <div class="book-box">
            <a href="{{ route('bookclass', $class->id) }}" class="btn-book">Book Now</a>
                <p><strong>Level:</strong> {{ $class->level }}</p>
                <p><strong>Duration:</strong> {{ $class->duration }}</p>
                <p><strong>Trainer:</strong> {{ $class->trainer }}</p>
            </div>

            <h3>Key Benefits of Yoga:</h3>
            <ul class="benefits">
                <li>Increases flexibility and strength</li>
                <li>Improves posture and balance</li>
                <li>Reduces stress and anxiety</li>
                <li>Enhances focus, mindfulness, and relaxation</li>
                <li>Supports respiratory and cardiovascular health</li>
            </ul>
        </section>
    </div>
</div>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f5eaf3;
    margin: 0;
    padding: 0;
    height: 100vh;
}

.top-nav {
    background-color: #834c71;
    padding: 15px;
    text-align: center;
}

.nav-links {
    display: flex;
    justify-content: center;
    align-items: center;
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
    min-height: calc(100vh - 80px);
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

.class-details h1 {
    color: #4c305f;
    margin-bottom: 15px;
}

.description {
    color: #333;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 20px;
}

.book-box {
    padding: 10px 0;
    margin-bottom: 30px;
    border-left: 2px solid #4c305f;
    padding-left: 20px;
}

.btn-book {
    display: inline-block;
    background-color: #d87384;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    margin-bottom: 10px;
}

.benefits {
    list-style-type: disc;
    padding-left: 20px;
}

.benefits li {
    margin-bottom: 8px;
    color: #4c305f;
}
</style>
@endsection
