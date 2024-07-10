<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|unique:users,username',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:8',
                'toc' => 'required|accepted',
            ]);

            $user = new User();
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->last_login_at = now();
            $user->save();
            auth()->login($user);
            event(new Registered($user));
            return response()->json([
                'status' => 'success',
                'message' => __('auth.register_success'),
                'redirect' => route('home.index')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('auth.general_error'),
                'dev_message' => $e->getMessage()
            ], 200);
        }
    }
}
