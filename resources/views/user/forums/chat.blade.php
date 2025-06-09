@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md border-r hidden md:block h-screen sticky top-0">
        <div class="p-6">
            <h2 class="text-xl font-bold mb-6 text-cyan-600">Menu</h2>
            <ul class="space-y-4">
                <li><a href="{{ route('user.dashboard') }}" class="text-gray-700 hover:text-cyan-600 no-underline">🏠 Dashboard</a></li>
                <li><a href="{{ route('user.forums.myforums') }}" class="text-gray-700 hover:text-cyan-600 no-underline">💬 Forum Saya</a></li>
                <li><a href="{{ route('user.forums.index') }}" class="text-gray-700 hover:text-cyan-600 no-underline">📚 Daftar Forum</a></li>
                <li><a href="{{ route('user.courses.index') }}" class="text-gray-700 hover:text-cyan-600 no-underline">🎓 Daftar Course</a></li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-center text-cyan-700">💬 Forum: {{ $forum->name }}</h2>

            <!-- Chat Messages -->
            <div id="chat-box" class="bg-white border rounded-lg shadow-sm p-4 mb-6 h-96 overflow-y-auto space-y-4">
                @forelse($forum->messages as $msg)
                    <div class="flex flex-col {{ $msg->user_id == auth()->id() ? 'items-end' : 'items-start' }}">
                        <div class="text-sm font-semibold text-gray-700">{{ $msg->user->name }}</div>
                        <div class="max-w-xs p-3 rounded-lg {{ $msg->user_id == auth()->id() ? 'bg-blue-100 text-right' : 'bg-gray-100 text-left' }}">
                            <p class="text-sm text-gray-800">{{ $msg->message }}</p>
                            <span class="text-xs text-gray-500 block mt-1">{{ $msg->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Belum ada pesan.</p>
                @endforelse
            </div>

            <!-- Chat Form -->
            <form action="{{ route('user.forums.chat.send', $forum->id) }}" method="POST" class="flex items-center gap-2">
                @csrf
                <input type="text" name="message" placeholder="Ketik pesan..." required
                       class="flex-1 p-2 border rounded-lg focus:outline-none focus:ring focus:border-cyan-500" />
                <button type="submit"
                        class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded-lg transition">
                    Kirim
                </button>
            </form>
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    });
</script>
@endsection
