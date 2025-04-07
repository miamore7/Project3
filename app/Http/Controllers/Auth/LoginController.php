<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Tangani redirect setelah login, kirim data juga ke view
    protected function authenticated($request, $user)
    {
        if ($user->role == 'admin') {
            $course = Course::latest()->take(5)->get();
            return view('admin.dashboard', compact('course'));
        }

        // Untuk user biasa
        return view('user.dashboard', ['user' => $user]);
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
