@extends('layouts.app')
@section('title','Church Leaders')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Church Leaders / Officers</h3>
  <a href="{{ route('church-leaders.create') }}" class="btn btn-primary">Assign Position</a>
</div>

<!-- Search and Filter Form -->
<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('church-leaders.index') }}" class="row g-3">
      <div class="col-md-4">
        <label for="search" class="form-label">Search</label>
        <input type="text" class="form-control" id="search" name="search" 
               value="{{ request('search') }}" placeholder="Name, phone, or email...">
      </div>
      <div class="col-md-3">
        <label for="position" class="form-label">Position</label>
        <select class="form-select" id="position" name="position">
          <option value="">All Positions</option>
          @foreach($positions as $position)
            <option value="{{ $position->name }}" {{ request('position') == $position->name ? 'selected' : '' }}>
              {{ ucfirst($position->name) }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100 me-2">
          <i class="fas fa-search"></i> Filter
        </button>
        <a href="{{ route('church-leaders.index') }}" class="btn btn-outline-secondary">
          <i class="fas fa-times"></i>
        </a>
      </div>
    </form>
  </div>
</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th>Positions</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @forelse($leaders as $leader)
      <tr>
        <td>{{ $leader->full_name }}</td>
        <td>{{ $leader->phone }}</td>
        <td>{{ $leader->email }}</td>
        <td>
          @foreach($leader->positions as $position)
            <span class="badge bg-primary me-1">{{ ucfirst($position->name) }}</span>
          @endforeach
        </td>
        <td>
          <a href="{{ route('church-leaders.edit', $leader) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
          <form action="{{ route('church-leaders.destroy', $leader) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove all positions from this member?')">Remove</button>
          </form>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="5" class="text-center">No church leaders found.</td>
      </tr>
    @endforelse
  </tbody>
</table>
{{ $leaders->links() }}
@endsection
