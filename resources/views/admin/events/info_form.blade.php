@extends('layouts.app')
@section('title', 'Edit Event Info Request')
@section('content')
<h1>Edit Info Request Form for {{ $event->title }}</h1>
@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif
<form method="POST" action="{{ route('admin.events.info_form.update', $event) }}">
    @csrf
    @method('PUT')
    <div id="fields-container">
        @if($infoRequest->form_fields)
            @foreach($infoRequest->form_fields as $i => $field)
            <div class="field-group">
                <label>Label: <input type="text" name="form_fields[{{ $i }}][label]" value="{{ $field['label'] }}" required></label>
                <label>Name: <input type="text" name="form_fields[{{ $i }}][name]" value="{{ $field['name'] }}" required></label>
                <label>Type: <input type="text" name="form_fields[{{ $i }}][type]" value="{{ $field['type'] }}" required></label>
                <label>Required: <input type="checkbox" name="form_fields[{{ $i }}][required]" value="1" {{ $field['required'] ? 'checked' : '' }}></label>
                <button type="button" onclick="removeField(this)">Remove</button>
            </div>
            @endforeach
        @endif
    </div>
    <button type="button" onclick="addField()">Add Field</button><br/><br/>
    <button type="submit">Save Form</button>
</form>

<script>
function addField() {
    const container = document.getElementById('fields-container');
    const index = container.children.length;
    const div = document.createElement('div');
    div.className = 'field-group';
    div.innerHTML = `
        <label>Label: <input type="text" name="form_fields[${index}][label]" required></label>
        <label>Name: <input type="text" name="form_fields[${index}][name]" required></label>
        <label>Type: <input type="text" name="form_fields[${index}][type]" required></label>
        <label>Required: <input type="checkbox" name="form_fields[${index}][required]" value="1"></label>
        <button type="button" onclick="removeField(this)">Remove</button>
    `;
    container.appendChild(div);
}
function removeField(button) {
    button.parentElement.remove();
}
</script>
@endsection
