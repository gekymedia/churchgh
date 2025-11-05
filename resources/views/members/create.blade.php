@extends('layouts.app')
@section('title','Add Member')
@section('content')
<h3>Add Member</h3>
<form method="POST" action="{{ route('members.store') }}" class="row g-3">
  @csrf
  <div class="col-md-6">
    <label class="form-label">First Name</label>
    <input name="first_name" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Last Name</label>
    <input name="last_name" class="form-control" required>
  </div>
  <div class="col-md-4">
    <label class="form-label">Phone</label>
    <input name="phone" class="form-control">
  </div>
  <div class="col-md-4">
    <label class="form-label">Email</label>
    <input name="email" type="email" class="form-control">
  </div>
  <div class="col-md-4">
    <label class="form-label">Gender</label>
    <select name="gender" class="form-select">
      <option value="">--</option>
      <option value="male">Male</option>
      <option value="female">Female</option>
    </select>
  </div>
  <div class="col-md-6">
    <label class="form-label">Date of Birth</label>
    <input name="dob" type="date" class="form-control">
  </div>
  <div class="col-md-6">
    <label class="form-label">Address</label>
    <input name="address" class="form-control">
  </div>
  <div class="col-12">
    <label class="form-label">Membership Status</label>
    <input name="membership_status" class="form-control" value="active">
  </div>
  <div class="col-12">
    <button class="btn btn-primary">Save</button>
  </div>
</form>
@endsection
