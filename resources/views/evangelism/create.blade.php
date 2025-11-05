@extends('layouts.app')
@section('title','Evangelism Messages')
@section('content')
<h3>Send Evangelism Message</h3>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('evangelism.send') }}" class="row g-3">
      @csrf
      <div class="col-md-3">
        <label class="form-label">Channel</label>
        <select name="channel" class="form-select">
          <option value="sms">SMS</option>
          <option value="whatsapp">WhatsApp</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Lead (leave blank to broadcast)</label>
        <select name="lead_id" class="form-select">
          <option value="">-- Select Lead --</option>
          @foreach($leads as $lead)
            <option value="{{ $lead->id }}">{{ $lead->name }} ({{ $lead->phone }})</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="broadcast" value="1" id="broadcast">
          <label class="form-check-label" for="broadcast">Broadcast to all leads</label>
        </div>
      </div>
      <div class="col-12">
        <label class="form-label">Message</label>
        <select id="evangelismTemplateSelect" class="form-select mb-2">
          <option value="">-- Choose a template (optional) --</option>
          <option value="Hi @{{name}}, we would love to invite you to our upcoming event this Sunday at 9am. Hope you can join us!">Invitation to Service</option>
          <option value="Hello @{{name}}, just reaching out to share that God loves you and has great plans for your life. We'd be honoured to have you visit us.">Inspiration</option>
          <option value="Greetings @{{name}}, remember you are always welcome at our church. Feel free to contact us with any questions.">General Outreach</option>
        </select>
        <textarea name="message" class="form-control" rows="4" required></textarea>
      </div>
      <div class="col-12">
        <button class="btn btn-primary">Send</button>
      </div>
    </form>
  </div>
</div>
<script>
  (function(){
    const templateSelect = document.getElementById('evangelismTemplateSelect');
    if(templateSelect){
      templateSelect.addEventListener('change', function(){
        const textarea = this.closest('form').querySelector('textarea[name="message"]');
        if(!textarea) return;
        const selected = this.value;
        if(selected){
          const leadSelect = this.closest('form').querySelector('select[name="lead_id"]');
          let name = '';
          if(leadSelect && leadSelect.value){
            const opt = leadSelect.options[leadSelect.selectedIndex].text;
            name = opt.split('(')[0].trim();
          }
          textarea.value = selected.replace('@{{name}}', name || 'friend');
        }
      });
    }
  })();
</script>
@endsection