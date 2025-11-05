@extends('layouts.app')
@section('title','Create Lead')
@section('content')
<h3>Create Lead</h3>

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('leads.store') }}" class="row g-3">
  @csrf
  <div class="col-md-4">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
  </div>
  <div class="col-md-4">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
  </div>
  <div class="col-12">
    <label class="form-label">Notes</label>
    <textarea name="notes" class="form-control" rows="4">{{ old('notes') }}</textarea>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('leads.index') }}" class="btn btn-secondary">Cancel</a>
  </div>
</form>
@endsection