<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            // Get intended URL
            $url = $request->session()->get('url.intended', route('home'));
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

    public function redirectToProvider($provider)
    {
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
            if ($authUser) {
                auth()->login($authUser);
                return redirect()->route('home');
            } else {
                return redirect()->route('auth.login')->with('error', __('auth.failed'));
            }
        } catch (\Throwable $th) {
            return redirect()->route('auth.login')->with('error', __('auth.failed'));
        }
    }
}
