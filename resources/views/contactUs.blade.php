@extends('layouts.app')

@section('title', $page_title)

@section('bgpicture')
<div class="bgpic" style="background-image: url('../img/bannerTC.jpg');">
	
	<div class="bgpic-caption">
		{!! strtoupper($page_title) !!}
	</div><!--bgpic-caption-->
</div><!--bgpic-->
@endsection

@section('content')
<script src='https://www.google.com/recaptcha/api.js'></script>

<!-- Modal for capcha-->
<div class="modal fade" id="capchaModal">
    <div class="centering" style="display:flex; justify-content: center; align-items: center; width:100%; height:100%;">
        <div class="modal-dialog" role="document">
        <div class="modal-content" id="recap" style="padding:2em;">
            <div class="g-recaptcha" data-sitekey="6LdQEiQUAAAAAMA-wPlYi46EklyNtSRY5vMFAwLC" data-callback="submitForm"></div>
        </div>
    </div>
    </div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-6 m-3 m-sm-auto">
            <form method="POST" action="/contact.send" id="contactUsForm">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }} row">
                    <label for="firstname" class="col-md-4 control-label">First Name</label>

                    <div class="col-md-8 container-field">
                        <input id="firstname" type="text" class="form-control input-field" name="firstname" value="{{ old('firstname') }}" required autofocus>

                        @if ($errors->has('firstname'))
                            <span class="help-block">
                                <strong>{{ $errors->first('firstname') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }} row">
                    <label for="lastname" class="col-md-4 control-label">Last Name</label>

                    <div class="col-md-8 container-field">
                        <input id="lastname" type="text" class="form-control input-field" name="lastname" value="{{ old('lastname') }}" required autofocus>

                        @if ($errors->has('lastname'))
                            <span class="help-block">
                                <strong>{{ $errors->first('lastname') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} row">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                    <div class="col-md-8 container-field">
                        <input id="email" type="email" class="form-control input-field" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }} row">
                    <label for="subject" class="col-md-4 control-label">Subject</label>

                    <div class="col-md-8 container-field">
                        <input id="subject" type="text" class="form-control input-field" name="subject" value="{{ old('subject') }}" required autofocus>

                        @if ($errors->has('subject'))
                            <span class="help-block">
                                <strong>{{ $errors->first('subject') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }} row">
                    <label for="message" class="col-md-4 control-label">Message</label>

                    <div class="col-md-8 container-field">

                        <textarea name="message" id="message" cols="30" rows="5" class="form-control input-textarea" required></textarea>

                        @if ($errors->has('message'))
                            <span class="help-block">
                                <strong>{{ $errors->first('message') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8 ml-auto container-field">
                        <button type="button" id="btnSubmit" class="btn btn-primary btn-emoona-design float-right">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>

	</div>

</div><!--tc-apge-wrapper-->
<script>
    $('#btnSubmit').click(function(){
        $('#capchaModal').modal('show');

		$('#email_form').submit(function()
		{
			return false;
		});
    });

    function submitForm ()
	{
	    var options = {
            url: '/contact.send',
            type: 'post',
            success: function(response)
            {
                toggleSuccess(response.msg);
                setTimeout(function(){ location.reload() }, 3000);
            },
            error: function(response)
            {
                toggleError(JSON.stringify(response.responseJSON.errors));
                // console.log(response.responseJSON.errors_debug);
            }
        };
        
        $("#contactUsForm").ajaxSubmit(options);
	}
</script>

@endsection