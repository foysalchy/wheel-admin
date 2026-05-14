@extends('layouts.admin')

@section('content')

<h1 class="mt-4">Rounds</h1>
<style>
    .flex-fill{
        border-right:1px solid black
    }
    .fw-bold{
        border-bottom:1px solid gray
    }
    
</style>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">All Game Rounds</li>
</ol>


<div class="d-flex gap-4 align-items-center mb-3">

  <h3 class="mb-0">
    🎲 Round ID: <span id="roundId" class="badge bg-primary px-3 py-2"></span>
  </h3>

  <h3 class="mb-0">
    ⏱ Time Left: <span id="timeLeft" class="badge bg-danger px-3 py-2"></span>s
  </h3>
   <span>Select Number: {{$roundf->result}}</span>

</div>

<!-- 0 - 9 Row -->
<div class="card shadow-sm p-3 mb-3">
  

  <div class="d-flex justify-content-between text-center flex-wrap gap-2">

    <div class="flex-fill">
      <div class="fw-bold">0</div>
      <small id="num0">0</small>
      <div>
        <a id="win0" class="btn btn-primary btn-sm @if($roundf->result) d-none @endif " >Win This</a>
      </div>
    </div>

    <div class="flex-fill">
      <div class="fw-bold">1</div>
      <small id="num1">0</small>
      <div>
        <a id="win1" class="btn btn-primary btn-sm @if($roundf->result) d-none @endif">Win This</a>
      </div>
    </div>

    <div class="flex-fill">
      <div class="fw-bold">2</div>
      <small id="num2">0</small>
      <div>
        <a id="win2" class="btn btn-primary btn-sm @if($roundf->result) d-none @endif">Win This</a>
      </div>
    </div>

    <div class="flex-fill">
      <div class="fw-bold">3</div>
      <small id="num3">0</small>
      <div><a id="win3" class="btn btn-primary btn-sm @if($roundf->result) d-none @endif">Win This</a></div>
    </div>

    <div class="flex-fill">
      <div class="fw-bold">4</div>
      <small id="num4">0</small>
      <div><a id="win4" class="btn btn-primary btn-sm @if($roundf->result) d-none @endif">Win This</a></div>
    </div>

    <div class="flex-fill">
      <div class="fw-bold">5</div>
      <small id="num5">0</small>
      <div><a id="win5" class="btn btn-primary btn-sm @if($roundf->result) d-none @endif">Win This</a></div>
    </div>

    <div class="flex-fill">
      <div class="fw-bold">6</div>
      <small id="num6">0</small>
      <div><a id="win6" class="btn btn-primary btn-sm @if($roundf->result) d-none @endif">Win This</a></div>
    </div>

    <div class="flex-fill">
      <div class="fw-bold">7</div>
      <small id="num7">0</small>
      <div><a id="win7" class="btn btn-primary btn-sm @if($roundf->result) d-none @endif">Win This</a></div>
    </div>

    <div class="flex-fill">
      <div class="fw-bold">8</div>
      <small id="num8">0</small>
      <div><a id="win8" class="btn btn-primary btn-sm @if($roundf->result) d-none @endif">Win This</a></div>
    </div>

    <div class="flex-fill">
      <div class="fw-bold">9</div>
      <small id="num9">0</small>
      <div><a id="win9" class="btn btn-primary btn-sm @if($roundf->result) d-none @endif">Win This</a></div>
    </div>

  </div>
</div>

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
<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>

<script>
  const socket = io("https://origensoft.com");

  let currentRoundId = null;

  socket.on("connect", () => {
    console.log("connected");
  });

socket.on("sync_state", (data) => {

  // 🔥 AUTO REFRESH IF ROUND CHANGED
  const bladeRoundId = "{{$roundf->roundid}}";

  if (data.roundId && String(data.roundId) !== String(bladeRoundId)) {
    location.reload();
    return;
  }

  document.getElementById("roundId").innerText = data.roundId;
  document.getElementById("timeLeft").innerText = data.timeLeft;

  if (data.roundId && currentRoundId !== data.roundId) {
    currentRoundId = data.roundId;
    socket.emit("get_bet_summary", { roundId: data.roundId });
  }

  // dynamic update win links
  for (let i = 0; i <= 9; i++) {
    const el = document.getElementById("win" + i);
    if (el) {
      el.href = `/admin/win/round/${i}/${data.roundId}`;
    }
  }
});

  socket.on("bet_summary", (data) => {
    for (let i = 0; i <= 9; i++) {
      const el = document.getElementById("num" + i);
      if (el) el.innerText = 0;
    }

    data.forEach(item => {
      const el = document.getElementById("num" + item.number);
      if (el) {
        el.innerText = item.total;
      }
    });
  });
</script>
@endsection