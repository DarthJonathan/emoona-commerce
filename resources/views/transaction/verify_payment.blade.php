<div class="container">
    <form action="" id="addVerificationImage">
    <div class="row">
        <div class="col-md-6">
            <div class="input-group">
                <label class="input-group-btn mb-2 mb-sm-0 mr-0">
                    <span class="btn btn-primary" style="cursor: pointer">
                        Browse&hellip; <input type="file" name="image" style="display: none;">
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $id }}">
            </div>
        </div>
        <div class="col-md-6">
            <button class="btn btn-primary btn-block" type="button" id="submit">Add New</button>
        </div>
    </div>
    </form>
</div>

<script>
    $(document).ready(function()
    {
        $(document).on('change', ':file', function() {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });

        $(':file').on('fileselect', function(event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });

        $('#submit').click(function()
        {
            var options = {
                url: '{{ action('TransactionController@verifyPaymentSubmit') }}',
                type: 'post',
                success: function(response)
                {
//                    console.log(response);
                    $('#modal').modal('toggle');
                    toggleSuccess(response.msg);
                    location.reload();
                },
                error: function(response)
                {
                    $('#modal').modal('toggle');
                    toggleError(response.responseJSON.errors);
                    console.log(response.responseText);
                }
            };

            $("#addVerificationImage").ajaxSubmit(options);
        });
    });
</script>