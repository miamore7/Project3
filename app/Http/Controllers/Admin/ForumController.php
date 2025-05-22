<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    // Menampilkan semua forum
    public function index()
    {
        $forums = Forum::with('members')->get();
        return view('admin.forums.index', compact('forums'));
    }

    // Menampilkan form untuk membuat forum
    public function create()
    {
        return view('admin.forums.create');
    }

    // Menyimpan forum baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:forums,name',
            'description' => 'nullable',
        ]);

        Forum::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.forums.index')->with('success', 'Forum berhasil dibuat.');
    }

    // Menampilkan form edit
    public function edit(Forum $forum)
    {
        return view('admin.forums.edit', compact('forum'));
    }

    // Menyimpan perubahan forum
    public function update(Request $request, Forum $forum)
    {
        $request->validate([
            'name' => 'required|unique:forums,name,' . $forum->id,
            'description' => 'nullable',
        ]);

        $forum->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.forums.index')->with('success', 'Forum berhasil diperbarui.');
    }

    // Menghapus forum
    public function destroy(Forum $forum)
    {
        $forum->delete();
        return back()->with('success', 'Forum berhasil dihapus.');
    }
}
