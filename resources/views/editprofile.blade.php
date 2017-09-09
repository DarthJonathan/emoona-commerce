@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="card">
                    <div class="card-header">
                        Edit Profile
                    </div>
                    <div class="card-body">
                        <form class="form" method="POST" action="{{ URL::to('update') }}">

                            {{ csrf_field() }}

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="firstname">First Name</label>
                                        <input type="text" name="firstname" id="firstname" value="{{ $firstname }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" value="{{ $lastname }}" name="lastname" id="lastname" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" placeholder="Your address here" required class="form-control">{{ $user_info['address'] }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="Postcode">Postcode</label>
                                        <input type="number" value="{{ $user_info['postcode'] }}" name="postcode" required id="postcode" placeholder="12345" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="province">Province</label>
                                        <select name="province" id="province" required class="form-control">
                                            <option value="Jakarta">DKI Jakarta</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <select name="country" id="country" class="form-control">
                                    <option value="INA">Indonesia</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="birthday">Birthday</label>
                                        <input type="date" value="{{ $user_info['birthday'] }}" name="birthday" id="birthday" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-0">
                                        <p>Gender</p>
                                        <div class="form-check form-check-inline mb-0">
                                            <label for="gender" class="form-check-label mr-5 ml-2">
                                                <input class="form-check-input" type="radio" name="gender"
                                                       @if($user_info['gender'] == 'male') checked @endif
                                                       id="gender" value="male"> Male
                                            </label>
                                            <label for="gender" class="form-check-label">
                                                <input class="form-check-input" type="radio"
                                                       @if($user_info['gender'] == 'female') checked @endif
                                                        name="gender" id="gender" value="female"> Female
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="number" name="phone" value="{{ $user_info['phone'] }}" id="phone" required class="form-control">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group mt-2 float-right">
                                <input type="submit" value="Submit" class="btn btn-dark">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection