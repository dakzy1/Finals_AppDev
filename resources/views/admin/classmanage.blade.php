<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Management</title>
    <link rel="shortcut icon" href="{{ asset('images/Appdev_logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5eaf3;
            overflow: auto;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .nav-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #834c71;
            color: white;
            padding: 15px 30px;
        }


        h2, h3 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-submit, .btn-cancel, .btn-edit, .btn-delete, .toggle-form-btn {
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-submit {
            background-color: #28a745;
            color: white;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: white;
        }

        .btn-edit {
            background-color: #007bff;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-group {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
            }

        .btn-edit,
        .btn-delete {
            width: 70px;
            height: 40px;
            padding: 0;
            line-height: 40px;
            text-align: center;
            box-sizing: border-box;
            display: inline-block;
        }

        .toggle-form-btn {
            margin-top: 20px;
            background-color: #17a2b8;
            color: white;
        }

        .btn-submit:hover { background-color: #218838; }
        .btn-cancel:hover { background-color: #5a6268; }
        .btn-edit:hover { background-color: #0069d9; }
        .btn-delete:hover { background-color: #c82333; }
        .toggle-form-btn:hover { background-color: #138496; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #834c71;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .edit-user-form {
            margin-top: 20px;
            padding: 20px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            background-color: #fefefe;
            border: 1px solid #dee2e6;
            border-radius: 8px;
   
        }
        .edit-user-form h3 {
            font-size: 20px;
            margin-bottom: 15px;
        }
        .edit-user-form .form-group {
            margin-bottom: 10px;
        }
        .edit-user-form label {
            font-size: 14px;
            margin-bottom: 3px;
        }
        .edit-user-form input,
        .edit-user-form select {
            padding: 8px;
            font-size: 14px;
        }

        .edit-user-form .form-actions {
            margin-top: 15px;
            gap: 8px;
        }

        .edit-user-form .btn-submit,
        .edit-user-form .btn-cancel {
            font-size: 14px;
            padding: 8px 16px;
        }


        .edit-user-form.active {
            display: block;
        }

        .edit-user-form:not(.active) {
            display: none;
        }

        /* Success message (green) for added/updated users */
        .success-message {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #e6ffe6;
            color: #155724;
            padding: 10px 15px;
            border-radius: 4px;
            border-left: 6px solid #28a745;
            margin-bottom: 15px;
            font-size: 14px;
            opacity: 1;
            transition: opacity 0.5s ease-out;
            max-width: 600px;
            text-align: center;
            margin: 20px auto;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Danger message (red) for deleted users */
        .danger-message {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border-radius: 4px;
            border-left: 6px solid #dc3545;
            margin-bottom: 15px;
            font-size: 14px;
            opacity: 1;
            transition: opacity 0.5s ease-out;
            max-width: 600px;
            text-align: center;
            margin: 20px auto;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Fade-out animation for both alerts */
        .success-message.fade-out,
        .danger-message.fade-out {
            opacity: 0;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-5px); }
        }

        .success-message.fade-out {
            animation: fadeOut 0.5s ease-in-out forwards;
        }
        #backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease;
        z-index: 999;
        }

        #backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        /* Offcanvas */
        #offcanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: #f8f9fa;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
            transform: translateX(-100%);
            transition: transform 0.4s ease;
            z-index: 1000;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        #offcanvas.active {
            transform: translateX(0);
        }

        .logo-placeholder {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 12px;
            border: 2px solid #dee2e6;
        }

        .logo-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .admin-label {
            font-weight: 600;
            font-size: 15px;
            color: #333;
            margin-bottom: 20px;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
            align-items: center;
        }

        .button-container form,
        .logout-container form {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .button-container button,
        .logout-container button {
            width: 80%;
            padding: 8px 0;
            font-size: 14px;
            font-weight: 500;
            border: none;
            border-radius: 5px;
            transition: background 0.2s;
            cursor: pointer;
        }

        .button-container button {
            background-color: #007bff;
            color: white;
        }

        .button-container button:hover {
            background-color: #0056b3;
        }

        .logout-container {
            margin-top: auto;
            margin-bottom: 30px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .logout-container button {
            background-color: #dc3545;
            color: white;
        }

        .logout-container button:hover {
            background-color: #b02a37;
        }

        .nav-bar {
            padding: 10px;
        }

        .nav-bar button {
            padding: 8px 16px;
            font-size: 16px;
            background-color: white;
            color: #834c71;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .nav-bar button:hover {
            background-color:rgba(212, 212, 212, 0.87);
        }
        .ck-editor__editable_inline {
            min-height: 150px;
            max-height: 300px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1050; /* Bootstrap default */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-backdrop {
            z-index: 1040;
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            position: relative;
            overflow: hidden;
            margin-top: 50px; /* Adjusted to center the modal */
        }

        /* Specific styling for confirmUpdateModal to fix it at the center of the screen */
        #confirmUpdateModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1060; /* Matches other confirmation modals to ensure it stays on top */
            display: none; /* Controlled by Bootstrap JavaScript */
        }

        #confirmUpdateModal .modal-dialog {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin: 0; /* Remove default margin to center precisely */
            max-width: 500px; /* Increased from 400px to make the modal larger */
            width: 90%; /* Ensure it scales down on smaller screens */
        }

        #confirmUpdateModal .modal-content {
            margin: 0; /* Remove default margin to center precisely */
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2); /* Optional: Add shadow for better visibility */
            width: 100%; /* Ensure it takes the full width of the modal-dialog */
        }

        /* Adjust inner modal elements for better spacing */
        #confirmUpdateModal .modal-header {
            padding: 15px 20px; /* Slightly reduce padding for a more spacious feel */
            font-size: 18px; /* Increase font size of the title */
        }

        #confirmUpdateModal .modal-body {
            padding: 20px; /* Keep padding but ensure content is readable */
            font-size: 16px; /* Increase font size for better readability */
            line-height: 1.5; /* Improve text readability */
        }

        #confirmUpdateModal .modal-footer {
            padding: 15px 20px; /* Slightly reduce padding */
        }

        /* Ensure buttons are appropriately sized */
        #confirmUpdateModal .modal-footer .btn {
            padding: 10px 20px; /* Increase button padding for better clickability */
            font-size: 16px; /* Increase font size for buttons */
        }
    </style>
    <script>
        function toggleAddClassForm() {
            const form = document.getElementById('add-class-form');
            form.classList.toggle('active');
        }
    </script>
