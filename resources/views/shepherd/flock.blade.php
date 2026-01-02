@extends('layouts.app')
@section('title','My Flock')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>My Flock (Assigned Members)</h3>
</div>

<div class="row mb-4">
  <div class="col-md-3">
    <div class="stat-card">
      <div class="stat-icon" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);">
        <i class="fas fa-users"></i>
      </div>
      <div class="stat-content">
        <h3>{{ $flock->count() }}</h3>
        <p>Total Members</p>
      </div>
    </div>
  </div>
</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th>Status</th>
      <th>Last Attendance</th>
      <th>Notes</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @forelse($flock as $member)
      <tr>
        <td>{{ $member->full_name }}</td>
        <td>{{ $member->phone }}</td>
        <td>{{ $member->email }}</td>
        <td>
          <span class="badge bg-{{ $member->membership_status === 'active' ? 'success' : 'secondary' }}">
            {{ ucfirst($member->membership_status) }}
          </span>
        </td>
        <td>
          @if($member->attendances->count() > 0)
            {{ $member->attendances->sortByDesc('created_at')->first()->created_at->diffForHumans() }}
          @else
            <span class="text-muted">Never</span>
          @endif
        </td>
        <td>{{ $member->pivot->notes ?? '-' }}</td>
        <td>
          <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-eye"></i> View
          </a>
          <a href="{{ route('followups.create') }}?member_id={{ $member->id }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-tasks"></i> Follow Up
          </a>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="7" class="text-center">No members assigned to your flock yet.</td>
      </tr>
    @endforelse
  </tbody>
</table>
@endsection
