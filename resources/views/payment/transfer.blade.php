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
            <div class="col-lg-12">
                <div class="card text-center">
                    <div class="card-header">
                        Transfer Payment
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Please Pay To</h4>
                        <p class="card-text">LALALALALA a/n lalalalala</p>
                        <a href="{{ URL::to('/verify/') }}" class="btn btn-primary">Verify Payment</a>
                    </div>
                    <div class="card-footer text-muted">
                        7 Days
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection