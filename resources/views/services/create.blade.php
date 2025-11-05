@extends('layouts.app')
@section('title','Create Service')
@section('content')
<h3>Create Service</h3>
<form method="POST" action="{{ route('services.store') }}" class="row g-3">
  @csrf
  <div class="col-md-6">
    <label class="form-label">Name</label>
    <input name="name" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Starts At</label>
    <input name="starts_at" type="datetime-local" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Location</label>
    <input name="location" class="form-control">
  </div>
  <div class="col-12">
    <label class="form-label">Notes</label>
    <input name="notes" class="form-control">
  </div>
  <div class="col-12"><button class="btn btn-primary">Save</button></div>
</form>
@endsection
