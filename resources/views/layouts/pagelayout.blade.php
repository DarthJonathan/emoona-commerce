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
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/front.js') }}"></script>
    <script src="{{ asset('js/jquery.form.min.js') }}"></script>
    <script src="{{ asset('js/pace.min.js') }}"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Emoona Studio</title>

    <style>
       
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
        <li><a href="{{ URL::to('/profile') }}">MY <span>ACCOUNT</span></a></li>
    	<li><span>BAG</span>(0)</li>
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


<div class="content">
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

</body>
</html>