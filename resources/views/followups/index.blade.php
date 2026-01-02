@extends('layouts.app')
@section('title','Follow Ups')
@section('content')
<h3>Member Follow‑Ups</h3>

<div class="mb-3 d-flex justify-content-between">
  <div>
    <a href="{{ route('followups.create') }}" class="btn btn-primary">Add Follow‑Up</a>
  </div>
  <div>
    <a href="{{ route('members.index') }}" class="btn btn-secondary">Back to Members</a>
  </div>
</div>

<!-- Search and Filter Form -->
<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('followups.index') }}" class="row g-3">
      <div class="col-md-3">
        <label for="search" class="form-label">Search</label>
        <input type="text" class="form-control" id="search" name="search" 
               value="{{ request('search') }}" placeholder="Member name or notes...">
      </div>
      <div class="col-md-2">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status">
          <option value="">All</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
          <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
        </select>
      </div>
      <div class="col-md-2">
        <label for="category" class="form-label">Category</label>
        <select class="form-select" id="category" name="category">
          <option value="">All</option>
          <option value="Visit" {{ request('category') == 'Visit' ? 'selected' : '' }}>Visit</option>
          <option value="Call" {{ request('category') == 'Call' ? 'selected' : '' }}>Call</option>
          <option value="Prayer" {{ request('category') == 'Prayer' ? 'selected' : '' }}>Prayer</option>
          <option value="Counseling" {{ request('category') == 'Counseling' ? 'selected' : '' }}>Counseling</option>
          <option value="Discipleship" {{ request('category') == 'Discipleship' ? 'selected' : '' }}>Discipleship</option>
        </select>
      </div>
      <div class="col-md-2">
        <label for="assigned_user_id" class="form-label">Assigned To</label>
        <select class="form-select" id="assigned_user_id" name="assigned_user_id">
          <option value="">All</option>
          @foreach($users as $user)
            <option value="{{ $user->id }}" {{ request('assigned_user_id') == $user->id ? 'selected' : '' }}>
              {{ $user->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-1">
        <label for="date_from" class="form-label">From</label>
        <input type="date" class="form-control" id="date_from" name="date_from" 
               value="{{ request('date_from') }}">
      </div>
      <div class="col-md-1">
        <label for="date_to" class="form-label">To</label>
        <input type="date" class="form-control" id="date_to" name="date_to" 
               value="{{ request('date_to') }}">
      </div>
      <div class="col-md-1 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100 me-2">
          <i class="fas fa-search"></i>
        </button>
        <a href="{{ route('followups.index') }}" class="btn btn-outline-secondary">
          <i class="fas fa-times"></i>
        </a>
      </div>
    </form>
  </div>
</div>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Member</th>
      <th scope="col">Category</th>
      <th scope="col">Assigned To</th>
      <th scope="col">Date</th>
      <th scope="col">Note</th>
      <th scope="col">Status</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    @forelse($followups as $f)
      <tr>
        <td>{{ $f->id }}</td>
        <td>{{ $f->member?->full_name ?? '' }}</td>
        <td>{{ $f->category }}</td>
        <td>{{ $f->assignedUser?->name }}</td>
        <td>{{ optional($f->followup_date)->format('Y-m-d') }}</td>
        <td>{{ \Illuminate\Support\Str::limit($f->note, 50) }}</td>
        <td>
          @php $status = $f->status ?? ($f->completed_at ? 'closed' : 'pending'); @endphp
          <span class="badge {{ $status === 'closed' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($status) }}</span>
        </td>
        <td>
          @if(($f->status ?? ($f->completed_at ? 'closed' : 'pending')) !== 'closed')
            <form method="POST" action="{{ route('followups.complete',$f) }}" class="d-inline">
              @csrf
              <button class="btn btn-sm btn-success" onclick="return confirm('Mark as completed?')">Complete</button>
            </form>
          @endif
          <a href="{{ route('followups.edit',$f) }}" class="btn btn-sm btn-info">Edit</a>
          <form method="POST" action="{{ route('followups.destroy',$f) }}" class="d-inline" onsubmit="return confirm('Delete this follow‑up?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="6" class="text-center">No follow‑ups found.</td>
      </tr>
    @endforelse
  </tbody>
</table>

{{ $followups->links() }}
@endsection