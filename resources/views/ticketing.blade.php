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

	@if(!isset($toggle))
	<div class="row">
		<div class="col-md-7 m-auto">
			<center><h5 class="section-title"> Create New Support Ticket</h5></center>
			<form method="POST" action="#" id="newTicketUser">

				{{ csrf_field() }}

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
                        <button type="button" onclick="newTicketUser()" class="btn btn-primary btn-emoona-design">
                            Submit
                        </button>
                    </div>
                </div>
			</form>
		</div>
	</div>
    @endif

	<div class="row section-all-tickets">
		<div class="col-md-9 m-auto ticket-section">
			<center><h5 class="section-title"> Your Support Tickets </h5></center>
			@foreach($tickets as $ticket)
				<!-- Item Ticket 1 -->
				<div class="card collapse-ticket-header">
					<a data-toggle ="collapse" href="#collapse-ticket-content{{ $ticket->id }}" aria-expanded="false">
						<div class="card-header">
							<div class="row">
								<div class="col-md-4">{{ $ticket->title }}</div>
								<div class="col-md-6">{{ $ticket->category }}</div>
								<div class="col-md-2">
									@if($ticket->completed ==  null)
										Open
									@else
										Closed
									@endif
								</div>
							</div>
						</div>
					</a>
					<div class="card-block collapse collapse-ticket-content" id="collapse-ticket-content{{ $ticket->id }}">

						<div class="replies-field-{{ $ticket->id }}">
							@foreach($ticket->ticket_detail as $detail)

								@if($detail->replying_user_id == Auth::id())
									<!-- Format for current user -->
									<div class="row">
										<div class="col-md-8"></div><div class="col-md-4 box-username"><center> You </center></div>
										<div class="col-md-12 box-message">
											{{ $detail->text }}
										</div>
									</div>
								@else
									<!-- Format for staff/admin -->
									<div class="row">
										<div class="col-md-4 box-username"><center> Admin</center></div>
										<div class="col-md-12 box-message">
											{{ $detail->text }}
										</div>
									</div>
								@endif

							@endforeach
						</div>

						@if($ticket->completed == null)
							<!-- available only if status is not completed -->
							<form method="POST" action="#" id="replyTicketUser{{ $ticket->id }}">
								<div class="form-group row {{ $errors->has('message') ? ' has-error' : '' }}">

									{{ csrf_field() }}

									<input type="hidden" name="id" value="{{ $ticket->id }}">

									<div class="col-md-8 m-auto container-field">
										<textarea id="reply{{ $ticket->id }}" class="form-control input-textarea" name="reply" required rows="5" placeholder="Reply"></textarea>

										@if ($errors->has('message'))
											<span class="help-block">
										<strong>{{ $errors->first('message') }}</strong>
									</span>
										@endif
									</div>
								</div>

								<div class="form-group row">
									<div class="col-md-8 m-auto container-field">
										<button onclick="replyTicketUser({{ $ticket->id }})" type="button" class="btn btn-primary btn-emoona-design" style="cursor: pointer">
											Reply
										</button>
									</div>
								</div>
							</form>
						@endif

					</div>
				</div>
			@endforeach
		</div>
	</div>

</div>

@if(isset($toggle))
    <script>
        $(document).ready(function(){
            $('#collapse-ticket-content{{ $toggle }}').collapse('toggle')
        });
    </script>
@endif

@endsection