@extends ('layouts.admin')

@section('title', 'Admin Dashboard')
@section('dashboard_active', 'class=active')

@section('content')
    <h1>Ini dashboard</h1>
    {{ Auth::user() }}
@endsection