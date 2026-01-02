@extends('layouts.app')
@section('title','Leads')
@section('content')
<h3>Leads (Evangelism Contacts)</h3>

<div class="mb-3 d-flex justify-content-between">
  <div>
    <a href="{{ route('leads.create') }}" class="btn btn-primary">Add Lead</a>
  </div>
  <div>
    <a href="{{ route('evangelism.create') }}" class="btn btn-secondary">Send Message</a>
  </div>
</div>

<!-- Search Form -->
<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('leads.index') }}" class="row g-3">
      <div class="col-md-10">
        <label for="search" class="form-label">Search</label>
        <input type="text" class="form-control" id="search" name="search" 
               value="{{ request('search') }}" placeholder="Name, phone, email, or notes...">
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100 me-2">
          <i class="fas fa-search"></i> Search
        </button>
        <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary">
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
      <th scope="col">Name</th>
      <th scope="col">Phone</th>
      <th scope="col">Email</th>
      <th scope="col">Notes</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    @forelse($leads as $lead)
      <tr>
        <td>{{ $lead->id }}</td>
        <td>{{ $lead->name }}</td>
        <td>{{ $lead->phone }}</td>
        <td>{{ $lead->email }}</td>
        <td>{{ \Illuminate\Support\Str::limit($lead->notes, 50) }}</td>
        <td>
          <a href="{{ route('leads.edit',$lead) }}" class="btn btn-sm btn-info">Edit</a>
          <form method="POST" action="{{ route('leads.destroy',$lead) }}" class="d-inline" onsubmit="return confirm('Delete this lead?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="6" class="text-center">No leads found.</td>
      </tr>
    @endforelse
  </tbody>
</table>

{{ $leads->links() }}
@endsection