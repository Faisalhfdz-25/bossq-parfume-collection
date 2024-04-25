@extends('layouts.app')

@section('title', 'User Table')

@push('style')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>User Table</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <!-- Button trigger modal for creating user -->
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                            data-target="#createUserModal">
                            <i class="fa-solid fa-plus" style="color: #ffffff;"></i> Create User
                        </button>

                        <div class="table-responsive">
                            <table id="users-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <!-- Button trigger modal for editing user -->
                                                    <button type="button" class="btn btn-warning btn-sm edit-user mr-2"
                                                        data-toggle="modal" data-target="#editUserModal{{ $user->id }}"
                                                        data-user-id="{{ $user->id }}" data-backdrop="false">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <!-- Delete User Form -->
                                                    <form id="delete-form-{{ $user->id }}"
                                                        action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm delete-user">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>

                                        </tr>
                                        @php $count++; @endphp
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal for creating user -->
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Form for creating user -->
                                <form action="{{ route('user.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control" required>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select name="role" id="role" class="form-control" required>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for editing user -->
    @foreach ($users as $user)
        <!-- Modal for editing user -->
        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Form for editing user -->
                                    <form id="edit-form-{{ $user->id }}"
                                        action="{{ route('user.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="edit_name{{ $user->id }}">Name</label>
                                            <input type="text" name="name" id="edit_name{{ $user->id }}"
                                                class="form-control" value="{{ $user->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_email{{ $user->id }}">Email</label>
                                            <input type="email" name="email" id="edit_email{{ $user->id }}"
                                                class="form-control" value="{{ $user->email }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_phone{{ $user->id }}">Phone</label>
                                            <input type="text" name="phone" id="edit_phone{{ $user->id }}"
                                                class="form-control" value="{{ $user->phone }}" required>
                                        </div>
                                        <!-- Add more input fields as needed -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_username{{ $user->id }}">Username</label>
                                        <input type="text" name="username" id="edit_username{{ $user->id }}"
                                            class="form-control" value="{{ $user->username }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_password{{ $user->id }}">Password</label>
                                        <input type="password" name="password" id="edit_password{{ $user->id }}"
                                            class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_role{{ $user->id }}">Role</label>
                                        <select name="role" id="edit_role{{ $user->id }}" class="form-control"
                                            required>
                                            <option value="admin" @if ($user->role == 'admin') selected @endif>Admin
                                            </option>
                                            <option value="user" @if ($user->role == 'user') selected @endif>User
                                            </option>
                                            <!-- Add more options as needed -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@push('scripts')
    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Sweet Alert for delete confirmation
            $('.delete-user').click(function() {
                var userId = $(this).data('user-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this user!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the delete form
                        $('#delete-form-' + userId).submit();
                    }
                });
            });

            // Handle success message after deletion
            var successMessage = '{{ session('success') }}';
            if (successMessage) {
                Swal.fire({
                    title: 'Success!',
                    text: successMessage,
                    icon: 'success',
                    timer: 2000 // Set the timer for auto-close
                });
            }

            // Handle modal for editing user
            $('.edit-user').click(function() {
                var userId = $(this).data('user-id');
                $('#editUserModal' + userId).modal({
                    show: true,
                    backdrop: false
                });
            });

        });
    </script>
@endpush
