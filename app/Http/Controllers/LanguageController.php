<?php
namespace App\Http\Controllers;

class LanguageController extends Controller
{
    public function switch($lang)
    {
        if (in_array($lang, ['en', 'ar'])) {
            session(['locale' => $lang]);
        }
        return back();
    }
}
