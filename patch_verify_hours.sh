#!/bin/bash
set -euo pipefail

echo "==> Writing controllers (clean full content)"

/* CertificateVerifyController */
cat > app/Http/Controllers/CertificateVerifyController.php << 'PHP'
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CertificateVerifyController extends Controller
{
    /**
     * Public: verify a certificate by numeric ID
     * URL: /verify/{id}
     */
    public function verify($id)
    {
        $cert = DB::table('certificates')->where('id', $id)->first();

        if (!$cert) {
            return view('certificates.verify', [
                'found' => false,
                'id'    => $id,
            ]);
        }

        $user  = DB::table('users')->where('id', $cert->user_id)->first();
        $event = DB::table('events')->where('id', $cert->event_id)->first();

        return view('certificates.verify', [
            'found' => true,
            'id'    => $id,
            'cert'  => $cert,
            'user'  => $user,
            'event' => $event,
        ]);
    }
}
PHP

/* VolunteerHoursController */
cat > app/Http/Controllers/VolunteerHoursController.php << 'PHP'
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VolunteerHoursController extends Controller
{
    // GET /volunteer/hours
    public function index()
    {
        $uid    = Auth::id();
        $hours  = DB::table('volunteer_hours')->where('user_id', $uid)->orderByDesc('id')->get();
        $events = DB::table('events')->select('id','title')->orderByDesc('date')->limit(100)->get();

        return view('volunteer.hours', [
            'hours'  => $hours,
            'events' => $events,
        ]);
    }

    // POST /volunteer/hours
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'hours'    => 'required|numeric|min:0.5|max:24',
        ]);

        $uid = Auth::id();

        DB::table('volunteer_hours')->insert([
            'user_id'    => $uid,
            'event_id'   => (int) $request->event_id,
            'hours'      => (float) $request->hours,
            'approved'   => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('volunteer.hours')->with('success', __('Hours submitted and pending approval.'));
    }
}
PHP

/* Admin\VolunteerHoursAdminController */
cat > app/Http/Controllers/Admin/VolunteerHoursAdminController.php << 'PHP'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class VolunteerHoursAdminController extends Controller
{
    // POST /admin/hours/{id}/approve
    public function approve($id)
    {
        $row = DB::table('volunteer_hours')->where('id', $id)->first();
        if (!$row) {
            return back()->with('error', __('Record not found.'));
        }

        $new = ($row->approved ? 0 : 1);
        DB::table('volunteer_hours')->where('id', $id)->update([
            'approved'  => $new,
            'updated_at'=> now(),
        ]);

        return back()->with('success', $new ? __('Approved') : __('Unapproved'));
    }
}
PHP

echo "==> Ensuring volunteer hours view exists"
mkdir -p resources/views/volunteer
if [ ! -f resources/views/volunteer/hours.blade.php ]; then
cat > resources/views/volunteer/hours.blade.php << 'BLADE'
@extends('layouts.app')

@section('content')
  <h1 class="mb-3">{{ __('My Volunteer Hours') }}</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <form method="POST" action="{{ route('volunteer.hours.store') }}" class="mb-4" style="border:1px solid #eaeaea; padding:12px;">
    @csrf
    <div class="mb-2">
      <label for="event_id">{{ __('Event') }}</label>
      <select id="event_id" name="event_id" required class="form-control">
        <option value="">{{ __('Choose...') }}</option>
        @foreach($events as $e)
          <option value="{{ $e->id }}">{{ $e->title }}</option>
        @endforeach
      </select>
      @error('event_id') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-2">
      <label for="hours">{{ __('Hours') }}</label>
      <input type="number" min="0.5" step="0.5" max="24" id="hours" name="hours" required class="form-control" />
      @error('hours') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-primary">{{ __('Submit Hours') }}</button>
  </form>

  <h2 class="mt-4">{{ __('Submitted Hours') }}</h2>
  <table class="table table-striped w-100">
    <thead>
      <tr>
        <th>{{ __('ID') }}</th>
        <th>{{ __('Event') }}</th>
        <th>{{ __('Hours') }}</th>
        <th>{{ __('Status') }}</th>
        <th>{{ __('Date') }}</th>
      </tr>
    </thead>
    <tbody>
      @forelse($hours as $h)
        <tr>
          <td>{{ $h->id }}</td>
          <td>{{ optional(\Illuminate\Support\Facades\DB::table('events')->find($h->event_id))->title }}</td>
          <td>{{ $h->hours }}</td>
          <td>{{ $h->approved ? __('Approved') : __('Pending') }}</td>
          <td>{{ $h->created_at }}</td>
        </tr>
      @empty
        <tr><td colspan="5">{{ __('No hours yet.') }}</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
BLADE
fi

echo "==> Appending routes (using grep -- so patterns never parse as options)"
append_if_missing () {
  local pattern="$1"
  local line="$2"
  if ! grep -qF -- "$pattern" routes/web.php; then
    echo "$line" >> routes/web.php
    echo "  + added: $pattern"
  else
    echo "  = exists: $pattern"
  fi
}

append_if_missing "->name('cert.verify')" \
"Route::get('/verify/{id}', [\\App\\Http\\Controllers\\CertificateVerifyController::class, 'verify'])->name('cert.verify');"

append_if_missing "->name('volunteer.hours')" \
"Route::middleware(['web','auth'])->get('/volunteer/hours', [\\App\\Http\\Controllers\\VolunteerHoursController::class, 'index'])->name('volunteer.hours');"

append_if_missing "->name('volunteer.hours.store')" \
"Route::middleware(['web','auth'])->post('/volunteer/hours', [\\App\\Http\\Controllers\\VolunteerHoursController::class, 'store'])->name('volunteer.hours.store');"

append_if_missing "admin.hours.approve" \
"Route::middleware(['web','auth','admin'])->post('/admin/hours/{id}/approve', [\\App\\Http\\Controllers\\Admin\\VolunteerHoursAdminController::class, 'approve'])->name('admin.hours.approve');"

echo "==> Clearing caches"
php artisan route:clear || true
php artisan config:clear || true
php artisan view:clear || true
php artisan optimize || true

echo "==> Routes we just added:"
php artisan route:list --name=cert.verify --name=volunteer.hours --name=volunteer.hours.store --name=admin.hours.approve | sed -n '1,160p'
