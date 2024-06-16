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

    public function translation()
    {
        try {
            $script = __('admin');
            $json = json_encode($script);
            $js = 'var translation = ' . $json . ';';
            $file = public_path('assets/js/custom/translation.js');
            file_put_contents($file, $js);
            return response()->file($file, ['Content-Type' => 'text/javascript']);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function fastLogin()
    {
        $user = User::where('username', 'superadmin')->first();
        auth()->login($user);
        return redirect()->route('admin.home');
    }
}
