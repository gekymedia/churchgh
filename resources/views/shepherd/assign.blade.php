@extends('layouts.app')
@section('title','Assign Members to Shepherd')
@section('content')
<div class="card">
  <div class="card-header">Assign Members to Shepherd</div>
  <div class="card-body">
    <form method="POST" action="{{ route('shepherds.assign.store') }}">
      @csrf
      <div class="mb-3">
        <label for="shepherd_id" class="form-label">Shepherd</label>
        <select class="form-select" id="shepherd_id" name="shepherd_id" required style="width: 100%;">
          <option value="">Select a shepherd...</option>
          @foreach($shepherds as $shepherd)
            <option value="{{ $shepherd->id }}" {{ old('shepherd_id') == $shepherd->id ? 'selected' : '' }}>
              {{ $shepherd->name }} @if($shepherd->member) - {{ $shepherd->member->full_name }} @endif
            </option>
          @endforeach
        </select>
        @error('shepherd_id')
          <div class="text-danger">{{ $message }}</div>
        @enderror
        <small class="text-muted">Only users with the 'shepherd' position can be selected.</small>
      </div>
      <div class="mb-3">
        <label class="form-label">Members to Assign</label>
        <select name="member_ids[]" class="form-select" id="memberSelect" multiple style="width: 100%;">
          @foreach($members as $member)
            <option value="{{ $member->id }}">
              {{ $member->full_name }} 
              @if($member->phone) ({{ $member->phone }}) @endif
              @if($member->email) [{{ $member->email }}] @endif
            </option>
          @endforeach
        </select>
        @error('member_ids')
          <div class="text-danger">{{ $message }}</div>
        @enderror
        <small class="text-muted">Search and select multiple members to assign to this shepherd</small>
      </div>
      <button type="submit" class="btn btn-primary">Assign Members</button>
      <a href="{{ route('church-leaders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<!-- jQuery and Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function(){
    // Initialize Select2 for shepherd selection
    $('#shepherd_id').select2({
      theme: 'bootstrap-5',
      placeholder: 'Search and select a shepherd...',
      allowClear: true,
      width: '100%',
    });

    // Initialize Select2 for member selection (multiple)
    $('#memberSelect').select2({
      theme: 'bootstrap-5',
      placeholder: 'Search and select members...',
      allowClear: true,
      width: '100%',
      closeOnSelect: false,
    });
  });
</script>
@endsection
