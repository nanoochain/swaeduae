{{-- Place this snippet inside your navbar links in layouts/app.blade.php --}}
@auth
    <a href="{{ route('volunteer.profile') }}" class="inline-block px-4 py-2 rounded-lg bg-teal-100 text-teal-700 hover:bg-teal-200 font-semibold ml-2">
        <i class="fas fa-user-circle"></i> ملفي
    </a>
@endauth
