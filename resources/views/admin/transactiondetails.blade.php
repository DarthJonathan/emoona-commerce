<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <table class="table">
                <thead>
                <tr>
                    <td>No</td>
                    <td>Item</td>
                    <td>Color</td>
                    <td>Size</td>
                    <td>Quantity</td>
                </tr>
                </thead>
                <tbody class="trans-detail">
                    @foreach($transactions as $key => $transaction)
                        <tr></tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $transaction->item->name }}</td>
                            <td>{{ $transaction->item_detail->color }}</td>
                            <td>{{ $transaction->item_detail->size }}</td>
                            <td>{{ $transaction->quantity }}</td>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>