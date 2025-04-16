@extends('layouts.app')

@section('content')
<h2>Forum yang Tersedia</h2>

<ul>
    @foreach($forums as $forum)
        <li>
            <strong>{{ $forum->name }}</strong><br>
            <form action="{{ route('user.forums.request', $forum->id) }}" method="POST">
                @csrf
                <button type="submit">Request Join</button>
            </form>
        </li>
    @endforeach
</ul>
@endsection
