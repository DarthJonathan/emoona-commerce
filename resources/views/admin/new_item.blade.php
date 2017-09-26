<div class="row">
    <div class="col-lg-12">
        <form action="{{ \Illuminate\Support\Facades\Redirect::to('new_item') }}" method="post">

            {{ csrf_field() }}

            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label">Item Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="itemName" name="itemName" placeholder="Enter Item Name">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-3 col-form-label">Item Price</label>
                <div class="input-group col-sm-9">
                    <div class="input-group-addon">IDR</div>
                    <input type="number" class="form-control" id="itemPrice" name="itemPrice" placeholder="Enter Item Price">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-3 col-form-label">SKU</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="itemSKU" name="itemSKU" placeholder="Enter SKU">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-3">Pre Order</div>
                <div class="col-sm-9">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"> Enable Pre Order
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