@extends('layouts.app')
@section('title','Evangelism Messages')
@section('content')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

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
          <option value="telegram">Telegram</option>
          <option value="gekychat">GekyChat</option>
          <option value="email">Email</option>
        </select>
      </div>
      <div class="col-md-5">
        <label class="form-label">Select Leads (leave blank to broadcast to all)</label>
        <select name="lead_ids[]" class="form-select" id="leadSelect" multiple style="width: 100%;">
          @foreach($leads as $lead)
            <option value="{{ $lead->id }}" 
                    data-phone="{{ $lead->phone }}" 
                    data-email="{{ $lead->email }}">
              {{ $lead->name }} 
              @if($lead->phone) ({{ $lead->phone }}) @endif
              @if($lead->email) [{{ $lead->email }}] @endif
            </option>
          @endforeach
        </select>
        <small class="text-muted">Search and select multiple leads, or leave empty to broadcast to all</small>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="broadcast" value="1" id="broadcast">
          <label class="form-check-label" for="broadcast">Broadcast to all leads</label>
        </div>
      </div>
      <div class="col-12" id="emailSubjectField" style="display: none;">
        <label class="form-label">Email Subject</label>
        <input type="text" name="subject" class="form-control" placeholder="Message from ChurchGH">
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

<!-- jQuery and Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function(){
    // Initialize Select2 for lead selection
    $('#leadSelect').select2({
      theme: 'bootstrap-5',
      placeholder: 'Search and select leads...',
      allowClear: true,
      width: '100%',
      closeOnSelect: false,
      tags: false,
    });

    const templateSelect = document.getElementById('evangelismTemplateSelect');
    const channelSelect = document.querySelector('select[name="channel"]');
    const emailSubjectField = document.getElementById('emailSubjectField');
    const broadcastCheckbox = document.getElementById('broadcast');
    const leadSelect = document.getElementById('leadSelect');
    
    // Show/hide email subject field based on channel
    if(channelSelect && emailSubjectField){
      function toggleEmailSubject(){
        emailSubjectField.style.display = channelSelect.value === 'email' ? 'block' : 'none';
      }
      channelSelect.addEventListener('change', toggleEmailSubject);
      toggleEmailSubject(); // Initial check
    }
    
    // Disable/enable lead select based on broadcast checkbox
    if(broadcastCheckbox){
      function toggleLeadSelect(){
        const isBroadcast = broadcastCheckbox.checked;
        if(isBroadcast){
          $('#leadSelect').val(null).trigger('change').prop('disabled', true);
        } else {
          $('#leadSelect').prop('disabled', false);
        }
      }
      broadcastCheckbox.addEventListener('change', toggleLeadSelect);
      toggleLeadSelect(); // Initial check
    }
    
    // Template selection
    if(templateSelect){
      templateSelect.addEventListener('change', function(){
        const textarea = this.closest('form').querySelector('textarea[name="message"]');
        if(!textarea) return;
        const selected = this.value;
        if(selected){
          // Get first selected lead name if any
          const selectedLeads = $('#leadSelect').select2('data');
          let name = '';
          if(selectedLeads && selectedLeads.length > 0){
            name = selectedLeads[0].text.split('(')[0].trim().split('[')[0].trim();
          }
          textarea.value = selected.replace('@{{name}}', name || 'friend');
        }
      });
    }
    
    // Update template when leads are selected
    $('#leadSelect').on('select2:select select2:unselect', function(){
      const templateSelect = document.getElementById('evangelismTemplateSelect');
      if(templateSelect && templateSelect.value){
        // Re-apply template with current selection
        templateSelect.dispatchEvent(new Event('change'));
      }
    });
  });
</script>
@endsection