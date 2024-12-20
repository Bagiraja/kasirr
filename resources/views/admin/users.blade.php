@extends('layouts.admin')

@section('content')
<style>
    body{
        overflow-y: auto;
        overflow-x: auto;
    }
    .user-management {

        padding: 20px;
    }

    .search-container {
        max-width: 600px;
        margin-bottom: 2rem;
    }

    .table-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .role-select-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .role-select {
        min-width: 150px;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: flex-start;
    }

    .delete-btn {
        background-color: #dc3545;
        color: white;
    }

    .custom-table {
        font-size: 0.9rem;
        margin-bottom: 2rem;
    }

    .custom-table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .pagination {
        margin-bottom: 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .role-select-container {
            flex-direction: column;
            align-items: stretch;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn {
            width: 100%;
            margin-bottom: 5px;
        }
    }
</style>
<div class="container-fluid user-management">
    <h3 class="mb-4">Manajemen Pengguna</h3>
    <!-- Search Form -->
    <div class="search-container">
        <form action="{{ route('admin.users.search') }}" method="GET">
            <div class="input-group">
                <input 
                    type="text" 
                    class="form-control" 
                    name="query" 
                    placeholder="Search users by name or email" 
                    value="{{ request()->input('query') }}"
                    aria-label="Search users"
                >
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>
    </div>

    <!-- Add User Button -->
    <div class="mb-4">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-plus"></i> Add New User
        </button>
    </div>

    <!-- User List Table -->
    <div class="table-container">
        <h4 class="mb-4">User Management</h4>
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="role-select-container">
                                    <form id="role-form-{{ $user->id }}" 
                                          action="{{ route('admin.users.update-role', $user->id) }}" 
                                          method="POST" 
                                          class="d-flex gap-2">
                                        @csrf
                                        <select name="role" class="form-select role-select">
                                            @foreach(['admin', 'pengguna', 'petugas_kasir', 'petugas_barang'] as $role)
                                                <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>
                                                    {{ ucwords(str_replace('_', ' ', $role)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Update
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.users.delete', $user->id) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm delete-btn"
                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
                <!-- Tombol 'Previous' -->
                <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $users->previousPageUrl() }}">Previous</a>
                </li>

                <!-- Menampilkan nomor halaman -->
                @for ($i = 1; $i <= $users->lastPage(); $i++)
                    <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                <!-- Tombol 'Next' -->
                <li class="page-item {{ !$users->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a>
                </li>
            </ul>
        </nav>

    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.users.store') }}" method="POST" id="addUserForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="pengguna">Pengguna</option>
                            <option value="petugas_kasir">Petugas Kasir</option>
                            <option value="petugas_barang">Petugas Barang</option>
                        </select>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation for add user
    const addUserForm = document.getElementById('addUserForm');
    if (addUserForm) {
        addUserForm.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
            }
        });
    }

    // Confirm delete
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this user?')) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endsection