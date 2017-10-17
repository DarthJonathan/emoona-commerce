@extends('layouts.app')

@section('title', 'Notifications')

@section('bgpicture')
    <div class="bgpic" style="background-image: url('{{ asset('img/bannerShop.jpg') }}');">

        <div class="bgpic-caption">
            NOTIFICATIONS
        </div><!--bgpic-caption-->
    </div><!--bgpic-->
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h3>Notifications</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach(\Illuminate\Support\Facades\Session::get('notifications') as $key => $item)
                                <a href="{{ $item }}" class="list-group-item list-group-item-action">{{ $key }}</a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection