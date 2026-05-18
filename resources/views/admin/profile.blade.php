@extends('layouts.admin')

@section('content')

<div class="container-fluid px-4">

    <!-- TOP HEADER -->

    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">

        <div>
            <h1 class="fw-bold mb-1">
                User Profile
            </h1>

            <p class="text-muted mb-0">
                Complete user information & transaction history
            </p>
        </div>

        <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#editUserModal">

            <i class="fas fa-edit"></i>
            Edit User

        </button>

    </div>

    <!-- PROFILE CARD -->

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-2 text-center">

                    <div style="
                        width:90px;
                        height:90px;
                        border-radius:50%;
                        background:#0d6efd;
                        color:white;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:32px;
                        font-weight:bold;
                        margin:auto;
                    ">
                        {{ strtoupper(substr($user->username,0,1)) }}
                    </div>

                </div>

                <div class="col-md-10">

                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <small class="text-muted">Username</small>
                            <h5 class="fw-bold">
                                {{ $user->username }}
                            </h5>
                        </div>

                        <div class="col-md-3 mb-3">
                            <small class="text-muted">Email</small>
                            <h6>
                                {{ $user->email }}
                            </h6>
                        </div>

                        <div class="col-md-2 mb-3">
                            <small class="text-muted">Wallet</small>
                            <h5 class="text-success fw-bold">
                                ₹ {{ number_format($user->wallet,2) }}
                            </h5>
                        </div>

                        <div class="col-md-2 mb-3">
                            <small class="text-muted">Promoter</small>
                            <br>

                            @if($user->is_promoter)
                                <span class="badge bg-success">
                                    YES
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    NO
                                </span>
                            @endif
                        </div>

                        <div class="col-md-2 mb-3">
                            <small class="text-muted">VIP</small>
                            <br>

                            @if($user->is_vip)
                                <span class="badge bg-warning text-dark">
                                    VIP
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    NO
                                </span>
                            @endif
                        </div>

                        <div class="col-md-2">
                            <small class="text-muted">Status</small>
                            <br>

                            @if($user->status == 1)
                                <span class="badge bg-success">
                                    Active
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Block
                                </span>
                            @endif
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
<!-- STATISTICS -->

<div class="row mb-4">

    <!-- TOTAL DEPOSIT -->

    <div class="col-md-4 mb-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">
                            Total Deposit
                        </small>

                        <h3 class="fw-bold text-success mb-0">
                            ₹ {{ number_format($totalDeposit, 2) }}
                        </h3>

                    </div>

                    <div class="bg-success bg-opacity-10 p-3 rounded">

                        <i class="fas fa-arrow-down text-success fa-2x"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- TOTAL WITHDRAW -->

    <div class="col-md-4 mb-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">
                            Total Withdraw
                        </small>

                        <h3 class="fw-bold text-danger mb-0">
                            ₹ {{ number_format($totalWithdraw, 2) }}
                        </h3>

                    </div>

                    <div class="bg-danger bg-opacity-10 p-3 rounded">

                        <i class="fas fa-money-bill-wave text-danger fa-2x"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- TOTAL BET -->

    <div class="col-md-4 mb-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">
                            Total Bet
                        </small>

                        <h3 class="fw-bold text-primary mb-0">
                            ₹ {{ number_format($totalBet, 2) }}
                        </h3>
                        <p>Win ₹{{$bets->where('status',1)->sum('amount')}} | Loss ₹{{$bets->where('status',2)->sum('amount')}} | Cancel ₹{{$bets->where('status',3)->sum('amount')}}</p>

                    </div>

                    <div class="bg-primary bg-opacity-10 p-3 rounded">

                        <i class="fas fa-dice text-primary fa-2x"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
    <!-- FILTER -->

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row align-items-end">

                    <div class="col-md-4">

                        <label class="form-label">
                            From Date
                        </label>

                        <input type="date"
                               name="from"
                               value="{{ $from }}"
                               class="form-control">

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">
                            To Date
                        </label>

                        <input type="date"
                               name="to"
                               value="{{ $to }}"
                               class="form-control">

                    </div>

                    <div class="col-md-4">

                        <button class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i>
                            Filter History
                        </button>

                    </div>

                </div>

            </form>

        </div>
        <div class="card-body">
            <!-- PAID ACTION -->

 

 

        <form method="POST" action="{{ route('admin.bets.pay') }}">

            @csrf

            <div class="row align-items-end">

                <div class="col-md-4">

                    <label>From Date</label>

                    <input type="date"
                           name="from"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-4">

                    <label>To Date</label>

                    <input type="date"
                           name="to"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-4">

                    <button class="btn btn-success w-100">
                        <i class="fas fa-check"></i>
                        Mark Bets as Paid
                    </button>

                </div>

            </div>

        </form>

 

 
        </div>

    </div>

    <!-- DEPOSIT HISTORY -->

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-white fw-bold">
            Deposit History
        </div>

        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Account</th>
                        <th>TRX</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($deposits as $deposit)

                    <tr>

                        <td>#{{ $deposit->id }}</td>

                        <td>
    {{ \Carbon\Carbon::parse($deposit->created_at)->format('d M Y, h:i A') }}
