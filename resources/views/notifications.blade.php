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
                            @if(!is_array($item))
                                <td>
                                    <a href="{{ $item }}">{{ $key }}</a>
                                </td>
                            @else
                                <td>
                                    <a href="{{ $item[0] }}">{{ $key }}</a>
                                </td>
                                <td><a href="/notification/remove/{{ $item[1] }}">&cross;</a></td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection