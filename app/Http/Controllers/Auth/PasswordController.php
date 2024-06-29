<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    //
    public function showLinkRequestForm()
    {
        return view('pages.auth.passwords.reset');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );
        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => 'success',
                'message' => __('passwords.sent')
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => __('passwords.user')
            ]);
        }
    }
}