</td>
                        <td class="fw-bold text-success">
                            ₹ {{ $deposit->amount }}
                        </td>

                        <td>
                            {{ strtoupper($deposit->method) }}
                        </td>

                        <td>
                            {{ $deposit->account_number }}
                        </td>

                        <td>
                            {{ $deposit->trx_id }}
                        </td>

                        <td>

                            @if($deposit->status == 'approved')
                                <span class="badge bg-success">
                                    Approved
                                </span>

                            @elseif($deposit->status == 'pending')
                                <span class="badge bg-warning text-dark">
                                    Pending
                                </span>

                            @else
                                <span class="badge bg-danger">
                                    Rejected
                                </span>
                            @endif

                        </td>

                        <td>

                            @if($deposit->status == 'pending')

                                <div class="d-flex gap-1">

                                    <form method="POST"
                                          action="{{ url('/admin/deposits/'.$deposit->id.'/approve') }}">

                                        @csrf

                                        <button class="btn btn-success btn-sm">
                                            Approve
                                        </button>

                                    </form>

                                    <form method="POST"
                                          action="{{ url('/admin/deposits/'.$deposit->id.'/reject') }}">

                                        @csrf

                                        <button class="btn btn-danger btn-sm">
                                            Reject
                                        </button>

                                    </form>

                                </div>

                            @else

                                <span class="text-muted">
                                    No Action
                                </span>

                            @endif

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <!-- WITHDRAW HISTORY -->

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-white fw-bold">
            Withdrawal History
        </div>

        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Account</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($withdrawals as $withdraw)

                    <tr>

                        <td>#{{ $withdraw->id }}</td>
<td>
    {{ \Carbon\Carbon::parse($withdraw->created_at)->format('d M Y, h:i A') }}
</td>
                        <td class="fw-bold text-danger">
                            ₹ {{ $withdraw->amount }}
                        </td>

                        <td>
                            {{ strtoupper($withdraw->method) }}
                        </td>

                        <td>
                            {{ $withdraw->account_number }}
                        </td>

                        <td>
                            {{ $withdraw->account_name }}
                        </td>

                        <td>

                            @if($withdraw->status == 'approved')
                                <span class="badge bg-success">
                                    Approved
                                </span>

                            @elseif($withdraw->status == 'pending')
                                <span class="badge bg-warning text-dark">
                                    Pending
                                </span>

                            @else
                                <span class="badge bg-danger">
                                    Rejected
                                </span>
                            @endif

                        </td>

                        <td>

                            @if($withdraw->status == 'pending')

                                <div class="d-flex gap-1">

                                    <form method="POST"
                                          action="{{ url('/admin/withdrawals/'.$withdraw->id.'/approve') }}">

                                        @csrf

                                        <button class="btn btn-success btn-sm">
                                            Approve
                                        </button>

                                    </form>

                                    <form method="POST"
                                          action="{{ url('/admin/withdrawals/'.$withdraw->id.'/reject') }}">

                                        @csrf

                                        <button class="btn btn-danger btn-sm">
                                            Reject
                                        </button>

                                    </form>

                                </div>

                            @else

                                <span class="text-muted">
                                    No Action
                                </span>

                            @endif

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <!-- BET HISTORY -->

    <div class="card shadow-sm border-0 mb-5">

        <div class="card-header bg-white fw-bold">
            Bet History
        </div>

        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Number</th>
                        <th>Amount</th>
                        <th>Round</th>
                        <th>Bet Status</th>
                        <th>Paid Status</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($bets as $bet)

                    <tr>

                        <td>#{{ $bet->id }}</td>
                        <td>
    {{ \Carbon\Carbon::parse($bet->created_at)->format('d M Y, h:i A') }}
</td>

                        <td>
                            {{ $bet->number }}
                        </td>

                        <td class="fw-bold">
                            ₹ {{ $bet->amount }}
                        </td>

                        <td>
                            {{ $bet->round_id }}
                        </td>

                        <td>

                            @if($bet->status == 0)

                                <span class="badge bg-warning text-dark">
                                    Pending
                                </span>

                            @elseif($bet->status == 1)

                                <span class="badge bg-success">
                                    Win
                                </span>

                            @elseif($bet->status == 2)

                                <span class="badge bg-danger">
                                    Loss
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    Cancel
                                </span>

                            @endif

                        </td>
                        <td>

                            @if($bet->status == 0)

                                <span class="badge bg-warning text-dark">
                                    Pending
                                </span>
 
                            @else if($bet->is_paid == 0)

                                <span class="badge bg-secondary">
                                    UnPaid
                                </span>
                            @else

                                <span class="badge bg-success">
                                    Paid
                                </span>

                            @endif

                        </td>

                        <td>
                            {{ $bet->created_at }}
                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- EDIT USER MODAL -->

<div class="modal fade"
     id="editUserModal"
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
                               value="{{ $user->username }}">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ $user->email }}">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Wallet
                        </label>

                        <input type="number"
                               step="0.01"
                               name="wallet"
                               class="form-control"
                               value="{{ $user->wallet }}">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            New Password
                        </label>

                        <input type="password"
                               name="password"
                               class="form-control">

                    </div>

                    <div class="form-check mb-2">

                        <input class="form-check-input"
                               type="checkbox"
                               name="promoter"
                               value="1"
                               {{ $user->is_promoter ? 'checked' : '' }}>

                        <label class="form-check-label">
                            Promoter Account
                        </label>

                    </div>

                    <div class="form-check mb-3">

                        <input class="form-check-input"
                               type="checkbox"
                               name="vip"
                               value="1"
                               {{ $user->is_vip ? 'checked' : '' }}>

                        <label class="form-check-label">
                            VIP Account
                        </label>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select name="status"
                                class="form-select">

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

@endsection