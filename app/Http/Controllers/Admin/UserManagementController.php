<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
	public function index()
	{
		// Get all emails with a pending reset request
		$resetEmails = DB::table('password_resets')->pluck('email');
		// Get users whose email is in the reset requests
		$users = User::whereIn('email', $resetEmails)->get();
		return view('admin.user-management.index', compact('users'));
	}

	public function resetPasswordToDefault($id)
	{
		$user = User::findOrFail($id);
		$user->password = Hash::make('password123'); // Set your default password here
		$user->save();

		return back()->with('status', 'Password has been reset to default.');
	}
}
