@extends('layouts.app')

@section('title','Settings')
@section('page-title','Notification Settings')
@section('breadcrumb','Settings')

@section('content')
<div class="card">
  <div class="card-header">Update Your Settings</div>
  <div class="card-body">
    <form action="{{ route('settings.update') }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-3 form-check">
        <input type="checkbox" name="receive_quote_email" id="receive_quote_email" class="form-check-input" value="1" {{ $user->receive_quote_email ? 'checked' : '' }}>
        <label for="receive_quote_email" class="form-check-label">Receive devotional quotes via email</label>
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" name="receive_event_reminder_email" id="receive_event_reminder_email" class="form-check-input" value="1" {{ $user->receive_event_reminder_email ? 'checked' : '' }}>
        <label for="receive_event_reminder_email" class="form-check-label">Receive event reminders via email</label>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email',$user->email) }}">
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone',$user->phone) }}">
      </div>
      <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
  </div>
</div>
@endsection