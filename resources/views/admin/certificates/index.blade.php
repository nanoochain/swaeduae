@extends('layouts.admin_theme')

@section('content')
<h1>Certificates</h1>

<a href="{{ route('admin.certificates.create') }}" class="btn btn-primary">Add Certificate</a>

<table class="table-auto w-full mt-4">
    <thead>
        <tr>
            <th>ID</th><th>Title</th><th>User</th><th>Issue Date</th><th>Status</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($certificates as $certificate)
        <tr>
            <td>{{ $certificate->id }}</td>
            <td>{{ $certificate->title }}</td>
            <td>{{ $certificate->user->name ?? '' }}</td>
            <td>{{ $certificate->issue_date }}</td>
            <td>{{ $certificate->status }}</td>
            <td>
                <a href="{{ route('admin.certificates.edit', $certificate->id) }}" class="text-blue-600">Edit</a> |
                <form action="{{ route('admin.certificates.destroy', $certificate->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete certificate?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 underline">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $certificates->links() }}

@endsection
