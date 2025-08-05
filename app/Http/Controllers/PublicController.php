<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $opps = Opportunity::orderBy('start_date', 'asc')->limit(4)->get();
        return view('public.home', compact('opps'));
    }

    public function about()    { return view('public.about'); }
    public function contact()  { return view('public.contact'); }
    public function faq()      { return view('public.faq'); }
    public function partners() { return view('public.partners'); }
    public function stories()  { return view('public.stories'); }
}
