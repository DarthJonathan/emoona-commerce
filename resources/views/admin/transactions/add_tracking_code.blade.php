<div class="row">
    <div class="col-lg-12">

        <form action="#" id="trackingCodeForm">

        {{ csrf_field() }}

        <input type="hidden" name="transaction_id" value="{{ $transaction_id }}">

        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label">Tracking Code</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="code" name="code" placeholder="Enter Tracking Code" required>
            </div>
        </div>

        <div class="form-group row mt-4 mb-0">
            <div class="col-sm-12">
                <button class="btn btn-primary btn-block" style="cursor: pointer" id="submit" type="button">Enter</button>
            </div>
        </div>

        </form>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('#submit').click(function()
        {
            var options = {
                url: '{{ action('admin\TransactionController@addTrackingCode') }}',
                type: 'post',
                success: function(response)
                {
                    loadTransactionDatas();
                    $('#modal').modal('toggle');
                    toggleSuccess(response.msg);
                },
                error: function(response)
                {
                    $('#modal').modal('toggle');
                    toggleError(JSON.stringify(response.responseJSON.errors));
                    console.log(response.responseJSON.errors_debug);
                }
            };

            $("#trackingCodeForm").ajaxSubmit(options);
        });

    });
</script>