@extends('layouts.app')

@section('content')
<div class="container py-8">
    <h2 class="text-2xl font-bold mb-6 text-center">Chat Forum: {{ $forum->name }}</h2>

    <!-- Chat Window -->
    <div class="chat-container" style="border:1px solid #ccc; padding:20px; margin-bottom:20px; height:400px; overflow-y:auto; border-radius:10px; background-color:#f9f9f9;">
        @foreach($forum->messages as $msg)
            <div class="message @if($msg->user_id == auth()->id()) message-sent @else message-received @endif mb-4">
                <div class="message-header flex justify-between items-center">
                    <strong class="text-sm">{{ $msg->user->name }}</strong>
                    <small class="text-xs text-gray-500">{{ $msg->created_at->format('d M Y, H:i') }}</small>
                </div>
                <div class="message-body mt-2 p-2 rounded-lg @if($msg->user_id == auth()->id()) bg-blue-100 text-right @else bg-gray-100 text-left @endif">
                    {{ $msg->message }}
                </div>
            </div>
        @endforeach
    </div>

    <!-- Message Input -->
    <form action="{{ route('user.forums.chat.send', $forum->id) }}" method="POST" class="flex items-center space-x-2">
        @csrf
        <input type="text" name="message" placeholder="Ketik pesan..." class="w-full p-2 rounded-lg border border-gray-300" required>
        <button type="submit" class="btn btn-primary p-2 rounded-lg">Kirim</button>
    </form>
</div>
@endsection

@section('styles')
<style>
    .chat-container {
        background-color: #f7f7f7;
        border-radius: 10px;
        padding: 20px;
        height: 400px;
        overflow-y: scroll;
    }
    .message {
        margin-bottom: 20px;
    }
    .message-sent {
        text-align: right;
    }
    .message-received {
        text-align: left;
    }
    .message-body {
        padding: 10px;
        border-radius: 8px;
        font-size: 14px;
    }
    .message-sent .message-body {
        background-color: #d1e7dd;
        color: #495057;
    }
    .message-received .message-body {
        background-color: #f1f1f1;
        color: #495057;
    }
    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
@endsection
