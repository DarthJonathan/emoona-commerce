@extends('layouts.app')
@section('title', 'Login')

@section('bgpicture')
    <div class="bgpic" style="background-image: url('{{ asset('img/bannerShop.jpg') }}');">

        <div class="bgpic-caption">
            LOGIN
        </div><!--bgpic-caption-->
    </div><!--bgpic-->
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 m-auto">
            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} row">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                    <div class="col-md-8 container-field">
                        <input id="email" type="email" class="form-control input-field" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
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
                    <div class="col-md-4"> 
                    </div>
                    <div class="col-md-8 container-field">
                        <a class="btn-link link-forgot-dedicated" href="{{ URL::to('password/reset') }}">
                            Forgot Your Password?
                        </a>
                    </div>
                </div>
                                

                <div class="form-group row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 container-field">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8 container-field">
                        <button type="submit" class="btn btn-primary btn-emoona-design">
                            Login
                        </button>
                    </div>
                </div>
            </form>      
        </div>
    </div>
</div>
@endsection
