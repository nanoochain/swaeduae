@extends('layouts.app')
@section('content')
<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4">Opportunities</h1>
    <a class="btn btn-primary" href="{{ route('admin.opportunities.create') }}">New</a>
  </div>

  @if(session('status')) <div class="alert alert-success">{{ session('status') }}</div> @endif

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead><tr>
        <th>Title</th><th>Region</th><th>Category</th><th>Date</th><th>Status</th><th></th>
      </tr></thead>
      <tbody>
        @forelse($items as $it)
          <tr>
            <td>{{ $it->title }}</td>
            <td>{{ $it->region }}</td>
            <td>{{ $it->category }}</td>
            <td>{{ optional($it->date)->format('Y-m-d') }}</td>
            <td><span class="badge bg-secondary">{{ $it->status }}</span></td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.opportunities.edit',$it) }}">Edit</a>
              <form method="POST" action="{{ route('admin.opportunities.destroy',$it) }}" style="display:inline">@csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-muted">No items.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-2">{{ $items->links() }}</div>
</div>
@endsection
