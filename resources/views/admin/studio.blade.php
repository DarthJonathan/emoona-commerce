@extends ('layouts.admin')

@section('title', 'Studio Management')
@section('studio_active', 'class=active')

@section('content')
	<div class="container-fluid">
        <h3>Studio</h3>
        <div class="row">
            <div class = "col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Category</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('admin/studio/createCategory') }}" method="post">
                            {{csrf_field()}}

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

                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>

                    </div>

                    <div class="card-header">
                        <h4>Categories</h4>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{$category->name}}</td>
                                        <td>{{$category->template}}</td>
                                        <td>
                                            <button class="btn btn-primary" onclick="editStudioCategory(this)" data-id="{{ $category->id }}">Edit</button>
                                            <span>&nbsp;</span>
                                            <a class="btn btn-primary" href="{{url('/admin/studio/deleteCategory/'.$category->id)}}">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Item</h4>
                    </div>

                    <div class="card-body">
                        <form enctype='multipart/form-data' action="{{url('admin/studio/addStudioItem')}}" method="post">
                            {{csrf_field()}}

                            <div class="form-group row">
                                <label for="title" class="col-sm-3 col-form-label">Item Title</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="itemName" name="title" placeholder="Enter Item Title" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="content" class="col-sm-3 col-form-label">Item Content</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="itemContent" name="content"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-sm-3 col-form-label">Type</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="createItemType" name="type">
                                        <option>Choose</option>
                                        <option value="campaign">Campaign</option>
                                        <option value="lookbook">Lookbook</option>
                                        <option value="film">Film</option>
                                        <option value="project">Project</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category" class="col-sm-3 col-form-label">Category</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="createItemCategory" name="category">
                                        <option>Choose</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="banner" class="col-sm-3 col-form-label">Banner</label>
                                <input type="file" name="banner" accept="image/*">
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-sm-3 col-form-label">Photos & Videos: </label>
                                <input type="file" name="media[]" multiple>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-primary btn-block" style="cursor: pointer" value="Create New">
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="card-header">
                        <h4>Items</h4>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->title}}</td>
                                        <td>{{$item->StudioCategory->name}}</td>
                                        <td>
                                            <a onclick="editStudioItem(this)" data-id="{{ $item->id }}" class="btn btn-primary">Edit</a>
                                            <span>&nbsp;</span>
                                            <a class="btn btn-primary" href="{{url('/admin/studio/deleteItem/'.$item->id)}}">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>		
	</div>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#createItemType").change(function() {
                var value = $(this).val();
                $.ajax({
                    type : "POST",
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    url : '/admin/studio/getCategory',
                    data : {
                        template : value
                    },
                    success : function(data){
                        $('#createItemCategory').html(data);   
                    }
                })
            });
        });
    </script>
@endsection