<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Informasi Magang SMK Informatika Ciputat</title>

    <!-- Scripts -->
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <!-- <script src="{{ asset('js/jquery.js') }}" defer></script> -->
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script src="{{ asset('js/popper.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- STYLES -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- SCSS -->
    <!-- <link href="{{ asset('css/style.scss') }}" rel="stylesheet"> -->

    <!-- SELECT2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- BOOSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ms-auto">
        <!-- Authentication Links -->
        @guest
        @if (Route::has('login'))
        <!-- <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li> -->
        @endif

        @if (Route::has('register'))
        <!-- <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
        </li> -->
        @endif
        @else
        <div class="wrapper d-flex align-items-stretch">
            <nav id="sidebar">
                <div class="p-4 pt-5 flex-grow-1">
                    <div class="text-center mb-5 text-uppercase">
                        <b>
                            {{ Auth::user()->siswa->nama ?? Auth::user()->guru->nama ?? 'super admin' }}
                        </b>
                        <br>
                        {{ Auth::user()->siswa->nisn ?? Auth::user()->guru->nuptk ?? '' }}
                    </div>

                    @if (Auth::user()->level_id == 1)
                    <ul class="list-unstyled components mb-5">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/home') }}">
                                <i class="fa fa-desktop" aria-hidden="true"></i>
                                Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/guru') }}">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                Data Guru</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/siswa') }}">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                Data Siswa</a>
                        </li>

                        <li>
                            <a class="nav-link" href="{{ url('/admin/magang') }}">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                Data Magang</a>
                        </li>

                        <li>
                            <a class="nav-link" href="{{ url('/admin/sidang-siswa') }}">
                                <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                Data Sidang Siswa</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                {{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>

                    @elseif (Auth::user()->level_id == 2)

                    <ul class="list-unstyled components mb-5">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/home') }}">
                                <i class="fa fa-desktop" aria-hidden="true"></i> Dashboard</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/guru/data-siswa-bimbingan') }}">
                                <i class="fa fa-envelope" aria-hidden="true"></i> Data Siswa Magang</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                {{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                    @else
                    <ul class="list-unstyled components mb-5">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/home') }}">
                                <i class="fa fa-desktop" aria-hidden="true"></i>
                                Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ url('/siswa/bimbingan') }}">
                                <i class="fa fa-users" aria-hidden="true"></i> Bimbingan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/siswa/permohonan-magang') }}">
                                <i class="fa fa-envelope-open" aria-hidden="true"></i> Permohonan Magang</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                {{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                    @endif
                </div>

            </nav>

            <!-- Page Content  -->
            <div id="content" class="p-1">

                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">

                        <button type="button" id="sidebarCollapse" class="btn btn-primary">
                            <i class="fa fa-bars"></i>
                            <span class="sr-only">Toggle Menu</span>
                        </button>
                        <div class="ml-auto">
                            <marquee behavior="scroll" direction="left">
                                <b>SISTEM INFORMASI MAGANG SMK INFORMATIKA CIPUTAT</b>
                            </marquee>

                        </div>
                    </div>
                </nav>
                @endguest

                <main class="py-1">
                    @yield('content')
                </main>
                <div class="text-center fixed-bottom note" style="color:grey">
                    <small>Copyright © 2023 - diahbudiratriningrum. All Rights Reserved</small>
                </div>
            </div>
        </div>
    </ul>
</body>


</html>

<script>
    $(document).ready(function() {
        var currentUrl = window.location.href;

        // Loop through each menu item
        $('.nav-item').each(function() {
            var menuUrl = $(this).find('a').attr('href');

            // Check if current URL matches menu URL
            if (currentUrl.includes(menuUrl)) {
                $(this).addClass('active');
                return false; // Stop the loop if active menu is found
            }
        });
    });
</script>