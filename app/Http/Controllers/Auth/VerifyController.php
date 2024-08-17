<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function showEmailVerificationForm()
    {
        return view('pages.auth.verify.email');
    }

    public function sendVerificationEmail(Request $request)
    {
        try {
            $request->user()->sendEmailVerificationNotification();
            return response()->json([
                'status' => 'success',
                'message' => __('auth.verification_email_sent')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('auth.general_error'),
                'dev_message' => $e->getMessage()
            ]);
        }
    }

    public function emailVerify(Request $request, $id, $hash)
    {
        try {
            // auth check
            if (!auth()->check()) {
                $user = User::findOrFail($id);
            } else {
                $user = auth()->user();
            }
            if (!$user->hasVerifiedEmail()) {
                // log activity
                activity()->causedBy($user)->log('Email verified');
                $user->markEmailAsVerified();
            }
            return redirect()->route('home.index');
        } catch (\Exception $e) {
            abort(403);
        }
    }
}
