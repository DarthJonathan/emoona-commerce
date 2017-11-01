<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <form action="" id="addSlideImage">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group">
                            <label class="input-group-btn mb-2 mb-sm-0 mr-0">
                                <span class="btn btn-primary" style="cursor: pointer">
                                    Browse&hellip; <input type="file" name="image[]" style="display: none;" multiple>
                                </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                            {{ csrf_field() }}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-primary btn-block" type="button" id="submit">Add New</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(document).on('change', ':file', function () {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });

        $(':file').on('fileselect', function (event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if (input.length) {
                input.val(log);
            } else {
                if (log) alert(log);
            }

        });

        $('#submit').click(function()
        {
            var options = {
                url: '{{ action('admin\WebconfigController@storeSliderImage') }}',
                type: 'POST',
                success: function(response)
                {
                    $('#modal').modal('toggle');
                    toggleSuccess(response.msg);
                    setTimeout(location.reload(), 2500);
                },
                error: function(response)
                {
                    $('#modal').modal('toggle');
                    toggleError(JSON.stringify(response.responseJSON.errors));
                    console.log(response.responseJSON.errors_debug);
                }
            };

            $("#addSlideImage").ajaxSubmit(options);
        });
    });
</script>