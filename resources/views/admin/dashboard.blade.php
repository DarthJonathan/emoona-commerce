@extends ('layouts.admin')

@section('title', 'Admin Dashboard')
@section('dashboard_active', 'class=active')

@section('content')
    <div class="container">
        <div class="row">
                <pre>
                    <?php print_r($analytics->toArray()); ?>
                </pre>
            <div class="col-lg-6">

            </div>
            <div class="col-lg-6">

            </div>
        </div>
    </div>
@endsection