</head>
<body>
    <!-- Backdrop -->
<div id="backdrop"></div>

<!-- Offcanvas -->
<div id="offcanvas">
    <div class="logo-placeholder">
        <img src="{{ asset('images/admin-logo.jpg') }}" alt="Logo">
    </div>
    <div class="admin-label">ADMIN</div>

    <div class="button-container">
        <form action="{{ route('admin.dashboard') }}" method="GET">
            <button type="submit"> <i class="fa fa-users" style="margin-right: 8px;"></i>User Management</button>
        </form>
    </div>
    <diV></diV>

    <div class="button-container">
        <form action="{{ route('redirect.page') }}" method="GET">
            <button type="submit"> <i class="fa fa-cogs" style="margin-right: 8px;"></i>Class Management</button>
        </form>
    </div>

    <div class="logout-container">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</div>

<!-- Navbar -->
<div class="nav-bar">
    <button onclick="toggleOffcanvas(true)">☰ Menu</button>
</div>

<!-- Script -->
<script>
    function toggleOffcanvas(show) {
        const offcanvas = document.getElementById('offcanvas');
        const backdrop = document.getElementById('backdrop');

        if (show) {
            offcanvas.classList.add('active');
            backdrop.classList.add('active');
        } else {
            offcanvas.classList.remove('active');
            backdrop.classList.remove('active');
        }
    }

    document.getElementById('backdrop').addEventListener('click', () => {
        toggleOffcanvas(false);
    });

    document.addEventListener('click', function (event) {
        const offcanvas = document.getElementById('offcanvas');
        if (!offcanvas.contains(event.target) && !event.target.closest('button')) {
            toggleOffcanvas(false);
        }
    });
</script>


