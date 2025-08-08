<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $upcoming = Event::whereDate('date', '>=', now()->toDateString())
            ->orderBy('date')->take(6)->get();

        $latest = Event::orderBy('created_at','desc')->take(6)->get();

        return view('home', compact('upcoming','latest'));
    }

    public function about()    { return view('pages.about'); }
    public function contact()  { return view('pages.contact'); }
    public function faq()      { return view('pages.faq'); }
    public function platform() { return view('pages.platform'); }

    public function setLocale($locale)
    {
        if (!in_array($locale, ['ar','en'])) $locale = 'ar';
        Session::put('locale', $locale);
        return back();
    }
}
