@extends('layouts.app')
@section('title', 'Tickets')

@section('bgpicture')
    <div class="bgpic" style="background-image: url('{{ asset('img/bannerShop.jpg') }}');">

        <div class="bgpic-caption">
            SUPPORT TICKETS
        </div><!--bgpic-caption-->
    </div><!--bgpic-->
@endsection

@section('content')
<div class="container">

	<div class="row">
		<div class="col-md-7 m-auto">
			<center><h5 class="section-title"> Create New Support Ticket</h5></center>
			<form method="POST" action="">
				<div class="form-group row  {{ $errors->has('title') ? ' has-error' : '' }}">
					<label for ="category" class="col-md-3 control-label">Category</label>

					<div class="col-md-4 container-field">
						<input id="category" type="text" class="form-control input-field" name="category" required>

				        @if ($errors->has('category'))
				            <span class="help-block">
				                <strong>{{ $errors->first('category') }}</strong>
				            </span>
				        @endif
			        </div>				
				</div>

				<div class="form-group row {{ $errors->has('title') ? ' has-error' : '' }}">
				    <label for="title" class="col-md-3 control-label">Title</label>

				    <div class="col-md-4 container-field">
				        <input id="title" type="text" class="form-control input-field" name="title" required>

				        @if ($errors->has('title'))
				            <span class="help-block">
				                <strong>{{ $errors->first('title') }}</strong>
				            </span>
				        @endif
				    </div>
				</div>

				<div class="form-group row {{ $errors->has('message') ? ' has-error' : '' }}">
				    <label for="message" class="col-md-3 control-label">Your Inquiry</label>

				    <div class="col-md-8 container-field">
				        <textarea id="message" type="text" class="form-control input-textarea" name="message" required rows="8"></textarea>

				        @if ($errors->has('message'))
				            <span class="help-block">
				                <strong>{{ $errors->first('message') }}</strong>
				            </span>
				        @endif
				    </div>
				</div>

				<div class="form-group row">
                    <div class="col-md-3"></div>
                    <div class="col-md-8  container-field">
                        <button type="submit" class="btn btn-primary btn-emoona-design">
                            Submit
                        </button>
                    </div>
                </div>
			</form>
		</div>
	</div>

	<div class="row section-all-tickets">
		<div class="col-md-9 m-auto">
			<center><h5 class="section-title"> Your Support Tickets </h5></center>
			<!-- Item Ticket 1 -->
			<div class="card collapse-ticket-header">
				<a data-toggle ="collapse" href="#collapse-ticket-content1" aria-expanded="false">
					<div class="card-header">
						<div class="row">
							<div class="col-md-4">Help ga tau cara pake website ini tolong dibantu</div>
							<div class="col-md-6">Cara Order Gimana</div>
							<div class="col-md-2">Pending</div>
						</div>
					</div>
				</a>
				<div class="card-block collapse collapse-ticket-content" id="collapse-ticket-content1">

					<!-- Format for current user -->
					<div class="row">
						<div class="col-md-8"></div><div class="col-md-4 box-username"><center> You </center></div>
						<div class="col-md-12 box-message"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
							sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad 
							minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea 
							commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse 
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, 
							sunt in culpa qui officia deserunt mollit anim id est laborum
						</div>
					</div>

					<!-- Format for staff/admin -->
					<div class="row"> 
						<div class="col-md-4 box-username"><center> Admin Name Here </center></div>
						<div class="col-md-12 box-message"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
							sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad 
							minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea 
							commodo consequat.
						</div>
					</div>

					<!-- available only if status is not completed -->
					<form method="POST" action="">
						<div class="form-group row {{ $errors->has('message') ? ' has-error' : '' }}">

				    		<div class="col-md-8 m-auto container-field">
				       			 <textarea id="reply" type="text" class="form-control input-textarea" name="reply" required rows="5" placeholder="Reply"></textarea>

						        @if ($errors->has('message'))
						            <span class="help-block">
						                <strong>{{ $errors->first('message') }}</strong>
						            </span>
						        @endif
						    </div>
						</div>

						<div class="form-group row">
		                    <div class="col-md-8 m-auto container-field">
		                        <button type="submit" class="btn btn-primary btn-emoona-design">
		                            Reply
		                        </button>
		                    </div>
		                </div>
					</form>

				</div>
			</div>

			<!-- Item Ticket 2 -->
			<div class="card collapse-ticket-header">
				<a data-toggle ="collapse" href="#collapse-ticket-content2" aria-expanded="false">
					<div class="card-header">
						<div class="row">
							<div class="col-md-4">Complaint</div>
							<div class="col-md-6">LALALALALA</div>
							<div class="col-md-2">Completed</div>
						</div>
					</div>
				</a>
				<div class="card-block collapse collapse-ticket-content" id="collapse-ticket-content2">

					<!-- Format for current user -->
					<div class="row">
						<div class="col-md-8"></div><div class="col-md-4 box-username"><center> You </center></div>
						<div class="col-md-12 box-message"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
							sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad 
							minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea 
							commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse 
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, 
							sunt in culpa qui officia deserunt mollit anim id est laborum
						</div>
					</div>

					<!-- Format for staff/admin -->
					<div class="row"> 
						<div class="col-md-4 box-username"><center> Admin Name Here </center></div>
						<div class="col-md-12 box-message"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
							sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad 
							minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea 
							commodo consequat.
						</div>
					</div>

					<div class="row">
						<div class="col-md-8"></div><div class="col-md-4 box-username"><center> You </center></div>
						<div class="col-md-12 box-message"> Ok. Thank you.
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>

</div>
@endsection