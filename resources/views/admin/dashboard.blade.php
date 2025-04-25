@extends('layouts.layout')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f0f7;
    }

    .nav-bar {
        background-color: #824674;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
    }

    .nav-bar button {
        background: none;
        border: none;
        color: #f9c6a0;
        font-weight: bold;
        font-size: 16px;
        margin: 0 15px;
        cursor: pointer;
    }

    .nav-bar button.active {
        color: white;
        text-decoration: underline;
    }

    .container {
        background-color: white;
        padding: 30px;
        border-radius: 30px;
        margin: 30px auto;
        width: 80%;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        position: relative;
    }

    h2 {
        font-weight: bold;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        text-align: left;
        padding: 12px;
        border: 1px solid #ccc;
    }

    th {
        background-color: #f3e6f3;
    }

    .btn-edit {
        background-color: #006080;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 8px;
        cursor: pointer;
        margin-right: 10px;
    }

    .btn-delete {
        background-color: #d60000;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 8px;
        cursor: pointer;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .edit-user-form {
        background-color: #fff0f6;
        max-width: 500px;
        margin: 20px auto;
        padding: 20px 25px;
        border: 2px solid #dba0c6;
        border-radius: 16px;
        box-shadow: 0 4px 8px rgba(130, 70, 116, 0.1);
        display: none;
    }

    .edit-user-form.active {
        display: block;
    }

    .edit-user-form h3 {
        margin-bottom: 20px;
        color: #824674;
        font-weight: bold;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #333;
    }

    .form-group input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 10px;
        font-size: 14px;
        background-color: #fff;
        transition: border-color 0.3s ease-in-out;
    }

    .form-group input:focus {
        border-color: #824674;
        outline: none;
    }

    .form-actions {
        margin-top: 20px;
    }

    .btn-submit {
        background-color: #824674;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        margin-right: 10px;
        font-weight: bold;
    }

    .btn-cancel {
        background-color: #ccc;
        padding: 10px 18px;
        border-radius: 10px;
        color: #333;
        text-decoration: none;
        font-weight: bold;
    }

    .btn-submit:hover {
        background-color: #6a3a5b;
    }

    .btn-cancel:hover {
        background-color: #b3b3b3;
    }

    .logout-container {
        position: fixed;
        bottom: 20px;
        left: 20px;
        z-index: 100;
    }

    .logout-btn {
        background-color: #824674;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 2px 2px 8px rgba(0,0,0,0.2);
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .logout-btn:hover {
        background-color: #6a3a5b;
        transform: scale(1.05);
    }

    .toggle-form-btn {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background-color: #824674;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 2px 2px 8px rgba(0,0,0,0.2);
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .toggle-form-btn:hover {
        background-color: #6a3a5b;
        transform: scale(1.05);
    }
</style>

<div class="logout-container">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</div>

<div class="nav-bar">
    <div><strong>Admin</strong></div>
    <div>
        <button class="tab-btn active" onclick="switchTab('user')">User</button>
        <button class="tab-btn" onclick="switchTab('class')">Class</button>
    </div>
</div>

<div id="user" class="tab-content active">
    <div class="container">
        <h2>User Management</h2>

        @if(session('success'))
            <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
        @endif

        @isset($editUser)
        <div class="edit-user-form active">
            <h3>Edit User</h3>
            <form method="POST" action="{{ route('admin.update', $editUser->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{{ $editUser->name }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ $editUser->email }}" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Update</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
        @endisset

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('admin.dashboard', ['edit' => $user->id]) }}" class="btn-edit">Edit</a>
                        <form action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Delete this user?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="class" class="tab-content">
    <div class="container">
        <h2>Class Management</h2>

        @if(session('success'))
            <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
        @endif

        @if($editClass)
        <div class="edit-user-form active">
            <h3>Edit Class</h3>
            <form method="POST" action="{{ route('admin.update', $editClass->id) }}" onsubmit="return confirm('Are you sure you want to update this class?')">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Class Name</label>
                    <input type="text" id="name" name="name" value="{{ $editClass->name }}" required>
                </div>
                <div class="form-group">
                    <label for="level">Difficulty Level</label>
                    <select id="level" name="level" required>
                        <option value="Beginner" {{ $editClass->level == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="Intermediate" {{ $editClass->level == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="Advanced" {{ $editClass->level == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="duration">Duration (minutes)</label>
                    <input type="number" id="duration" name="duration" value="{{ $editClass->duration }}" required>
                </div>
                <div class="form-group">
                    <label for="trainer">Trainer Name</label>
                    <input type="text" id="trainer" name="trainer" value="{{ $editClass->trainer }}" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">Update Class</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
        @else
        <div class="edit-user-form" id="add-class-form">
            <h3>Add New Class</h3>
            <form method="POST" action="{{ route('class.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="level">Level</label>
                    <input type="text" id="level" name="level" required>
                </div>
                <div class="form-group">
                    <label for="duration">Duration</label>
                    <input type="text" id="duration" name="duration" required>
                </div>
                <div class="form-group">
                    <label for="trainer">Trainer</label>
                    <input type="text" id="trainer" name="trainer" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">Add Class</button>
                </div>
            </form>
        </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Duration</th>
                    <th>Trainer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fitnessClasses as $class)
                <tr>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->level }}</td>
                    <td>{{ $class->duration }}</td>
                    <td>{{ $class->trainer }}</td>
                    <td>
                        <a href="{{ route('admin.dashboard', ['edit_class' => $class->id]) }}" class="btn-edit">Edit</a>
                        <form action="{{ route('class.destroy', $class->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Delete this class?')">Delete</button>
                        </form>
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

<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(div => {
            div.classList.remove('active');
        });
        document.getElementById(tabId).classList.add('active');

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
    }

    function toggleAddClassForm() {
        const form = document.getElementById('add-class-form');
        form.classList.toggle('active');
    }
</script>
@endsection