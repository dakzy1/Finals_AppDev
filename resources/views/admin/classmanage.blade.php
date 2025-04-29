<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Management</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
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
            background-color: #343a40;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .edit-user-form {
            margin-top: 30px;
        }

        .edit-user-form.active {
            display: block;
        }

        .edit-user-form:not(.active) {
            display: none;
        }

        .alert-success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
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
<div id="class" class="tab-content">
    <div class="container">
        <h2>Class Management</h2>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
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
                    <a href="{{ route('admin.classmanage') }}" class="btn-cancel">Cancel</a>
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
                        <a href="{{ route('admin.classmanage', ['edit_class' => $class->id]) }}" class="btn-edit">Edit</a>
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
</body>
</html>
