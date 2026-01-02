@extends('layouts.app')
@section('title','Dashboard')
@section('content')
<div class="row g-3">
  <!-- Key statistics -->
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Total Members</h6>
        <div class="display-6">{{ $members }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">New Members (This Month)</h6>
        <div class="display-6">{{ $new_members }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Services</h6>
        <div class="display-6">{{ $services }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Upcoming Events</h6>
        <div class="display-6">{{ $events }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Total Tithes</h6>
        <div class="display-6">GHS {{ number_format($tithes,2) }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Total Offerings</h6>
        <div class="display-6">GHS {{ number_format($offerings,2) }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Online Giving (This Month)</h6>
        <div class="display-6">GHS {{ number_format($givings,2) }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Pending Follow‑Ups</h6>
        <div class="display-6">{{ $pending_followups }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Leads</h6>
        <div class="display-6">{{ $lead_count }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Attendance Records</h6>
        <div class="display-6">{{ $attendances }}</div>
      </div>
    </div>
  </div>
</div>

<!-- Today’s Devotional -->
<div class="row mt-4">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">Today’s Devotional</div>
      <div class="card-body">
        @if($todays_quote)
          <h5>{{ $todays_quote->title }}</h5>
          @if($todays_quote->scripture)
            <p><strong>{{ $todays_quote->scripture }}</strong></p>
          @endif
          <p>{{ \Illuminate\Support\Str::limit($todays_quote->message, 150) }}</p>
        @else
          <p>No devotional message scheduled for today.</p>
        @endif
      </div>
    </div>
  </div>

  <!-- Upcoming Events list -->
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">Upcoming Events</div>
      <div class="card-body">
        @if($upcoming_events->isEmpty())
          <p>No upcoming events.</p>
        @else
          <ul class="list-group list-group-flush">
            @foreach($upcoming_events as $event)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <strong>{{ $event->title }}</strong><br>
                  <small>{{ $event->starts_at->format('M d, Y h:i A') }}</small>
                </div>
              </li>
            @endforeach
          </ul>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Recent Giving History -->
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header">Recent Giving (Last 5 Transactions)</div>
      <div class="card-body">
        @if($recent_givings->isEmpty())
          <p>No giving records found.</p>
        @else
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Date</th>
                <th>Donor</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Reference</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recent_givings as $giving)
              <tr>
                <td>{{ $giving->paid_at?->format('d M Y') ?? '-' }}</td>
                <td>
                  @if($giving->is_anonymous || !$giving->user)
                    Anonymous
                  @else
                    {{ $giving->user->name }}
                  @endif
                </td>
                <td>{{ ucfirst($giving->type) }}</td>
                <td>GHS {{ number_format($giving->amount,2) }}</td>
                <td>{{ $giving->reference }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
