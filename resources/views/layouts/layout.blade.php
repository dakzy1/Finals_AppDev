<!DOCTYPE html>
<html>
<head>
    <title>Laravel Navigation Tabs</title>
    <link rel="shortcut icon" href="{{ asset('images/exercise-weight-icon-6.png') }}" type="image/x-icon">
    <style>
        .hidden { display: none; }
        .active-btn { background-color: #3490dc; color: white; }
        .nav-btn { padding: 10px 20px; border: 1px solid #ccc; cursor: pointer; }
         
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.section');
            sections.forEach(s => s.classList.add('hidden'));

            const buttons = document.querySelectorAll('.nav-btn');
            buttons.forEach(b => b.classList.remove('active-btn'));

            document.getElementById(sectionId).classList.remove('hidden');
            document.getElementById(sectionId + '-btn').classList.add('active-btn');
        }

        window.onload = () => showSection('home'); // default
    </script>
</body>
</html>