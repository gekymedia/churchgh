@extends('layouts.app')
@section('title','Edit Event')
@section('content')
<h3>Edit Event</h3>
<form method="POST" action="{{ route('events.update') }}" class="row g-3">
  @csrf @method('PUT')
  <div class="col-md-6">
    <label class="form-label">Title</label>
    <input name="title" class="form-control" value="{{ old('title',$event->title) }}" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Starts At</label>
    <input name="starts_at" type="datetime-local" class="form-control" value="{{ old('starts_at',$event->starts_at->format('Y-m-d\TH:i')) }}" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Ends At</label>
    <input name="ends_at" type="datetime-local" class="form-control" value="{{ old('ends_at', optional($event->ends_at)->format('Y-m-d\TH:i')) }}">
  </div>
  <div class="col-md-6">
    <label class="form-label">Location</label>
    <input name="location" class="form-control" value="{{ old('location',$event->location) }}">
  </div>
  <div class="col-12">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description',$event->description) }}</textarea>
  </div>
  <div class="col-12"><button class="btn btn-primary">Save</button></div>
</form>
@endsection
