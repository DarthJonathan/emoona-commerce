@extends('layouts.app')

@section('bgpicture')
<div id="home-pic-con" class="bgpicHome">
    @foreach($sliders as $key => $slide)
	<div class="home-image bghom{{ ($key+1) }}"
		 onclick="sliderRedirect(this)"
		 data-link="{{ $slide->url }}"
         style="background-image: url('/storage/img/home-slider/{{ explode("/", $slide->image)[4] }}')"
    ></div>
    @endforeach
</div>
@endsection

@section('title', 'Home')

@section('content')
	<script src="{{ asset('js/instaHome.js') }}"></script>
	<div class="content-wrapper">
	<div class="home-content-1">
		<div class="wrapper-home-content-1">
		<div class="container">
			<div class="row">
				
				<div class="col-md-4 col-sm-12 woman-coll collections" onclick="openCategory(this)" data-cat="woman">
					<div class="content-box cb1"
                         style="background-image: url('/storage/img/home-collections/{{ explode("/", $collections[0])[3] }}')"
                    >
					</div>
				
				</div><!--col-->

				<div class="col-md-4 col-sm-12 men-coll-text collections mb-sm-5 mb-md-0" onclick="openCategory(this)" data-cat="men">
					<div class="content-box cb2">
						<div class="text-content-box tcb2">
						<div class="wrapper-center">
							<div class="line-content-box-1">
								{!! $datas['9']->value_1 !!}
							</div><!--line-content-box-1-->
							<hr>
							<div class="line-content-box-3">
								{!! $datas['1']->value_1 !!}
							</div><!--line-content-box-1-->
							</div><!--wrapper-center-->
						</div><!--text-content-box-1-->
					</div>
				
				</div><!--col-->

				<div class="col-md-4 col-sm-12 others-coll collections" onclick="openCategory(this)" data-cat="others">
					<div class="content-box cb3"
                         style="background-image: url('/storage/img/home-collections/{{ explode("/", $collections[1])[3] }}')"
                    >
					</div>
				
				</div><!--col-->

				<div class="col-md-4 col-sm-12 woman-coll-text collections mb-sm-5 mb-md-0" onclick="openCategory(this)" data-cat="woman">
					<div class="content-box cb4">
						<div class="text-content-box tcb4">
						<div class="wrapper-center">
							<div class="line-content-box-1">
								{!! $datas[10]->value_1 !!}
							</div><!--line-content-box-1-->
							<hr>
							<div class="line-content-box-3">
								{!! $datas['0']->value_1 !!}
							</div><!--line-content-box-1-->
							</div><!--wrapper-center-->	
						</div><!--text-content-box-4-->
					</div>
				
				</div><!--col-->

				<div class="col-md-4 col-sm-12 men-coll collections" onclick="openCategory(this)" data-cat="men">
					<div class="content-box cb5"
                         style="background-image: url('/storage/img/home-collections/{{ explode("/", $collections[2])[3] }}')"
                    >
					</div>
				
				</div><!--col-->

				<div class="col-md-4 col-sm-12 others-coll-text collections mb-sm-5 mb-md-0" onclick="openCategory(this)" data-cat="others">
					<div class="content-box cb6">
						<div class="text-content-box tcb6">
						<div class="wrapper-center">
							<div class="line-content-box-1">
								{!! $datas['11']->value_1 !!}
							</div><!--line-content-box-1-->
							<hr>
							<div class="line-content-box-3">
								{!! $datas['2']->value_1 !!}
							</div><!--line-content-box-1-->
							</div><!--wrapper-center-->	
						</div><!--text-content-box-6-->
					</div>
				
				</div><!--col-->

			</div><!--row-->
			</div><!--container-->
		</div><!--wrapper-content-1-->
	</div><!--content1-->
	
	<div class="home-content-2">
		<div class="content-banner">	
		</div><!--content-banner-->

		<div class="title-featured">
			<div class="title-line">
				FEATURED PRODUCTS
				<hr>
			</div><!--title-line-->
		</div><!--title-featured-->
		
	<div class="content-featured">
		<div class="wrapper-home-content-2">
			<div class="row">

				@foreach($featured as $key => $feature)
					<div class="col-md-3" style="cursor:pointer;" onclick="viewProduct(this)" data-id="{{ $feature->item->id }}" data-gender="{{ $feature->getCategory()->gender }}" data-category="{{ $feature->getCategory()->name }}">
						<div
							class="box-featured bf1"
							style="background-image: url('/storage/item_detail/{{ explode('/', $images[$key][0])[2] }}/{{ explode('/', $images[$key][0])[3] }}')"
						>

						</div><!--box-featured-->
						<div class="box-featured-desc">
							{{ $feature->item->name }}
						</div><!--box-desc-->
						<div class="box-featured-money">
							IDR {{ $feature->item->price }}
						</div><!--box-money-->
					</div><!--col-md-3-->
				@endforeach

			</div><!--row-->
		</div><!--wrapper-home-content-2-->
	</div><!--content-featured-->	

	</div><!--content2-->

	<div class="home-content-3">
		<div class="wrapper-home-content-3">
			<div class="instagram-feed-title">
				INSTAGRAM FEED
			</div><!--instagram-feed-title-->
			<div class="instagram-feed-box" id="instafeed">
				
			</div><!--instagram-feed-box-->
		
		<div class="subsc-content-wrapper">
			<div class="container">
				<div class="row">

				<div class="col-lg-12">
			<div class="subsc-header">
				.HAVE FAITH / SUBSCRIBE.
			</div><!--subs-heading-->
			
		</div><!--col-lg-12-->
	</div><!--row-->
	
	<div class="row">
		<div class="col-lg-12">
			<div class="subsc-text">
			<br>
				{!! $datas['3']->value_1 !!}
			</div>
		</div>	
	</div>

		<div class="row">
		<div class="col-lg-12">

		<form action="{{ URL::to('/newsletter/sign.up') }}" method="post" id="signUpNewsletter">
			{{ csrf_field() }}
			<table border="0" class="subsc-tab-form">
				<tr>
					<td><input type="text" name="firstname" placeholder="First Name"></td>
					<td><input type="text" name="lastname" placeholder="Last Name"></td>
				</tr>
			</table>

			<table class="subsc-tab-form stb2">
				<tr>
					<td colspan="2"><input type="text" name="email" placeholder="Email">

					</td>
					<td id="subsc-btn">
						<button class="btn" style="cursor:pointer;">SUBSCRIBE</button>
					</td>
				</tr>
			</table>
			</form>
		</div><!--lg-->

	</div><!--row-->
	</div><!--container-->

		</div><!--subsc-content-wrapper-->
			
		</div><!--wrapper-home-content-3-->
	</div><!--home-content-3-->

		
</div><!--content-wrapper-->
@endsection