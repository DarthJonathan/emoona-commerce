@extends('layouts.app')

@section('title', 'Cart Checkout')

@section('bgpicture')
    <div class="bgpic" style="background-image: url('{{ asset('img/bannerShop.jpg') }}');">

        <div class="bgpic-caption">
            CHECKOUT
        </div><!--bgpic-caption-->
    </div><!--bgpic-->
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <table class="table">
                    <thead>
                    <tr>
                        <td>No.</td>
                        <td>Item Name</td>
                        <td>Quantity</td>
                        <td>Price</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cart as $count => $item)
                        <tr>
                            <td>{{ ($count+1) }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>IDR {{ $item->getPriceSum() }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">Total Quantity</td>
                        <td>{{ Cart::getTotalQuantity() }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">Total Price</td>
                        <td>{{ Cart::getTotal() }}</td>
                    </tr>
                    </tbody>
                </table>
                <button class="btn btn-primary" onclick="clearCart()" style="cursor: pointer">Cancle Purchase</button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <form action="{{ URL::to('/payment') }}" method="post">

                    {{ csrf_field() }}

                    <div class="input-group">
                        <select class="form-control form-control-sm" name="payment_type">
                            @foreach($payment_type as $single)
                                <option value="{{ $single->id }}">{{ $single->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mt-3">
                        <button class="btn btn-primary" style="cursor: pointer">Confirm Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection