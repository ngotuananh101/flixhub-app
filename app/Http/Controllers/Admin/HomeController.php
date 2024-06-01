<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

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
}
