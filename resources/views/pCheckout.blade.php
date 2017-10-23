@extends('layouts.pagelayout')

@section('bgpicture')
<div class="bgpic" style="background-image: url('../img/bannerShop.jpg');">
	
	<div class="bgpic-caption">
		CHECKOUT
	</div><!--bgpic-caption-->
</div><!--bgpic-->
@endsection

@section('content')

<div class="checkout-page-wrapper">

	<div class="cout-page-header">
		IN YOUR BAG
	</div><!--coutpage-header-->


	<table class="table cout-table">
		<thead>
			<tr>
				<th>Item</th>
				<th>Qty</th>
				<th>Price</th>
			</tr>
		</thead>
		<tbody>

			<tr>
				<td>THIS IS THE OUTFIT</td>
				<td>x 2</td>
				<td>$100</td>
			</tr>

			<tr>
				<td>THIS IS THE OUTFIT</td>
				<td>x 2</td>
				<td>$100</td>
			</tr>

			<tr id="cout-total-p">
				<td>TOTAL</td>
				<td></td>
				<td>$200</td>
			</tr>
		</tbody>
	</table>

	<div class="cout-payment">
		<div class="cout-c-paymethod">
			Payment Method
		</div>
		

		<form class="form-inline">
			<select class="form-control" id="cout-paymethod">
      			<option>Transfer</option>
    		</select>
		
			<div class="cout-btn">
				<button class="btn">CANCEL</button>
			</div>
    		<div class="cout-btn btn-confirm">
				<button class="btn">CONFIRM</button>
			</div>
    		

		</form>
	
	</div><!--cout-payment-->
	

</div><!--checkout-page-wrapper-->

@endsection