<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Title</label>
    <input class="form-control" name="title" value="{{ old('title', $event->title ?? '') }}" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Date</label>
    <input type="date" class="form-control" name="date" value="{{ old('date', isset($event) ? $event->date->toDateString() : '') }}" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Location</label>
    <input class="form-control" name="location" value="{{ old('location', $event->location ?? '') }}">
  </div>
  <div class="col-12">
    <label class="form-label">Description</label>
    <textarea rows="6" class="form-control" name="description">{{ old('description', $event->description ?? '') }}</textarea>
  </div>
  <div class="col-md-4">
    <label class="form-label">Hours</label>
    <input type="number" step="0.25" class="form-control" name="hours" value="{{ old('hours', $event->hours ?? '') }}">
  </div>
  <div class="col-12">
    <button class="btn btn-dark">{{ $button }}</button>
  </div>
</div>
