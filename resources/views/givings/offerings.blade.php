@extends('layouts.app')
@section('title','Offerings')
@section('content')
<h3>Offerings</h3>
<div class="card mb-3">
  <div class="card-body">
    <form class="row g-2" method="POST" action="{{ route('offerings.store') }}">
      @csrf
      <div class="col-md-4">
        <label class="form-label">Member (optional)</label>
        <input name="member_id" class="form-control" placeholder="ID or leave blank">
      </div>
      <div class="col-md-3">
        <label class="form-label">Amount (GHS)</label>
        <input name="amount" type="number" step="0.01" class="form-control" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Paid At</label>
        <input name="paid_at" type="datetime-local" class="form-control" required>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-primary w-100">Save</button>
      </div>
    </form>
  </div>
</div>

<table class="table table-striped">
  <thead><tr><th>Member</th><th>Amount</th><th>Category</th><th>Paid At</th><th>Ref</th></tr></thead>
  <tbody>
  @foreach($offerings as $o)
    <tr>
      <td>{{ optional($o->member)->full_name ?? 'Anonymous' }}</td>
      <td>GHS {{ number_format($o->amount,2) }}</td>
      <td>{{ $o->category }}</td>
      <td>{{ $o->paid_at->format('Y-m-d H:i') }}</td>
      <td>{{ $o->reference }}</td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $offerings->links() }}
@endsection
