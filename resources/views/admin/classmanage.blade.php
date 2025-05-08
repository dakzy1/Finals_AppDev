<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Management</title>
    <link rel="shortcut icon" href="{{ asset('images/Appdev_logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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

        .alert-success {
            color: green;
            text-align: center;
            margin-bottom: 15px;
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
            <button type="submit">User Management</button>
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

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
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

                <form id="editClassForm" method="POST" action="{{ route('class.update', $editClass->id) }}" onsubmit="return confirm('Are you sure you want to update this class?')">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Class Name</label>
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
                        <select id="level" name="level" required>
                            <option value="Beginner" {{ $editClass->level == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="Intermediate" {{ $editClass->level == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="Advanced" {{ $editClass->level == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <div style="display: flex; align-items: center;">
                            <input type="number" id="duration" name="duration" min="1" max="100" value="{{ $editClass->duration }}" required style="margin-right: 5px;">
                            <span>minutes</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="trainer">Trainer Name</label>
                        <input type="text" id="trainer" name="trainer" maxlength="50" value="{{ $editClass->trainer }}" required>
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
                            <label for="name">Class Name</label>
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
                                <input type="number" id="duration" name="duration" min="1" max="100" required style="margin-right: 5px;">
                                <span>minutes</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="trainer">Trainer Name</label>
                            <input type="text" id="trainer" name="trainer" maxlength="50" required>
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
    <script>
    document.getElementById('duration').addEventListener('input', function () {
        let value = this.value;

        // Remove non-digit characters and limit to 3 digits
        value = value.replace(/\D/g, '').slice(0, 2);
        this.value = value;
    });
    </script>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    $(document).ready(function () {
        $('#userTable').DataTable();
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
</body>
</html>
