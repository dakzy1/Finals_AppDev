@extends('layouts.navbar')

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
                                <div class="view-mode visible-fade">
                                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($schedule->date)->format('F j, Y') }}</p>
                                    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($schedule->time)->format('g:i A') }}</p>
                                    <p><strong>Trainer:</strong> {{ Str::limit($schedule->trainer, 20, '...') }}</p>

                                    <form action="{{ route('bookclass.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this schedule?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn" title="Delete">
                                        <i class="fa-regular fa-trash-can" style="color: #b00020; font-size: 18px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
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
                    @php
                        $userBookedClassIds = \App\Models\Schedule::where('user_id', Auth::id())->pluck('class_id')->toArray();
                    @endphp

                    @foreach($classes as $class)
                        @php
                            $bookedCount = $class->schedules->count();
                            $limit = $class->user_limit;
                        @endphp

                        <div class="class-card">
                            <div class="class-info">
                                <h3>{{ $class->name }}</h3>
                                <p><strong>Level:</strong> {{ $class->level }}</p>
                                <p><strong>Duration:</strong> {{ $class->duration }} Minutes</p>
                                <p><strong>Trainer:</strong> {{ $class->trainer }}</p>
                                <p><strong>Bookings:</strong> {{ $bookedCount }} / {{ $limit }}</p>

                                @if ($bookedCount >= $limit)
                                    <p style="color: red;"><strong>This class is fully booked.</strong></p>
                                @endif
                            </div>

                            @if ($bookedCount >= $limit)
                                <button class="btn-book" disabled>Fully Booked</button>
                            @elseif (in_array($class->id, $userBookedClassIds))
                                <button class="btn-book" disabled>Already Booked</button>
                            @else
                                <a href="{{ route('viewclass', $class->id) }}" class="btn-book">View</a>
                            @endif

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

    .custom-container {
        max-width: 1200px;
        margin: auto;
        padding: 0;
    }

    .main-content {
        display: flex;
        align-items: flex-start; /* <--- prevents equal height */
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


    .delete-btn {
        background: transparent;
        border: none;
        cursor: pointer;

    }

    .delete-btn svg {
        transition: transform 0.2s ease;
    }

    .delete-btn:hover svg {
        transform: scale(1.2);
        fill: darkred;
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
