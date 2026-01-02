@extends('layouts.app')
@section('title','Settings')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>System Settings</h3>
</div>

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <i class="fas fa-exclamation-circle me-2"></i>
  {{ session('error') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
  <div class="card-header">Social Media & Payment Configuration</div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.settings.update') }}">
      @csrf
      
      <h5 class="mb-3">Social Media Handles</h5>
      <div class="row mb-4">
        <div class="col-md-6 mb-3">
          <label for="social_facebook" class="form-label">
            <i class="fab fa-facebook text-primary"></i> Facebook URL
          </label>
          <input type="url" class="form-control" id="social_facebook" name="social_facebook" 
                 value="{{ $socialMediaSettings['facebook'] }}" placeholder="https://facebook.com/churchgh">
        </div>
        <div class="col-md-6 mb-3">
          <label for="social_twitter" class="form-label">
            <i class="fab fa-twitter text-info"></i> Twitter/X URL
          </label>
          <input type="url" class="form-control" id="social_twitter" name="social_twitter" 
                 value="{{ $socialMediaSettings['twitter'] }}" placeholder="https://twitter.com/churchgh">
        </div>
        <div class="col-md-6 mb-3">
          <label for="social_instagram" class="form-label">
            <i class="fab fa-instagram text-danger"></i> Instagram URL
          </label>
          <input type="url" class="form-control" id="social_instagram" name="social_instagram" 
                 value="{{ $socialMediaSettings['instagram'] }}" placeholder="https://instagram.com/churchgh">
        </div>
        <div class="col-md-6 mb-3">
          <label for="social_youtube" class="form-label">
            <i class="fab fa-youtube text-danger"></i> YouTube URL
          </label>
          <input type="url" class="form-control" id="social_youtube" name="social_youtube" 
                 value="{{ $socialMediaSettings['youtube'] }}" placeholder="https://youtube.com/@churchgh">
        </div>
        <div class="col-md-6 mb-3">
          <label for="social_whatsapp" class="form-label">
            <i class="fab fa-whatsapp text-success"></i> WhatsApp Number
          </label>
          <input type="text" class="form-control" id="social_whatsapp" name="social_whatsapp" 
                 value="{{ $socialMediaSettings['whatsapp'] }}" placeholder="+233XXXXXXXXX">
        </div>
        <div class="col-md-6 mb-3">
          <label for="social_website" class="form-label">
            <i class="fas fa-globe"></i> Website URL
          </label>
          <input type="url" class="form-control" id="social_website" name="social_website" 
                 value="{{ $socialMediaSettings['website'] }}" placeholder="https://churchgh.com">
        </div>
      </div>

      <hr>

      <h5 class="mb-3">Paystack Payment Configuration</h5>
      <div class="row mb-4">
        <div class="col-md-6 mb-3">
          <label for="paystack_public_key" class="form-label">Paystack Public Key</label>
          <input type="text" class="form-control" id="paystack_public_key" name="paystack_public_key" 
                 value="{{ $paymentSettings['paystack_public_key'] }}" placeholder="pk_test_...">
          <small class="text-muted">Get this from your Paystack dashboard</small>
        </div>
        <div class="col-md-6 mb-3">
          <label for="paystack_secret_key" class="form-label">Paystack Secret Key</label>
          <input type="password" class="form-control" id="paystack_secret_key" name="paystack_secret_key" 
                 value="{{ $paymentSettings['paystack_secret_key'] }}" placeholder="sk_test_...">
          <small class="text-muted">Keep this secret! Get this from your Paystack dashboard</small>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Save Settings
      </button>
      <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>

<div class="card mt-4">
  <div class="card-header">Payment Gateway Status</div>
  <div class="card-body">
    @php
      $publicKey = $paymentSettings['paystack_public_key'] ?? '';
      $secretKey = $paymentSettings['paystack_secret_key'] ?? '';
    @endphp
    @if($publicKey && $secretKey)
      <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> Paystack is configured and ready to use.
      </div>
    @else
      <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i> Paystack is not configured. Please add your API keys above.
      </div>
    @endif
  </div>
</div>
@endsection

