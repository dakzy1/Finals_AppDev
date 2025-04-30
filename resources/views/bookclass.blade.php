@extends('layouts.navbar') 

@section('title', 'Book Class')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #fce4ec;
        font-family: sans-serif;
        overflow: hidden;
    }

    .container {
        display: flex;
        height: calc(100vh - 60px); /* Full height minus navbar */
        width: 100%;
        bottom: 20px;
        padding: 10px 15px;
        box-sizing: border-box;
        gap: 20px;
    }

    .left-panel, .right-panel {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .right-panel {
        background-color: #f8f8f8;
    }

    .class-details h2 {
        color: #9c27b0;
        margin-bottom: 10px;
    }

    .class-details p {
        margin: 5px 0;
    }

    .booking-form label {
        display: block;
        margin: 10px 0 5px;
        font-weight: bold;
    }

    .booking-form input, .booking-form select {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btn-book {
        background-color: #f06292;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        display: block;
        margin-top: auto;
        align-self: center;
    }

    .calendar-header {
        background-color: #f48fb1;
        padding: 15px 10px;
        text-align: center;
        border-radius: 10px 10px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .calendar-header h2 {
        margin: 0;
        color: #fff;
        font-weight: bold;
        font-size: 1.5rem;
        flex-grow: 1;
    }

    .calendar-header button {
        background-color: #d87384;
        border: none;
        padding: 8px 12px;
        color: white;
        font-weight: bold;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1rem;
        margin: 0 5px;
        transition: background-color 0.3s;
    }

    .calendar-header button:hover {
        background-color: #c75b6c;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        padding: 15px;
        background-color: #f5f5f5;
        border-radius: 0 0 10px 10px;
        flex-grow: 1;
    }

    .calendar-grid div {
        text-align: center;
        background-color: #e0e0e0;
        border-radius: 10px;
        font-weight: bold;
        color: #555;
        transition: background-color 0.3s, transform 0.2s;
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        padding: 5px 5px;
        margin-top: 0px;
    }

    .calendar-grid .day:hover {
        background-color: #d1d1d1;
        transform: scale(1.05);
        cursor: pointer;
    }

    .calendar-grid .selected {
        background-color: #f44336;
        color: white;
        border-radius: 50%;
        transform: scale(1.1);
    }

    .calendar-grid .day-header {
        background-color: transparent;
        color: #9c27b0;
        font-weight: bold;
        padding: 0px 10px;
    }

    #date {
        background-color: #f9f9f9;
        border: none;
        font-weight: bold;
        font-size: 16px;
        cursor: default;
    }
</style>

<div class="container">
    <div class="left-panel">
        <div class="class-details">
            <h2>{{ $class->name }}</h2>
            <p><strong>Duration:</strong> {{ $class->duration }} Minutes</p>
            <p><strong>Difficulty:</strong> {{ $class->level }}</p>
            <p><strong>Location:</strong> {{ $class->location ?? 'Not specified' }}</p>
        </div>

        <form class="booking-form" method="POST" action="{{ route('bookclass.store', $class->id) }}">
            @csrf
            <label for="trainer">Trainer:</label>
            <select id="trainer" name="trainer">
                <option value="Tomanda">Tomanda</option>
            </select>

            <label for="time">Select Time:</label>
            <select id="time" name="time" required>
                <option value="08:00 AM" {{ old('time') == '08:00 AM' ? 'selected' : '' }}>08:00 AM</option>
                <option value="10:00 AM" {{ old('time') == '10:00 AM' ? 'selected' : '' }}>10:00 AM</option>
                <option value="01:00 PM" {{ old('time') == '01:00 PM' ? 'selected' : '' }}>01:00 PM</option>
            </select>
            @error('time')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="date">Select Date:</label>
            <input type="date" id="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" required readonly style="pointer-events: none;">
            @error('date')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit" class="btn-book">Book Now</button>
        </form>
    </div>

    <div class="right-panel">
        <div class="calendar-header">
            <button onclick="changeMonth(-1)">❮</button>
            <h2 id="monthYear"></h2>
            <button onclick="changeMonth(1)">❯</button>
        </div>
        <div class="calendar-grid" id="calendarGrid"></div>
    </div>
</div>

<script>
    let currentDate = new Date();
    const monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    function renderCalendar() {
        const monthYear = document.getElementById('monthYear');
        const calendarGrid = document.getElementById('calendarGrid');
        calendarGrid.innerHTML = '';

        monthYear.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

        const daysOfWeek = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
        for (let day of daysOfWeek) {
            const dayHeader = document.createElement('div');
            dayHeader.classList.add('day-header');
            dayHeader.textContent = day;
            calendarGrid.appendChild(dayHeader);
        }

        const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
        const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.classList.add('empty');
            calendarGrid.appendChild(emptyCell);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayCell = document.createElement('div');
            dayCell.classList.add('day');
            dayCell.textContent = day;

            const today = new Date();
            if (
                day === today.getDate() &&
                currentDate.getMonth() === today.getMonth() &&
                currentDate.getFullYear() === today.getFullYear()
            ) {
                dayCell.classList.add('selected');
            }

            dayCell.addEventListener('click', function () {
                selectDate(day);
                document.querySelectorAll('.day').forEach(d => d.classList.remove('selected'));
                dayCell.classList.add('selected');
            });

            calendarGrid.appendChild(dayCell);
        }
    }

    function selectDate(day) {
        const selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
        const year = selectedDate.getFullYear();
        const month = String(selectedDate.getMonth() + 1).padStart(2, '0');
        const date = String(selectedDate.getDate()).padStart(2, '0');
        const formattedDate = `${year}-${month}-${date}`;
        document.getElementById('date').value = formattedDate;
    }

    function changeMonth(offset) {
        currentDate.setMonth(currentDate.getMonth() + offset);
        renderCalendar();
    }

    renderCalendar();
</script>
@endsection
