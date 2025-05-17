@extends('layouts.navbar')

@section('content')
<div class="custom-container">
    <div class="main-content">
        <!-- Left Column: Welcome + Sidebar -->
        <div class="left-column">
            <!-- Redesigned Welcome Section -->
            <div class="welcome-section">
                <div class="welcome-card">
                    <div class="welcome-header">
                        <h1>Welcome to FitZone{{ Auth::check() ? ', ' . Str::limit(Auth::user()->first_name, 10) : '' }} </h1>
                    </div>

                    <div class="schedule-box upcoming-schedule-box">
                        <div>
                            <small class="label">Upcoming Class</small>
                            @if ($upcomingSchedule)
                                <h3>{{ $upcomingSchedule->fitnessClass->name }}</h3>
                                <small>
                                    {{ \Carbon\Carbon::parse($upcomingSchedule->date)->format('F j') }},
                                    {{ \Carbon\Carbon::parse($upcomingSchedule->time)->format('g:i A') }}
                                </small>
                            @else
                                <h3>No Upcoming Class</h3>
                                <small>Please book a class!</small>
                            @endif
                        </div>
                        <i class="fa-solid fa-calendar-days calendar-icon"></i>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="sidebar">
                <h2>Schedule</h2>
                <div class="schedule-items">
                    @if (session('success'))
                        <div class="success-message">{{ session('success') }}</div>
                    @endif

                    @if($schedules->isEmpty())
                        <p>No schedules booked yet.</p>
                    @else
                        @foreach($schedules as $schedule)
                            <div class="schedule-box" data-schedule-id="{{ $schedule->id }}">
                                <div class="schedule-header" onclick="toggleDetails(this)">
                                    <h4>{{ e($schedule->fitnessClass->name) }}</h4>
                                </div>
                                <div class="schedule-details-content">
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
        </div>

        <!-- Classes Section -->
        <section class="class-details">
            <h2>Classes</h2>
            <label for="classFilter"><strong>Filter by Class:</strong></label>
            <select id="classFilter">
                <option value="all">All Classes</option>
                @foreach($classes->unique('name') as $class)
                    <option value="{{ e($class->name) }}">{{ e($class->name) }}</option>
                @endforeach
            </select>

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
                            $isBooked = in_array($class->id, $userBookedClassIds);
                            $isFull = $bookedCount >= $limit;
                        @endphp

                        <div class="class-card">
                            <div class="class-info">
                                <h3 class="class-name"> {{ e($class->name) }}</h3>
                                <p><strong>Level:</strong> {{ e($class->level) }}</p>
                                <p><strong>Duration:</strong> {{ e($class->duration) }} Minutes</p>
                                <p><strong>Trainer:</strong> {{ e($class->trainer) }}</p>
                                <p><strong>Bookings:</strong> {{ $bookedCount }} / {{ $limit }}</p>
                            </div>

                            @if ($isFull)
                                <button class="btn-full" disabled>Fully Booked</button>
                            @elseif ($isBooked)
                                <button class="btn-booked" disabled>Already Booked</button>
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

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f5eaf3;
        margin: 0;
    }

    .custom-container {
        max-width: 1300px;
        margin: auto;
        padding: 0;
        margin: 0;
    }

    .left-column {
        margin-left: 50px;
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 259px;
        flex-shrink: 0;
    }

   .welcome-section {
        text-align: center;
        width: 1000px;
        max-width: 300px;
        margin-bottom: 20px;
    }

    .welcome-card {
        background: linear-gradient(to right, #fdeff4, #f9c5d1);
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .welcome-header {
        text-align: center;
        color: #834c71;
    }

    .welcome-header i {
        font-size: 30px;
        margin-bottom: 0px;
    }

    .welcome-header h1 {
        font-size: 1.8rem;
        margin-bottom: 30px;
    }

    .upcoming-schedule-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding: 15px;
        background-color: #fff;
        border-left: 6px solid #d87384;
    }

    .calendar-icon {
        font-size: 30px;
        color: #d87384;
        margin-left: 10px;
    }

    .label {
        font-weight: bold;
        color: #d87384;
        font-size: 0.9rem;
    }

    .main-content {
        display: flex;
        gap: 80px;
        padding: 20px 10px;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: flex-start;
    }

    .sidebar {
        width: 100%;
        background-color: #ffffff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
    }

    .sidebar h2 {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: #d87384;
        position: sticky;
        top: 0;
        background-color: #ffffff;
        z-index: 1;
        padding-bottom: 5px;
    }

    .sidebar h4 {
        font-size: 1.0rem;
        margin-bottom: 15px;
        color: #d87384;
    }

    .schedule-items {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-height: 240px; /* Approx height for 3 schedule boxes */
        overflow-y: auto;
        padding-right: 5px;
    }
    .schedule-items::-webkit-scrollbar {
        width: 6px;
    }

    .schedule-items::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .schedule-items::-webkit-scrollbar-thumb {
        background: #d87384;
        border-radius: 10px;
    }

    .schedule-items::-webkit-scrollbar-thumb:hover {
        background: #c05c6e;
    }

    .schedule-box {
        background-color: #fef1f4;
        color: #333;
        padding: 3px 10px;
        border-left: 6px solid #d87384;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        cursor: pointer;
        transition: transform 0.2s ease;
        margin-bottom: 5px;
    }

    .schedule-box:hover {
        transform: translateY(-3px);
    }

    .schedule-details-content {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: max-height 0.4s ease, opacity 0.4s ease;
        padding: 0;
        margin: 0;
    }

    .schedule-details-content.open {
        max-height: 300px;
        opacity: 1;
    }

    .view-mode {
        padding: 0;
        margin: 0;
        line-height: 1;
    }
    .view-mode p {
        font-size: 0.8rem;
        margin: 0;
        padding: 0;
    }

    .delete-btn {
        background: transparent;
        border: none;
        cursor: pointer;
        margin-top: 5px;
        margin-left: 200px;
        padding: 0;
        transition: transform 0.3s, color 0.3s;
    }

    .delete-btn:hover i {
        transform: scale(1.2);
        color: darkred;
    }

    .class-details {
        width: 100%; 
        max-width: 850px; 
        margin-left: 40px;
        flex: 1;
        background-color: #f7d9eb;
        padding: 15px 40px 10px 40px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        flex-grow: 1;
    }
    
    .class-details h2 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: #7a3558;
    }

    #classFilter {
        padding: 5px 10px;
        margin: 10px 0 20px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .class-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }
    .class-card {
        background-color: #fff;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.07);
        transition: transform 0.2s;
    }
    .class-card:hover {
        transform: translateY(-5px);
    }

    .class-info {
        margin-bottom: 10px;
    }

    .class-info h3 {
        color: #d87384;
        margin: 0 0 10px;
    }

    .class-info p {
        font-size: 0.9rem;
        margin: 3px 0;
    }
    .btn-book,
    .btn-booked,
    .btn-full {
        display: inline-block;
        padding: 8px 16px;
        font-size: 0.9rem;
        border-radius: 8px;
        text-decoration: none;
        text-align: center;
        transition: background-color 0.3s, transform 0.2s;
    }
    .btn-book {
        background-color: #d87384;
        color: white;
    }
    .btn-book:hover {
        background-color: #c05c6f;
        transform: scale(1.03);
    }
    .btn-booked {
        background-color: #ffe5ec;
        color: #d87384;
        cursor: not-allowed;
    }
    .btn-full {
        background-color: #f5c6cb;
        color: #721c24;
        cursor: not-allowed;
    }

    .success-message {
        background-color: #e6f4ea; /* Light green background */
        color: #2e7d32; /* Dark green text */
        padding: 8px 12px;
        border-radius: 8px;
        border-left: 4px solid #4caf50; /* Green border for emphasis */
        margin-bottom: 10px;
        font-size: 0.9rem;
        opacity: 1;
        transition: opacity 1s ease;
    }
    .success-message.fade-out {
        opacity: 0;
    }
    #classFilter {
        width: 100%;
        margin-bottom: 15px;
        padding: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    @media (max-width: 768px) {
        .main-content {
            flex-direction: column;
            padding: 20px;
        }

        .left-column {
            max-width: 100%;
        }

        .sidebar {
            width: 100%;
        }

        .class-details {
            padding-left: 0;
            margin-left: 0;
        }

        .class-card {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<script>
    function toggleDetails(headerElement) {
        const content = headerElement.nextElementSibling;
        content.classList.toggle('open');
    }
    function toggleDetails(header) {
        const details = header.nextElementSibling;
        const allDetails = document.querySelectorAll('.schedule-details-content');
        
        // Close all other open details
        allDetails.forEach(item => {
            if (item !== details && item.classList.contains('open')) {
                item.classList.remove('open');
            }
        });
        
        // Toggle the clicked details
        details.classList.toggle('open');
    }
    document.addEventListener('DOMContentLoaded', function () {
    const successMessage = document.querySelector('.success-message');
    if (successMessage) {
        setTimeout(() => {
            successMessage.classList.add('fade-out');
            setTimeout(() => {
                successMessage.remove();
            }, 1000);
        }, 5000);
    }
});
    document.getElementById('classFilter').addEventListener('change', function () {
        const selected = this.value.toLowerCase();
        const cards = document.querySelectorAll('.class-card');

        cards.forEach(card => {
            const name = card.querySelector('.class-name').textContent.toLowerCase();
            card.style.display = (selected === 'all' || name.includes(selected)) ? '' : 'none';
        });
    });
</script>
@endsection