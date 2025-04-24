<!-- resources/views/welcome.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to FitZone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .container {
            display: flex;
            height: 100vh;
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
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .left p {
            font-size: 1.2em;
            margin-bottom: 40px;
        }
        .class-box {
            background-color: #A76CAB;
            padding: 20px;
            border-radius: 12px;
            width: fit-content;
        }
        .class-box h3 {
            margin: 0;
            font-size: 1.5em;
        }
        .class-box small {
            display: block;
            margin-top: 5px;
        }
        .right {
            background: url('/images/yoga-bg.png') no-repeat center center/cover;
            width: 50%;
            position: relative;
        }
        .right button {
            position: absolute;
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px 25px;
            background-color: #5D2E7E;
            color: white;
            font-size: 1em;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <h1>Welcome to<br>FitZone</h1>
            <p>Track your fitness journey<br>and book classes</p>

            <div class="class-box">
                <small>Upcoming Class</small>
                <h3>Yoga Class</h3>
                <small>April 9, 9:00 AM</small>
            </div>
        </div>

        <div class="right">
            <a href="{{ route('home') }}">
                <button>Book a Class Now!!</button>
            </a>
        </div>
    </div>
</body>
</html>
