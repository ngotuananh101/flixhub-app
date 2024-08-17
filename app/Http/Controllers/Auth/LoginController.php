<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginSessions;
use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Displays the login form for the application.
     *
     * @return View
     */
    public function showLoginForm()
    {
        if (session()->has('auth_state')) {
            session()->forget('auth_state');
        }
        return view('pages.auth.login');
    }

    /**
     * Handles the login request.
     *
     * @param Request $request The HTTP request.
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $currentIp = $request->getClientIp();
        $browserName = Browser::browserName();
        $platformName = Browser::platformName();
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            // Get intended URL
            $url = $request->session()->get('url.intended', route('home.index'));
            // Update last login
            auth()->user()->update(['last_login_at' => now()]);
            $this->logSession(auth()->user(), $currentIp, $browserName, $platformName);
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

    /**
     * Redirects the user to the specified provider for authentication.
     *
     * @param string $provider The name of the provider.
     * @param Request $request The HTTP request.
     * @return RedirectResponse The redirect response.
     */
    public function redirectToProvider(string $provider, Request $request)
    {
        if ($request->has('auth_state')) {
            session()->put('auth_state', $request->auth_state);
        }
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handles the callback from a social media provider.
     *
     * @param string $provider The name of the social media provider.
     * @param Request $request The HTTP request.
     * @return RedirectResponse
     */
    public function handleProviderCallback(string $provider, Request $request)
    {
        $currentIp = $request->getClientIp();
        $browserName = Browser::browserName();
        $platformName = Browser::platformName();
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
                    // Update last login
                    $authUser->update(['last_login_at' => now()]);
                    $this->logSession($authUser, $currentIp, $browserName, $platformName);
                    return redirect()->route('home.index');
                }
            } else {
                if ($authUser) {
                    auth()->login($authUser);
                    // Update last login
                    $authUser->update(['last_login_at' => now()]);
                    $this->logSession($authUser, $currentIp, $browserName, $platformName);
                    return redirect()->route('home.index');
                } else {
                    return redirect()->route('auth.login')->with('error', __('auth.failed'));
                }
            }
        } catch (\Throwable $th) {
            return redirect()->route('auth.login')->with('error', __('auth.failed'));
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param $authUser
     * @param string|null $currentIp
     * @param $browserName
     * @param $platformName
     * @return void
     */
    public function logSession($authUser, ?string $currentIp, $browserName, $platformName): void
    {
        $loginSession = new LoginSessions();
        $loginSession->user_id = $authUser->id;
        $loginSession->ip = $currentIp;
        $loginSession->browser = $browserName;
        $loginSession->platform = $platformName;
        $loginSession->status = 'logged_in';
        $loginSession->save();
        session()->put('current_session', $loginSession);
    }
}
