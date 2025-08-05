<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function index()
    {
        $opps = Opportunity::latest()->paginate(10);
        return view('opportunities.index', compact('opps'));
    }
}
