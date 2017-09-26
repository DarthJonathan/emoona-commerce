<div class="row">
    <div class="col-lg-12">
        <form action="{{ \Illuminate\Support\Facades\Redirect::to('new_item') }}" method="post">

            {{ csrf_field() }}

            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label">Category Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="itemName" name="categoryName" placeholder="Enter Category Name">
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