@extends('layouts.admin')

@section('content')

<h1 class="mt-4">All Bets</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Bet History</li>
</ol>

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
                                ৳ {{ $bet->amount }}
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

        </div>

    </div>
</div>

@endsection