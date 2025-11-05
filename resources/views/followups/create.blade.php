@extends('layouts.app')
@section('title','Create Follow‑Up')
@section('content')
<h3>Create Follow‑Up</h3>

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('followups.store') }}" class="row g-3">
  @csrf
  <div class="col-md-4">
    <label class="form-label">Member</label>
    <select name="member_id" class="form-select" required>
      <option value="">-- Select Member --</option>
      @foreach($members as $m)
        <option value="{{ $m->id }}" {{ old('member_id') == $m->id ? 'selected' : '' }}>
          {{ $m->first_name }} {{ $m->last_name }}
        </option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3">
    <label class="form-label">Follow‑Up Date</label>
    <input type="date" name="followup_date" class="form-control" value="{{ old('followup_date') }}" required>
  </div>
  <div class="col-12">
    <label class="form-label">Note</label>
    <textarea name="note" class="form-control" rows="4">{{ old('note') }}</textarea>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('followups.index') }}" class="btn btn-secondary">Cancel</a>
  </div>
</form>
@endsection