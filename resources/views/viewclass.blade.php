@extends('layouts.navbar')

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
                            <div class="class-details-content">
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

        <!-- Class Details -->
        <section class="class-details">
            <h1>{{ $class->name }}</h1>
            <p class="description">
                Yoga is a physical, mental, and spiritual practice that originated in ancient India. It combines gentle physical postures (called asanas), breathing techniques (pranayama), and meditation to promote overall well-being.
            </p>

            <div class="book-box">
            <a href="{{ route('bookclass', $class->id) }}" class="btn-book">Book Now</a>
                <p><strong>Level:</strong> {{ $class->level }}</p>
                <p><strong>Duration:</strong> {{ $class->duration }} Minutes</p>
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
        cursor: pointer;
    }

    .class-header {
        font-weight: bold;
    }

    .class-details-content {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: max-height 0.4s ease, opacity 0.4s ease;
    }

    .class-details-content.open {
        max-height: 300px; /* Large enough to hold content */
        opacity: 1;
        overflow: visible;
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
                            /*DIDI nag stop */
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
        padding: 5px 10px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        margin-top: 5px;
        margin-right: 1px;
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

    /* Smooth transition for edit/view forms */
    .class-details-content .view-mode,
    .class-details-content .edit-form {
        transition: opacity 0.4s ease, transform 0.4s ease;
    }

    /* Hide with animation */
    .hidden-fade {
        opacity: 0;
        transform: translateY(-10px);
        pointer-events: none;
    }

    /* Show with animation */
    .visible-fade {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }
</style>

        <script>
        function toggleDetails(header) {
            const details = header.nextElementSibling;
            details.classList.toggle('open');
        }

        function enableEdit(button) {
            const container = button.closest('.class-details-content');
            const viewMode = container.querySelector('.view-mode');
            const editForm = container.querySelector('.edit-form');

            // Animate hiding view mode
            viewMode.classList.remove('visible-fade');
            viewMode.classList.add('hidden-fade');

            // Animate showing edit form after a short delay
            setTimeout(() => {
                viewMode.style.display = 'none';
                editForm.style.display = 'grid';
                editForm.classList.remove('hidden-fade');
                editForm.classList.add('visible-fade');
            }, 300);
        }

        function cancelEdit(button) {
            const container = button.closest('.class-details-content');
            const viewMode = container.querySelector('.view-mode');
            const editForm = container.querySelector('.edit-form');

            // Animate hiding edit form
            editForm.classList.remove('visible-fade');
            editForm.classList.add('hidden-fade');

            // Animate showing view mode after a short delay
            setTimeout(() => {
                editForm.style.display = 'none';
                viewMode.style.display = 'block';
                viewMode.classList.remove('hidden-fade');
                viewMode.classList.add('visible-fade');
            }, 300);
        }
        </script>
@endsection
