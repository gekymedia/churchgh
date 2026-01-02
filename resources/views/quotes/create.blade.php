@extends('layouts.app')

@section('title','Create Quote')
@section('page-title','New Devotional Quote')
@section('breadcrumb','Quotes')

@section('content')
<div class="card">
  <div class="card-header">Create Quote</div>
  <div class="card-body">
    <form action="{{ route('quotes.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label" for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label" for="scripture">Scripture (optional)</label>
        <input type="text" name="scripture" id="scripture" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label" for="message">Message</label>
        <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label" for="delivery_date">Delivery Date</label>
          <input type="date" name="delivery_date" id="delivery_date" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label" for="delivery_time">Delivery Time (optional, HH:MM)</label>
          <input type="time" name="delivery_time" id="delivery_time" class="form-control">
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
    </form>
  </div>
</div>
@endsection