@extends('layouts.app')
@section('title','Edit Follow‑Up')
@section('content')
<h3>Edit Follow‑Up</h3>

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('followups.update',$followup) }}" class="row g-3">
  @csrf
  @method('PUT')
  <div class="col-md-4">
    <label class="form-label">Member</label>
    <select name="member_id" class="form-select" id="memberSelect" required style="width: 100%;">
      @foreach($members as $m)
        <option value="{{ $m->id }}" {{ $followup->member_id == $m->id ? 'selected' : '' }}>
          {{ $m->first_name }} {{ $m->last_name }}
          @if($m->phone) ({{ $m->phone }}) @endif
        </option>
      @endforeach
    </select>
  </div>
  <div class="col-md-4">
    <label class="form-label">Category</label>
    <input type="text" name="category" class="form-control" value="{{ old('category',$followup->category) }}">
  </div>
  <div class="col-md-4">
    <label class="form-label">Assign To</label>
    <select name="assigned_user_id" class="form-select" id="assignedUserSelect" style="width: 100%;">
      <option value="">-- None --</option>
      @foreach($users as $u)
        <option value="{{ $u->id }}" {{ (old('assigned_user_id',$followup->assigned_user_id) == $u->id) ? 'selected' : '' }}>{{ $u->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3">
    <label class="form-label">Follow‑Up Date</label>
    <input type="date" name="followup_date" class="form-control" value="{{ optional($followup->followup_date)->format('Y-m-d') }}" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <option value="pending" {{ $followup->status == 'pending' ? 'selected' : '' }}>Pending</option>
      <option value="contacted" {{ $followup->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
      <option value="discipleship ongoing" {{ $followup->status == 'discipleship ongoing' ? 'selected' : '' }}>Discipleship Ongoing</option>
      <option value="closed" {{ $followup->status == 'closed' ? 'selected' : '' }}>Closed</option>
    </select>
  </div>
  <div class="col-12">
    <label class="form-label">Note</label>
    <textarea name="note" class="form-control" rows="4">{{ $followup->note }}</textarea>
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('followups.index') }}" class="btn btn-secondary">Cancel</a>
  </div>
</form>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<!-- jQuery and Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function(){
    $('#memberSelect').select2({
      theme: 'bootstrap-5',
      placeholder: 'Search and select a member...',
      allowClear: true,
      width: '100%',
    });
    
    $('#assignedUserSelect').select2({
      theme: 'bootstrap-5',
      placeholder: 'Search and select a user...',
      allowClear: true,
      width: '100%',
    });
  });
</script>
@endsection