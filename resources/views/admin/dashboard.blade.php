@extends('layouts.admin')

@section('content')

<h1 class="mt-4">Dashboard</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Overview</li>
</ol>

<div class="container-fluid px-0">

    <!-- Cards -->
    <div class="row g-3">

        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white shadow h-100">
                <div class="card-body">
                    <h6>Total Users</h6>
                    <h2>{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white shadow h-100">
                <div class="card-body">
                    <h6>Total Deposit</h6>
                    <h2>₹ {{ $totalDeposit }}</h2>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white shadow h-100">
                <div class="card-body">
                    <h6>Total Withdraw</h6>
                    <h2>₹ {{ $totalWithdraw }}</h2>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-dark shadow h-100">
                <div class="card-body">
                    <h6>Profit</h6>
                    <h2>₹ {{ $profit }}</h2>
                </div>
            </div>
        </div>

    </div>


    <!-- Tables Row -->
    <div class="row mt-4">

        <!-- Last Bets -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Last 5 Bets</div>
                <div class="card-body table-responsive">
                    <table class="table table-sm">
                        <tr>
                            <th>User</th>
                            <th>Number</th>
                            <th>Amount</th>
                        </tr>
                        @foreach($lastBets as $bet)
                        <tr>
                            <td>{{ $bet->user->username ?? '' }}</td>
                            <td>{{ $bet->number }}</td>
                            <td>₹ {{ $bet->amount }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- Last Winners -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Last 5 Winners</div>
                <div class="card-body table-responsive">
                    <table class="table table-sm">
                        <tr>
                            <th>User</th>
                            <th>Number</th>
                            <th>Amount</th>
                        </tr>
                        @foreach($lastWinners as $bet)
                        <tr>
                            <td>{{ $bet->user->username ?? '' }}</td>
                            <td>{{ $bet->number }}</td>
                            <td>₹ {{ $bet->amount }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Deposit & Withdraw -->
    <div class="row mt-4">

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Last 5 Deposits</div>
                <div class="card-body table-responsive">
                    <table class="table table-sm">
                        <tr>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                        @foreach($lastDeposits as $d)
                        <tr>
                            <td>{{ $d->user->username ?? '' }}</td>
                            <td>₹ {{ $d->amount }}</td>
                            <td>{{ $d->created_at }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Last 5 Withdrawals</div>
                <div class="card-body table-responsive">
                    <table class="table table-sm">
                        <tr>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                        @foreach($lastWithdrawals as $w)
                        <tr>
                            <td>{{ $w->user->username ?? '' }}</td>
                            <td>₹ {{ $w->amount }}</td>
                            <td>{{ $w->created_at }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- Chart -->
    <div class="card mt-4">
        <div class="card-header">
            Profit Overview
        </div>
        <div class="card-body">
            <canvas id="profitChart"></canvas>
        </div>
    </div>

</div>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('profitChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Now'],
        datasets: [{
            label: 'Profit',
            data: [{{ $profit }}],
            borderWidth: 2
        }]
    }
});
</script>

@endsection