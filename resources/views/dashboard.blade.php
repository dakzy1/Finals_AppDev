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
                        <div class="class-box" data-schedule-id="{{ $schedule->id }}">
                            <div class="class-header" onclick="toggleDetails(this)">
                                <h4>{{ $schedule->fitnessClass->name }}</h4>
                            </div>
                            <div class="class-details-content" style="display: none;">
                                {{-- View mode --}}
                                <div class="view-mode">
                                    <p><strong>Date:</strong> <span class="view-date">{{ \Carbon\Carbon::parse($schedule->date)->format('Y-m-d') }}</span></p>
                                    <p><strong>Time:</strong> <span class="view-time">{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}</span></p>
                                    <p><strong>Trainer:</strong> <span class="view-trainer">{{ $schedule->trainer }}</span></p>
                                    <button class="edit-btn" onclick="enableEdit(this)">Edit</button>
                                </div>

                                {{-- Edit mode --}}
                                <form class="edit-form" action="{{ route('bookclass.update', $schedule->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('PUT')
                                    <label for="date-{{ $schedule->id }}">Date:</label>
                                    <input type="date" name="date" id="date-{{ $schedule->id }}" value="{{ \Carbon\Carbon::parse($schedule->date)->format('Y-m-d') }}" required>

                                    <label for="time-{{ $schedule->id }}">Time:</label>
                                    <input type="time" name="time" id="time-{{ $schedule->id }}" value="{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}" required>

                                    <label for="trainer-{{ $schedule->id }}">Trainer:</label>
                                    <input type="text" name="trainer" id="trainer-{{ $schedule->id }}" value="{{ $schedule->trainer }}" required>

                                    <button type="submit" class="save-btn">Save</button>
                                    <button type="button" class="cancel-btn" onclick="cancelEdit(this)">Cancel</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </aside>

<script>
    function toggleDetails(header) {
        const details = header.nextElementSibling;
        details.style.display = details.style.display === 'none' ? 'block' : 'none';
    }

    function enableEdit(button) {
        const container = button.closest('.class-details-content');
        container.querySelector('.view-mode').style.display = 'none';
        container.querySelector('.edit-form').style.display = 'block';
    }

    function cancelEdit(button) {
        const container = button.closest('.class-details-content');
        container.querySelector('.edit-form').style.display = 'none';
        container.querySelector('.view-mode').style.display = 'block';
    }
</script>

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

<!-- ✅ Styles and Script placed properly inside the same file -->
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
    cursor: pointer;
}

.class-header {
    font-weight: bold;
}

.class-details-content {
    margin-top: 10px;
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

.edit-form {
    margin-top: 15px;
    display: grid;
    grid-template-columns: 100px 1fr;
    row-gap: 10px;
    column-gap: 10px;
    align-items: center;
    
}

.edit-form label {
    font-weight: bold;
    color: #fff;
    
}

.edit-form input[type="date"],
.edit-form input[type="time"],
.edit-form input[type="text"] {
    padding: 8px;
    border-radius: 6px;
    border: none;
    background-color: #f7d9eb;
    color: #333;
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    width: 100%;
    box-sizing: border-box;
}

.save-btn,
.cancel-btn {
    grid-column: span 2;
    padding: 8px 8px;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
    margin-top: 5px;
    margin-right: 8px;
    width: 70px;
}

.save-btn {
    background-color: #fff;
    color: #a84f61;
}

.cancel-btn {
    background-color: transparent;
    color: #fff;
    border: 2px solid #fff;
}

</style>

<script>
function toggleDetails(header) {
    const details = header.nextElementSibling;
    if (details.style.display === "none" || details.style.display === "") {
        details.style.display = "block";
    } else {
        details.style.display = "none";
    }
}
</script>
@endsection
