<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">

    <!-- JS -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/popper-utils.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/instafeed.min.js') }}"></script>
    <script src="{{ asset('js/instacustoms.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/front.js') }}"></script>
    <script src="{{ asset('js/jquery.form.min.js') }}"></script>
    <script src="{{ asset('js/pace.min.js') }}"></script>
    <script src="{{ asset('js/all.js') }}"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Emoona Studio</title>

    <style>
        .dropdown-menu-right {
            right: 0;
            left: auto;
        }
    </style>

</head>
<body>
<div class="navbar">
    <div class="navbar1">
        <ul class="my-2">
            <li>
                <div class="navbar-search">
                    <input type="text" id="searchbar" placeholder="Search.." >
                </div><!--navbar-search-->
            </li>
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" id="bag-items">
                    <span>BAG</span>({{ Cart::getTotalQuantity() }})
                </a>
                <div class="dropdown-menu dropdown-align-right navbar-dropdown ">
                    <div class="cart-container">
                        <div class="cart-item-container">

                        <!-- Loaded Via Ajax -->
                            
                        </div>

                        <div class="cart-confirmation row align-items-center">
                            <div class="col-lg-7">
                                <h6>Total :</h6>
                                <h5 id="total-price">Rp.{{ Cart::getTotal() }},00</h5>
                            </div>
                            <div class="col-lg-5">
                                <a class="btn-checkout" href>Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @if(!Auth::guest())
                <li>
                    <div class="dropdown">
                        <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                            @if(count(\Illuminate\Support\Facades\Session::get('notifications')) > 0)
                                <span class="badge badge-primary">
                                {{ count(\Illuminate\Support\Facades\Session::get('notifications')) }}
                            </span>
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Notifications">
                            <a class="dropdown-item" href="{{ URL::to('notifications') }}">
                                Notifications
                                @if(count(\Illuminate\Support\Facades\Session::get('notifications')) > 0)
                                    <span class="badge badge-primary">
                                    {{ count(\Illuminate\Support\Facades\Session::get('notifications')) }}
                                </span>
                                @endif
                            </a>
                            <hr>
                            <a class="dropdown-item" href="{{ URL::to('profile/edit') }}">Edit Profile</a>

                            <a href="{{ route('logout') }}" class="dropdown-item"
                               onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"
                            >
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </li>
            @else
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown">
                        MY <span>ACCOUNT</span>
                    </a>
                    <div class="dropdown-menu dropdown-align-right navbar-dropdown navbar-dropdown-account">
                        <form method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="email">E-Mail </label>
                                <input type="email" id="email" name="email" class="navbar-dropdown-input">
                            </div>
                            <div class="form-group form-group-password">
                                <label for="password">Password </label>
                                <input type="password" id="password" name="password" class="navbar-dropdown-input">
                            </div>
                            <a href="{{ route('password.request') }}" class="link-forgot">Forgot Your Password?</a>
                            <input type="submit" class="btn-login" value="LOGIN">
                            <a href="{{ route('register') }}" class="link-register">REGISTER</a>
                        </form>
                    </div>
                </li>
            @endif
        </ul>
    </div><!--navbar-1-->

    <div class="navbar2">
        <ul>
            <li><a href="{{ URL::to('/studio') }}">STUDIO</a></li>
            <li><a href="{{ URL::to('/store') }}">SHOP</a></li>
            <li class="title"><a href="{{ URL::to('/') }}">E.MOON.A</a></li>
            <li><a href="{{ URL::to('/social') }}">SOCIAL</a></li>
            <li><a href="{{ URL::to('/about') }}">ABOUT</a></li>
        </ul>
    </div> <!--navbar2-->


</div><!--navbar-->

<div class="background">
    @yield('bgpicture')
</div><!--background-->

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
            <div class="alert alert-success alert-body-success">
                Success!
            </div>
        </div>
    </div>
</div>

<div class="notification-error notification hidden mt-3">
    <div class="container">
        <div class="col-lg-6 mx-auto mt-2">
            <div class="alert alert-danger alert-body-error">
                Success!
            </div>
        </div>
    </div>
</div>

<div class="content pb-4">
    @yield('content')
</div>


<div class="footer">

    <ul>
        <li>TERMS & CONDITIONS</li>
        <li>RETURN & EXCHANGES</li>
        <li>SHIPPING</li>
        <li>CONTACT</li>
    </ul>

</div><!--footer-->

<script>
    $(document).ready(function()
    {
        loadCart();
    });
</script>
</body>
</html>