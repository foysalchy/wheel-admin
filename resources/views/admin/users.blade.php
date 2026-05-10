@extends('layouts.admin')

@section('content')

<h1 class="mt-4">Users</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">All Registered Users</li>
</ol>

<div class="card mb-4">

    <div class="card-header">
        <i class="fas fa-users me-1"></i>
        Users List
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle" id="datatablesSimple">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Wallet</th>
                        <th>Email</th>
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
                            <span class="text-success fw-bold">
                                ₹ {{ $user->wallet }}
                            </span>
                        </td>

                        <td>
                            <span class="text-muted">
                                {{ $user->email }}
                            </span>
                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection