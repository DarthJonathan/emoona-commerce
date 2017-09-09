@extends('layouts.admin')

@section('title', 'User Transactions')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 m-auto">
            <div class="card">
                <div class="card-header">
                     User Transactions
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Payment Type</td>
                                <td>Notes</td>
                                <td>Payment Proof</td>
                                <td>Status</td>
                                <td>Created</td>
                                <td>Transaction Details</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $count => $transaction)
                                <tr>
                                    <td>{{ $count+1 }}</td>
                                    <td>{{ $transaction['payment_type']['name'] }}</td>
                                    <td>{{ $transaction['notes'] }}</td>
                                    <td>
                                        @if($transaction['transfer_proof'] == null)
                                            <button class="btn btn-danger">Not Paid</button>
                                        @else
                                            <img src="{{ $transaction['transfer_proof'] }}" alt="">
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaction['status'] == 1)
                                            <button class="btn btn-danger">Not Paid</button>
                                        @elseif($transaction['status'] == 2)
                                            <button class="btn btn-warning">Paid</button>
                                        @elseif($transaction['status'] == 3)
                                            <button class="btn btn-primary">Delivered</button>
                                        @endif
                                    </td>
                                    <td>{{ $transaction['created'] }}</td>
                                    <td>
                                        <button
                                                class="btn btn-secondary"
                                                style="cursor: pointer"
                                                data-id="{{ $transaction['id'] }}"
                                                onclick="seeTransactionDetail(this)"
                                        >
                                            See Details
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection