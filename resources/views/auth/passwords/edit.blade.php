@extends('layouts.app')
@section('title', 'Change Password')

@section('bgpicture')
    <div class="bgpic" style="background-image: url('{{ asset('img/bannerShop.jpg') }}');">

        <div class="bgpic-caption">
            Change Password
        </div><!--bgpic-caption-->
    </div><!--bgpic-->
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 m-3 m-sm-auto">
                <form method="POST" action="{{ action('UserController@storePassword') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }} row">
                        <label for="old_password" class="col-md-4 control-label">Old Password</label>

                        <div class="col-md-8 container-field">
                            <input id="old_password" type="password" class="form-control input-field" name="old_password" value="{{ old('old_password') }}" required autofocus>

                            @if ($errors->has('old_password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('old_password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} row">
                        <label for="password" class="col-md-4 control-label">New Password</label>

                        <div class="col-md-8 container-field">
                            <input id="password" type="password" class="form-control input-field" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} row">
                        <label for="password_confirmation" class="col-md-4 control-label">Password Confirmation</label>

                        <div class="col-md-8 container-field">
                            <input id="password_confirmation" type="password" class="form-control input-field" name="password_confirmation" required>

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8 container-field">
                            <button type="submit" class="btn btn-primary float-right btn-emoona-design">
                                Change
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
