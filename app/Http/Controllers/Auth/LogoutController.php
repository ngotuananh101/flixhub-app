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
        // Log activity
        $loginSession = session()->get('current_session');
        if ($loginSession) {
            $loginSession->status = 'logged_out';
            $loginSession->save();
        }
        // Logout
        auth()->logout();
        return redirect()->route('auth.login');
    }
}
