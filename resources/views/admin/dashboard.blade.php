<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="{{ asset('images/Appdev_logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
    body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .nav-bar {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            background-color: #2e3338;
            color: white;
            padding: 10px 20px;
            height: 30px;
        }
        .nav-bar button {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .nav-bar button:hover {
            background-color: #0056b3;
        }

        /* Button container styling inside offcanvas */
        .button-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 15px;
            margin-top: 20px;
        }

        .button-container form {
            width: 100%;
        }

        .button-container button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            background-color: #007bff;
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        .button-container button:hover {
            background-color: #0056b3;
        }

        .tab-btn {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            border-radius: 5px;
            background-color: #444;
            color: white;
            cursor: pointer;
        }

        .tab-btn.active {
            background-color: #007bff;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2, h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background-color: #2e3338;
            color: white;
        }

        th, td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }

        tr:nth-child(even) {
            background-color: #f4f4f4;
        }

        .btn-edit,
        .btn-delete {
            display: inline-block;  /* Normalizes <a> and <button> */
            padding: 8px 16px;      /* Make sure both use the same padding */
            font-size: 14px;        /* Normalize font size */
            font-weight: bold;      /* Optional, for visual consistency */
            line-height: 1.2;       /* Ensure consistent vertical spacing */
            text-align: center;     /* Align text for <a> */
            vertical-align: middle; /* Align with other inline-block elements */
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            border: none;
        }
        .btn-edit{
            background-color: #007bff;
        }
        .btn-delete{
            background-color: #dc3545;
        }

        .btn-edit:hover {
            background-color: #0056b3;
        }

        

        .btn-delete:hover {
            background-color: #b02a37;
        }

        .btn-add {
            background-color: #28a745;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-add:hover {
            background-color: #218838;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-actions {
            text-align: right;
        }

        .btn-submit, .btn-cancel {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }

        .btn-submit {
            background-color: #007bff;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .btn-cancel {
            background-color: #6c757d;
            text-decoration: none;
            padding: 8px 16px;
            display: inline-block;
        }

        .btn-cancel:hover {
            background-color: #565e64;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
        .edit-user-form {
            max-width: 500px;
            margin: 0 auto 30px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fdfdfd;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .edit-user-form h3 {
            font-size: 20px;
            margin-bottom: 15px;
        }

        .edit-user-form .form-group {
            margin-bottom: 10px;
        }

        .edit-user-form .form-group label {
            font-size: 14px;
            margin-bottom: 4px;
        }

        .edit-user-form .form-group input,
        .edit-user-form .form-group select {
            padding: 6px 10px;
            font-size: 14px;
            height: 36px;
        }

        .edit-user-form .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 15px;
        }

        .edit-user-form .btn-submit,
        .edit-user-form .btn-cancel {
            font-size: 14px;
            padding: 6px 14px;
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
            background-color: #343a40;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .nav-bar button:hover {
            background-color: #23272b;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 28px;
            color: #aaa;
            cursor: pointer;
        }

        .close-btn:hover {
            color: black;
        }
        /* Style for smaller, aligned radio buttons */
        .form-group input[type="radio"] {
            transform: scale(0.8); /* Smaller size */
            margin-right: 5px;
            vertical-align: middle;
        }

        .form-group label[for="male"],
        .form-group label[for="female"],
        .form-group label[for="other"] {
            margin-right: 15px;
            font-weight: normal;
            vertical-align: middle;
        }

</style>
  

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
        <form action="{{ route('redirect.page') }}" method="GET">
            <button type="submit">Class Management</button>
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

<div id="user" class="tab-content active">
    <div class="container">
        <h2>User Management</h2>

        @if(session('success'))
            <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
        @endif

        @isset($editUser)
        <!-- Edit User Modal -->
        <div id="editUserModal" class="modal" style="display: block;">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h3>Edit User</h3>

                @if ($errors->any())
                    <div style="color: red; margin-bottom: 10px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.update', $editUser->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" maxlength="50" value="{{ $editUser->first_name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="middle_name">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name" maxlength="25" value="{{ $editUser->middle_name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" maxlength="25" value="{{ $editUser->last_name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" maxlength="25" value="{{ $editUser->email }}" required>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label><br>

                        <div style="display: inline-block;">
                            <input type="radio" id="male" name="gender" value="male" {{ $editUser->gender == 'male' ? 'checked' : '' }}>
                            <label for="male">Male</label>
                        </div>

                        <div style="display: inline-block;">
                            <input type="radio" id="female" name="gender" value="female" {{ $editUser->gender == 'female' ? 'checked' : '' }}>
                            <label for="female">Female</label>
                        </div>

                        <div style="display: inline-block;">
                            <input type="radio" id="other" name="gender" value="other" {{ $editUser->gender == 'other' ? 'checked' : '' }}>
                            <label for="other">Other</label>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" maxlength="25" placeholder="Leave blank to keep the current password">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-delete">Update</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn-edit">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        @endisset



        <table id="userTable" class="display">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>E-mail</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr @if($user->status === 'deactivated') style="background-color: #e9ecef; color: #6c757d;" @endif>
                    <td>{{ Str::limit($user->first_name, 10, '...') }}</td>
                    <td>{{ Str::limit($user->middle_name, 10, '...') }}</td>
                    <td>{{ Str::limit($user->last_name, 10, '...') }}</td>
                    <td>{{ ucfirst($user->gender) }}</td>
                    <td>{{ Str::limit($user->email, 20, '...') }}</td>
                    <td>
                        <a href="{{ route('admin.dashboard', ['edit' => $user->id]) }}" class="btn-edit">Edit</a>
                        
                        <form action="{{ route('admin.toggleStatus', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn-delete">
                                {{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#userTable').DataTable();
    });
    function closeModal() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => modal.style.display = "none");
        // Optional: Redirect only for edit modal
       
    }

    document.addEventListener('DOMContentLoaded', function () {
        const nameFields = ['first_name', 'middle_name', 'last_name'];

        nameFields.forEach(function(id) {
            const input = document.getElementById(id);
            input.addEventListener('input', function () {
                this.value = this.value.replace(/[^a-zA-Z\s\-]/g, '');
            });
        });
    });
</script>
</body>
</html>