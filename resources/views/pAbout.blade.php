@extends('layouts.pagelayout')

@section('bgpicture')
<div class="bgpic" style="background-image: url('../img/bannerAbout.jpg');">
	
	<div class="bgpic-caption">
		ABOUT
	</div><!--bgpic-caption-->
</div><!--bgpic-->
@endsection

@section('content')

<div class="about-page-wrapper">

	<div class="about-page-header">

		<div class="about-page-h-logo">
			<img src="{{ asset('img/logoOri.png') }}" alt="">
		</div>

		<div class="about-page-h-desc">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non dicta tempore pariatur consequatur eum, dolorem in molestias incidunt optio.
		</div>
	</div><!--about-page-header-->

	<div class="about-page-owner">
		
		<div class="row">
			<div class="col-md-6">
				<div class="about-page-pic abp1">
					
				</div><!--about-page-picture-->
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum mollitia enim corporis veritatis saepe, sint eligendi ratione ducimus neque? Cum accusantium mollitia eveniet excepturi nulla cumque, distinctio iste quis repellendus!
			</div>

			<div class="col-md-6">
				<div class="about-page-pic abp1">
					
				</div><!--about-page-picture-->
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis quod voluptates earum consequatur similique sunt harum, dolor pariatur nesciunt, cumque aperiam porro aspernatur nulla sit, inventore sed voluptatem rem impedit.
			</div>


		</div><!--row-->	
	
	</div><!--about-pageowner-->

</div><!--about-page-wrapper-->

@endsection