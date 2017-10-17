@extends('layouts.app')

@section('title', 'Checkout')

@section('bgpicture')
    <div class="bgpic" style="background-image: url('{{ asset('img/bannerShop.jpg') }}');">

        <div class="bgpic-caption">
            CART
        </div><!--bgpic-caption-->
    </div><!--bgpic-->
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if(Cart::isEmpty())
                    <h4>Cart Is Empty</h4>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <td>No.</td>
                                <td>Item Name</td>
                                <td>Quantity</td>
                                <td>Price</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contents as $count => $item)
                                <tr>
                                    <td>{{ ($count+1) }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>IDR {{ $item->getPriceSum() }}</td>
                                    <td>
                                        <button class="btn btn-danger" onclick="removeItem(this)" data-id="{{ $item->id }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3">Total Quantity</td>
                                <td colspan="2">{{ Cart::getTotalQuantity() }}</td>
                            </tr>
                            <tr>
                                <td colspan="3">Total Price</td>
                                <td colspan="2">{{ Cart::getTotal() }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-primary" onclick="clearCart()" style="cursor: pointer">Clear Cart</button>
                    <a href="{{ URL::to('/checkout') }}">
                        <button class="btn btn-primary" onclick="checkOut()" style="cursor: pointer">Checkout</button>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection