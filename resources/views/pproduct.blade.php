@extends('layouts.app')

@section('title', $product['name'])

@section('bgpicture')
<div class="bgpic" style="background-image: url('{{ asset('img/bannerShop.jpg') }}');">
	
	<div class="bgpic-caption">
		SHOP
	</div><!--bgpic-caption-->
</div><!--bgpic-->
@endsection

@section('content')

	<?php

		$images = array();

		foreach($product['item_detail'] as $detail)
		{
		    $files = Storage::files('public/item_detail/' . $detail['images']);

		    foreach($files as $count => $file) {
//		        $images[$detail['color']][$count] = $file;

                $file_path = explode('/',$file)[2] . '/' . explode('/',$file)[3];
				array_push($images, $file_path);
			}
		}

	?>


<div class="product-page-wrapper">
	<a href="" id="backtoshop">BACK TO SHOP</a>

	<form action="#" id="productForm">

		{{ csrf_field() }}

		<input type="hidden" name="product_id" value="{{ $product['id'] }}">
		<input type="hidden" name="product_name" value="{{ $product['name'] }}">
		<input type="hidden" name="product_price" value="{{ $product['price'] }}">
		<input type="hidden" name="product_image" value="{{ $images[0] }}">

		<div class="row">

			<div class="col-md-6">
				<div class="product-pic-zone">
					
					<div class="p-main-wrapper">

						<div class="product-main-pic" id="p-main-con">

							@foreach($images as $image)
								<div class="p-main-img" style="background-image: url({{ asset('storage/item_detail/' . $image) }})"></div>
							@endforeach
					</div><!--productmain-pic-->
					</div><!--pmainwrapper-->
					

					<div id="p-second-con" class="product-secondary-pic">

						@foreach($images as $image)
							<div class="p-second-img" style="background-image: url({{ asset('storage/item_detail/' . $image) }})"></div>
						@endforeach
						
					</div><!--secondarypic-->

				</div><!--productpiczone-->
			</div><!--col-md-6-->

			<div class="col-md-6">
				<div class="desc-product-wrapper">

					<div class="desc-product-title">
						{{ $product['name'] }}
					</div><!--deskproducttitle-->

					<div class="desc-product-price">
						IDR {{ $product['price'] }}
					</div><!--deskproductprice-->

					<div class="desc-product-desc">
						DESCRIPTION
						<div class="sub-desc-product-desc">
							{{ $product['description'] }}
						</div><!--subdescprocuct-->
					</div><!--deskproductdesc-->

					{{-- Check if every item is empty --}}
					@foreach($product['item_detail'] as $value => $item)
						@if($item['stock']>1)
							<?php $flag = 1 ?>
						@else
							<?php $flag = 0 ?>
						@endif
					@endforeach

					@if($product['item_detail'] != null && $flag == 1)

						<div class="desc-product-color">
							COLOR:
							<div class="sub-desc-product-color">
								<ul>
									@foreach($product['item_detail'] as $value => $item)
										@if($item['status'] == 'available' && $item['stock'] > 0)
											<li><div class="cbox" style="background-color: {{ $item['color'] }}; cursor: pointer" onclick="colorClick(this)" data-id="{{ $item['color'] }}"></div></li>
										@endif
									@endforeach
								</ul>
							</div><!--subdescproductcolor-->
						</div><!--deskproductcolor-->

						<div class="desc-product-size">
							SIZE:
							<div class="sub-desc-product-size">

							  <div class="form-group">
								<select class="form-control" id="size" name="product_detail_id" required>
								<option value="non">Select Color First</option>
									{{--Size--}}
								</select>
							</div>

							</div><!--subdescproductsize-->

						</div><!--descproductsize-->

						<div class="desc-product-qty">
							QUANTITY:
							<div class="sub-desc-product-qty">

							  <div class="form-group">
								<input class="form-control" name="quantity" type="number" value="1" min="1" max="10">
							</div><!--formgroup-->
							</div><!--subdescproductsize-->

						</div><!--descproductsize-->

						<div class="desc-product-button">
							<button type="button" class="btn" style="cursor: pointer" onclick="addToCart()"
									@if($product['item_detail'] == null) disabled @endif
							>ADD TO CART</button>
						</div><!--desc-product-button-->

					@else
						<div class="desc-product-out">
							OUT OF STOCK
							<div class="sub-desc-product-out">
								<ul>
									<li>
										<input type="text" id="line-email" placeholder="EMAIL">
									</li>
									<li>
										<button type="button" class="btn">NOTIFY ME</button>
									</li>
								</ul>
							</div><!--descproductout-->
						</div><!--desc-product-out-->
					@endif

				</div><!--descproductwrapper-->
			</div><!--col-md-6-->

		</div><!--row-->
	</form>
</div><!--product-page-wrapper-->
<script>

    var item_details = JSON.parse('<?php echo json_encode($product['item_detail']) ?>');

	function colorClick(e)
	{
        var id = $(e).data('id');

        $('.cbox').removeClass('active');
        $(e).addClass('active');

        loadSizes(id);
	}

	function loadSizes(id)
	{
		$('#size').empty();

		var size = $('#size');

		$.each(item_details, function(key, value){
			if(value.color == id)
			{
				size.append('<option value="' + value.id + '">' + value.size + '</option>')
			}
		});
	}
</script>
@endsection