<div id="class" class="tab-content">
    <div class="container">
        <h2>Class Management</h2>
        @if (session('success'))
            <div class="success-message {{ session('message_type') === 'danger' ? 'danger' : 'success' }}">
                {{ session('success') }}
            </div>
        @endif
        @if($editClass)
        <!-- Edit Class Modal -->
        <div id="editClassModal" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h3>Edit Class</h3>

                @if ($errors->any())
                    <div style="color: red; margin-bottom: 10px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="editClassForm" method="POST" action="{{ route('class.update', $editClass->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Fitness Classes</label>
                        <select id="name" name="name" required>
                            <option value="Yoga" {{ $editClass->name == 'Yoga' ? 'selected' : '' }}>Yoga</option>
                            <option value="Zumba" {{ $editClass->name == 'Zumba' ? 'selected' : '' }}>Zumba</option>
                            <option value="Cardio" {{ $editClass->name == 'Cardio' ? 'selected' : '' }}>Cardio</option>
                            <option value="Pilates" {{ $editClass->name == 'Pilates' ? 'selected' : '' }}>Pilates</option>
                            <option value="HIIT" {{ $editClass->name == 'HIIT' ? 'selected' : '' }}>HIIT</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="level">Difficulty Level</label>
                        <div style="display: flex; gap: 10px; font-size: 14px; margin-top: 5px;">
                            <label style="display: flex; align-items: center; gap: 4px;">
                                <input type="radio" name="level" value="Beginner" {{ $editClass->level == 'Beginner' ? 'checked' : '' }} required>
                                Beginner
                            </label>
                            <label style="display: flex; align-items: center; gap: 4px;">
                                <input type="radio" name="level" value="Intermediate" {{ $editClass->level == 'Intermediate' ? 'checked' : '' }}>
                                Intermediate
                            </label>
                            <label style="display: flex; align-items: center; gap: 4px;">
                                <input type="radio" name="level" value="Advanced" {{ $editClass->level == 'Advanced' ? 'checked' : '' }}>
                                Advanced
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <div style="display: flex; align-items: center;">
                            <input type="number" id="duration" name="duration" min="1" max="120" value="{{ $editClass->duration }}" required style="margin-right: 5px; width: 80px;">
                            <span>minutes</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="trainer">Trainer Name</label>
                        <input type="text" id="trainer" name="trainer" maxlength="50" value="{{ $editClass->trainer }}" required>
                    </div>

                    <div class="form-group">
                            <label for="user_limit">Booking Limit</label>
                            <input type="number" id="user_limit" name="user_limit" min="1" max="20" value="{{ $editClass->user_limit }}" required style="margin-right: 5px; width: 80px;" 
                                onkeydown="return false;">
                    </div>

                    <div class="form-group">
                        <label for="time">Select Instructor Available Time:</label>
                            <select id="time" name="time" required style="margin-right: 5px; width: 120px;">
                                <option value="" selected disabled {{ old('time') ? '' : 'selected' }}>Select time</option>
                                <option value="06:00:00" {{ old('time') == '06:00:00' ? 'selected' : '' }}>06:00 AM</option>
                                <option value="07:00:00" {{ old('time') == '07:00:00' ? 'selected' : '' }}>07:00 AM</option>
                                <option value="08:00:00" {{ old('time') == '08:00:00' ? 'selected' : '' }}>08:00 AM</option>
                                <option value="09:00:00" {{ old('time') == '09:00:00' ? 'selected' : '' }}>09:00 AM</option>
                                <option value="10:00:00" {{ old('time') == '10:00:00' ? 'selected' : '' }}>10:00 AM</option>
                                <option value="11:00:00" {{ old('time') == '11:00:00' ? 'selected' : '' }}>11:00 AM</option>
                                <option value="12:00:00" {{ old('time') == '11:00:00' ? 'selected' : '' }}>12:00 PM</option>

                                <option value="13:00:00" {{ old('time') == '13:00:00' ? 'selected' : '' }}>01:00 PM</option>
                                <option value="14:00:00" {{ old('time') == '14:00:00' ? 'selected' : '' }}>02:00 PM</option>
                                <option value="15:00:00" {{ old('time') == '15:00:00' ? 'selected' : '' }}>03:00 PM</option>
                                <option value="16:00:00" {{ old('time') == '16:00:00' ? 'selected' : '' }}>04:00 PM</option>
                                <option value="17:00:00" {{ old('time') == '17:00:00' ? 'selected' : '' }}>05:00 PM</option>
                                <option value="18:00:00" {{ old('time') == '18:00:00' ? 'selected' : '' }}>06:00 PM</option>
                            </select>
                            <span>Start Time</span>
                    </div>
                    <div class="form-group">
                            <select id="end_time" name="end_time" required style="margin-right: 5px; width: 120px;">
                                <option value="" selected disabled {{ old('end_time') ? '' : 'selected' }}>Select time</option>
                                <option value="06:00:00" {{ old('end_time') == '06:00:00' ? 'selected' : '' }}>06:00 AM</option>
                                <option value="07:00:00" {{ old('end_time') == '07:00:00' ? 'selected' : '' }}>07:00 AM</option>
                                <option value="08:00:00" {{ old('end_time') == '08:00:00' ? 'selected' : '' }}>08:00 AM</option>
                                <option value="09:00:00" {{ old('end_time') == '09:00:00' ? 'selected' : '' }}>09:00 AM</option>
                                <option value="10:00:00" {{ old('end_time') == '10:00:00' ? 'selected' : '' }}>10:00 AM</option>
                                <option value="11:00:00" {{ old('end_time') == '11:00:00' ? 'selected' : '' }}>11:00 AM</option>
                                <option value="12:00:00" {{ old('end_time') == '11:00:00' ? 'selected' : '' }}>12:00 PM</option>

                                <option value="13:00:00" {{ old('end_time') == '13:00:00' ? 'selected' : '' }}>01:00 PM</option>
                                <option value="14:00:00" {{ old('end_time') == '14:00:00' ? 'selected' : '' }}>02:00 PM</option>
                                <option value="15:00:00" {{ old('end_time') == '15:00:00' ? 'selected' : '' }}>03:00 PM</option>
                                <option value="16:00:00" {{ old('end_time') == '16:00:00' ? 'selected' : '' }}>04:00 PM</option>
                                <option value="17:00:00" {{ old('end_time') == '17:00:00' ? 'selected' : '' }}>05:00 PM</option>
                                <option value="18:00:00" {{ old('end_time') == '18:00:00' ? 'selected' : '' }}>06:00 PM</option>
                            </select>
                            <span>End Time</span> 
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description">{{ old('description', $editClass->description ?? '') }}</textarea>
                        <small id="charCount">0 / 255 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="description_2">Key Benefits</label>
                        <textarea id="description_2" name="key_benefits">{{ old('key_benefits', $editClass->key_benefits ?? '') }}</textarea>
                        <small id="charCount_2">0 / 255 characters</small>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">Update Class</button>
                        <a href="{{ route('admin.classmanage') }}" class="btn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        @else
        <!-- Modal for Add Class -->
        <div id="addClassModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <div class="edit-user-form active" id="add-class-form-modal">
                    <h3>Add New Class</h3>
                    <!-- Move your existing Add Class form content here -->
                    <form method="POST" action="{{ route('class.store') }}" onsubmit="disableSubmit(this)">
                        @csrf
                        <!-- Keep all form groups the same as before -->
                        <div class="form-group">
                            <label for="name">Fitness Classes</label>
                            <select id="name" name="name" required>
                                <option value="Yoga">Yoga</option>
                                <option value="Zumba">Zumba</option>
                                <option value="Cardio">Cardio</option>
                                <option value="Pilates">Pilates</option>
                                <option value="HIIT">HIIT</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="level">Difficulty Level</label>
                            <select id="level" name="level" required>
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <div style="display: flex; align-items: center;">
                            <input type="number" id="duration" name="duration"
                                    min="1" max="120" step="1" required
                                    style="margin-right: 5px; width: 80px;" 
                                    onkeydown="return false;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="trainer">Trainer Name</label>
                            <input type="text" id="trainer" name="trainer" maxlength="50" required>
                        </div>
                        <div class="form-group">
                            <label for="user_limit">Booking Limit</label>
                            <input type="number" id="user_limit" name="user_limit" min="1" max="20" required style="margin-right: 5px; width: 80px;" 
                                onkeydown="return false;">
                        </div>
                        <div class="form-group">
                        <label for="time">Select Instructor Available Time:</label>
                            <select id="time" name="time" required style="margin-right: 5px; width: 120px;">
                                <option value="" selected disabled {{ old('time') ? '' : 'selected' }}>Select time</option>
                                <option value="06:00:00" {{ old('time') == '06:00:00' ? 'selected' : '' }}>06:00 AM</option>
                                <option value="07:00:00" {{ old('time') == '07:00:00' ? 'selected' : '' }}>07:00 AM</option>
                                <option value="08:00:00" {{ old('time') == '08:00:00' ? 'selected' : '' }}>08:00 AM</option>
                                <option value="09:00:00" {{ old('time') == '09:00:00' ? 'selected' : '' }}>09:00 AM</option>
                                <option value="10:00:00" {{ old('time') == '10:00:00' ? 'selected' : '' }}>10:00 AM</option>
                                <option value="11:00:00" {{ old('time') == '11:00:00' ? 'selected' : '' }}>11:00 AM</option>
                                <option value="12:00:00" {{ old('time') == '11:00:00' ? 'selected' : '' }}>12:00 PM</option>

                                <option value="13:00:00" {{ old('time') == '13:00:00' ? 'selected' : '' }}>01:00 PM</option>
                                <option value="14:00:00" {{ old('time') == '14:00:00' ? 'selected' : '' }}>02:00 PM</option>
                                <option value="15:00:00" {{ old('time') == '15:00:00' ? 'selected' : '' }}>03:00 PM</option>
                                <option value="16:00:00" {{ old('time') == '16:00:00' ? 'selected' : '' }}>04:00 PM</option>
                                <option value="17:00:00" {{ old('time') == '17:00:00' ? 'selected' : '' }}>05:00 PM</option>
                                <option value="18:00:00" {{ old('time') == '18:00:00' ? 'selected' : '' }}>06:00 PM</option>
                            </select>
                            <span>Start Time</span>
                        </div>
                        <div class="form-group">
                            <select id="end_time" name="end_time" required style="margin-right: 5px; width: 120px;">
                                <option value="" selected disabled {{ old('end_time') ? '' : 'selected' }}>Select time</option>
                                <option value="06:00:00" {{ old('end_time') == '06:00:00' ? 'selected' : '' }}>06:00 AM</option>
                                <option value="07:00:00" {{ old('end_time') == '07:00:00' ? 'selected' : '' }}>07:00 AM</option>
                                <option value="08:00:00" {{ old('end_time') == '08:00:00' ? 'selected' : '' }}>08:00 AM</option>
                                <option value="09:00:00" {{ old('end_time') == '09:00:00' ? 'selected' : '' }}>09:00 AM</option>
                                <option value="10:00:00" {{ old('end_time') == '10:00:00' ? 'selected' : '' }}>10:00 AM</option>
                                <option value="11:00:00" {{ old('end_time') == '11:00:00' ? 'selected' : '' }}>11:00 AM</option>
                                
                                
                                <option value="13:00:00" {{ old('end_time') == '13:00:00' ? 'selected' : '' }}>01:00 PM</option>
                                <option value="14:00:00" {{ old('end_time') == '14:00:00' ? 'selected' : '' }}>02:00 PM</option>
                                <option value="15:00:00" {{ old('end_time') == '15:00:00' ? 'selected' : '' }}>03:00 PM</option>
                                <option value="16:00:00" {{ old('end_time') == '16:00:00' ? 'selected' : '' }}>04:00 PM</option>
                                <option value="17:00:00" {{ old('end_time') == '17:00:00' ? 'selected' : '' }}>05:00 PM</option>
                                <option value="18:00:00" {{ old('end_time') == '18:00:00' ? 'selected' : '' }}>06:00 PM</option>
                            </select>
                            <span>End Time</span> 
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" maxlength="255"></textarea>
                            <small id="charCount">0 / 255 characters</small>
                        </div>
                        <div class="form-group">
                            <label for="description_2">Key Benefits</label>
                            <textarea id="description_2" name="key_benefits" maxlength="255"></textarea>
                            <small id="charCount_2">0 / 255 characters</small>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn-submit" id="addClassBtn">Add Class</button>
                            <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @endif

        <table id="userTable" class="display">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Duration</th>
                    <th>Trainer</th>
                    <th>Description</th>
                    <th>Key Benefits</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fitnessClasses as $class)
                <tr>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->level }}</td>
                    <td>{{ $class->duration }} Minutes</td>
                    <td style="max-width: 300px; white-space: normal; word-wrap: break-word;">
                        {{ Str::limit($class->trainer, 10, '...') }} 
                    </td>
                    <td style="max-width: 300px; white-space: normal; word-wrap: break-word;"> 
                        {{ Str::limit(strip_tags($class->description), 10, '...') }}
                    </td>
                    <td style="max-width: 300px; white-space: normal; word-wrap: break-word;">
                        {{ Str::limit(strip_tags($class->key_benefits), 10, '...') }}
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.classmanage', ['edit_class' => $class->id]) }}" class="btn-edit">Edit</a>
                            <form id="delete-form-{{ $class->id }}" action="{{ route('class.destroy', $class->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <!-- Delete Button -->
                                <button type="button" class="btn-delete" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal" data-form-id="delete-form-{{ $class->id }}" onclick="setDeleteAction(this)">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if(!$editClass)
        <button class="toggle-form-btn" onclick="toggleAddClassForm()">Add Class</button>
        @endif
    </div>
