@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    <h3>Settings</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">

        <!-- SETTINGS -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Game Settings</div>
                <div class="card-body">

                    <form method="POST" action="{{ url('/admin/settings/update') }}">
                        @csrf

                        <div class="mb-2">
                            <label>Site Name</label>
                            <input type="text" name="site_name"
                                   class="form-control"
                                   value="{{ $settings->site_name ?? '' }}">
                        </div>

                        <div class="mb-2">
                            <label>Game Win Mode</label>
                            <select name="game_win_mode" class="form-control">
                                <option value="1" {{ ($settings->game_win_mode ?? '') == 1 ? 'selected' : '' }}>
                                    Lowest Bet Number
                                </option>
                                <option value="2" {{ ($settings->game_win_mode ?? '') == 2 ? 'selected' : '' }}>
                                    Percentage Wise
                                </option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label>Game Time Mode</label>
                            <select name="game_time_mode" class="form-control">
                                <option value="1" {{ ($settings->game_time_mode ?? '') == 1 ? 'selected' : '' }}>
                                    1 Minute
                                </option>
                                <option value="2" {{ ($settings->game_time_mode ?? '') == 2 ? 'selected' : '' }}>
                                    15 Minute
                                </option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Percentage Mode</label>
                            <input type="text" name="win_per"
                                   class="form-control"
                                   value="{{ $settings->win_per ?? '' }}">
                        </div>
                         <div class="mb-2">
                            <label>Win Amount X  </label>
                            <input type="text" name="win_rate"
                                   class="form-control"
                                   value="{{ $settings->win_rate ?? '' }}">
                        </div>




                        <button class="btn btn-primary mt-2">
                            Save Settings
                        </button>

                    </form>

                </div>
            </div>
        </div>

        <!-- USERS -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Users Under You</div>
                <div class="card-body table-responsive">

                   
                      
                        @foreach($users as $user)
                    
                            <form method="POST" action="{{ url('/admin/user/update/'.$user->id) }}">
    @csrf

    <div class="  g-2 align-items-end">

        <!-- Username -->
        <div class=" ">
            <label class="form-label">Username</label>
            <input type="text"
                   name="username"
                   value="{{ $user->username }}"
                   class="form-control form-control-sm">
        </div>

        <!-- Name -->
        <div class=" ">
            <label class="form-label">Name</label>
            <input type="text"
                   name="name"
                   value="{{ $user->name }}"
                   class="form-control form-control-sm">
        </div>

        <!-- Phone -->
        <div class=" ">
            <label class="form-label">Phone</label>
            <input type="text"
                   name="phone"
                   value="{{ $user->phone }}"
                   class="form-control form-control-sm">
        </div>

        <!-- Email -->
        <div class="col-md-3">
            <label class="form-label">Email</label>
            <input type="email"
                   name="email"
                   value="{{ $user->email }}"
                   class="form-control form-control-sm">
        </div>

        <!-- Password -->
        <div class=" ">
            <label class="form-label">Password</label>
            <input type="password"
                   name="password"
                   placeholder="New password"
                   class="form-control form-control-sm">
        </div>

        <!-- Button -->
        <div class="col-md-1 d-grid">
            <label class="form-label">&nbsp;</label>
            <button class="btn btn-success btn-sm">
                Save
            </button>
        </div>

    </div>
</form>
                       
                        @endforeach

                  

                </div>
            </div>
        </div>

    </div>

</div>

@endsection