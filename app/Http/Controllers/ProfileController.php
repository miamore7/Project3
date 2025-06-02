<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    // Menampilkan Profil
    public function show()
    {
        return view('profile.show', ['user' => Auth::user()]);
    }

    // Menampilkan Form Edit Profil
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    // Update Profil
public function update(Request $request)
{
    $user = auth()->user();
    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'password' => 'nullable|confirmed|min:8',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    if ($request->password) {
        $user->password = bcrypt($request->password);
    }
    $user->save();

    return redirect()->back()->with('profile.updated', true);
}

}