</div>
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmUpdateModal" tabindex="-1" aria-labelledby="confirmUpdateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmUpdateModalLabel">Confirm Update</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to update this class?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="confirmUpdateBtn">Yes, Update</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this class?
            </div>
            <div class="modal-footer">
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger" onclick="disableThis(this); document.getElementById(targetFormId).submit();">Yes, Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    $(document).ready(function () {
        $('#userTable').DataTable();
    });
    document.addEventListener("DOMContentLoaded", function () {
    const startSelect = document.getElementById("time");
    const endSelect = document.getElementById("end_time");

    function validateTimeSelection() {
        const startTime = startSelect.value;
        const endTime = endSelect.value;

        if (!startTime || !endTime) return;

        const startHour = parseInt(startTime.split(':')[0]);
        const endHour = parseInt(endTime.split(':')[0]);

        const isValidStart =
            (startHour >= 6 && startHour <= 11) || (startHour >= 13 && startHour <= 18);
        const isValidEnd =
            (endHour >= 6 && endHour <= 11) || (endHour >= 13 && endHour <= 18);

        if (!isValidStart) {
            alert("Start time must be between 6:00 AM–11:00 AM or 1:00 PM–6:00 PM.");
            startSelect.value = "";
            return;
        }

        if (!isValidEnd) {
            alert("End time must be between 6:00 AM–11:00 AM or 1:00 PM–6:00 PM.");
            endSelect.value = "";
            return;
        }

        // Ensure start is before end (on a 24-hour scale)
        if (startHour >= endHour) {
            alert("Overtime Work is not Allowed!.");
            endSelect.value = "";
        }
    }

    startSelect.addEventListener("change", validateTimeSelection);
    endSelect.addEventListener("change", validateTimeSelection);
});
</script>
<script>
    const editForm = document.getElementById('editClassForm');
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmUpdateModal'));
    const confirmBtn = document.getElementById('confirmUpdateBtn');

    editForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        confirmModal.show(); // Show Bootstrap modal
    });

    confirmBtn.addEventListener('click', function() {
        confirmModal.hide();
        editForm.submit(); // Submit the form after confirmation
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        ClassicEditor
        .create(document.querySelector('#description'))
        .then(editor => {
            const maxLength = 255;
            const maxNewLines = 3;

            editor.model.document.on('change:data', () => {
                const htmlData = editor.getData();
                const plainText = htmlData.replace(/<[^>]*>/g, ''); // remove HTML tags

                // Count new lines based on paragraph tags or line breaks
                const newLineCount = (htmlData.match(/<p>|<br\s*\/?>/g) || []).length;

                // Limit characters
                if (plainText.length > maxLength) {
                    alert(`Description must not exceed ${maxLength} characters.`);
                    editor.setData(plainText.substring(0, maxLength));
                    return;
                }

                // Limit new lines
                if (newLineCount > maxNewLines) {
                    alert(`Maximum of ${maxNewLines} new lines allowed.`);
                    
                    // Optional: remove extra paragraphs (truncate by line count)
                    const lines = htmlData.split(/(<p>.*?<\/p>|<br\s*\/?>)/i);
                    let lineTotal = 0;
                    let filtered = "";

                    for (let i = 0; i < lines.length; i++) {
                        if (/<p>|<br\s*\/?>/i.test(lines[i])) {
                            lineTotal++;
                        }

                        filtered += lines[i];

                        if (lineTotal >= maxNewLines) break;
                    }

                    editor.setData(filtered);
                    return;
                }

                document.getElementById('charCount').innerText = `${plainText.length} / ${maxLength} characters`;
            });
        })
        .catch(error => {
            console.error(error);
        });

        ClassicEditor
        .create(document.querySelector('#description_2'))
        .then(editor => {
            const maxLength = 255;
            const maxNewLines = 5;

            editor.model.document.on('change:data', () => {
                const htmlData = editor.getData();
                const plainText = htmlData.replace(/<[^>]*>/g, ''); // remove HTML tags

                // Count new lines based on paragraph tags or line breaks
                const newLineCount = (htmlData.match(/<p>|<br\s*\/?>/g) || []).length;

                // Limit characters
                if (plainText.length > maxLength) {
                    alert(`Description must not exceed ${maxLength} characters.`);
                    editor.setData(plainText.substring(0, maxLength));
                    return;
                }

                // Limit new lines
                if (newLineCount > maxNewLines) {
                    alert(`Maximum of ${maxNewLines} new lines allowed.`);
                    
                    // Optional: remove extra paragraphs (truncate by line count)
                    const lines = htmlData.split(/(<p>.*?<\/p>|<br\s*\/?>)/i);
                    let lineTotal = 0;
                    let filtered = "";

                    for (let i = 0; i < lines.length; i++) {
                        if (/<p>|<br\s*\/?>/i.test(lines[i])) {
                            lineTotal++;
                        }

                        filtered += lines[i];

                        if (lineTotal >= maxNewLines) break;
                    }

                    editor.setData(filtered);
                    return;
                }

                document.getElementById('charCount_2').innerText = `${plainText.length} / ${maxLength} characters`;
            });
        })
        .catch(error => {
            console.error(error);
        });
        
    });
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("addClassModal");
        const toggleBtn = document.querySelector(".toggle-form-btn");

        toggleBtn.addEventListener("click", () => {
            modal.style.display = "block";
        });
    });

    function closeModal() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => modal.style.display = "none");
        // Optional: Redirect only for edit modal
        window.location.href = "{{ route('admin.classmanage') }}";
       
    }

    document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        // Skip the edit class form
        if (form.id === 'editClassForm') return;

        form.addEventListener('submit', function () {
            const submitButton = form.querySelector('.btn-submit');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Submitting...';
            }
        });
    });
});
</script>
<script>
    // Function to disable the submit button
