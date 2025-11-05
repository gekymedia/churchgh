@extends('layouts.app')
@section('title','Services')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Services</h3>
  <a href="{{ route('services.create') }}" class="btn btn-primary">Create</a>
</div>
<table class="table table-striped">
  <thead><tr><th>Name</th><th>Starts</th><th>Location</th><th></th></tr></thead>
  <tbody>
  @foreach($services as $s)
    <tr>
      <td>{{ $s->name }}</td>
      <td>{{ $s->starts_at->format('Y-m-d H:i') }}</td>
      <td>{{ $s->location }}</td>
      <td>
        <a href="{{ route('services.edit',$s) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
        <form action="{{ route('services.destroy',$s) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $services->links() }}
@endsection
