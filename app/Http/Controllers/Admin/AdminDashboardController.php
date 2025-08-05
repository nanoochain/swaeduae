<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $users = DB::table('users')->count();
        $events = DB::table('events')->count();
        $certs = DB::table('certificates')->count();
        $logs = File::exists(storage_path('logs/laravel.log')) ? implode("\n", array_slice(explode("\n", File::get(storage_path('logs/laravel.log'))), -20)) : 'No logs.';
        return view('admin.dashboard', compact('users', 'events', 'certs', 'logs'));
    }

    // CSV Export for Users
    public function exportUsers()
    {
        $users = DB::table('users')->select('id','name','email','created_at')->get();
        $csv = "ID,Name,Email,Registered\n";
        foreach ($users as $u) {
            $csv .= "{$u->id},\"{$u->name}\",\"{$u->email}\",{$u->created_at}\n";
        }
        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=users.csv'
        ]);
    }

    // CSV Export for Events
    public function exportEvents()
    {
        $events = DB::table('events')->select('id','title','city','date','status')->get();
        $csv = "ID,Title,City,Date,Status\n";
        foreach ($events as $e) {
            $csv .= "{$e->id},\"{$e->title}\",\"{$e->city}\",{$e->date},{$e->status}\n";
        }
        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=events.csv'
        ]);
    }

    // Manual DB backup stub
    public function backup(Request $request)
    {
        // This is a stub - real backup requires CLI/hosting support!
        \Log::info('Admin ran backup on: ' . now());
        return back()->with('success', __('Backup triggered (stub, see hosting tools for real DB backup).'));
    }
}
