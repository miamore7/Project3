<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect users after login based on their role.
     */
    protected function redirectTo()
    {
        if (Auth::user()->role == 'admin') {
            return '/admin/dashboard';
        }
        return '/user/dashboard';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