let targetFormId = null;

    const deleteModal = document.getElementById('deleteConfirmModal');

    // Function to disable buttons (adapted from dashboard.blade.php)
    function disableThis(button) {
        if (button.tagName === 'A') {
            // For anchor tags: disable and navigate
            button.classList.add('disabled');
            button.style.pointerEvents = 'none';
            button.style.opacity = '0.6';
        } else {
            // For buttons: check if it's the confirm delete button in the modal
            if (button.id === 'confirmDeleteBtn') {
                button.disabled = true;
                button.textContent = 'Deleting...'; // Optional: Update text for feedback
            } else if (button.classList.contains('btn-delete')) {
                // For delete buttons opening the modal: delay disabling to allow modal to open
                setTimeout(() => {
                    button.disabled = true;
                }, 100);
            } else {
                // For other buttons: disable immediately
                button.disabled = true;
            }
        }

        // For buttons opening modals, restore them after a while
        if (button.getAttribute('data-bs-toggle') === 'modal') {
            setTimeout(() => {
                button.disabled = false;
            }, 3000); // Re-enable after 3 seconds if needed
        }
    }

    // Function to set the form ID and disable the delete button
    function setDeleteAction(button) {
        targetFormId = button.getAttribute('data-form-id');
        disableThis(button); // Disable the delete button after click
    }

    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        targetFormId = button.getAttribute('data-form-id');
        // Reset the confirm button state when the modal opens
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        confirmDeleteBtn.disabled = false;
        confirmDeleteBtn.textContent = 'Yes, Delete';
    });

    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = document.querySelector('.success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.classList.add('fade-out');
                setTimeout(() => {
                    successMessage.remove();
                }, 1000);
            }, 3000);
        }
    });
</script>
</body>
</html>
