@extends ('layouts.admin')

@section('title', 'Social Management')
@section('social_active', 'class=active')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class = "col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4>Social Page</h4>
					</div>
					<div class="card-body row justify-content-md-center">
						<!-- <div class="col-md-8">
							<form action="" method="post">
								{{csrf_field()}}

								<div class="card">
                                <span class="card-header">Page Description</span>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="tagline" class="col-form-label mb-2">Tagline</label>
                                        <input type="text"  name="tagline" id="tagline" class="form-control" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="social_description" class="col-form-label mb-2">Description</label>
                                        <textarea  name="social_description" id="social_description" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-dark float-right" onclick="saveColletionsCard()">Save</button>
                                    </div>
                                </div>
                            </div>
							</form>
						</div> -->

						<div class="col-md-12">
							<div class="card">
                                <span class="card-header">Images</span>
                                <div class="card-body">
                                    <div class=" row">
                                      @foreach($photos as $photo)
                                      	<div class="col-md-3 admin-social-image-container">
                                      		<img src="/storage/img/social/{{ explode('/', $photo->image)[4] }}" class="admin-social-image">
                                      		<a href="{{url('/admin/social/remove/'.$photo->id)}}" class="btn btn-dark">Delete</a>
                                      	</div>
                                      @endforeach
                                    </div>
                                    <div class="input-group mt-3 col-lg-12">

                                    	<div class="col-lg-6">
                                    		<form enctype='multipart/form-data' action="{{ action('admin\SocialController@saveImages') }}" method="post">

                                    			{{ csrf_field() }}

                                    			<div class="input-group">
					                                <label class="input-group-btn">
					                                    <span class="btn btn-dark" style="cursor: pointer">
					                                        Add Image(s) <input type="file" name="images[]" multiple accept="image/*">
					                                    </span>
					                                </label>
					                            </div>

					                            <input type="submit" class="btn btn-dark" value="Save">
                                    		</form>
				                            
				                        </div>
                                    </div>

                                    <ul>
								        @foreach($errors->all() as $error)
								            <li>{{$error}}</li>
								        @endforeach
								    </ul>

                                </div>
                            </div>
						</div>
					</div>

					

				</div>
			</div>
		</div>
	</div>
@endsection