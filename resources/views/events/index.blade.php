@extends('layouts.app')
@section('title','Events')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Events</h3>
  <a href="{{ route('events.create') }}" class="btn btn-primary">Create</a>
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
