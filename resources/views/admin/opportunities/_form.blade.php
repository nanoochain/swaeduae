@csrf
<div class="row g-3">
  <div class="col-md-8">
    <label class="form-label">Title</label>
    <input name="title" class="form-control" value="{{ old('title', $item->title ?? '') }}" required>
  </div>
  <div class="col-md-4">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      @foreach(['open','closed','archived'] as $s)
        <option @selected(old('status', $item->status ?? 'open')===$s)>{{ $s }}</option>
      @endforeach
    </select>
  </div>

  <div class="col-md-6">
    <label class="form-label">Region</label>
    <input name="region" class="form-control" value="{{ old('region', $item->region ?? '') }}">
  </div>
  <div class="col-md-6">
    <label class="form-label">Category</label>
    <input name="category" class="form-control" value="{{ old('category', $item->category ?? '') }}">
  </div>

  <div class="col-md-4">
    <label class="form-label">Date</label>
    <input type="date" name="date" class="form-control" value="{{ old('date', optional($item->date ?? null)->format('Y-m-d')) }}">
  </div>
  <div class="col-md-4">
    <label class="form-label">Application deadline</label>
    <input type="date" name="application_deadline" class="form-control" value="{{ old('application_deadline', optional($item->application_deadline ?? null)->format('Y-m-d')) }}">
  </div>
  <div class="col-md-2">
    <label class="form-label">Start</label>
    <input type="time" name="start_time" class="form-control" value="{{ old('start_time', $item->start_time ?? '') }}">
  </div>
  <div class="col-md-2">
    <label class="form-label">End</label>
    <input type="time" name="end_time" class="form-control" value="{{ old('end_time', $item->end_time ?? '') }}">
  </div>

  <div class="col-md-12">
    <label class="form-label">Location</label>
    <input name="location" class="form-control" value="{{ old('location', $item->location ?? '') }}">
  </div>

  <div class="col-md-12">
    <label class="form-label">Summary</label>
    <textarea name="summary" class="form-control" rows="3">{{ old('summary', $item->summary ?? '') }}</textarea>
  </div>

  <div class="col-md-12">
    <label class="form-label">Requirements</label>
    <textarea name="requirements" class="form-control" rows="3">{{ old('requirements', $item->requirements ?? '') }}</textarea>
  </div>

  <div class="col-md-3">
    <label class="form-label">Slots</label>
    <input type="number" name="slots" class="form-control" min="0" value="{{ old('slots', $item->slots ?? 0) }}">
  </div>

  <div class="col-md-9">
    <label class="form-label">Poster (image)</label>
    <input type="file" name="poster" class="form-control">
    @if(!empty($item->poster_path))
      <img src="{{ asset('storage/'.$item->poster_path) }}" class="mt-2 rounded" style="max-height:120px">
    @endif
  </div>
</div>

<div class="mt-3">
  <button class="btn btn-primary">Save</button>
  <a class="btn btn-light" href="{{ route('admin.opportunities.index') }}">Cancel</a>
</div>
