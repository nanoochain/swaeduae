@extends('layouts.admin')
@section('title', 'Partners')
@section('content')
<div class="py-8 px-6">
    <h1 class="text-2xl font-bold mb-6 text-blue-900">Partners</h1>
    <a href="{{ route('admin.partners.create') }}" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-green-700">Add Partner</a>
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-b">
                    <th class="px-4 py-2">Logo</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $partner)
                    <tr class="border-b">
                        <td class="px-4 py-2">
                            <img src="{{ asset('storage/partners/'.$partner->logo) }}" class="h-12" alt="{{ $partner->name }}">
                        </td>
                        <td class="px-4 py-2">{{ $partner->name }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.partners.edit', $partner->id) }}" class="text-blue-700 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.partners.destroy', $partner->id) }}" class="inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete this partner?')" class="text-red-700 hover:underline ml-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-gray-400">No partners found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
