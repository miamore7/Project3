@extends('layouts.app')

@section('content')
<h2>Buat Forum</h2>
<form action="{{ route('admin.forums.store') }}" method="POST">
    @csrf
    <label>Nama Forum:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Deskripsi:</label><br>
    <textarea name="description"></textarea><br><br>

    <button type="submit">Buat</button>
</form>
@endsection
