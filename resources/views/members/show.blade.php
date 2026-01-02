@extends('layouts.app')
@section('title','Member Details')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Member: {{ $member->full_name }}</h3>
  <div>
    <a href="{{ route('members.edit', $member) }}" class="btn btn-primary">Edit</a>
    <a href="{{ route('members.index') }}" class="btn btn-secondary">Back</a>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="card mb-3">
      <div class="card-header">Personal Information</div>
      <div class="card-body">
        <p><strong>Name:</strong> {{ $member->full_name }}</p>
        <p><strong>Phone:</strong> {{ $member->phone ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $member->email ?? 'N/A' }}</p>
        <p><strong>Gender:</strong> {{ ucfirst($member->gender ?? 'N/A') }}</p>
        <p><strong>Date of Birth:</strong> {{ $member->dob ? $member->dob->format('F j, Y') : 'N/A' }}</p>
        <p><strong>Marital Status:</strong> {{ ucfirst($member->marital_status ?? 'N/A') }}</p>
        <p><strong>Address:</strong> {{ $member->address ?? 'N/A' }}</p>
        <p><strong>Status:</strong> 
          <span class="badge bg-{{ $member->membership_status === 'active' ? 'success' : 'secondary' }}">
            {{ ucfirst($member->membership_status) }}
          </span>
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card mb-3">
      <div class="card-header">Positions</div>
      <div class="card-body">
        @if($member->positions->count() > 0)
          @foreach($member->positions as $position)
            <span class="badge bg-primary me-2 mb-2">{{ ucfirst($position->name) }}</span>
          @endforeach
        @else
          <p class="text-muted">No positions assigned</p>
        @endif
      </div>
    </div>
    @if($member->isShepherd())
      <div class="card mb-3">
        <div class="card-header">Shepherd Information</div>
        <div class="card-body">
          <p><strong>Flock Size:</strong> {{ $member->user?->flock()->count() ?? 0 }} members</p>
          @if($member->user)
            <p><strong>User Account:</strong> {{ $member->user->email }}</p>
          @endif
        </div>
      </div>
    @endif
    @if($member->ministries->count() > 0)
      <div class="card mb-3">
        <div class="card-header">Ministries</div>
        <div class="card-body">
          @foreach($member->ministries as $ministry)
            <span class="badge bg-info me-2 mb-2">{{ $ministry->name }}</span>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
