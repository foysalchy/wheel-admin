@extends('layouts.admin')

@section('content')

<h1 class="mt-4">Rounds</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">All Game Rounds</li>
</ol>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-dice me-1"></i>
        Round History
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="datatablesSimple">

                <thead class="table-dark">
                    <tr>
                        <th>Round ID</th>
                        <th>Result</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($rounds as $round)

                    <tr>
                        <td>{{ $round->roundid }}</td>

                        <td>
                            <span class="badge bg-primary">
                                {{ $round->result ?? 'N/A' }}
                            </span>
                        </td>

                        <td>
                            @if($round->status == 1)
                                <span class="badge bg-danger">Closed</span>
                            @else
                                <span class="badge bg-success">Running</span>
                            @endif
                        </td>

                        <td>{{ $round->created_at }}</td>
                    </tr>

                    @endforeach

                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection