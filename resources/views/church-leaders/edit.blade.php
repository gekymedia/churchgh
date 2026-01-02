@extends('layouts.app')
@section('title','Edit Positions')
@section('content')
<div class="card">
  <div class="card-header">Edit Positions for {{ $member->full_name }}</div>
  <div class="card-body">
    <form method="POST" action="{{ route('church-leaders.update', $member) }}">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label class="form-label">Positions</label>
        <div class="row" id="positionsContainer">
          @foreach($positions as $position)
            <div class="col-md-3 mb-2 position-option" 
                 data-position-name="{{ $position->name }}"
                 data-position-id="{{ $position->id }}">
              <div class="form-check">
                <input class="form-check-input position-checkbox" 
                       type="checkbox" 
                       name="positions[]" 
                       value="{{ $position->id }}" 
                       id="position_{{ $position->id }}"
                       {{ $member->positions->contains($position->id) ? 'checked' : '' }}>
                <label class="form-check-label" for="position_{{ $position->id }}">
                  {{ ucfirst($position->name) }}
                </label>
              </div>
              <small class="text-muted">{{ $position->description }}</small>
            </div>
          @endforeach
        </div>
        @error('positions')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
      <button type="submit" class="btn btn-primary">Update Positions</button>
      <a href="{{ route('church-leaders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function(){
    const memberGender = '{{ $member->gender ?? '' }}';
    
    // Filter positions based on member gender
    document.querySelectorAll('.position-option').forEach(function(option) {
      const positionName = option.dataset.positionName;
      const checkbox = option.querySelector('.position-checkbox');
      
      // Hide and disable deaconess for male members
      if (positionName === 'deaconess' && memberGender === 'male') {
        option.style.display = 'none';
        checkbox.disabled = true;
        if (checkbox.checked) {
          checkbox.checked = false;
        }
      }
      // Hide and disable deacon for female members
      else if (positionName === 'deacon' && memberGender === 'female') {
        option.style.display = 'none';
        checkbox.disabled = true;
        if (checkbox.checked) {
          checkbox.checked = false;
        }
      }
      // Show and enable for other cases
      else {
        option.style.display = '';
        checkbox.disabled = false;
      }
    });
  });
</script>
@endsection
