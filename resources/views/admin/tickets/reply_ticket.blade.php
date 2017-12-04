<div class="container">
<div class="row">
    <div class="col-lg-12">
        <form action="{{ action('admin\SupportController@replyTicket') }}" method="post" id="openTicketForm" enctype="multipart/form-data">

            {{ csrf_field() }}

            <input type="hidden" name="id" value="{{ $id }}">

            <div class="form-group row">
                <label for="content" class="col-sm-3 col-form-label">Content</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="content" name="content" required></textarea>
                </div>
            </div>

            {{--<div class="form-row mb-3">--}}
                {{--<div class="col-md-3">--}}
                    {{--<label for="" class="ml-2">Image</label>--}}
                {{--</div>--}}
                {{--<div class="col pl-2">--}}
                    {{--<div class="input-group">--}}
                        {{--<label class="input-group-btn mb-2 mb-sm-0 mr-0">--}}
                            {{--<span class="btn btn-primary" style="cursor: pointer">--}}
                                {{--Browse&hellip; <input type="file" name="image" style="display: none;">--}}
                            {{--</span>--}}
                        {{--</label>--}}
                        {{--<input type="text" class="form-control" readonly>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="form-group row mt-4 mb-0">
                <div class="col-sm-12">
                    <button class="btn btn-primary btn-block" style="cursor: pointer" id="submit" type="button">Create New</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<script>
    $(document).ready(function(){

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
                url: '{{ action('admin\SupportController@replyTicket') }}',
                type: 'post',
                success: function(response)
                {
                    $('#modal').modal('toggle');
                    toggleSuccess(response.msg);

                    var id = Number(response.id);

                    refreshData(id)
                },
                error: function(response)
                {
                    $('#modal').modal('toggle');
                    toggleError(JSON.stringify(response.responseJSON.errors));
                    console.log(response.responseJSON.errors_debug);
                }
            };

            $("#openTicketForm").ajaxSubmit(options);
        });

    });
</script>