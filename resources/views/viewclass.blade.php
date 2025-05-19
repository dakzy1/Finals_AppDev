@extends('layouts.navbar')

@section('content')
<div class="custom-container">
    <a href="{{ route('dashboard') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Go Back
    </a>
    <div class="main-content">
        <!-- Sidebar (Schedule) -->
            <aside class="sidebar">
                <h2>Schedule</h2>
                <div class="schedule-items">
                    @if (session('success'))
                        <div class="success-message {{ session('message_type') === 'danger' ? 'danger' : 'success' }}">
                            {{ session('success') }}
                        </div>
                    @endif

                @if($schedules->isEmpty())
                    <p>No schedules booked yet.</p>
                @else
                    @foreach($schedules as $schedule)
                        <div class="schedule-box" data-schedule-id="{{ $schedule->id }}">
                            <div class="schedule-header" onclick="toggleDetails(this)">
                                @if ($schedule->fitnessClass)
                                    <h4>{{ e($schedule->fitnessClass->name) }}</h4>
                                @else
                                    <h4>Class Not Found</h4>
                                @endif
                            </div>
                            <div class="schedule-details-content">
                                <div class="view-mode visible-fade">
                                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($schedule->date)->format('F j, Y') }}</p>
                                    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($schedule->time)->format('g:i A') }}</p>
                                    <p><strong>Trainer:</strong> {{ Str::limit($schedule->trainer, 20, '...') }}</p>

                                        <form action="{{ route('bookclass.destroy', $schedule->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        <button type="button"
                                            class="delete-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-action="{{ route('bookclass.destroy', $schedule->id) }}"
                                            onclick="setDeleteAction(this)"
                                            title="Delete">
                                            <i class="fa-regular fa-trash-can" style="color: #b00020; font-size: 18px;"></i>
                                        </button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </aside>
        </aside>

        <!-- Class Details -->
        <section class="class-details">
            <h1>{{ $class->name }}</h1>
            <div class="description" style="white-space: normal; word-wrap: break-word; line-height: 1.6;">
                {!! $class->description !!}
            </div>

            <div class="book-box">
                <a href="{{ route('bookclass', $class->id) }}" class="btn-book" onclick="disableThis(this)">Book Now</a>
                <p><strong>Level:</strong> {{ $class->level }}</p>
                <p><strong>Duration:</strong> {{ $class->duration }} Minutes</p>
                <p><strong>Trainer:</strong> {{ $class->trainer }}</p>
            </div>

            <h3>Key Benefits of {{ $class->name }}:</h3>
            @if(Str::contains($class->key_benefits, "\n"))
                <ul class="benefits" style="white-space: normal; word-wrap: break-word; line-height: 1.6;">
                    @foreach(explode("\n", $class->key_benefits) as $benefit)
                        @if(trim($benefit) !== '')
                            <li>{{ ltrim($benefit, '-• ') }}</li>
                        @endif
                    @endforeach
                </ul>
            @else
                <ul class="benefits" style="white-space: normal; word-wrap: break-word; line-height: 1.6;">
                    {!! $class->key_benefits !!}
                </ul>
            @endif
        </section>
    </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="disableThis(this)"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this schedule?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-delete" onclick="disableThis(this)">Yes, Delete</button>
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal" onclick="disableThis(this)">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f5eaf3;
        margin: 0;
        padding: 0;
    }

    .custom-container {
        max-width: 1300px;
        margin: auto;
        padding: 0;
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

    .main-content {
        display: flex;
        gap: 80px;
        padding: 20px 10px;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: flex-start;
    }

    .sidebar {
        width: 100%;
        max-width: 259px;
        background-color: #ffffff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        flex-shrink: 0;
        margin-left: 23px;
        margin-top: 10px;

    }

    .sidebar h2 {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: #d87384;
        position: sticky;
        top: 0;
        background-color: #ffffff;
        z-index: 1;
        padding-bottom: 5px;
    }

    .sidebar h4 {
        font-size: 1.0rem;
        margin-bottom: 15px;
        color: #d87384;
    }

    .schedule-items {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-height: 240px; /* Approx height for 3 schedule boxes */
        overflow-y: auto;
        padding-right: 5px;
    }
    .schedule-items::-webkit-scrollbar {
        width: 6px;
    }

    .schedule-items::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .schedule-items::-webkit-scrollbar-thumb {
        background: #d87384;
        border-radius: 10px;
    }

    .schedule-items::-webkit-scrollbar-thumb:hover {
        background: #c05c6e;
    }
    .schedule-box {
        background-color: #fef1f4;
        color: #333;
        padding: 3px 10px;
        border-left: 6px solid #d87384;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        cursor: pointer;
        transition: transform 0.2s ease;
        margin-bottom: 5px;
        color: #7a3558;
    }

    .schedule-box:hover {
        transform: translateY(-3px);
    }

    .schedule-details-content {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: max-height 0.4s ease, opacity 0.4s ease;
        padding: 0;
        margin: 0;
    }

    .schedule-details-content.open {
        max-height: 300px;
        opacity: 1;
    }

    .view-mode {
        padding: 0;
        margin: 0;
        line-height: 1.5;
    }

    .view-mode p {
        font-size: 0.8rem;
        margin: 0;
        padding: 0;
        color: #7a3558;

    }

    .delete-btn {
        background: transparent;
        border: none;
        cursor: pointer;
        margin-top: 5px;
        margin-left: 200px;
        padding: 0;
        transition: transform 0.3s, color 0.3s;
    }

    .delete-btn:hover i {
        transform: scale(1.2);
        color: darkred;
    }

    .class-details {
        flex: 1;
        max-width: 850px;
        margin-right: 25px;
        background-color: #f7d9eb;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .class-details h1 {
        color: #4c305f;
        margin-bottom: 15px;
    }

    .description {
        color: #333;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .book-box {
        padding: 10px 0;
        margin-bottom: 30px;
        border-left: 2px solid #4c305f;
        padding-left: 20px;
    }

    .btn-book {
        display: inline-block;
        background-color: #d87384;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .benefits {
        list-style-type: disc;
        padding-left: 20px;
    }

    .benefits li {
        margin-bottom: 8px;
        color: #4c305f;
    }
    .success-message {
        padding: 10px 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        font-weight: bold;
        width: fit-content;
        animation: fadeIn 0.5s ease-in-out;
    }

    .success-message.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .success-message.danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .main-content {
            flex-direction: column;
            padding: 20px;
        }

        .sidebar {
            max-width: 100%;
        }

        .class-details {
            max-width: 100%;
        }
    }
        /* Modal Styling (Adapted from your other page) */
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-dialog {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100%;
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 8px;
        width: 90%;
        max-width: 400px;
        position: relative;
    }

    .modal-header {
        display: flex;
        justify-content: center;
        align-items: center;
        border-bottom: 1px solid #dee2e6;
    }

    .modal-title {
        font-size: 1.25rem;
        color: #333;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .modal-body {
        padding: 20px 0;
        text-align: center;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 10px;
        border-top: 1px solid #dee2e6;
    }

    .btn-cancel {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    .btn-cancel:disabled,
    .btn-delete:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-cancel:hover:not(:disabled) {
        background-color: #5a6268;
    }

    .btn-delete:hover:not(:disabled) {
        background-color: #c82333;
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
            // For buttons: check if it's the delete button in the modal
            if (button.classList.contains('btn-delete')) {
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
    function toggleDetails(header) {
        const details = header.nextElementSibling;
        const allDetails = document.querySelectorAll('.schedule-details-content');
        
        // Close all other open details
        allDetails.forEach(item => {
            if (item !== details && item.classList.contains('open')) {
                item.classList.remove('open');
            }
        });
        
        // Toggle the clicked details
        details.classList.toggle('open');
    }
    document.addEventListener('DOMContentLoaded', function () {
    const successMessage = document.querySelector('.success-message');
    if (successMessage) {
        setTimeout(() => {
            successMessage.classList.add('fade-out');
            setTimeout(() => {
                successMessage.remove();
            }, 1000);
        }, 5000);
    }
});
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const action = button.getAttribute('data-action');

        if (action) {
            deleteForm.setAttribute('action', action);
        }
    });

    // Optional: disable button to prevent multiple submissions
    deleteForm.addEventListener('submit', function () {
        const submitBtn = deleteForm.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerText = 'Deleting...';
    });
</script>
@endsection