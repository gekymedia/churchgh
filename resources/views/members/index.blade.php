@extends('layouts.app')
@section('title','Members')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Members</h3>
  <a href="{{ route('members.create') }}" class="btn btn-primary">Add Member</a>
</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Name</th><th>Phone</th><th>Email</th><th>Status</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
  @foreach($members as $m)
    <tr>
      <td>{{ $m->full_name }}</td>
      <td>{{ $m->phone }}</td>
      <td>{{ $m->email }}</td>
      <td>{{ $m->membership_status }}</td>
      <td>
        <a href="{{ route('members.edit',$m) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
        <form action="{{ route('members.destroy',$m) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete member?')">Delete</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $members->links() }}
@endsection
