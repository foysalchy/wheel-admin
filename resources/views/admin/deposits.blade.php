@extends('layouts.admin')

@section('content')

<h1 class="mt-4">Deposits</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Deposit Requests</li>
</ol>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-money-bill-wave me-1"></i>
        All Deposits
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

@foreach($deposits as $deposit)

<tr>

    <td>{{ $deposit->user->username ?? 'N/A' }}</td>

    <td class="text-success fw-bold">৳ {{ $deposit->amount }}</td>

    <td>
        <span class="badge bg-info text-dark">
            {{ $deposit->method }}
        </span>
    </td>

    <td>
        @if($deposit->status == 'pending')
            <span class="badge bg-warning text-dark">Pending</span>
        @elseif($deposit->status == 'approved')
            <span class="badge bg-success">Approved</span>
        @else
            <span class="badge bg-danger">Rejected</span>
        @endif
    </td>

    <!-- ✅ DATE COLUMN -->
    <td>
        <small class="text-muted">
            {{ $deposit->created_at->format('d M Y, h:i A') }}
        </small>
    </td>

    <td>
        @if($deposit->status == 'pending')
            <form method="POST" action="{{ url('/admin/deposits/'.$deposit->id.'/approve') }}" class="d-inline">
                @csrf
                <button class="btn btn-success btn-sm">Approve</button>
            </form>
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