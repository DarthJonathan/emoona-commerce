@extends('layouts.app')

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

		<div class="about-page-h-desc mt-5">
			{!! $webconfig[8]->value_1 !!}
		</div>
	</div><!--about-page-header-->

	{{--<br>--}}

	{{--<div class="about-page-owner">--}}
		{{----}}
		{{--<div class="row">--}}

			{{--<div class="col-md-12">--}}

				{{--<div class="about-page-pic abp1">WHAT EVEN</div><!--about-page-picture-->--}}
				{{--Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis quod voluptates earum consequatur similique sunt harum, dolor pariatur nesciunt, cumque aperiam porro aspernatur nulla sit, inventore sed voluptatem rem impedit.--}}
			{{--</div>--}}


		{{--</div><!--row-->	--}}
	{{----}}
	{{--</div><!--about-pageowner-->--}}

</div><!--about-page-wrapper-->

@endsection