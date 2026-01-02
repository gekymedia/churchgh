@extends('layouts.app')
@section('title','Assign Position')
@section('content')
<div class="card">
  <div class="card-header">Assign Position to Member</div>
  <div class="card-body">
    <form method="POST" action="{{ route('church-leaders.store') }}">
      @csrf
      <div class="mb-3">
        <label for="member_id" class="form-label">Member</label>
        <select class="form-select" id="member_id" name="member_id" required style="width: 100%;">
          <option value="">Select a member...</option>
          @foreach($members as $member)
            <option value="{{ $member->id }}" 
                    data-gender="{{ $member->gender }}"
                    {{ old('member_id') == $member->id ? 'selected' : '' }}>
              {{ $member->full_name }} 
              @if($member->phone) - {{ $member->phone }} @endif
              @if($member->email) [{{ $member->email }}] @endif
            </option>
          @endforeach
        </select>
        @error('member_id')
          <div class="text-danger">{{ $message }}</div>
        @enderror
      </div>
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
                       id="position_{{ $position->id }}">
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
      <button type="submit" class="btn btn-primary">Assign Position</button>
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
    // Initialize Select2 for member selection
    $('#member_id').select2({
      theme: 'bootstrap-5',
      placeholder: 'Search and select a member...',
      allowClear: true,
      width: '100%',
    });

    // Function to filter positions based on member gender
    function filterPositionsByGender() {
      const memberId = $('#member_id').val();
      if (!memberId) {
        // Show all positions if no member selected
        $('.position-option').show();
        $('.position-checkbox').prop('disabled', false);
        return;
      }

      const selectedOption = $('#member_id option:selected');
      const memberGender = selectedOption.data('gender');

      $('.position-option').each(function() {
        const positionName = $(this).data('position-name');
        const $checkbox = $(this).find('.position-checkbox');
        
        // Hide and disable deaconess for male members
        if (positionName === 'deaconess' && memberGender === 'male') {
          $(this).hide();
          $checkbox.prop('disabled', true).prop('checked', false);
        }
        // Hide and disable deacon for female members
        else if (positionName === 'deacon' && memberGender === 'female') {
          $(this).hide();
          $checkbox.prop('disabled', true).prop('checked', false);
        }
        // Show and enable for other cases
        else {
          $(this).show();
          $checkbox.prop('disabled', false);
        }
      });
    }

    // Filter positions when member selection changes
    $('#member_id').on('change', filterPositionsByGender);
    
    // Initial filter if member is pre-selected
    filterPositionsByGender();
  });
</script>
@endsection
