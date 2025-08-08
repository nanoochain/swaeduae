@extends('layouts.admin_theme')

@section('content')
<h1>Add Certificate</h1>

<form method="POST" action="{{ route('admin.certificates.store') }}" enctype="multipart/form-data">
    @csrf
    <label>User ID:</label>
    <input type="number" name="user_id" required>

    <label>Title:</label>
    <input type="text" name="title" required>

    <label>Description:</label>
    <textarea name="description"></textarea>

    <label>Issue Date:</label>
    <input type="date" name="issue_date" required>

    <label>Hours:</label>
    <input type="number" name="hours">

    <label>PDF File:</label>
    <input type="file" name="pdf" accept="application/pdf">

    <label>Status:</label>
    <select name="status" required>
        <option value="pending">Pending</option>
        <option value="approved">Approved</option>
        <option value="rejected">Rejected</option>
    </select>

    <button type="submit">Add Certificate</button>
</form>
@endsection
