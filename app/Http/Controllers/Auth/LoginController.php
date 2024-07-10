<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (session()->has('auth_state')) {
            session()->forget('auth_state');
        }
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            // Get intended URL
            $url = $request->session()->get('url.intended', route('home.index'));
            // Update last login
            auth()->user()->update(['last_login_at' => now()]);
            return response()->json([
                'status' => 'success',
                'message' => __('auth.login_success'),
                'redirect' => $url
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => __('auth.failed')
        ], 401);
    }

    public function redirectToProvider($provider, Request $request)
    {
        if ($request->has('auth_state')) {
            session()->put('auth_state', $request->auth_state);
        }
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            $pro_id = $provider . '_id';
            $authUser = User::where('email', $user->email)
                ->orWhere($pro_id, $user->id)
                ->first();
            if (session()->has('auth_state') && session('auth_state') == 'register') {
                session()->forget('auth_state');
                if ($authUser) {
                    return redirect()->route('auth.login')->with('error', __('auth.exists'));
                } else {
                    $randomPass = Str::random(16);
                    $authUser = User::create([
                        'avatar' => $user->avatar,
                        'username' => md5('' . $user->email . time()),
                        'email' => $user->email,
                        'email_verified_at' => now(),
                        'password' => bcrypt($randomPass),
                        'last_login_at' => now(),
                        $pro_id => $user->id
                    ]);
                    auth()->login($authUser);
                    return redirect()->route('home.index');
                }
            } else {
                if ($authUser) {
                    auth()->login($authUser);
                    // Update last login
                    $authUser->update(['last_login_at' => now()]);
                    return redirect()->route('home.index');
                } else {
                    return redirect()->route('auth.login')->with('error', __('auth.failed'));
                }
            }
        } catch (\Throwable $th) {
            return redirect()->route('auth.login')->with('error', __('auth.failed'));
        }
    }
}
