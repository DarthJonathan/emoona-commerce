<div class="container">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <h1>Edit Studio Item</h1>
        </div>
        <form action="" class="col-lg-12" id="studioItemContent">
            {{ csrf_field() }}

            <input type="hidden" name="id" value="{{ $studio->id }}">

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" value="{{ $studio->title }}" required class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" placeholder="Content" required class="form-control">{{ $studio->content }}</textarea>
            </div>

            <div class="form-group row">
                <div class="col-lg-12">
                    <button class="btn btn-dark btn-block" onclick="itemContent()" type="button">Submit</button>
                </div>
            </div>
        </form>

        <div class="col-lg-12">
            <hr>
        </div>

        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-6">
                    <img src="/storage/img/studio/{{ explode('/',$files[0])[3] }}/banner.jpg" style="width:100%;" alt="">
                </div>
                <div class="col-md-6 row">
                    <h4>Banner Image</h4>
                    <form action="#" method="post" enctype="multipart/form-data" class="row mt-3" id="changeBannerImageStudio">
                        <input type="hidden" name="file_path" value="{{ explode('/',$files[0])[3] }}">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <label class="input-group-btn mb-2 mb-sm-0 mr-0">
                                    <span class="btn btn-primary" style="cursor: pointer">
                                        Browse&hellip; <input type="file" name="banner" style="display: none;">
                                    </span>
                                </label>
                                <input type="text" class="form-control" readonly>
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{ $studio->id }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button class="btn btn-primary btn-block" type="button" id="submit" onclick="changeBannerImage()">Change</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <hr>
        </div>

        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <h4>Media Files</h4>
                </div>
                <div class="col-lg-12">
                    <div class="image-scroller">
                        <div class="image-group">
                            @foreach($files as $count => $file)
                                <?php
                                $file_path = explode('/',$file)[3] . '/' . explode('/',$file)[4];

                                if(explode('/',$file)[4] == "banner.jpg")
                                    continue;
                                ?>
                                @if(explode('.', $file_path)[1] == 'mp4')
                                    <div class="col-lg-8 float-left">
                                        <video style="width:100%" controls data-id="{{ $count }}" onclick="checkBox(this)">
                                            <source src="/storage/img/studio/{{ $file_path }}#t=0.1" type="video/mp4">
                                        </video>
                                        <center><input type="checkbox" class="tobe-deleted" name="delete" id="{{ $count }}" value="{{ $file_path }}"></center>
                                    </div>
                                @else
                                    <div class="col-lg-4 float-left">
                                        <img src="{{ asset('/storage/img/studio/' . $file_path) }}" alt="Image Error" data-id="{{ $count }}" onclick="checkBox(this)">
                                        <center><input type="checkbox" class="tobe-deleted" name="delete" id="{{ $count }}" value="{{ $file_path }}"></center>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-3">
                    <button class="btn btn-primary btn-block" onclick="deleteSelected()">Delete Selected</button>
                </div>
                <form action="#" method="post" enctype="multipart/form-data" class="col-lg-12 mt-3" id="addMediaFilesStudio">
                    <input type="hidden" name="file_path" value="{{ explode('/',$files[0])[3] }}">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label class="input-group-btn mb-2 mb-sm-0 mr-0">
                            <span class="btn btn-primary" style="cursor: pointer">
                                Browse&hellip; <input type="file" name="media[]" style="display: none;" multiple>
                            </span>
                                </label>
                                <input type="text" class="form-control" readonly>
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{ $id }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <button class="btn btn-primary btn-block" type="button" id="submit" onclick="addMediaItem()">Add New</button>
                        </div>
                    </div>
                </form>
            </div>
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
    });

    function changeBannerImage()
    {
        var options = {
            url: '{{ action('admin\StudioController@changeBannerImageStudio') }}',
            type: 'post',
            success: function(response)
            {
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

        $("#changeBannerImageStudio").ajaxSubmit(options);
    }

    function itemContent ()
    {
        var options = {
            url: '{{ action('admin\StudioController@storeEditStudioItem') }}',
            type: 'post',
            success: function(response)
            {
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

        $("#studioItemContent").ajaxSubmit(options);
    }

    function addMediaItem()
    {
        var options = {
            url: '{{ action('admin\StudioController@addStudioItemMedia') }}',
            type: 'post',
            success: function(response)
            {
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

        $("#addMediaFilesStudio").ajaxSubmit(options);
    }

    function deleteSelected() {

        var deletes = [];
        var files = "{{ explode('/',$files[0])[3] }}";

        $('.tobe-deleted:checked').each(function()
        {
            deletes.push($(this).val());
        });

        $.ajax({
            url:'/admin/studio/delete_media_studio',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            data: { id:deletes, files:files },
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