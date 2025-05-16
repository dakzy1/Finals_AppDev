@extends('layouts.navbar')

@section('content')
<div class="custom-container">
    <a href="{{ route('dashboard') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Go Back
    </a>
    <div class="main-content">
        <!-- Sidebar (Schedule) -->
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

        <!-- Class Details -->
        <section class="class-details">
            <h1>{{ $class->name }}</h1>
            <div class="description" style="white-space: normal; word-wrap: break-word; line-height: 1.6;">
                {!! $class->description !!}
            </div>

            <div class="book-box">
                <a href="{{ route('bookclass', $class->id) }}" class="btn-book">Book Now</a>
                <p><strong>Level:</strong> {{ $class->level }}</p>
                <p><strong>Duration:</strong> {{ $class->duration }} Minutes</p>
                <p><strong>Trainer:</strong> {{ $class->trainer }}</p>
            </div>

            <h3>Key Benefits of {{ $class->name }}:</h3>
            @if(Str::contains($class->key_benefits, "\n"))
                <ul class="benefits" style="white-space: normal; word-wrap: break-word; line-height: 1.6;">
                    @foreach(explode("\n", $class->key_benefits) as $benefit)
                        @if(trim($benefit) !== '')
                            <li>{{ ltrim($benefit, '-• ') }}</li>
                        @endif
                    @endforeach
                </ul>
            @else
                <ul class="benefits" style="white-space: normal; word-wrap: break-word; line-height: 1.6;">
                    {!! $class->key_benefits !!}
                </ul>
            @endif
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

    .custom-container {
        max-width: 1300px;
        margin: auto;
        padding: 0;
    }

    .back-btn {
        position: fixed;
        top: 62px;
        left: 35px;
        background-color: #d87384;
        color: white;
        padding: 8px 14px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        z-index: 1000;
    }

    .back-btn:hover {
        background-color: #c05c6e;
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
        max-width: 259px;
        background-color: #ffffff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        flex-shrink: 0;
        margin-left: 23px;
        margin-top: 230px;

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
        margin-left: 140px;
        padding: 0;
        transition: transform 0.3s, color 0.3s;
    }

    .delete-btn:hover i {
        transform: scale(1.2);
        color: darkred;
    }

    .class-details {
        flex: 1;
        max-width: 850px;
        margin-right: 25px;
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

    @media (max-width: 768px) {
        .main-content {
            flex-direction: column;
            padding: 20px;
        }

        .sidebar {
            max-width: 100%;
        }

        .class-details {
            max-width: 100%;
        }
    }
</style>

<script>
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
</script>
@endsection