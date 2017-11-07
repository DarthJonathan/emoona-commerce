@extends('layouts.app')

@section('title', 'Register')

@section('bgpicture')
    <div class="bgpic" style="background-image: url('{{ asset('img/bannerRegister.jpg') }}');">

        <div class="bgpic-caption">
            REGISTER
        </div><!--bgpic-caption-->
    </div><!--bgpic-->
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 m-3 m-sm-auto">
            <form method="POST" action="{{ route('register') }}">
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

                <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }} row">
                    <label for="birthday" class="col-md-4 control-label">Birthday</label>

                    <div class="col-md-8 container-field">
                        <input id="birthday" type="date" class="form-control input-field" name="birthday" value="{{ old('birthday') }}" required>

                        @if ($errors->has('birthday'))
                            <span class="help-block">
                                <strong>{{ $errors->first('birthday') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} row">
                    <label for="password" class="col-md-4 control-label">Password</label>

                    <div class="col-md-8 container-field">
                        <input id="password" type="password" class="form-control input-field" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                    <div class="col-md-8 container-field">
                        <input id="password-confirm" type="password" class="form-control input-field" name="password_confirmation" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 container-field">
                        <label class="form-check-label">
                            <input type="checkbox" name="newsletter" class="form-check-input">
                            Sign Up for Newsletter
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 mx-auto container-field">
                        <button type="submit" class="btn btn-primary btn-emoona-design">
                            Register
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
