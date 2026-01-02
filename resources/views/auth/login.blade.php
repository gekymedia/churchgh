@extends('layouts.guest')

@section('title','Login')

@section('content')
<div class="card">
  <div class="card-header">Login</div>
  <div class="card-body">
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="mb-3">
        <label for="identifier" class="form-label">Email or Phone</label>
        <input type="text" name="identifier" id="identifier" class="form-control @error('identifier') is-invalid @enderror" value="{{ old('identifier') }}" required autofocus>
        @error('identifier')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
  </div>
</div>
@endsection