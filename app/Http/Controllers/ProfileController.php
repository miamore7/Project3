<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Flash message ke session dengan key 'status'
        return redirect()->back()->with('status', 'profile.updated');
    }
}
