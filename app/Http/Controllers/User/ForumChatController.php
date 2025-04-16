<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use App\Models\ForumMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumChatController extends Controller
{
    public function show($forumId)
    {
        $forum = Forum::with('messages.user')->findOrFail($forumId);

        // cek apakah user sudah join forum
        if (!$forum->members->contains(Auth::id())) {
            abort(403, 'You are not a member of this forum.');
        }

        return view('user.forums.chat', compact('forum'));
    }

    public function sendMessage(Request $request, $forumId)
    {
        $request->validate(['message' => 'required']);
        $forum = Forum::findOrFail($forumId);

        if (!$forum->members->contains(Auth::id())) {
            abort(403);
        }

        ForumMessage::create([
            'forum_id' => $forumId,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return back();
    }
    public function chat($forumId)
{
    $user = Auth::user();
    $activeForum = Forum::with('messages.user')->findOrFail($forumId);
    $messages = $activeForum->messages;

    return view('user.forums.chat', compact('activeForum', 'messages'));
}



}
