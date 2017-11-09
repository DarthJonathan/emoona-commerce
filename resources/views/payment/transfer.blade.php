@extends ('layouts.app')

@section('title', 'Transfer Payment')

@section('bgpicture')
    <div class="bgpic" style="background-image: url('{{ asset('img/bannerShop.jpg') }}');">

        <div class="bgpic-caption">
            ACCOUNT INFORMATION
        </div><!--bgpic-caption-->
    </div><!--bgpic-->
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <h1 class="mb-5">Transfer Account Information</h1>
                <p>Please pay to</p>
                <h3 class="mt-1 mb-5">
                    {!! $info->value !!}
                </h3>
                <a onclick="printThis()" href="#" class="btn btn-dark mt-3">Print</a>
                <a href="/" class="btn btn-dark mt-3">Home</a>
            </div>
        </div>
    </div>
@endsection