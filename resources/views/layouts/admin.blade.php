<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleadmin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pace-theme.css') }}">
    <!-- JS -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/popper-utils.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/all.js') }}"></script>
    <script src="{{ asset('js/jquery.form.min.js') }}"></script>
    <script src="{{ asset('js/pace.min.js') }}"></script>
    <script src="{{ asset('js/html.sortable.min.js') }}"></script>
    {{--Tiny MCE--}}
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=zbjkih4psdass55dhyxx68abl4afbzgu8qj49n1rkkrul1oy"></script>
    <script>tinymce.init({ selector:'textarea' });</script>

    {{--DataTables--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('third-party/datatables/datatables.min.css') }}"/>
    <script type="text/javascript" src="{{ asset('third-party/datatables/datatables.min.js') }}"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Emoona Studio</title>

</head>
<body>

<!-- Navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark desktopNavbar">
    <a class="navbar-brand" href="#">
        E.MOON.A Admin
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        </ul>

        <ul class="navbar-nav">
        <!-- sample only, delete later
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="mailsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ asset('img/mail-icon.png') }}" width="20px" height="auto">
                    @if(count(Session::get('notifications')) > 0)
                        <span class="mailBubble">
                            {{ count(Session::get('notifications')) }}
                        </span>
                    @endif
                </a>

                <div class="dropdown-menu dropdown-menu-right mr-3" aria-labelledby="mailsDropdown">
                    <a class="dropdown-item" href="#">do A</a>
                    <a class="dropdown-item" href="#">do B</a>
                    <a class="dropdown-item" href="#">do C</a>
                </div>
            </li>
            -->

            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="accountDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="profilePicture" style="background-image: url({{ asset('img/profile-icon.png') }})"></div>
                    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdown">
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
            </li>
        </ul> 
    </div>
</nav>

<!-- Mobile Navbar -->

<nav class="navbar fixed-top navbar-dark mobileNavbar">
    <a class="navbar-brand" href="#">
        E.MOON.A Dashboard
    </a>

    <div class="navbar-toggler" data-toggle="collapse" data-target="#navbarMobileContent" aria-controls="navbarContent" aria-expanded="false">
        {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
        <div class="profilePicture" style="background-image: url({{ asset('img/profile-icon.png') }})"></div>
    </div>

    <div class="collapse navbar-collapse" id="navbarMobileContent">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <img src="{{ asset('img/mail-icon.png') }}">
                    <span>Notifications</span>
                    @if(count(Session::get('notifications')) > 0)
                        <span style="margin-left: 20px; color:white; opacity:0.5">
                            {{ count(Session::get('notifications')) }} new notification(s)
                        </span>
                    @else
                        <span style="margin-left: 20px; color:white; opacity:0.5">
                            No new notifications
                        </span>
                    @endif
                </a>   
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"> <img src="{{ asset('img/sidebar-icons/dashboard-icon.png') }}"><span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"> <img src="{{ asset('img/sidebar-icons/dashboard-icon.png') }}"><span>Web Configuration</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"> <img src="{{ asset('img/sidebar-icons/post-icon.png') }}"><span>Post</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"> <img src="{{ asset('img/sidebar-icons/media-icon.png') }}"><span>Media</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"> <img src="{{ asset('img/sidebar-icons/sales-icon.png') }}"><span>Sales</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"> <img src="{{ asset('img/sidebar-icons/report-icon.png') }}"><span>Report</span></a>
            </li>

            <hr style=" width:100%; border: 1px solid white;">
            <li class="nav-item">
                 <a class="nav-link" href="profile/edit">Edit Profile</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link"
                   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>

</nav>

<div class="bodyWrapper">
        <!-- Sidebar -->
        <div class="sidebarWrapper col-lg-2">
            <div id="sidebar">
                <center>
                    <div class="sidebarLogo">
                        <img src="{{ asset('img/logo.png') }}" width="50%" height="auto">
                    </div>

                    {{--Depreceated--}}
                    {{--<form class="searchBox">--}}
                        {{--<div class="input-group sidebarSearch">--}}
                            {{--<input class="form-control" type="text" placeholder="Search">--}}
                            {{--<button class="input-group-addon"><img src="{{ asset('img/search-icon.png') }}" width="20px"></button>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                        
                    
                </center>
                    <div class="sidebarSectionHeader">NAVIGATION</div>
                    <ul class="sidebarSection">
                        <a href="{{ route('admindashboard') }}"><li @yield('dashboard_active')><img src="{{ asset('img/sidebar-icons/dashboard-icon.png') }}">Dashboard</li></a>
                        <a href="{{ route('web_configuration') }}"><li @yield('webconfig_active')><img src="{{ asset('img/sidebar-icons/dashboard-icon.png') }}">Web Configuration</li></a>
                        <a href="{{ route('storeitems') }}"><li @yield('items_active')><img src="{{ asset('img/sidebar-icons/post-icon.png') }}">Store Items</li></a>
                        <a href="{{ route('newsletter') }}"><li @yield('newsletter_active')><img src="{{ asset('img/sidebar-icons/post-icon.png') }}">Newsletter</li></a>
                        <a href="{{ route('accounts') }}"><li @yield('accounts_active')><img src="{{ asset('img/sidebar-icons/media-icon.png') }}">Accounts</li></a>
                        <a href="{{ route('transactions') }}"><li @yield('transactions_active')><img src="{{ asset('img/sidebar-icons/sales-icon.png') }}">Sales</li></a>
                        <a href="{{ route('tickets') }}"><li @yield('tickets_active')><img src="{{ asset('img/sidebar-icons/report-icon.png') }}">Report</li></a>
                    </ul>

                <!-- Not used
                    <div class="sidebarSectionHeader">IMPORTANCE</div>
                    <ul class="sidebarImportance">
                        <li><div class="importanceBubble"></div><span>Important</span></li>
                        <li><div class="importanceBubble"></div><span>Warning</span></li>
                        <li><div class="importanceBubble"></div><span>Information</span></li>
                    </ul>
                -->
            
            </div>
        </div>
        <!-- Body -->
        <section class="contentWrapper col-lg-10 pull-right pb-4">
            <div class="content">
                @if( Session::has('message') )
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 m-auto">
                                <div class="alert alert-primary placeholder">
                                    {{ Session::get('message') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </section>  
</div>

{{--Modal--}}
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="center-box">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">&nbsp</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="ajax-loading">
                    <img id="loading-image" class="m-3" src="/img/ajax-loader.gif"/>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
</div>

{{--Notification--}}
<div class="notification-success notification hidden mt-3">
    <div class="container">
        <div class="col-lg-6 mx-auto">
            <div class="alert alert-light alert-body-success">
                Success!
            </div>
        </div>
    </div>
</div>

<div class="notification-error notification hidden mt-3">
    <div class="container">
        <div class="col-lg-6 mx-auto mt-2">
            <div class="alert alert-dark alert-body-error">
                Error!
            </div>
        </div>
    </div>
</div>

@if(old('message', null) != null)
    <script>
        $(document).ready(function()
        {
            @if(old('message-type') == 'danger')
                toggleSuccess({{ old('message') }});
            @elseif(old('message-type') == 'danger')
                toggleError({{ old('message') }})
            @endif
        });
    </script>
@endif

@if(session('error', null) != null || session('success',null) != null)
    <script>
        $(document).ready(function()
        {
            @if(session('error',null) != null)
                toggleError('{{ session('error') }}');
            @elseif(session('success', null) != null)
                toggleSuccess('{{ session('success') }}');
            @endif
        });
    </script>
@endif
</body>
</html>