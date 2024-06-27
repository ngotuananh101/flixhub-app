<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.admin.home.index');
    }

    public function fastLogin()
    {
        $user = User::where('username', 'superadmin')->first();
        auth()->login($user);
        return redirect()->route('admin.home');
    }
}
