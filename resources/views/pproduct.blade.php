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
                $file_path = explode('/',$file)[2] . '/' . explode('/',$file)[3];
				array_push($images, $file_path);
			}
		}

		$flag = 0;

	?>


<div class="product-page-wrapper">
	<a href="" id="backtoshop">BACK TO SHOP</a>

	<form action="#" id="productForm">

		{{ csrf_field() }}

		<input type="hidden" name="product_id" value="{{ $product['id'] }}">
		<input type="hidden" name="product_name" value="{{ $product['name'] }}">
		<input type="hidden" name="product_image" value="{{ $images[0] }}">

		<div class="row">

			<div class="col-md-5">
				<div class="product-pic-zone">
					
					<div class="p-main-wrapper">

						<div class="product-main-pic" id="p-main-con">

							@foreach($images as $image)
								<div class="p-main-img" style="padding-bottom: 0">
                                    <img src="{{ asset('storage/item_detail/' . $image) }}" style="width: 100%" alt="">
								</div>
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

			<div class="col-md-7">
				<div class="desc-product-wrapper">

					<div class="desc-product-title">
						{{ $product['name'] }}
					</div><!--deskproducttitle-->

					<div class="desc-product-price">
						IDR <?php echo number_format($product['price'], 0, '.', ',') ?>
					</div><!--deskproductprice-->

					<div class="desc-product-desc">
						DESCRIPTION
						<div class="sub-desc-product-desc px-5">
							{{ $product['description'] }}
						</div><!--subdescprocuct-->
					</div><!--deskproductdesc-->

					{{-- Check if every item is empty --}}
					@foreach($product['item_detail'] as $value => $item)
						@if($item['stock']>=1 && $item['status'] != 'hidden')
							<?php $flag++; ?>
						@endif
					@endforeach
                    @if(sizeof($product['item_detail']) > 0)
                        <?php $flag++; ?>
                    @endif

					@if($product['item_detail'] != null && $flag != 0)

						<div class="desc-product-color">
							COLOR:
							<div class="sub-desc-product-color">
								<ul class="colors">

								</ul>
							</div><!--subdescproductcolor-->
						</div><!--deskproductcolor-->

						<div class="desc-product-size">
							SIZE:
							<div class="sub-desc-product-size">

							  <div class="form-group">
								<select class="form-control" id="size" name="product_detail_id" onchange="checkStatus()" id="product_detail_id" required>
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

                        <div class="notify" style="display: none">
                            <div class="desc-product-out">
                                Item will be available very soon
                                @if(\Illuminate\Support\Facades\Auth::check())
                                    <div class="sub-desc-product-out">
                                        <ul>
                                            {{--<li>--}}
                                                {{--<input type="text" name="line-email" id="line-email" placeholder="EMAIL">--}}
                                            {{--</li>--}}
                                            <li>
                                                <button type="button" id="notifyBtn" style="cursor: pointer;" class="btn" data-cat="preorder" onclick="notifyMe(this)">NOTIFY ME</button>
                                            </li>
                                        </ul>
                                    </div><!--descproductout-->
                                @endif
                            </div><!--desc-product-out-->
                        </div>
					@else
						<div class="desc-product-out">
							OUT OF STOCK
							@if(\Illuminate\Support\Facades\Auth::check())
							<div class="sub-desc-product-out">
								<ul>
									{{--<li>--}}
										{{--<input type="text" name="line-email" id="line-email" placeholder="EMAIL">--}}
									{{--</li>--}}
									<li>
										<button type="button" style="cursor: pointer;" class="btn" data-cat="no-stock" data-id="{{ $product['id'] }}" onclick="notifyMe(this)">NOTIFY ME</button>
									</li>
								</ul>
							</div><!--descproductout-->
							@endif
						</div><!--desc-product-out-->
					@endif

				</div><!--descproductwrapper-->
			</div><!--col-md-6-->

		</div><!--row-->
	</form>
</div><!--product-page-wrapper-->
<script>

    $(document).ready(function()
    {
        loadColors();

        console.log(item_details);
    });

    var item_details = JSON.parse('<?php echo json_encode($product['item_detail']) ?>');
    var item_discount = JSON.parse('<?php echo json_encode($discounts) ?>');
	var price = {!! $product['price'] !!};

    function loadColors ()
    {
        var colors = $('.colors');
        var colors_saved = [];

        $.each(item_details, function (key, value){

			if(value.deleted == 1)
				return true;

            if(colors_saved.includes(value.color) || item_details.deleted == 1)
                return true;
            else
                colors_saved.push(value.color);

            var html = '<li><div class="cbox" style="background-color: '+ value.color + '; cursor: pointer" onclick="colorClick(this)" data-id="' + value.id + '" data-color="'+ value.color +'"></div></li>';
            colors.append(html);
        });
    }

	function colorClick(e)
	{
        var color   = $(e).data('color');
        var id      = $(e).data('id');
        var avail   = $(e).data('avail');
        var price   = price;

        $('.cbox').removeClass('active');
        $(e).addClass('active');

		$('.desc-product-price').html('IDR ' + price);

        $.each(item_discount, function(key, value){
            if(key == id)
            {
                var discounted = price-(price*value);
                $('.desc-product-price').html('IDR <s>' + makePrice(price) + '</s> ' + makePrice(discounted));
            }
        });

        loadSizes(color);
        checkStatus();
	}

	function loadSizes(id)
	{
		$('#size').empty();

		var size = $('#size');

		$.each(item_details, function(key, value){
			if(value.color == id)
			{
			    if(value.deleted == 1)
			        return true;

				size.append('<option value="' + value.id + '" data-avail="'+ value.status +'" data-id="'+ value.id +'">' + value.size + '</option>')
			}
		});
		
	}

	function checkStatus ()
    {
        var check = $("#size option:selected").val();
        var status = "";
        var stock = 0;
        var price   = {!! $product['price'] !!};

        $.each(item_details, function(key, value){
            if(value.id == check)
            {
                status = value.status;
                stock = value.stock;
            }
        });

        if(status == 'preorder' || stock == 0)
        {
            $('.desc-product-button').hide();
            $('.notify').css('display', 'block');
        }else {
            $('.desc-product-button').show();
            $('.notify').css('display', 'none');
        }

		$('.desc-product-price').html('IDR ' + price);

        $.each(item_discount, function(key, value){
            if(key == check)
            {
                var discounted = price-(price*value);
                $('.desc-product-price').html('IDR <s>' + makePrice(price) + '</s> ' + makePrice(discounted));
            }

        });
    }
</script>
@endsection