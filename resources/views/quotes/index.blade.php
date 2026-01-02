@extends('layouts.app')

@section('title','Devotional Quotes')
@section('page-title','Devotional Quotes')
@section('breadcrumb','Quotes')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <h2>Quotes</h2>
  <a href="{{ route('quotes.create') }}" class="btn btn-primary">New Quote</a>
</div>

<!-- Search and Filter Form -->
<div class="card mb-3">
  <div class="card-body">
    <form method="GET" action="{{ route('quotes.index') }}" class="row g-3">
      <div class="col-md-3">
        <label for="search" class="form-label">Search</label>
        <input type="text" class="form-control" id="search" name="search" 
               value="{{ request('search') }}" placeholder="Title, scripture, or message...">
      </div>
      <div class="col-md-2">
        <label for="sent_status" class="form-label">Status</label>
        <select class="form-select" id="sent_status" name="sent_status">
          <option value="">All</option>
          <option value="sent" {{ request('sent_status') == 'sent' ? 'selected' : '' }}>Sent</option>
          <option value="pending" {{ request('sent_status') == 'pending' ? 'selected' : '' }}>Pending</option>
        </select>
      </div>
      <div class="col-md-2">
        <label for="date_from" class="form-label">From Date</label>
        <input type="date" class="form-control" id="date_from" name="date_from" 
               value="{{ request('date_from') }}">
      </div>
      <div class="col-md-2">
        <label for="date_to" class="form-label">To Date</label>
        <input type="date" class="form-control" id="date_to" name="date_to" 
               value="{{ request('date_to') }}">
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100 me-2">
          <i class="fas fa-search"></i> Filter
        </button>
        <a href="{{ route('quotes.index') }}" class="btn btn-outline-secondary">
          <i class="fas fa-times"></i>
        </a>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Title</th>
          <th>Delivery Date</th>
          <th>Sent At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($quotes as $quote)
        <tr>
          <td>{{ $quote->title }}</td>
          <td>{{ $quote->delivery_date->format('d M Y') }}</td>
          <td>{{ $quote->sent_at?->format('d M Y H:i') ?? '-' }}</td>
          <td>
            <a href="{{ route('quotes.edit', $quote) }}" class="btn btn-sm btn-secondary">Edit</a>
            <form action="{{ route('quotes.destroy', $quote) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this quote?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $quotes->links() }}
  </div>
</div>
@endsection