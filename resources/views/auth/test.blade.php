<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/exercise-weight-icon-6.png') }}" type="image/x-icon">
    <title>Book Class</title>
    <style>
        body {
            background-color: #fce4ec;
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #9c27b0;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }
        .container {
            display: flex;
            padding: 20px;
            gap: 20px;
        }
        .left-panel, .right-panel {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .left-panel {
            flex: 1;
        }
        .right-panel {
            flex: 1;
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
        .btn-delete {
            background-color: #f44336;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-add {
            background-color: #9c27b0;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-book {
            background-color: #f06292;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 20px auto 0;
        }
        .calendar-header {
            background-color: #f48fb1;
            padding: 10px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .calendar-header h2 {
            margin: 0;
            color: #fff;
            font-weight: bold;
        }
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            padding: 10px;
            background-color: #f5f5f5;
        }
        .calendar-grid div {
            text-align: center;
            padding: 10px;
            background-color: #e0e0e0;
            border-radius: 5px;
        }
        .calendar-grid .selected {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="{{ route('landingpage') }}">Home</a>
            <a href="{{ route('dashboard') }}">Class</a>
            <a href="{{ route('about') }}">About</a>
        </div>
    </div>
    <div class="container">
        <div class="left-panel">
            <button class="btn-delete">Delete</button>
            <div class="class-details">
                <h2>{{ $class->name }}</h2>
                <p><strong>Duration:</strong> {{ $class->duration }}</p>
                <p><strong>Difficulty:</strong> {{ $class->level }}</p>
                <p><strong>Location:</strong> {{ $class->location ?? 'Not specified' }}</p>
            </div>
            <form class="booking-form" method="POST" action="{{ route('bookclass.store', $class->id) }}">
                @csrf
                <label for="trainer">Trainer:</label>
                <input type="text" id="trainer" name="trainer" value="{{ old('trainer', $class->trainer) }}" required>
                @error('trainer')
                    <div class="error">{{ $message }}</div>
                @enderror
                
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
                <input type="date" id="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" required>
                @error('date')
                    <div class="error">{{ $message }}</div>
                @enderror
                
                <button type="submit" class="btn-book">Book Now</button>
            </form>
            <button class="btn-add">+ Add New Class</button>
        </div>
        <div class="right-panel">
            <div class="calendar-header">
                <h2>Calendar</h2>
                <p>Month: April | Year: 2025</p>
            </div>
            <div class="calendar-grid">
                <div>S</div><div>M</div><div>T</div><div>W</div><div>T</div><div>F</div><div>S</div>
                @for ($i = 1; $i <= 30; $i++)
                    <div class="{{ $i == 4 ? 'selected' : '' }}">{{ $i }}</div>
                @endfor
            </div>
        </div>
    </div>
</body>
</html>