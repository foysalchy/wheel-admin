@extends('layouts.admin')

@section('content')

<h1 class="mt-4">Users</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">All Registered Users</li>
</ol>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card mb-4">

    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-users me-1"></i>
            Users List
        </div>

        <!-- Create Button -->
        <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#createUserModal">
            <i class="fas fa-plus"></i>
            Create User
        </button>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle" id="datatablesSimple">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Wallet</th>
                        <th>Email</th>
                        <th>Promoter</th>
                        <th>Vip</th>
                        <th>status</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($users as $user)

                    <tr>

                        <td>
                            <span class="badge bg-secondary">
                                {{ $user->id }}
                            </span>
                        </td>

                        <td>
                            <span class="fw-bold">
                                {{ $user->username }}
                            </span>
                        </td>
                          <td>
                            <span class="fw-bold">
                                {{ $user->password_txt ?? '' }}
                            </span>
                        </td>

                        <td>
                            <span class="text-success fw-bold">
                                ₹ {{ $user->wallet }}
                            </span>
                        </td>

                        <td>
                            <span class="text-muted">
                                {{ $user->email }}
                            </span>
                        </td>
                        <td>
                @if($user->is_promoter)
                    <span class="badge bg-success">
                        YES
                    </span>
                @else
                    <span class="badge bg-secondary">
                        NO
                    </span>
                @endif
            </td>

            <!-- VIP -->
            <td>
                @if($user->is_vip)
                    <span class="badge bg-warning text-dark">
                        VIP
                    </span>
                @else
                    <span class="badge bg-secondary">
                        NO
                    </span>
                @endif
            </td>
             <td>
                @if($user->status == 1)
                    <span class="badge bg-success text-dark">
                        Active
                    </span>
                @else
                    <span class="badge bg-warning">
                        Block
                    </span>
                @endif
            </td>

                       <td >
<div class="d-flex gap-1">
    <!-- VIEW -->
<a href="{{ route('admin.users.profile', $user->id) }}"
   class="btn btn-info btn-sm">

    <i class="fas fa-eye"></i>

</a>
    <!-- EDIT -->
    <button class="btn btn-warning btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#editUserModal{{ $user->id }}">

        <i class="fas fa-edit"></i>
    </button>

    <!-- DELETE -->
    <form action="{{ route('admin.users.delete', $user->id) }}"
          method="POST"
          onsubmit="return confirm('Are you sure to delete this user?')">

        @csrf

        <button type="submit"
                class="btn btn-danger btn-sm">

            <i class="fas fa-trash"></i>

        </button>

    </form>
</div>
</td>

                    </tr>

                    <!-- EDIT MODAL -->
                    <div class="modal fade"
                         id="editUserModal{{ $user->id }}"
                         tabindex="-1">

                        <div class="modal-dialog">

                            <div class="modal-content">

                                <form action="{{ route('admin.users.update', $user->id) }}"
                                      method="POST">

                                    @csrf

                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Edit User
                                        </h5>

                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                        </button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Username
                                            </label>

                                            <input type="text"
                                                   name="username"
                                                   class="form-control"
                                                   value="{{ $user->username }}"
                                                   required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Email
                                            </label>

                                            <input type="email"
                                                   name="email"
                                                   class="form-control"
                                                   value="{{ $user->email }}"
                                                   required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Wallet
                                            </label>

                                            <input type="number"
                                                   step="0.01"
                                                   name="wallet"
                                                   class="form-control"
                                                   value="{{ $user->wallet }}"
                                                   required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                New Password
                                            </label>

                                            <input type="password"
                                                   name="password"
                                                   class="form-control">

                                            <small class="text-muted">
                                                Leave empty if you don't want to change password
                                            </small>
                                        </div>
                                        <div class="mb-3">

    <div class="form-check mb-2">
        <input class="form-check-input"
               type="checkbox"
               name="promoter"
               value="1"
               id="promoter{{ $user->id }}"
               {{ $user->is_promoter ? 'checked' : '' }}>

        <label class="form-check-label"
               for="promoter{{ $user->id }}">
            Promoter Account
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input"
               type="checkbox"
               name="vip"
               value="1"
               id="vip{{ $user->id }}"
               {{ $user->is_vip ? 'checked' : '' }}>

        <label class="form-check-label"
               for="vip{{ $user->id }}">
            VIP Account
        </label>
    </div>
    <div class="mb-3">

    <label class="form-label">
        Status
    </label>

    <select name="status" class="form-select">

        <option value="1"
            {{ $user->status == 1 ? 'selected' : '' }}>
            Active
        </option>

        <option value="0"
            {{ $user->status == 0 ? 'selected' : '' }}>
            Block
        </option>

    </select>

</div>

</div>

                                    </div>

                                    <div class="modal-footer">

                                        <button type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal">
                                            Close
                                        </button>

                                        <button type="submit"
                                                class="btn btn-primary">
                                            Update User
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- CREATE USER MODAL -->
<div class="modal fade"
     id="createUserModal"
     tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{ route('admin.users.store') }}"
                  method="POST">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">
                        Create User
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">
                            Username
                        </label>

                        <input type="text"
                               name="username"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Wallet
                        </label>

                        <input type="number"
                               step="0.01"
                               name="wallet"
                               class="form-control"
                               value="0"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Password
                        </label>

                        <input type="password"
                               name="password"
                               class="form-control"
                               required>
                    </div>
                      <div class="form-check mb-2">
        <input class="form-check-input"
               type="checkbox"
               name="promoter"
               value="1"
               id="createPromoter">

        <label class="form-check-label" for="createPromoter">
            Promoter Account
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input"
               type="checkbox"
               name="vip"
               value="1"
               id="createVip">

        <label class="form-check-label" for="createVip">
            VIP Account
        </label>
    </div>
    <div class="mb-3">

    <label class="form-label">
        Status
    </label>

    <select name="status" class="form-select">

        <option value="1">
            Active
        </option>

        <option value="0">
            Block
        </option>

    </select>

</div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="submit"
                            class="btn btn-success">
                        Create User
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection