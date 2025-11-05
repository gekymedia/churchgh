@extends('layouts.app')
@section('title','Edit Service')
@section('content')
<h3>Edit Service</h3>
<form method="POST" action="{{ route('services.update') }}" class="row g-3">
  @csrf @method('PUT')
  <div class="col-md-6">
    <label class="form-label">Name</label>
    <input name="name" class="form-control" value="{{ old('name',$service->name) }}" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Starts At</label>
    <input name="starts_at" type="datetime-local" class="form-control" value="{{ old('starts_at',$service->starts_at->format('Y-m-d\TH:i')) }}" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Location</label>
    <input name="location" class="form-control" value="{{ old('location',$service->location) }}">
  </div>
  <div class="col-12">
    <label class="form-label">Notes</label>
    <input name="notes" class="form-control" value="{{ old('notes',$service->notes) }}">
  </div>
  <div class="col-12"><button class="btn btn-primary">Save</button></div>
</form>
@endsection
