@extends('layouts.app')
@section('title','Attendance')
@section('content')
<h3>Attendance</h3>

<!-- Search and Filter Form -->
<div class="card mb-3">
  <div class="card-body">
    <form method="GET" action="{{ route('attendances.index') }}" class="row g-3">
      <div class="col-md-3">
        <label for="search" class="form-label">Search</label>
        <input type="text" class="form-control" id="search" name="search" 
               value="{{ request('search') }}" placeholder="Member name...">
      </div>
      <div class="col-md-2">
        <label for="service_id" class="form-label">Service</label>
        <select class="form-select" id="service_id" name="service_id">
          <option value="">All</option>
          @foreach($services as $service)
            <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
              {{ $service->name }} - {{ $service->starts_at->format('M d, Y') }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status">
          <option value="">All</option>
          <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
          <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
          <option value="online" {{ request('status') == 'online' ? 'selected' : '' }}>Online</option>
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
      <div class="col-md-1 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100 me-2">
          <i class="fas fa-search"></i>
        </button>
        <a href="{{ route('attendances.index') }}" class="btn btn-outline-secondary">
          <i class="fas fa-times"></i>
        </a>
      </div>
    </form>
  </div>
</div>

<div class="card mb-3">
  <div class="card-body">
    <form class="row g-2" method="POST" action="{{ route('attendances.store') }}">
      @csrf
      <div class="col-md-4">
        <label class="form-label">Service ID</label>
        <input name="service_id" class="form-control" placeholder="e.g., 1" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Member ID</label>
        <input name="member_id" class="form-control" placeholder="e.g., 1" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="present">Present</option>
          <option value="absent">Absent</option>
          <option value="online">Online</option>
        </select>
      </div>
      <div class="col-md-1 d-flex align-items-end">
        <button class="btn btn-primary w-100">Save</button>
      </div>
    </form>
  </div>
</div>

<table class="table table-striped">
  <thead><tr><th>Service</th><th>Member</th><th>Status</th><th>Time</th></tr></thead>
  <tbody>
  @foreach($records as $r)
    <tr>
      <td>{{ $r->service->name }} ({{ $r->service->starts_at->format('Y-m-d H:i') }})</td>
      <td>{{ $r->member->full_name }}</td>
      <td>{{ ucfirst($r->status) }}</td>
      <td>{{ $r->created_at->format('Y-m-d H:i') }}</td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $records->links() }}
@endsection
