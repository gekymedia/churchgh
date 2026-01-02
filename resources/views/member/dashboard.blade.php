@extends('layouts.app')

@section('title','Member Dashboard')
@section('page-title','Member Dashboard')
@section('breadcrumb','Member Dashboard')

@section('content')
<div class="row">
  <div class="col-lg-6">
    <div class="card mb-4">
      <div class="card-header">Today's Word</div>
      <div class="card-body">
        @if($quote)
          <h5 class="card-title">{{ $quote->title }}</h5>
          @if($quote->scripture)
          <p class="card-text"><strong>{{ $quote->scripture }}</strong></p>
          @endif
          <p class="card-text">{{ $quote->message }}</p>
        @else
          <p>No devotional message scheduled for today.</p>
        @endif
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card mb-4">
      <div class="card-header">Upcoming Events</div>
      <div class="card-body">
        @if($events->isEmpty())
          <p>No upcoming events in the next 30 days.</p>
        @else
          <ul class="list-group list-group-flush">
            @foreach($events as $event)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <strong>{{ $event->title }}</strong><br>
                <small>{{ $event->starts_at->format('F j, Y g:i A') }}</small>
              </div>
              <form action="{{ route('events.register', $event) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-success">Register</button>
              </form>
            </li>
            @endforeach
          </ul>
        @endif
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">Recent Giving History</div>
      <div class="card-body">
        @if($givings && $givings->count())
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Reference</th>
              </tr>
            </thead>
            <tbody>
              @foreach($givings as $giving)
              <tr>
                <td>{{ $giving->paid_at->format('d M Y') }}</td>
                <td>{{ ucfirst($giving->type) }}</td>
                <td>GHS {{ number_format($giving->amount,2) }}</td>
                <td>{{ $giving->reference }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <p>You have no recorded givings yet.</p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection