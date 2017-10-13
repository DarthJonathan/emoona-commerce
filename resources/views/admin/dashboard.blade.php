@extends ('layouts.admin')

@section('title', 'Admin Dashboard')
@section('dashboard_active', 'class=active')

@section('content')
    <pre>
    <?php
        print_r(Auth::User())
    ?>
    </pre>
@endsection