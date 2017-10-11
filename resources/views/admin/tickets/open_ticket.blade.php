<div class="row">
    <div class="col-lg-12">
        <form action="{{ action('admin\SupportController@openTicket') }}" method="post" id="openTicketForm" enctype="multipart/form-data">

            {{ csrf_field() }}

            <input type="hidden" name="category_id" value="{{ $id }}">
            <input type="hidden" name="" value="{{ $user_id }}">

            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label">Title</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Ticket Title" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label">Category</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="category" name="category" placeholder="Enter Ticket Category" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-3 col-form-label">Content</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="content" name="content" required></textarea>
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col-md-3">
                    <label for="" class="ml-2">Image</label>
                </div>
                <div class="col pl-2">
                    <div class="input-group">
                        <label class="input-group-btn mb-2 mb-sm-0 mr-0">
                            <span class="btn btn-primary" style="cursor: pointer">
                                Browse&hellip; <input type="file" name="image" style="display: none;">
                            </span>
                        </label>
                        <input type="text" class="form-control" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group row mt-4 mb-0">
                <div class="col-sm-12">
                    <button class="btn btn-primary btn-block" style="cursor: pointer" id="submit" type="button">Create New</button>
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
                url: '{{ action('admin\SupportController@openTicket') }}',
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

            $("#openTicketForm").ajaxSubmit(options);
        });

    });
</script>