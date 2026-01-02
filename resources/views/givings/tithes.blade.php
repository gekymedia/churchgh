@extends('layouts.app')
@section('title','Tithes')
@section('content')
<h3>Tithes</h3>

<!-- Search and Filter Form -->
<div class="card mb-3">
  <div class="card-body">
    <form method="GET" action="{{ route('tithes.index') }}" class="row g-3">
      <div class="col-md-2">
        <label for="search" class="form-label">Search</label>
        <input type="text" class="form-control" id="search" name="search" 
               value="{{ request('search') }}" placeholder="Member, reference...">
      </div>
      <div class="col-md-2">
        <label for="member_id" class="form-label">Member</label>
        <select class="form-select" id="member_id" name="member_id" style="width: 100%;">
          <option value="">All</option>
          @foreach($members as $m)
            <option value="{{ $m->id }}" {{ request('member_id') == $m->id ? 'selected' : '' }}>
              {{ $m->first_name }} {{ $m->last_name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label for="date_from" class="form-label">From Date</label>
        <input type="date" class="form-control" id="date_from" name="date_from" 
               value="{{ request('date_from') }}">
      </div>
      <div class="col-md-2">
        <label for="date_to" class="form-label">To Date</label>
        <input type="date" class="form-control" id="date_to" name="date_to" 
               value="{{ request('date_to') }}">
      </div>
      <div class="col-md-2">
        <label for="amount_min" class="form-label">Min Amount</label>
        <input type="number" step="0.01" class="form-control" id="amount_min" name="amount_min" 
               value="{{ request('amount_min') }}" placeholder="0.00">
      </div>
      <div class="col-md-2">
        <label for="amount_max" class="form-label">Max Amount</label>
        <input type="number" step="0.01" class="form-control" id="amount_max" name="amount_max" 
               value="{{ request('amount_max') }}" placeholder="0.00">
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary me-2">
          <i class="fas fa-search"></i> Filter
        </button>
        <a href="{{ route('tithes.index') }}" class="btn btn-outline-secondary">
          <i class="fas fa-times"></i> Clear
        </a>
      </div>
    </form>
  </div>
</div>

<div class="card mb-3">
  <div class="card-body">
    <form class="row g-2" method="POST" action="{{ route('tithes.store') }}">
      @csrf
      <div class="col-md-4">
        <label class="form-label">Member</label>
        <select name="member_id" class="form-select" id="memberSelectForm" required style="width: 100%;">
          @foreach($members as $m)
            <option value="{{ $m->id }}">{{ $m->first_name }} {{ $m->last_name }} @if($m->phone) ({{ $m->phone }}) @endif</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Amount (GHS)</label>
        <input name="amount" type="number" step="0.01" class="form-control" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Paid At</label>
        <input name="paid_at" type="datetime-local" class="form-control" required>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-primary w-100">Save</button>
      </div>
    </form>
  </div>
</div>

<table class="table table-striped">
  <thead><tr><th>Member</th><th>Amount</th><th>Paid At</th><th>Ref</th></tr></thead>
  <tbody>
  @foreach($tithes as $t)
    <tr>
      <td>{{ $t->member->full_name }}</td>
      <td>GHS {{ number_format($t->amount,2) }}</td>
      <td>{{ $t->paid_at->format('Y-m-d H:i') }}</td>
      <td>{{ $t->reference }}</td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $tithes->links() }}

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<!-- jQuery and Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function(){
    $('#member_id').select2({
      theme: 'bootstrap-5',
      placeholder: 'Search and select a member...',
      allowClear: true,
      width: '100%',
    });
    
    $('#memberSelectForm').select2({
      theme: 'bootstrap-5',
      placeholder: 'Search and select a member...',
      allowClear: true,
      width: '100%',
    });
  });
</script>
@endsection
