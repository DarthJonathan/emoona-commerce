@extends('layouts.app')

@section('title', 'Transaction Detail')

@section('bgpicture')
    <div class="bgpic" style="background-image: url('{{ asset('img/bannerShop.jpg') }}');">

        <div class="bgpic-caption">
            TRANSACTION DETAIL
        </div><!--bgpic-caption-->
    </div><!--bgpic-->
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <table class="table">
                    <tr>
                        <td>Payment Type</td>
                        <td>{{ $transaction->payment_type->name }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>{{ $transaction->status }}</td>
                    </tr>
                    <tr>
                        <td>Notes</td>
                        <td>{{ $transaction->notes }}</td>
                    </tr>
                    <tr>
                        <td>Transfer Proof</td>
                        <td>
                            @if($transaction->transfer_proof == null)
                                <button class="btn btn-primary" style="cursor: pointer" onclick="verifyPayment(this)" data-id="{{ $transaction->id }}">Verify Payment</button>
                            @else
                                <button class="btn btn-primary" style="cursor: pointer" onclick="verifyPayment(this)" data-id="{{ $transaction->id }}">Reupload Payment Proof</button>
                                <button class="btn btn-primary" style="cursor: pointer" onclick="viewPaymentProof(this)" data-id="{{ $transaction->id }}">View Payment Proof</button>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Shipping Code</td>
                        <td>
                            @if($transaction->shipping_code == null)
                                <button class="btn-danger btn">Not Shipped Yet</button>
                            @else
                                {{ $transaction->shipping_code }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Created At</td>
                        <td>{{ $transaction->created_at }}</td>
                    </tr>
                </table>
                <table class="table mt-5">
                    <thead>
                        <tr>
                            <td>Item Id</td>
                            <td>Item Color</td>
                            <td>Item Size</td>
                            <td>Quantity</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction_detail as $detail)
                            <tr>
                                <td>{{ $detail->id }}</td>
                                <td>{{ $detail->item_detail->color }}</td>
                                <td>{{ $detail->item_detail->size }}</td>
                                <td>{{ $detail->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection