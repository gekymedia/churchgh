@extends('layouts.app')
@section('title','Dashboard')
@section('content')
<div class="row g-3">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Members</h6>
        <div class="display-6">{{ $members }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Services</h6>
        <div class="display-6">{{ $services }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Events</h6>
        <div class="display-6">{{ $events }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Total Tithes</h6>
        <div class="display-6">GHS {{ number_format($tithes,2) }}</div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Total Offerings</h6>
        <div class="display-6">GHS {{ number_format($offerings,2) }}</div>
      </div>
    </div>
  </div>

  <!-- Pending follow‑ups metric -->
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Pending Follow‑Ups</h6>
        <div class="display-6">{{ $pending_followups }}</div>
      </div>
    </div>
  </div>

  <!-- Leads count metric -->
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <h6 class="text-muted">Leads</h6>
        <div class="display-6">{{ $lead_count }}</div>
      </div>
    </div>
  </div>
</div>
@endsection
