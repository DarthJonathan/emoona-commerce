@extends('layouts.app')

@section('bgpicture')
    <div class="bgpic" style="background-image: url('../img/bannerShop.jpg');">

        <div class="bgpic-caption">
            {{ strtoupper($title) }}
        </div><!--bgpic-caption-->
    </div><!--bgpic-->
@endsection

@section('title', $title)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>Payment Type</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr data-id="{{ $order->id }}" onclick="viewOrder(this)" style="cursor: pointer">
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->payment_type->name }}</td>
                                <td>
                                    @if($order->status == 0)
                                        <button class="btn btn-danger">Not Paid</button>
                                    @elseif($order->status == 1)
                                        <button class="btn btn-warning">Processing</button>
                                    @elseif($order->status == 2)
                                        <button class="btn btn-warning">Sent</button>
                                    @elseif($order->status == 3)
                                        <button class="btn btn-warning">Finished</button>
                                    @endif
                                </td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection