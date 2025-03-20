@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <p>Selamat datang, {{ Auth::user()->name }} (Admin)</p>
</div>
@endsection
