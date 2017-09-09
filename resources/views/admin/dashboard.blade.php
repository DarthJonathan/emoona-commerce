@extends ('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <h1>Ini dashboard</h1>
    {{ Auth::user() }}
@endsection