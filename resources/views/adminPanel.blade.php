@extends('layouts.app')

@section('title', 'Admin Panel')

@section('custom-css')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
    @role('admin')
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role_id == 1)
                            Admin
                        @else
                            User
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary mx-1"
                            data-bs-toggle="modal"
                            data-bs-target="#editUserModal"
                            data-id="{{ $user->id }}"
                            data-name="{{ $user->name }}"
                            data-email="{{ $user->email }}"
                            data-role="{{ $user->role_id }}">
                            Edit
                        </button>
                        <form action="{{ route('users.destroy', ['id' => $user->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal for update-->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form to edit user -->
                    <form id="editUserForm" method="POST" action="{{ route('users.update', ['id' => 'userIdPlaceholder']) }}">
                        @csrf
                        <input type="hidden" id="userId" name="user_id">
                        <div class="mb-3">
                            <label for="userName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="userName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="userEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="userRole" class="form-label">Role</label>
                            <select class="form-select" id="userRole" name="role" required>
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @else
        <p>You do not have permission to view or manage users.</p>
    @endrole
@endsection

@section('custom-js')

@endsection
