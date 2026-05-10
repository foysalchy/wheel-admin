<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
</head>

<body class="sb-nav-fixed">

<!-- TOP NAV -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">
        Admin Panel
    </a>

    <button class="btn btn-link btn-sm" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

</nav>

<div id="layoutSidenav">
<style>
    a svg{
        padding-right:10px
    }
</style>
    <!-- SIDEBAR -->
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark">

            <div class="sb-sidenav-menu">
                <div class="nav">

                   

                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>

                

                    <a class="nav-link" href="{{ route('admin.users') }}">
                        <i class="fas fa-users"></i> Users
                    </a>

                    <a class="nav-link" href="{{ route('admin.bets') }}">
                        <i class="fas fa-dice"></i> Bets
                    </a>

                    <a class="nav-link" href="{{ route('admin.deposits') }}">
                        <i class="fas fa-wallet"></i> Deposits
                    </a>

                    <a class="nav-link" href="{{ route('admin.withdrawals') }}">
                        <i class="fas fa-money-bill"></i> Withdrawals
                    </a>

                    <a class="nav-link" href="{{ route('admin.rounds') }}">
                        <i class="fas fa-sync"></i> Rounds
                    </a>

                </div>
            </div>

            <div class="sb-sidenav-footer">
                Logged in Admin
            </div>

        </nav>
    </div>

    <!-- PAGE CONTENT -->
    <div id="layoutSidenav_content">

        <main>
            <div class="container-fluid px-4">

                @yield('content')

            </div>
        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('js/scripts.js') }}"></script>
 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
 
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="{{asset('/')}}js/datatables-simple-demo.js"></script>
</body>
</html>