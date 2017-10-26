@extends('layouts.app')

@section('bgpicture')
<div class="bgpic" style="background-image: url('../img/bannerAcc.jpg');">
	
	<div class="bgpic-caption">
		ACCOUNT
	</div><!--bgpic-caption-->
</div><!--bgpic-->
@endsection


@section('content')

<div class="account-page-wrapper">
	<hr id="acc-hr-top">

	<div class="acc-page-name">
		Hi, {{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}
	</div><!--acc-page-name-->

	<hr>

	<div class="acc-page-information">

		<div class="acc-header acc-information">
			INFORMATIONS
		</div><!--acc-informations-->
		<div class="acc-info acc-name">
			{{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}
		</div><!--acc-name-->
		<div class="acc-info acc-email">
			{{ Auth::user()->email }}
		</div><!--acc-email-->
		<div class="acc-info acc-address">
			{{ Auth::user()->user_info->address }}
		</div><!--acc-address-->
		<div class="acc-info acc-edit-info">
			<a href="{{ URL::to('profile/edit') }}">Edit Your Information</a>
		</div>

		<div class="acc-header acc-password">
			PASSWORD
		</div><!--headerpassword-->
		<div class="acc-info acc-edit-pass">
			<a href="{{ URL::to('password.edit') }}">Edit Your Password</a>
		</div>
	
	</div><!--acc-page-information-->
	
	<hr>
		<div class="acc-icon-wrapper">
		<ul>
			<li style="cursor: pointer" onclick="orderHistory()">
			<div class="acc-order ico-history">
				<img src="{{ asset('img/history.png')}}" alt="">
			</div><!--icon-history-->
			Order History
			</li>

			<li style="cursor: pointer" onclick="orderTracking()">
			<div class="acc-order ico-track">
				<img src="{{ asset('img/track.png')}}" alt="">
			</div><!--track-->
			Order Status
			</li>

			<li style="cursor: pointer" onclick="viewTickets()">
				<div class="acc-order ico-track">
					<img src="{{ asset('img/track.png')}}" alt="">
				</div><!--track-->
				Support Tickets
			</li>
		</ul>
	
			
		</div><!--acc-icon-wrapper-->
	<hr>

	<div class="acc-decor-down">
		<h5>.</h5>
	</div>

</div><!--account-page-wrapper-->

@endsection