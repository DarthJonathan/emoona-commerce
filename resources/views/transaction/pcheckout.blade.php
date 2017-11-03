@extends('layouts.app')

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

			@foreach($cart as $count => $item)
				<tr>
					<td>{{ $item->name }}</td>
					<td>x {{ $item->quantity }}</td>
					<td>IDR {{ $item->getPriceSum() }}</td>
				</tr>
			@endforeach

			<tr id="cout-total-p">
				<td>TOTAL</td>
				<td></td>
				<td>IDR {{ Cart::getTotal() }}</td>
			</tr>
		</tbody>
	</table>

	<div class="cout-payment">
		<div class="cout-c-paymethod">
			Payment Method
		</div>


		<form class="form-inline mt-2" action="{{ URL::to('/payment') }}" method="post">
			{{ csrf_field() }}
			<select class="form-control" id="cout-paymethod" name="payment_type">
				@foreach($payment_type as $single)
					<option value="{{ $single->id }}">{{ $single->name }}</option>
				@endforeach
			</select>

			<div class="cout-btn">
				<button type="button" class="btn" style="cursor: pointer" onclick="clearCart()">CANCEL</button>
			</div>
				{{ csrf_field() }}
				<div class="cout-btn btn-confirm">
					<button class="btn" style="cursor: pointer">CONFIRM</button>
				</div>


		</form>

	</div><!--cout-payment-->


</div><!--checkout-page-wrapper-->
@endsection