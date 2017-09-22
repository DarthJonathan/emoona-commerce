<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">

    <!-- JS -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/popper-utils.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Emoona Studio</title>

    <style>
        .dropdown-menu-right {
            right: 0;
            left: auto;
        }

        .center-box {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hidden {
            transform: translateY(-100px);
            opacity: 0;
            z-index: -100;
            margin-bottom: -50px;
        }

        .notification {
            transition: all .3s ease-in-out;
        }

        .navbar{
            z-index: 100;
        }
    </style>

</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
        Emoona Studio
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ URL::to('admin') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ URL::to('admin/accounts') }}">Account Management</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ URL::to('admin/items') }}">Items Management</a>
            </li>
        </ul>
        <div class="form-inline my-2 my-lg-0">
            @if(Auth::guest())
                <a href="/register" class="nav-link">Register</a>
                <a href="/login" class="nav-link">Login</a>
            @else
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                        @if(count(Session::get('notifications')) > 0)
                            <span class="badge badge-primary">
                                {{ count(Session::get('notifications')) }}
                            </span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Notifications">
                        <a class="dropdown-item" href="notifications">
                            Notifications
                            @if(count(Session::get('notifications')) > 0)
                                <span class="badge badge-primary">
                                    {{ count(Session::get('notifications')) }}
                                </span>
                            @endif
                        </a>
                        <hr>
                        <a class="dropdown-item" href="profile/edit">Edit Profile</a>

                        <a href="{{ route('logout') }}" class="dropdown-item"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</nav>

{{--Modal--}}
<div class="center-box">
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">&nbsp</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    &nbsp
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{--Notification--}}
<div class="notification-success notification hidden">
    <div class="container">
        <div class="col-lg-6 mx-auto mt-2">
            <div class="alert alert-success alert-body-success">
                Success!
            </div>
        </div>
    </div>
</div>

<div class="notification-error notification hidden">
    <div class="container">
        <div class="col-lg-6 mx-auto mt-2">
            <div class="alert alert-danger alert-body-error">
                Success!
            </div>
        </div>
    </div>
</div>

<!-- Body -->
<section class="body px-3 py-3">
    @if( Session::has('message') )
        <div class="container">
            <div class="row">
                <div class="col-lg-8 m-auto">
                    <div class="alert alert-primary">
                        {{ Session::get('message') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @yield('content')
</section>

</body>
</html>