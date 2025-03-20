@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Dashboard</h1>
    <p>Selamat datang, {{ Auth::user()->name }} (User)</p>
</div>
@endsection
