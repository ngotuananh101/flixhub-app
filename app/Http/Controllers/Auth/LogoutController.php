<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('auth.login');
    }
}
