<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LangController extends Controller
{
    public function switch($lang)
    {
        if (!in_array($lang, ['en', 'ar'])) {
            $lang = 'en';
        }
        session(['locale' => $lang]);
        app()->setLocale($lang);
        return redirect()->back();
    }
}
