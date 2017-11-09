<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<form action="{{ url('admin/studio/editCategory') }}" method="post">
                    {{csrf_field()}}

                    <input type="hidden" name="id" value="{{ $data->id }}">

                    <div class="form-group row">
                        <label for="categoryName" class="col-sm-3 col-form-label">Category Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Enter Category Name" value="{{ $data->name }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="categoryDescription" class="col-sm-3 col-form-label">Category Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="categoryDescription" name="categoryDescription">{!! $data->description !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="type" class="col-sm-3 col-form-label">Type</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="createCategoryType" name="type">
                                <option value="campaign">Campaign</option>
                                <option value="lookbook">Lookbook</option>
                                <option value="film">Film</option>
                                <option value="project">Project</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="submit" class="btn btn-primary btn-block" style="cursor: pointer" value="Create New">
                        </div>
                    </div>

                </form>
		</div>
	</div>
</div>