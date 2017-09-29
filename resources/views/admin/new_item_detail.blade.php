<div class="row">
    <div class="col-lg-12">
        <form action="{{ action('admin\ItemManagement@newItemDetail') }}" method="post" enctype="multipart/form-data">

            {{ csrf_field() }}

            <input type="hidden" name="id" value="{{ $id }}">

            <div class="form-row mb-3">
                <div class="col">
                    <input type="text" class="form-control" id="color" name="color" placeholder="Enter Item Color" required>
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col">
                  <input type="text" required class="form-control" name="size" placeholder="Enter Item Size">
                </div>
                <div class="col">
                  <input type="number" required class="form-control" name="stock" placeholder="Enter Item Stock">
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col">
                    <label for="" class="ml-2">Image</label>
                    <br>
                    <div class="input-group">
                        <label class="input-group-btn mb-2 mb-sm-0 mr-0">
                            <span class="btn btn-primary" style="cursor: pointer">
                                Browse&hellip; <input type="file" name="image[]" style="display: none;" multiple>
                            </span>
                        </label>
                        <input type="text" class="form-control" readonly>
                    </div>
                </div>

                <div class="col">
                    <div class="form-check mx-2 ml-2">
                        <span>Status</span>
                        <br>
                      <label class="form-check-label">
                        <input class="form-check-input mt-3 mb-3" type="radio" name="status">Available
                      </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <button class="btn btn-primary btn-block" style="cursor: pointer">Create New</button>
                </div>
            </div>

        </form>
    </div>
</div>