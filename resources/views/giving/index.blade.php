@extends('layouts.app')

@section('title','Giving Records')
@section('page-title','Giving Records')
@section('breadcrumb','Giving')

@section('content')
<div class="card">
  <div class="card-header">All Givings</div>
  <div class="card-body">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Date</th>
          <th>Donor</th>
          <th>Type</th>
          <th>Amount</th>
          <th>Reference</th>
          <th>Note</th>
        </tr>
      </thead>
      <tbody>
        @foreach($givings as $giving)
        <tr>
          <td>{{ $giving->paid_at?->format('d M Y') }}</td>
          <td>
            @if($giving->is_anonymous || !$giving->user)
              Anonymous
            @else
              {{ $giving->user->name }}
            @endif
          </td>
          <td>{{ ucfirst($giving->type) }}</td>
          <td>GHS {{ number_format($giving->amount, 2) }}</td>
          <td>{{ $giving->reference }}</td>
          <td>{{ $giving->note }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="mt-3">
      {{ $givings->links() }}
    </div>
  </div>
</div>
@endsection