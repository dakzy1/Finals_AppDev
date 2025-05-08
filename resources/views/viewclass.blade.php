@extends('layouts.navbar')

@section('content')
<div class="custom-container">
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
                        <div class="class-box" data-schedule-id="{{ $schedule->id }}">
                            <div class="class-header" onclick="toggleDetails(this)">
                                <h4>{{ $schedule->fitnessClass->name }}</h4>
                            </div>
                            <div class="class-details-content">
                                <div class="view-mode visible-fade">
                                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($schedule->date)->format('Y-m-d') }}</p>
                                    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}</p>
                                    <p><strong>Trainer:</strong> {{ $schedule->trainer }}</p>

                                    <form action="{{ route('bookclass.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this schedule?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" viewBox="0 0 24 24">
                                                <path d="M9 3v1H4v2h1v14c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V6h1V4h-5V3H9zm0 4h6v12H9V7z"/>
                                            </svg>
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
        height: 100vh;
    }

    .custom-container {
        max-width: 1200px;
        margin: auto;
        padding: 0;
    }

    .main-content {
        display: flex;
        align-items: flex-start; /* <-- Key difference! */
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
