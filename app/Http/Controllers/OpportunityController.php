<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opportunity;

class OpportunityController extends Controller
{
    public function index()
    {
        $opportunities = Opportunity::paginate(10);
        return view('opportunities.index', compact('opportunities'));
    }
}
