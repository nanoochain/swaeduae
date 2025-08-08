<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class OpportunityController extends Controller
{
    public function index(Request $request)
    {
        $items = Opportunity::latest('date')->paginate(20)->appends($request->query());
        return view('admin.opportunities.index', compact('items'));
    }

    public function create()
    {
        return view('admin.opportunities.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        if ($request->hasFile('poster')) {
            $data['poster_path'] = $request->file('poster')->store('opportunities','public');
        }
        Opportunity::create($data);
        return redirect()->route('admin.opportunities.index')->with('status','Created');
    }

    public function edit(Opportunity $opportunity)
    {
        return view('admin.opportunities.edit', ['item'=>$opportunity]);
    }

    public function update(Request $request, Opportunity $opportunity)
    {
        $data = $this->validated($request);
        if ($request->hasFile('poster')) {
            if ($opportunity->poster_path) Storage::disk('public')->delete($opportunity->poster_path);
            $data['poster_path'] = $request->file('poster')->store('opportunities','public');
        }
        $opportunity->update($data);
        return redirect()->route('admin.opportunities.index')->with('status','Updated');
    }

    public function destroy(Opportunity $opportunity)
    {
        if ($opportunity->poster_path) Storage::disk('public')->delete($opportunity->poster_path);
        $opportunity->delete();
        return back()->with('status','Deleted');
    }

    private function validated(Request $r): array
    {
        return $r->validate([
            'title' => ['required','string','max:255'],
            'summary' => ['nullable','string'],
            'location' => ['nullable','string','max:255'],
            'region' => ['nullable','string','max:255'],
            'category' => ['nullable','string','max:255'],
            'date' => ['nullable','date'],
            'application_deadline' => ['nullable','date'],
            'start_time' => ['nullable','date_format:H:i'],
            'end_time' => ['nullable','date_format:H:i'],
            'slots' => ['nullable','integer','min:0'],
            'requirements' => ['nullable','string'],
            'status' => ['required', Rule::in(['open','closed','archived'])],
            'poster' => ['nullable','image','max:2048'],
        ]);
    }
}
