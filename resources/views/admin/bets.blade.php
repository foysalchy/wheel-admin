@extends('layouts.admin')

@section('content')

<h1 class="mt-4">All Bets</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Bet History</li>
</ol>

<div class="card mb-4 shadow-sm border-0">
    <div class="card-body">

        <form method="GET">
            <div class="row align-items-end">

                <div class="col-md-4">
                    <label>From Date</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-md-4">
                    <label>To Date</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>

                <div class="col-md-4">
                    <button class="btn btn-primary w-100">
                        Filter Bets
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
                <small>Total Bet</small>
                <h4 class="text-primary">₹ {{ number_format($totalBet,2) }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small>Total Win</small>
                <h4 class="text-success">₹ {{ number_format($totalWin,2) }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small>Total Loss</small>
                <h4 class="text-danger">₹ {{ number_format($totalLoss,2) }}</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small>Total Cancel</small>
                <h4 class="text-secondary">₹ {{ number_format($totalCancel,2) }}</h4>
            </div>
        </div>
    </div>

</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-dice me-1"></i>
        Bets List
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover" id="datatablesSimple">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Round ID</th>
                        <th>Number</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Time</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($bets as $bet)

                    <tr>
                        <td>{{ $bet->id }}</td>

                        <td>
                            <span class="fw-bold">
                                {{ $bet->user->username ?? 'N/A' }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-secondary">
                                {{ $bet->round_id }}
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-primary">
                                {{ $bet->number }}
                            </span>
                        </td>

                        <td>
                            <span class="text-success fw-bold">
                                ₹ {{ $bet->amount }}
                            </span>
                        </td>

                        <td>
                            @if($bet->status == 1)
                                <span class="badge bg-success">Win</span>
                            @else
                                <span class="badge bg-danger">Lose</span>
                            @endif
                        </td>

                        <td>
                            <small class="text-muted">
                                {{ $bet->created_at }}
                            </small>
                        </td>
                    </tr>

                @endforeach

                </tbody>

            </table>
<div class="d-flex justify-content-between align-items-center mt-4 p-3 bg-white rounded shadow-sm">

    <div class="text-muted small">
        Showing {{ $bets->firstItem() }} to {{ $bets->lastItem() }} of {{ $bets->total() }} results
    </div>

    <div class="pagination-wrapper">
        {{ $bets->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

</div>
<style>
    .pagination {
    margin: 0;
    gap: 5px;
}

.pagination .page-link {
    border-radius: 6px !important;
    border: 1px solid #e5e7eb;
    color: #333;
    padding: 6px 12px;
    transition: 0.2s;
}

.pagination .page-link:hover {
    background: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
}

.pagination .page-item.active .page-link {
    background: #0d6efd;
    border-color: #0d6efd;
    color: #fff;
}
.datatable-pagination{
    display:none
}
</style>
        </div>

    </div>
</div>

@endsection