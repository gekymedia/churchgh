@extends('layouts.app')
@section('title','Create Event')
@section('content')
<h3>Create Event</h3>
<form method="POST" action="{{ route('events.store') }}" class="row g-3">
  @csrf
  <div class="col-md-6">
    <label class="form-label">Title</label>
    <input name="title" class="form-control" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Starts At</label>
    <input name="starts_at" type="datetime-local" class="form-control" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Ends At</label>
    <input name="ends_at" type="datetime-local" class="form-control">
  </div>
  <div class="col-md-6">
    <label class="form-label">Location</label>
    <input name="location" class="form-control">
  </div>
  <div class="col-12">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3"></textarea>
  </div>
  <div class="col-12"><button class="btn btn-primary">Save</button></div>
</form>
@endsection
