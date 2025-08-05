@extends('layouts.admin')
@section('title', 'Edit Certificate')
@section('content')
<div class="py-8 px-6">
    <h1 class="text-2xl font-bold mb-4 text-blue-800">Edit Certificate</h1>
    <form method="POST" action="{{ route('admin.certificates.update', $certificate->id) }}" class="bg-white p-6 rounded shadow max-w-xl">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="font-bold">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="issued" @if($certificate->status == 'issued') selected @endif>Issued</option>
                <option value="pending" @if($certificate->status == 'pending') selected @endif>Pending</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="font-bold">Volunteer</label>
            <select name="user_id" class="w-full border rounded px-3 py-2">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @if($certificate->user_id == $user->id) selected @endif>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="font-bold">Event</label>
            <select name="event_id" class="w-full border rounded px-3 py-2">
                @foreach($events as $event)
                    <option value="{{ $event->id }}" @if($certificate->event_id == $event->id) selected @endif>{{ $event->title }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded font-bold hover:bg-blue-900">Update Certificate</button>
    </form>
</div>
@endsection
