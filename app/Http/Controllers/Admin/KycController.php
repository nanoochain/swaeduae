<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use Illuminate\Http\Request;

class KycController extends Controller
{
    public function index()
    {
        $kycs = Kyc::paginate(15);
        return view('admin.kyc.index', compact('kycs'));
    }

    public function show($id)
    {
        $kyc = Kyc::findOrFail($id);
        return view('admin.kyc.show', compact('kyc'));
    }
}
