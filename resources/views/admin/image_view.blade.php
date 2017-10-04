<div class="row">
    <div class="col-lg-12">
        <div class="image-scroller">
            <div class="image-group">
            @foreach($files as $count => $file)
                <?php
                    $file_path = explode('/',$file)[2] . '/' . explode('/',$file)[3];
                ?>
                        @if( ($count) % 3 == 0)
                            <div class="row">
                        @endif
                            <div class="col-lg-4">
                                <img src="{{ asset('/storage/item_detail/' . $file_path) }}" alt="Image Error" data-id="{{ $count }}" onclick="checkBox(this)">
                                <center><input type="checkbox" class="tobe-deleted" name="delete" id="{{ $count }}" value="{{ $file_path }}"></center>
                            </div>
                        @if( ($count+1) % 3 == 0 || count($files)-1 == $count)
                            </div>
                        @endif
            @endforeach
            </div>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12">
        <button class="btn btn-primary btn-block" onclick="deleteSelected()">Delete Selected</button>
    </div>
</div>
<br>
<form action="" id="addImageItemDetail">
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
            <input type="hidden" name="id" value="{{ $id }}">
        </div>
    </div>
    <div class="col-lg-6">
        <button class="btn btn-primary btn-block" type="button" id="submit">Add New</button>
    </div>
    </div>
</form>
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
                url: '{{ action('admin\ItemManagement@addImageItemDetail') }}',
                type: 'post',
                success: function(response)
                {
                    console.log(response);
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

            $("#addImageItemDetail").ajaxSubmit(options);
        });
    });

    function deleteSelected() {

        var deletes = [];

        $('.tobe-deleted:checked').each(function()
        {
            deletes.push($(this).val());
        });

        $.ajax({
            url:'/admin/delete_image',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: { id:deletes },
            success: function(response) {
                toggleSuccess(response.msg);
                $('#modal').modal('toggle');
            },
            error: function(response) {
                toggleError(response.responseJSON.errors);
                $('#modal').modal('toggle');
                console.log(response.responseJSON.errors_debug);
            }
        });
    }

    function checkBox(e) {
        var id = $(e).data('id');
        var checkBoxes = $('#' + id);

        checkBoxes.attr("checked", !checkBoxes.attr("checked"));
    }
</script>