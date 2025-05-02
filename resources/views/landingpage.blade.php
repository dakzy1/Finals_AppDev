<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/exercise-weight-icon-6.png') }}" type="image/x-icon">
    <title>Welcome to FitZone</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .landing-container {
            display: flex;
            width: 100vw; /* Full width */
            height: 100vh; /* Full height */
        }

        .left {
            background-color: #4b2953;
            color: white;
            padding: 50px;
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .left h1 {
            font-size: 3em;
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .left p {
            font-size: 1.5em;
            margin-bottom: 40px;
            line-height: 1.4;
        }

        .class-box {
            background-color: #A76CAB;
            padding: 25px;
            border-radius: 12px;
            width: fit-content;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .class-box h3 {
            margin: 0;
            font-size: 1.8em;
        }

        .class-box small {
            display: block;
            margin-top: 5px;
            font-size: 0.9em;
            opacity: 0.8;
        }

        .right {
            width: 50%;
            position: relative;
            background: url('/images/yoga-bg.png') no-repeat center center/cover;
        }

        .right button {
            position: absolute;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px 30px;
            background-color: #5D2E7E;
            color: white;
            font-size: 1.2em;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .right button:hover {
            background-color: #4A2366;
        }

        @media (max-width: 768px) {
            .landing-container {
                flex-direction: column;
            }

            .left, .right {
                width: 100%;
                min-height: 50vh;
            }

            .left {
                padding: 30px;
            }

            .left h1 {
                font-size: 2em;
            }

            .left p {
                font-size: 1.2em;
            }

            .right button {
                bottom: 40px;
                padding: 12px 20px;
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <div class="left">
            <h1>Welcome{{ Auth::check() ? ', ' . Auth::user()->first_name : '' }}<br>to FitZone
            </h1>
            <p>Track your fitness journey<br>and book classes</p>

            <div class="class-box">
                <small>Upcoming Class</small>

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
        </div>

        <div class="right">
            <a href="{{ route('dashboard') }}">
                <button>Book a Class Now!!</button>
            </a>
        </div>
    </div>
</body>

</html>