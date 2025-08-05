@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">👤 تعديل الملف الشخصي</h1>
    <form method="POST" action="{{ route('volunteer.profile.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label>الاسم</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control">
        </div>
        <div class="mb-4">
            <label>رقم الهاتف</label>
            <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="form-control">
        </div>
        <div class="mb-4">
            <label>الصورة الشخصية</label>
            <input type="file" name="avatar" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">حفظ</button>
    </form>

    <h2 class="mt-6 text-xl font-semibold">📆 ساعات التطوع</h2>
    <table class="table mt-3">
        <thead><tr><th>الفعالية</th><th>الساعات</th><th>التاريخ</th></tr></thead>
        <tbody>
        @foreach($hours as $entry)
            <tr>
                <td>{{ $entry->event_name }}</td>
                <td>{{ $entry->hours }}</td>
                <td>{{ $entry->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
