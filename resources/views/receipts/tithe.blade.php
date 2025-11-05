<!doctype html>
<html><head><meta charset="utf-8">
<style>body{font-family:DejaVu Sans,Arial,sans-serif}.box{border:1px solid #444;padding:16px}.title{font-size:18px;font-weight:bold;margin-bottom:8px}.muted{color:#555}</style>
</head><body>
<div class="box">
  <div class="title">Tithe Receipt</div>
  <div class="muted">GEKYMEDIA DEV · churchgh</div><hr>
  <div><strong>Member:</strong> {{ $tithe->member->full_name }}</div>
  <div><strong>Amount:</strong> GHS {{ number_format($tithe->amount,2) }}</div>
  <div><strong>Paid At:</strong> {{ $tithe->paid_at->format('Y-m-d H:i') }}</div>
  <div><strong>Reference:</strong> {{ $tithe->reference }}</div>
  <hr><small>Generated {{ now()->format('Y-m-d H:i') }}</small>
</div>
</body></html>
