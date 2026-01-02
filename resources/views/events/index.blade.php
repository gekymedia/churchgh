@extends('layouts.app')
@section('title','Events')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Events</h3>
  <a href="{{ route('events.create') }}" class="btn btn-primary">Create</a>
</div>

<!-- Search and Filter Form -->
<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('events.index') }}" class="row g-3">
      <div class="col-md-3">
        <label for="search" class="form-label">Search</label>
        <input type="text" class="form-control" id="search" name="search" 
               value="{{ request('search') }}" placeholder="Title, location, or description...">
      </div>
      <div class="col-md-2">
        <label for="time_filter" class="form-label">Time</label>
        <select class="form-select" id="time_filter" name="time_filter">
          <option value="">All</option>
          <option value="upcoming" {{ request('time_filter') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
          <option value="past" {{ request('time_filter') == 'past' ? 'selected' : '' }}>Past</option>
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
      <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100 me-2">
          <i class="fas fa-search"></i> Filter
        </button>
        <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
          <i class="fas fa-times"></i>
        </a>
      </div>
    </form>
  </div>
</div>

<table class="table table-striped">
  <thead><tr><th>Title</th><th>Starts</th><th>Ends</th><th>Location</th><th></th></tr></thead>
  <tbody>
  @foreach($events as $e)
    <tr>
      <td>{{ $e->title }}</td>
      <td>{{ $e->starts_at->format('Y-m-d H:i') }}</td>
      <td>{{ optional($e->ends_at)->format('Y-m-d H:i') }}</td>
      <td>{{ $e->location }}</td>
      <td>
        <a href="{{ route('events.edit',$e) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
        <form action="{{ route('events.destroy',$e) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $events->links() }}
@endsection
