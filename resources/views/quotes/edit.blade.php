@extends('layouts.app')

@section('title','Edit Quote')
@section('page-title','Edit Devotional Quote')
@section('breadcrumb','Quotes')

@section('content')
<div class="card">
  <div class="card-header">Edit Quote</div>
  <div class="card-body">
    <form action="{{ route('quotes.update', $quote) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label class="form-label" for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title',$quote->title) }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label" for="scripture">Scripture (optional)</label>
        <input type="text" name="scripture" id="scripture" class="form-control" value="{{ old('scripture',$quote->scripture) }}">
      </div>
      <div class="mb-3">
        <label class="form-label" for="message">Message</label>
        <textarea name="message" id="message" class="form-control" rows="4" required>{{ old('message',$quote->message) }}</textarea>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label" for="delivery_date">Delivery Date</label>
          <input type="date" name="delivery_date" id="delivery_date" class="form-control" value="{{ old('delivery_date',$quote->delivery_date->format('Y-m-d')) }}" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label" for="delivery_time">Delivery Time (optional, HH:MM)</label>
          <input type="time" name="delivery_time" id="delivery_time" class="form-control" value="{{ old('delivery_time',$quote->delivery_time) }}">
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
  </div>
</div>
@endsection