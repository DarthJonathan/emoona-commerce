<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ action('admin\WebconfigController@storeSliderImage') }}" method="post" enctype="multipart/form-data" id="addSlideImage">
                <div class="row">
                    <div class="col-lg-12 row mb-3">
                        {{ csrf_field() }}
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label class="input-group-btn mb-2 mb-sm-0 mr-0">
                                    <span class="btn btn-dark" style="cursor: pointer">
                                        Browse&hellip; <input type="file" name="image" style="display: none;" >
                                    </span>
                                </label>
                                <input type="text" class="form-control" readonly placeholder="Select a File">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label for="url" class="input-group-addon">http://</label>
                                <input type="text" name="url" id="url" class="form-control" placeholder="emoonastudio.com">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button class="btn btn-dark btn-block" id="submit">Add New</button>
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
    });
</script>