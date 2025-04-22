@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User Management</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
    @endif

    {{-- Edit Form (if $editUser is set) --}}
    @isset($editUser)
    <div style="margin-bottom: 30px; border: 1px solid #ccc; padding: 15px;">
        <h4>Edit User</h4>
        <form method="POST" action="{{ route('admin.update', $editUser->id) }}">
            @csrf
            @method('PUT')

            <div>
                <label>Name:</label>
                <input type="text" name="name" value="{{ $editUser->name }}" required>
            </div>

            <div>
                <label>Email:</label>
                <input type="email" name="email" value="{{ $editUser->email }}" required>
            </div>

            <button type="submit">Update</button>
            <a href="{{ route('admin.dashboard') }}">Cancel</a>
        </form>
    </div>
    @endisset

    {{-- Users Table --}}
    <table border="1" cellpadding="10" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th width="200">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('admin.dashboard', ['edit' => $user->id]) }}">Edit</a>
                    <form action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
