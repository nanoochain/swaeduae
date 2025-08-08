{{-- ... your table ... --}}
    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600">Edit</a>
    <form method="POST" action="{{ route('admin.users.toggle', $user) }}" style="display:inline;">
        @csrf
        <button class="text-yellow-600" onclick="return confirm('Toggle status?')">Toggle</button>
    </form>
    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline;">
        @csrf
        @method('DELETE')
        <button class="text-red-600" onclick="return confirm('Delete user?')">Delete</button>
    </form>
{{-- ... rest of your table ... --}}
