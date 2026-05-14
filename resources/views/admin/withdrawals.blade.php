@extends('layouts.admin')

@section('content')

<h1 class="mt-4">Withdrawals</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Withdrawal Requests</li>
</ol>
<div class="card mb-4 shadow-sm border-0">
    <div class="card-body">
        <form method="GET">
            <div class="row align-items-end">

                <div class="col-md-4">
                    <label>From</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-md-4">
                    <label>To</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>

                <div class="col-md-4">
                    <button class="btn btn-primary w-100">
                        Filter
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="row mb-4">

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small>Total Withdraw</small>
                <h4 class="text-danger">₹ {{ number_format($totalWithdraw,2) }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small>Pending</small>
                <h4 class="text-warning">₹ {{ number_format($pendingWithdraw,2) }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small>Approved</small>
                <h4 class="text-success">₹ {{ number_format($approvedWithdraw,2) }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small>Rejected</small>
                <h4 class="text-secondary">₹ {{ number_format($rejectedWithdraw,2) }}</h4>
            </div>
        </div>
    </div>

</div>
<div class="card mb-4">

    <div class="card-header">
        <i class="fas fa-hand-holding-usd me-1"></i>
        All Withdrawals
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle" id="datatablesSimple">

                <thead class="table-dark">
    <tr>
        <th>User</th>
        <th>Amount</th>
        <th>Method</th>
        <th>Status</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
</thead>

<tbody>

@foreach($withdrawals as $withdraw)

<tr>

    <td>{{ $withdraw->user->username ?? 'N/A' }}</td>

    <td class="text-danger fw-bold">₹ {{ $withdraw->amount }}</td>

    <td>
        <span class="badge bg-info text-dark">
            {{ $withdraw->method }}
        </span>
    </td>

    <td>
        @if($withdraw->status == 'pending')
            <span class="badge bg-warning text-dark">Pending</span>
        @elseif($withdraw->status == 'approved')
            <span class="badge bg-success">Approved</span>
        @else
            <span class="badge bg-danger">Rejected</span>
        @endif
    </td>

    <!-- ✅ DATE COLUMN -->
    <td>
        <small class="text-muted">
            {{ $withdraw->created_at->format('d M Y, h:i A') }}
        </small>
    </td>

    <td>
        @if($withdraw->status == 'pending')

            <form method="POST" action="{{ url('/admin/withdrawals/'.$withdraw->id.'/approve') }}" class="d-inline">
                @csrf
                <button class="btn btn-success btn-sm">Approve</button>
            </form>

            <form method="POST" action="{{ url('/admin/withdrawals/'.$withdraw->id.'/reject') }}" class="d-inline">
                @csrf
                <button class="btn btn-danger btn-sm">Reject</button>
            </form>

        @else
            <span class="text-muted">No Action</span>
        @endif
    </td>

</tr>

@endforeach

</tbody>

            </table>

        </div>

    </div>

</div>

@endsection