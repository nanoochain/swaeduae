<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function index(Request $request)
    {
        $q      = $request->string('q')->toString();
        $region = $request->string('region')->toString();
        $cat    = $request->string('category')->toString();
        $from   = $request->date('from');
        $to     = $request->date('to');
        $status = $request->string('status')->toString();

        $opportunities = Opportunity::query()
            ->when($q, fn($qq) =>
                $qq->where(function($w) use ($q){
                    $w->where('title','like',"%$q%")
                      ->orWhere('summary','like',"%$q%")
                      ->orWhere('location','like',"%$q%");
                })
            )
            ->when($region, fn($qq) => $qq->where('region',$region))
            ->when($cat, fn($qq) => $qq->where('category',$cat))
            ->when($status, fn($qq) => $qq->where('status',$status))
            ->when($from, fn($qq) => $qq->whereDate('date','>=',$from))
            ->when($to, fn($qq) => $qq->whereDate('date','<=',$to))
            ->latest('date')
            ->paginate(12)
            ->appends($request->query());

        // distincts for filter dropdowns
        $regions = Opportunity::whereNotNull('region')->distinct()->pluck('region')->sort()->values();
        $categories = Opportunity::whereNotNull('category')->distinct()->pluck('category')->sort()->values();

        return view('opportunities.index', compact('opportunities','regions','categories'));
    }

    public function show(Opportunity $opportunity)
    {
        return view('opportunities.show', compact('opportunity'));
    }
}
