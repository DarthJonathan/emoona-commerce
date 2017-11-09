 <script src="{{ asset('js/instaSocial.js') }}"></script>
@extends('layouts.app')

@section('title', 'Social')

@section('bgpicture')
<div class="bgpic" style="background-image: url('../img/bannerSocial.jpg');">
	
	<div class="bgpic-caption">
		SOCIAL
	</div><!--bgpic-caption-->
</div><!--bgpic-->
@endsection

@section('content')
<head>
    <script src="{{ asset('js/instaSocial.js') }}"></script>
</head>

	<div class="social-page-wrapper">

		<div class="social-page-header mb-5">
			<div class="social-page-header-t">
				.CONVICTION YOU CAN WEAR.
			</div>
			
		</div><!--div-social-page-header-->

		<div class="social-img-wrapper">
 
	    	<div class="social-picture-wrapper">
	    		<div class="row">

	 				@foreach($socials as $social)
	 				
					    <div class="col-md-3">
					    	<div class="social-picture" style="background-image:url('{{url('/storage/img/social/'. explode('/', $social->image)[4] )}}')">
				    		</div>
					    
					    </div><!--col-md-3-->
				    
				    @endforeach
    	
    			</div><!--row-->
		  	</div><!--shop-pic-wrapper-->
		 
	    </div><!--social-img-wrapper-->

		<!-- SEMENTARA, buat liat data -->
		<!-- <div class="col-md-10">
			<div class="row">
			@foreach($socials as $social)
				<div class="col-md-3">
					<img src="/storage/img/social/{{ explode('/', $social->image)[4] }}" style="height:400px">
				</div>
			@endforeach
			</div>
		</div> -->

		<div class="row" id="instafeed">
			
		</div>

		
	</div><!--social-page-wrapper-->

@endsection
