@extends ('layouts.admin')

@section('title', 'Admin Dashboard')
@section('dashboard_active', 'class=active')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <pre>
                    <?php print_r($analytics->toArray()); ?>
                </pre>
            </div>
            <div class="col-lg-6">

            </div>
        </div>
    </div>
@endsection