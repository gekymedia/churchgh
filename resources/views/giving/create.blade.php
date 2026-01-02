@extends('layouts.app')

@section('title','Give Online')
@section('page-title','Online Giving')
@section('breadcrumb','Giving')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">Give Online</div>
      <div class="card-body">
        <form action="{{ route('payment.initialize') }}" method="POST" id="givingForm">
          @csrf
          <div class="mb-3">
            <label for="type" class="form-label">Type of Giving</label>
            <select name="type" id="type" class="form-select" required>
              <option value="tithe">Tithe</option>
              <option value="offering">Offering</option>
              <option value="building">Building Fund</option>
              <option value="missions">Missions</option>
              <option value="special">Special Offering</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="amount" class="form-label">Amount (GHS)</label>
            <input type="number" step="0.01" min="0.01" name="amount" id="amount" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="note" class="form-label">Note (optional)</label>
            <textarea name="note" id="note" class="form-control" rows="2"></textarea>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_anonymous" id="is_anonymous" value="1" checked>
            <label class="form-check-label" for="is_anonymous">
              Give anonymously
            </label>
          </div>
          <button type="submit" class="btn btn-primary w-100">
            <i class="fas fa-credit-card"></i> Pay with Paystack
          </button>
        </form>
        
        <div class="mt-3 text-center">
          <small class="text-muted">
            <i class="fas fa-lock"></i> Secure payment powered by Paystack
          </small>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection