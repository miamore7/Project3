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
        $user = Auth::user();

        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Update Data
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
