@extends('layouts.app')
@section('title','Church Leader Details')
@section('content')
<div class="card">
  <div class="card-header">Church Leader: {{ $member->full_name }}</div>
  <div class="card-body">
    <div class="row mb-3">
      <div class="col-md-6">
        <strong>Name:</strong> {{ $member->full_name }}
      </div>
      <div class="col-md-6">
        <strong>Phone:</strong> {{ $member->phone ?? 'N/A' }}
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-6">
        <strong>Email:</strong> {{ $member->email ?? 'N/A' }}
      </div>
      <div class="col-md-6">
        <strong>Status:</strong> 
        <span class="badge bg-{{ $member->membership_status === 'active' ? 'success' : 'secondary' }}">
          {{ ucfirst($member->membership_status) }}
        </span>
      </div>
    </div>
    <div class="mb-3">
      <strong>Positions:</strong>
      <div class="mt-2">
        @foreach($member->positions as $position)
          <span class="badge bg-primary me-2">{{ ucfirst($position->name) }}</span>
        @endforeach
      </div>
    </div>
    @if($member->isShepherd())
      <div class="mb-3">
        <strong>Flock Size:</strong> {{ $member->user?->flock()->count() ?? 0 }} members
      </div>
    @endif
    <div class="mt-4">
      <a href="{{ route('church-leaders.edit', $member) }}" class="btn btn-primary">Edit Positions</a>
      <a href="{{ route('church-leaders.index') }}" class="btn btn-secondary">Back</a>
    </div>
  </div>
</div>
@endsection
