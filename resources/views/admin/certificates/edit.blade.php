@extends('layouts.admin_theme')

@section('content')
<h1>Edit Certificate</h1>

<form method="POST" action="{{ route('admin.certificates.update', $certificate->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Title:</label>
    <input type="text" name="title" value="{{ old('title', $certificate->title) }}" required>

    <label>Description:</label>
    <textarea name="description">{{ old('description', $certificate->description) }}</textarea>

    <label>Issue Date:</label>
    <input type="date" name="issue_date" value="{{ old('issue_date', $certificate->issue_date) }}" required>

    <label>Hours:</label>
    <input type="number" name="hours" value="{{ old('hours', $certificate->hours) }}">

    <label>PDF File:</label>
    <input type="file" name="pdf" accept="application/pdf">

    <label>Status:</label>
    <select name="status" required>
        <option value="pending" {{ $certificate->status == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="approved" {{ $certificate->status == 'approved' ? 'selected' : '' }}>Approved</option>
        <option value="rejected" {{ $certificate->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
    </select>

    <button type="submit">Update Certificate</button>
</form>
@endsection
