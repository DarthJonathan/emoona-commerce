@extends ('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')


    <h1>Ini dashboard</h1>
    <pre>
    {{ \Illuminate\Support\Facades\Auth::user() }}
</pre>
@endsection