@extends('layouts.navbar')

@section('content')
<div class="custom-container">
    <div class="main-content">
        <!-- Left Column: Welcome + Sidebar -->
        <div class="left-column">
            <!-- Redesigned Welcome Section -->
            <div class="welcome-section">
                <div class="welcome-card">
                    <div class="welcome-header">
                        <h1>Welcome to FitZone{{ Auth::check() ? ', ' . Str::limit(Auth::user()->first_name, 10) : '' }}</h1>
                    </div>

                    <div class="schedule-box upcoming-schedule-box">
                        <div>
                            <small class="label">Upcoming Class</small>
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
                        <i class="fa-solid fa-calendar-days calendar-icon"></i>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
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
                                    <h4>{{ e($schedule->fitnessClass->name) }}</h4>
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
        </div>

        <!-- Classes Section -->
        <section class="class-details">
            <h2>Classes</h2>
            <label for="classFilter"><strong class="filter-label">Filter by Class:</strong></label>
            <select id="classFilter">
                <option value="all">All Classes</option>
                @foreach($classes->unique('name') as $class)
                    <option value="{{ e($class->name) }}">{{ e($class->name) }}</option>
                @endforeach
            </select>

            <div class="class-cards">
                @if($classes->isEmpty())
                    <p>No classes available.</p>
                @else
                    @php
                        $userBookedClassIds = \App\Models\Schedule::where('user_id', Auth::id())->pluck('class_id')->toArray();
                    @endphp

                    @foreach($classes as $class)
                        @php
                            $bookedCount = $class->schedules->count();
                            $limit = $class->user_limit;
                            $isBooked = in_array($class->id, $userBookedClassIds);
                            $isFull = $bookedCount >= $limit;
                        @endphp

                        <div class="class-card">
                            <div class="class-info">
                                <h3 class="class-name">{{ e($class->name) }}</h3>
                                <p><strong>Level:</strong> {{ e($class->level) }}</p>
                                <p><strong>Duration:</strong> {{ e($class->duration) }} Minutes</p>
                                <p><strong>Trainer:</strong> {{ e($class->trainer) }}</p>
                                <p><strong>Bookings:</strong> {{ $bookedCount }} / {{ $limit }}</p>
                            </div>

                            @if ($isFull)
                                <button class="btn-full" disabled>Fully Booked</button>
                            @elseif ($isBooked)
                                <button class="btn-booked" disabled>Already Booked</button>
                            @else
                                <a href="{{ route('viewclass', $class->id) }}" class="btn-book" onclick="disableThis(this)">View</a>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- Pagination Controls -->
            <div class="pagination-controls">
                <button id="prev-page" disabled onclick="disableThis(this)">Previous</button>
                <span id="page-info">Page 1 of 1</span>
                <button id="next-page" onclick="disableThis(this)">Next</button>
            </div>
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
    }

    .custom-container {
        max-width: 1300px;
        margin: auto;
        padding: 0;
    }

    .left-column {
        margin-left: 50px;
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 259px;
        flex-shrink: 0;
    }

    .welcome-section {
        text-align: center;
        width: 1000px;
        max-width: 300px;
        margin-bottom: 20px;
    }

    .welcome-card {
        max-width: 300px;
        background: linear-gradient(to right, #fdeff4, #f9c5d1);
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .welcome-header {
        text-align: center;
        color: #834c71;
    }

    .welcome-header h1 {
        font-size: 1.8rem;
        margin-bottom: 30px;
    }

    .upcoming-schedule-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding: 15px;
        background-color: #fff;
        border-left: 6px solid #d87384;
    }
    .upcoming-schedule-box h3 {
        font-size: 1.2rem;
        margin: 0;
        color: #7a3558;
        margin: 10px 0 10px 0;
    }
    .upcoming-schedule-box small {
        font-size: 0.9rem;
        color: #7a3558;
    }

    .calendar-icon {
        font-size: 30px;
        color: #d87384;
        margin-left: 10px;
    }

    .label {
        font-weight: bold;
        color: #d87384;
        font-size: 0.9rem;
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
        background-color: #ffffff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
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

    .schedule-items {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-height: 240px;
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
        font-size: 0.9rem;
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

    .delete-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .class-details {
        width: 100%;
        max-width: 850px;
        margin-left: 40px;
        flex: 1;
        background-color: #f7d9eb;
        padding: 15px 40px 10px 40px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        flex-grow: 1;
    }

    .class-details h2 {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: #7a3558;
    }

    #classFilter {
        padding: 5px 10px;
        margin: 10px 0 20px;
        border-radius: 5px;
        border: 1px solid #ccc;
        max-width: 100px;
        color: #7a3558;
    }

    .filter-label {
        color: #7a3558;
    }

    .class-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }
    .class-card {
        background-color: #fff;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.07);
        transition: transform 0.2s;
    }
    .class-card:hover {
        transform: translateY(-5px);
    }

    .class-info {
        margin-bottom: 10px;
    }

    .class-info h3 {
        color: #d87384;
        margin: 0 0 10px;
    }

    .class-info p {
        font-size: 0.9rem;
        margin: 3px 0;
        color: #7a3558;
    }
    .btn-book,
    .btn-booked,
    .btn-full {
        display: inline-block;
        padding: 8px 16px;
        font-size: 0.9rem;
        border-radius: 8px;
        text-decoration: none;
        text-align: center;
        transition: background-color 0.3s, transform 0.2s;
    }
    .btn-book {
        background-color: #d87384;
        color: white;
    }
    .btn-book:hover {
        background-color: #c05c6f;
        transform: scale(1.03);
    }
    .btn-book.disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }
    .btn-booked {
        background-color: #ffe5ec;
        color: #d87384;
        cursor: not-allowed;
    }
    .btn-full {
        background-color: #f5c6cb;
        color: #721c24;
        cursor: not-allowed;
    }

    .success-message {
        padding: 10px 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        font-weight: bold;
        width: fit-content;
        animation: fadeIn 0.5s ease-in-out;
        position: relative;
        opacity: 1;
        transition: opacity 1s ease-in-out;
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
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-5px); }
    }

    .success-message.fade-out {
        animation: fadeOut 0.5s ease-in-out forwards;
    }

    #classFilter {
        width: 100%;
        margin-bottom: 15px;
        padding: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .pagination-controls {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .pagination-controls button {
        padding: 8px 16px;
        margin: 0 10px;
        background-color: #d87384;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .pagination-controls button:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    .pagination-controls span {
        font-size: 1rem;
        color: #333;
    }

    @media (max-width: 768px) {
        .main-content {
            flex-direction: column;
            padding: 20px;
        }

        .left-column {
            max-width: 100%;
        }

        .sidebar {
            width: 100%;
        }

        .class-details {
            padding-left: 0;
            margin-left: 0;
        }

        .class-card {
            flex-direction: column;
            align-items: flex-start;
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
    function setDeleteAction(button) {
        const form = document.getElementById('deleteForm');
        const action = button.getAttribute('data-action');
        form.setAttribute('action', action);
    }
</script>
<script>
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
<script>
    function toggleDetails(headerElement) {
        const content = headerElement.nextElementSibling;
        content.classList.toggle('open');
    }

    // Modified disableThis function
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
    document.addEventListener('DOMContentLoaded', function () {
        let currentPage = 1;
        const perPage = 10;

        function applyPagination() {
            const selectedFilter = document.getElementById('classFilter').value.toLowerCase();
            const allCards = document.querySelectorAll('.class-card');
            const filteredCards = Array.from(allCards).filter(card => {
                const name = card.querySelector('.class-name').textContent.toLowerCase();
                return selectedFilter === 'all' || name.includes(selectedFilter);
            });

            const totalFiltered = filteredCards.length;
            const totalPages = Math.ceil(totalFiltered / perPage);

            if (totalPages === 0) {
                document.getElementById('page-info').textContent = 'Page 0 of 0';
                document.getElementById('prev-page').disabled = true;
                document.getElementById('next-page').disabled = true;
                allCards.forEach(card => card.style.display = 'none');
                return;
            }

            if (currentPage > totalPages) {
                currentPage = totalPages;
            }

            document.getElementById('page-info').textContent = `Page ${currentPage} of ${totalPages}`;
            document.getElementById('prev-page').disabled = currentPage === 1;
            document.getElementById('next-page').disabled = currentPage === totalPages;

            const start = (currentPage - 1) * perPage;
            const end = start + perPage;

            allCards.forEach(card => {
                if (filteredCards.includes(card)) {
                    const index = filteredCards.indexOf(card);
                    if (index >= start && index < end) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                } else {
                    card.style.display = 'none';
                }
            });
        }

        document.getElementById('classFilter').addEventListener('change', function () {
            currentPage = 1;
            applyPagination();
        });

        document.getElementById('prev-page').addEventListener('click', function () {
            if (currentPage > 1) {
                currentPage--;
                applyPagination();
            }
        });

        document.getElementById('next-page').addEventListener('click', function () {
            const selectedFilter = document.getElementById('classFilter').value.toLowerCase();
            const allCards = document.querySelectorAll('.class-card');
            const filteredCards = Array.from(allCards).filter(card => {
                const name = card.querySelector('.class-name').textContent.toLowerCase();
                return selectedFilter === 'all' || name.includes(selectedFilter);
            });
            const totalPages = Math.ceil(filteredCards.length / perPage);
            if (currentPage < totalPages) {
                currentPage++;
                applyPagination();
            }
        });

        applyPagination();

        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const scheduleId = button.getAttribute('data-schedule-id');
            const form = deleteModal.querySelector('#deleteForm');
            form.action = `/bookclass/${scheduleId}`;
        });

        // Re-enable modal buttons when the modal closes
        deleteModal.addEventListener('hidden.bs.modal', function () {
            document.querySelectorAll('.delete-btn, .btn-delete, .btn-cancel, .btn-close').forEach(button => {
                button.disabled = false;
            });
        });
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection