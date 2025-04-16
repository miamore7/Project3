<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use App\Models\ForumUserRequest;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index()
    {
        $forums = Forum::all();
        return view('user.forums.index', compact('forums'));
    }

    public function requestJoin($forumId)
    {
        $alreadyRequested = ForumUserRequest::where('forum_id', $forumId)->where('user_id', Auth::id())->exists();
        if (!$alreadyRequested) {
            ForumUserRequest::create([
                'forum_id' => $forumId,
                'user_id' => Auth::id(),
            ]);
        }
        return back()->with('success', 'Join request sent.');
    }

    // Menampilkan forum yang diterima oleh user
    public function myForums()
    {
        // Ambil semua forum yang diterima oleh user
        $forums = Forum::whereHas('members', function($query) {
            $query->where('user_id', Auth::id());
        })->get();

        return view('user.forums.myforums', compact('forums'));
    }
}
