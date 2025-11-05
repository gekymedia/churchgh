@extends('layouts.app')
@section('title','Tithes')
@section('content')
<h3>Tithes</h3>
<div class="card mb-3">
  <div class="card-body">
    <form class="row g-2" method="POST" action="{{ route('tithes.store') }}">
      @csrf
      <div class="col-md-4">
        <label class="form-label">Member</label>
        <select name="member_id" class="form-select" required>
          @foreach($members as $m)
            <option value="{{ $m->id }}">{{ $m->first_name }} {{ $m->last_name }}</option>
          @endforeach
        </select>
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
  <thead><tr><th>Member</th><th>Amount</th><th>Paid At</th><th>Ref</th></tr></thead>
  <tbody>
  @foreach($tithes as $t)
    <tr>
      <td>{{ $t->member->full_name }}</td>
      <td>GHS {{ number_format($t->amount,2) }}</td>
      <td>{{ $t->paid_at->format('Y-m-d H:i') }}</td>
      <td>{{ $t->reference }}</td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $tithes->links() }}
@endsection
