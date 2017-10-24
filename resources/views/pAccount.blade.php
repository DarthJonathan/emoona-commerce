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
		Hi, Patricia	
	</div><!--acc-page-name-->

	<hr>

	<div class="acc-page-information">

		<div class="acc-header acc-information">
			INFORMATIONS
		</div><!--acc-informations-->
		<div class="acc-info acc-name">
			Patricia
		</div><!--acc-name-->
		<div class="acc-info acc-email">
			Patricia@email.com
		</div><!--acc-email-->
		<div class="acc-info acc-address">
			Jalan Anggrek Cakra No.1A, RT.4/RW.6, Kebon Jeruk, RT.1/RW.9, Kb. Jeruk, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11540
		</div><!--acc-address-->
		<div class="acc-info acc-edit-info">
			<a href="">Edit Your Information</a>
		</div>

		<div class="acc-header acc-password">
			PASSWORD
		</div><!--headerpassword-->
		<div class="acc-info acc-edit-pass">
			<a href="">Edit Your Password</a>
		</div>
	
	</div><!--acc-page-information-->
	
	<hr>
		<div class="acc-icon-wrapper">
		<ul>
			<li>
			<div class="acc-order ico-history">
				<img src="{{ asset('img/history.png')}}" alt="">
			</div><!--icon-history-->
			Order History
			</li>

			<li>
			<div class="acc-order ico-track">
				<img src="{{ asset('img/track.png')}}" alt="">
			</div><!--track-->
			Order Status
			</li>
		</ul>
	
			
		</div><!--acc-icon-wrapper-->
	<hr>

	<div class="acc-decor-down">
		<h5>.</h5>
	</div>

</div><!--account-page-wrapper-->

@endsection