<div class="row">
    <div class="col-lg-12">
        <form action="{{ action('admin\ItemManagement@newItem') }}" method="post" id="newItemForm">

            {{ csrf_field() }}

            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label">Item Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="itemName" name="itemName" placeholder="Enter Item Name" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-3 col-form-label">Item Price</label>
                <div class="input-group col-sm-9">
                    <div class="input-group-addon">IDR</div>
                    <input type="number" class="form-control" id="itemPrice" name="itemPrice" placeholder="Enter Item Price" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="gender" class="col-sm-3 col-form-label">Parent Category</label>
                <div class="form-group col-sm-9 mb-0">
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="others">Others</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="category" class="col-sm-3 col-form-label">Category</label>
                <div class="form-group col-sm-9 mb-0">
                    <select class="form-control" id="category" name="category" required>
                        <!-- Categories -->
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="sku" class="col-sm-3 col-form-label">SKU</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="sku" name="sku" placeholder="Enter SKU" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-3">Pre Order</div>
                <div class="col-sm-9">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="preorder"> Enable Pre Order
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <button class="btn btn-primary btn-block" style="cursor: pointer" id="submit" type="button">Create New</button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    var categories = JSON.parse('{!! $categories !!}');

    $(document).ready(function()
    {
        //First Load
        loadCategorySelection('male');

        $('#gender').change(function()
        {
            var selection = $(this).val();

            loadCategorySelection(selection);
        });

        $('#submit').click(function()
        {
            var options = {
                url: '{{ action('admin\ItemManagement@newItem') }}',
                type: 'post',
                success: function(response)
                {
                    var e = {id: response.id, category: 2};
                    $('#modal').modal('toggle');
                    loadNextCategory(e);
                    toggleSuccess(response.msg);
                },
                error: function(response)
                {
                    $('#modal').modal('toggle');
                    toggleError(JSON.stringify(response.responseJSON.errors));
                    console.log(response.responseJSON.errors_debug);
                }
            };

            $("#newItemForm").ajaxSubmit(options);
        });
    });

    function loadCategorySelection (gender)
    {
        //Clean Category Scroller
        $('#category').empty();

        $.each(categories, function(key, value) {
            if(value.gender == gender)
            {
                $('#category').append(
                    '<option value="' + value.id + '">' + value.name + '</option>'
                );
            }
        });
    }
</script>