@extends('layouts.app')
@section('title','Attendance')
@section('content')
<h3>Attendance</h3>

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
