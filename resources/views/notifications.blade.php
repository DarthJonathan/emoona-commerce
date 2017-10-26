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
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <h3>Notifications</h3>

                <table class="table table-hover mt-5">
                    @foreach($notifications as $key => $item)
                        <tr>
                            <td>
                                <a href="{{ $item->notification_url }}">{{ $item->notification_name }}</a>
                            </td>
                            <td><a href="/notification/remove/{{ $item->id }}">&cross;</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection