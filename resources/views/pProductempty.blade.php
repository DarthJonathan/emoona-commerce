@extends('layouts.pagelayout')

@section('bgpicture')
<div class="bgpic" style="background-image: url('../img/bannerShop.jpg');">
	
	<div class="bgpic-caption">
		SHOP
	</div><!--bgpic-caption-->
</div><!--bgpic-->
@endsection

@section('content')

<div class="product-page-wrapper">
	<a href="" id="backtoshop">BACK TO SHOP</a>

	
		<div class="row">

			<div class="col-md-6">
				<div class="product-pic-zone">
					
					<div class="p-main-wrapper">

						<div class="product-main-pic" id="p-main-con">
						<div class="p-main-img pm1"></div>
						<div class="p-main-img pm2"></div>
						<div class="p-main-img pm3"></div>
						<div class="p-main-img pm4"></div>
					</div><!--productmain-pic-->
					</div><!--pmainwrapper-->
					

					<div id="p-second-con" class="product-secondary-pic">
						
						<div class="p-second-img ps1"></div>
						<div class="p-second-img ps2"></div>
						<div class="p-second-img ps3"></div>
						<div class="p-second-img ps4"></div>
						
					</div><!--secondarypic-->

				</div><!--productpiczone-->
			</div><!--col-md-6-->

			<div class="col-md-6">
				<div class="desc-product-wrapper">

					<div class="desc-product-title">
						LOREM IPSUM
					</div><!--deskproducttitle-->

					<div class="desc-product-price">
						$47
					</div><!--deskproductprice-->

					<div class="desc-product-desc">
						DESCRIPTION
						<div class="sub-desc-product-desc">
							Material: Cotton <br> <br>
							Strechable Cotton
						</div><!--subdescprocuct-->
					</div><!--deskproductdesc-->

					<div class="desc-product-color">
						COLOR:
						<div class="sub-desc-product-color">
							<ul>
								<li><div class="cbox cbx1"></div></li>
								<li><div class="cbox cbx2"></div></li>
								<li><div class="cbox cbx3"></div></li>
							</ul>
						</div><!--subdescproductcolor-->
					</div><!--deskproductcolor-->

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

				</div><!--descproductwrapper-->
			</div><!--col-md-6-->

		</div><!--row-->
	
</div><!--product-page-wrapper-->
@endsection