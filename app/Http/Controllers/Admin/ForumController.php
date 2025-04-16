<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index()
    {
        $forums = Forum::with('members')->get();
        return view('admin.forums.index', compact('forums'));
    }

    public function create()
    {
        return view('admin.forums.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Forum::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);
        return redirect()->route('admin.forums.index')->with('success', 'Forum created.');
    }

    public function destroy(Forum $forum)
    {
        $forum->delete();
        return back()->with('success', 'Forum deleted.');
    }
}
