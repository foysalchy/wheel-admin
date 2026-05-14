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
<h3>Running Round: <span id="roundId"></span></h3>

<table class="table">
  <thead>
    <tr>
      <th>Number</th>
      <th>Total Bet</th>
    </tr>
  </thead>
  <tbody id="betTable"></tbody>
</table>
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
<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
<script>
  const socket = io("http://localhost:5000");

  socket.on("connect", () => {
    console.log("connected");
  });

  socket.on("sync_state", (data) => {
    document.getElementById("roundId").innerText = data.roundId;
  });

  socket.on("bet_summary", (data) => {
    let html = "";

    data.forEach(item => {
      html += `<tr>
        <td>${item.number}</td>
        <td>${item.total}</td>
      </tr>`;
    });

    document.getElementById("betTable").innerHTML = html;
  });
</script>
@endsection