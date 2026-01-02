@extends('layouts.app')
@section('title','Members')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Members</h3>
  <a href="{{ route('members.create') }}" class="btn btn-primary">Add Member</a>
</div>

<!-- Search and Filter Form -->
<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('members.index') }}" class="row g-3">
      <div class="col-md-4">
        <label for="search" class="form-label">Search</label>
        <input type="text" class="form-control" id="search" name="search" 
               value="{{ request('search') }}" placeholder="Name, phone, or email...">
      </div>
      <div class="col-md-2">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status">
          <option value="">All</option>
          <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
          <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
          <option value="visitor" {{ request('status') == 'visitor' ? 'selected' : '' }}>Visitor</option>
        </select>
      </div>
      <div class="col-md-2">
        <label for="gender" class="form-label">Gender</label>
        <select class="form-select" id="gender" name="gender">
          <option value="">All</option>
          <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
          <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
        </select>
      </div>
      <div class="col-md-2">
        <label for="marital_status" class="form-label">Marital Status</label>
        <select class="form-select" id="marital_status" name="marital_status">
          <option value="">All</option>
          <option value="single" {{ request('marital_status') == 'single' ? 'selected' : '' }}>Single</option>
          <option value="married" {{ request('marital_status') == 'married' ? 'selected' : '' }}>Married</option>
        </select>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100 me-2">
          <i class="fas fa-search"></i> Filter
        </button>
        <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">
          <i class="fas fa-times"></i>
        </a>
      </div>
    </form>
  </div>
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
