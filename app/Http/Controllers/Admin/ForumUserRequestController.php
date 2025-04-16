<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumUserRequest;
use App\Models\Forum;
use Illuminate\Http\Request;

class ForumUserRequestController extends Controller
{
    public function index()
    {
        $requests = ForumUserRequest::with('forum', 'user')->where('status', 'pending')->get();
        return view('admin.forums.requests', compact('requests'));
    }

    public function approve($id)
    {
        $request = ForumUserRequest::findOrFail($id);
        $request->update(['status' => 'approved']);
        $request->forum->members()->attach($request->user_id);
        return back()->with('success', 'User approved.');
    }

    public function reject($id)
    {
        $request = ForumUserRequest::findOrFail($id);
        $request->update(['status' => 'rejected']);
        return back()->with('success', 'User rejected.');
    }

    public function kick(Forum $forum, $userId)
    {
        $forum->members()->detach($userId);
        return back()->with('success', 'User kicked from forum.');
    }
}
