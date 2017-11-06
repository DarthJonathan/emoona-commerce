@extends('layouts.app')

@section('title', 'Shop')

@section('bgpicture')
<div class="bgpic" style="background-image: url('../img/bannerShop.jpg');">
	
	<div class="bgpic-caption">
		SHOP
	</div><!--bgpic-caption-->
</div><!--bgpic-->
@endsection

@section('content')

<div class="shop-page-wrapper">
	<div class="shop-page-nav-wrapper">
		<ul>
			<li><span class="category-links" id="menDropDown">MEN</span></li>
			<li><span class="category-links" id="womanDropDown">WOMAN</span></li>
			<li><span class="category-links" id="othersDropDown">OTHERS</span></li>
			<li><span class="category-links" onclick="loadSale()" id="saleDropDown">SALE</span></li>

		</ul>

		<ul class= "wdropdown" id="wdropdowns">
			<li class="category-links" data-id="0" onclick="loadFromCategory(this)">ALL</li>
			<li class="category-links">SINGLES</li>
			<li class="category-links">TOPS</li>
			<li class="category-links">BOTTOMS</li>
			<li class="category-links">OUTER</li>
		</ul><!--wdropdown-->

		<ul class= "mdropdown" id="mdropdowns">
			<li class="category-links">ALL</li>
			<li class="category-links">TOPS</li>
			<li class="category-links">BOTTOMS</li>
			<li class="category-links">OUTER</li>
		</ul><!--mdropdown-->

		<ul class= "odropdown" id="odropdowns">
			<li class="category-links">WALK & CARRIERS</li>
			<li class="category-links">HYBRID</li>
		</ul><!--odropdown-->

	</div><!--shop-page-nav-wrapper-->

	<div class="shop-page-shop">
		{{--Filled By Ajax--}}
	</div><!--shop-page-page-->
	
	
</div>

<script>
	$(document).ready(function(){

	    @if($category == null)
			//Load the Store First Time
			loadStore();
		@else
			loadCategory('{!! $category !!}');
		@endif
	});
</script>

@endsection