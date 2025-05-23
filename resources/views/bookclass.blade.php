@extends('layouts.navbar')

@section('content')
<div class="container">
    <a href="{{ route('viewclass', $class->id) }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Go Back
    </a>
    <div class="left-panel">
        <div class="class-details">
            <h2>{{ $class->name }}</h2>
            <p><strong>Duration:</strong> {{ $class->duration }} Minutes</p>
            <p><strong>Difficulty:</strong> {{ $class->level }}</p>
            <p><strong>Instructor Available Time:</strong> {{ \Carbon\Carbon::parse($class->time)->format('g:i A') }} to {{ \Carbon\Carbon::parse($class->end_time)->format('g:i A') }}</p>
        </div>
        
        <form class="booking-form" method="POST" action="{{ route('bookclass.store', $class->id) }}" style="display: flex; flex-direction: column; height: 100%;">
            @csrf
            <label for="trainer">Trainer:</label>
            <select id="trainer" name="trainer" required>
                <option value="{{ $class->trainer }}" selected>{{ $class->trainer }}</option>
            </select>

            @php
                $availableStart = \Carbon\Carbon::parse($class->time);
                $availableEnd = \Carbon\Carbon::parse($class->end_time);

                $timeOptions = [
                    '06:00:00' => '06:00 AM',
                    '07:00:00' => '07:00 AM',
                    '08:00:00' => '08:00 AM',
                    '09:00:00' => '09:00 AM',
                    '10:00:00' => '10:00 AM',
                    '11:00:00' => '11:00 AM',
                    '13:00:00' => '01:00 PM',
                    '14:00:00' => '02:00 PM',
                    '15:00:00' => '03:00 PM',
                    '16:00:00' => '04:00 PM',
                    '17:00:00' => '05:00 PM',
                    '18:00:00' => '06:00 PM',
                ];
            @endphp

            <label for="time">Select Time:</label>
            <select id="time" name="time" required>
                @foreach ($timeOptions as $value => $label)
                    @php
                        $optionTime = \Carbon\Carbon::createFromTimeString($value);
                        $isAvailable = $optionTime->between($availableStart, $availableEnd);
                    @endphp
                    <option value="{{ $value }}"
                        {{ $class->time == $value ? 'selected' : '' }}
                        {{ !$isAvailable ? 'disabled' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            <div style="position: relative; display: flex; align-items: center;">
                <input type="hidden" id="date" name="date" 
                    value="{{ old('date', now()->format('Y-m-d')) }}" 
                    readonly required 
                    style="padding-right: 30px; background-color: #f9f9f9; font-weight: bold; font-size: 16px; border: none; cursor: pointer;" />
                <span style="position: absolute; right: 10px; pointer-events: none;">
                </span>
            </div>

            @error('time')
                <div class="error">{{ $message }}</div>
            @enderror
            @error('date')
                <div class="error">{{ $message }}</div>
            @enderror

            @if (isset($warningMessage))
                <p style="color: red;">{{ $warningMessage }}</p>
            @endif

            <div style="margin-top: auto;">
                <button type="submit" class="btn-book" onclick="disableThis(this)">Book Now</button>
            </div>
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

<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #f5eaf3;
        font-family: sans-serif;
        overflow: hidden;
    }

    .container {
        display: flex;
        max-width: 1200px;
        width: 100%;
        margin: 30px auto;
        height: 550px;
        padding: 20px;
        gap: 20px;
        box-sizing: border-box;
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

    .btn-book:disabled {
        opacity: 0.6;
        cursor: not-allowed;
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
        height: 300px;
        flex-grow: 0;
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

<script>
    function disableThis(button) {
        if (button.tagName === 'A') {
            // For anchor tags: disable and navigate
            button.classList.add('disabled');
            button.style.pointerEvents = 'none';
            button.style.opacity = '0.6';
        } else {
            // For buttons: check if it's the delete or book button in the form
            if (button.classList.contains('btn-delete') || button.classList.contains('btn-book')) {
                // Delay disabling to allow form submission
                setTimeout(() => {
                    button.disabled = true;
                }, 100); // Small delay to allow form submission
            } else {
                // For other buttons, disable immediately
                button.disabled = true;
            }
        }

        // For buttons opening modals, restore them after a while (if not overridden by modal close)
        if (button.getAttribute('data-bs-toggle') === 'modal') {
            setTimeout(() => {
                button.disabled = false;
            }, 3000); // re-enable after 3 seconds if needed
        }
    }

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

        for (let day = 1; day <= daysInMonth; day++) {
            const dayCell = document.createElement('div');
            dayCell.classList.add('day');
            dayCell.textContent = day;

            const today = new Date();
            const dateToCompare = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);

            // Remove the time part for fair comparison
            today.setHours(0, 0, 0, 0);
            dateToCompare.setHours(0, 0, 0, 0);

            if (dateToCompare < today) {
                dayCell.classList.add('disabled');
                // Do not add click event for past dates
            } else {
                dayCell.addEventListener('click', function () {
                    selectDate(day);
                    document.querySelectorAll('.day').forEach(d => d.classList.remove('selected'));
                    dayCell.classList.add('selected');
                });
            }

            // Highlight today
            if (
                day === today.getDate() &&
                currentDate.getMonth() === today.getMonth() &&
                currentDate.getFullYear() === today.getFullYear()
            ) {
                dayCell.classList.add('selected');
            }

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