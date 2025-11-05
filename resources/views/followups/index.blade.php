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

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Member</th>
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
        <td>{{ optional($f->followup_date)->format('Y-m-d') }}</td>
        <td>{{ \Illuminate\Support\Str::limit($f->note, 50) }}</td>
        <td>
          @if($f->completed_at)
            <span class="badge bg-success">Completed</span>
          @else
            <span class="badge bg-warning text-dark">Pending</span>
          @endif
        </td>
        <td>
          @if(!$f->completed_at)
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