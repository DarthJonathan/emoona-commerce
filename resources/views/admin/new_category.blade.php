<div class="container">
<div class="row">
	<div class="col-lg-12">
		<form action="{{action('admin\ItemManagement@newCategory')}}" method="post">
			
			{{ csrf_field() }}

			<div class="form-group row">
				<label for="categoryName" class="col-sm-3 col-form-label">Category Name</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Enter Category Name">
				</div>
			</div>

			<div class="form-group row">
				<label for="categoryDescription" class="col-sm-3 col-form-label">Category Description</label>
				<div class="col-sm-9">
					<textarea class="form-control" id="categoryDescription" name="categoryDescription"></textarea>
				</div>
			</div>

			<div class="form-group row">
				<label for="gender" class="col-sm-3 col-form-label">Parent Category</label>
				<div class="col-sm-9">
					<select class="form-control" id="gender" name="gender">
						<option value="male">Male</option>
						<option value="female">Female</option>
						<option value="others">Others</option>
					</select>
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
</div>