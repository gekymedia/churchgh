@extends('layouts.app')
@section('title','Edit Member')
@section('content')
<h3>Edit Member</h3>
<form method="POST" action="{{ route('members.update') }}" class="row g-3">
  @csrf @method('PUT')
  <div class="col-md-6">
    <label class="form-label">First Name</label>
    <input name="first_name" class="form-control" value="{{ old('first_name',$member->first_name) }}" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Last Name</label>
    <input name="last_name" class="form-control" value="{{ old('last_name',$member->last_name) }}" required>
  </div>
  <div class="col-md-4">
    <label class="form-label">Phone</label>
    <input name="phone" class="form-control" value="{{ old('phone',$member->phone) }}">
  </div>
  <div class="col-md-4">
    <label class="form-label">Email</label>
    <input name="email" type="email" class="form-control" value="{{ old('email',$member->email) }}">
  </div>
  <div class="col-md-4">
    <label class="form-label">Gender</label>
    <select name="gender" class="form-select">
      <option value="">--</option>
      <option value="male" @selected(old('gender',$member->gender)=='male')>Male</option>
      <option value="female" @selected(old('gender',$member->gender)=='female')>Female</option>
    </select>
  </div>
  <div class="col-md-6">
    <label class="form-label">Date of Birth</label>
    <input name="dob" type="date" class="form-control" value="{{ old('dob', optional($member->dob)->format('Y-m-d')) }}">
  </div>
  <div class="col-md-6">
    <label class="form-label">Address</label>
    <input name="address" class="form-control" value="{{ old('address',$member->address) }}">
  </div>
  <div class="col-12">
    <label class="form-label">Membership Status</label>
    <input name="membership_status" class="form-control" {{ old('membership_status',$member->membership_status) }}>
  </div>
  <div class="col-12">
    <button class="btn btn-primary">Save</button>
  </div>
</form>
@endsection
