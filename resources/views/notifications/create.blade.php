@extends('layouts.app')
@section('title','Notifications')
@section('content')
<h3>Send Notification</h3>
<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('notifications.send') }}" class="row g-3">
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
      <div class="col-md-4">
        <label class="form-label">Member (leave blank to broadcast)</label>
        <select name="member_id" class="form-select" id="memberSelect" style="width: 100%;">
          <option value="">-- Select Member --</option>
          @foreach($members as $m)
            <option value="{{ $m->id }}" 
                    data-phone="{{ $m->phone }}" 
                    data-email="{{ $m->email }}">
              {{ $m->first_name }} {{ $m->last_name }} 
              @if($m->phone) ({{ $m->phone }}) @endif
              @if($m->email) [{{ $m->email }}] @endif
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="broadcast" value="1" id="broadcast">
          <label class="form-check-label" for="broadcast">Broadcast to all members</label>
        </div>
      </div>
      <div class="col-12" id="emailSubjectField" style="display: none;">
        <label class="form-label">Email Subject</label>
        <input type="text" name="subject" class="form-control" placeholder="Notification from ChurchGH">
      </div>
      <div class="col-12">
        <label class="form-label">Message</label>
        <!-- Template selection to quickly populate the message -->
        <select id="templateSelect" class="form-select mb-2">
          <option value="">-- Choose a template (optional) --</option>
          <option value="Hello @{{name}}, we hope you are doing well. We look forward to seeing you at our next service!">General Greeting</option>
          <option value="Hi @{{name}}, you're invited to our Sunday service this week at 9am. We'd love to worship with you!">Invitation to Service</option>
          <option value="Dear @{{name}}, remember that God cares for you. If you need prayer or support, please reach out to us.">Prayer & Support</option>
        </select>
        <textarea name="message" class="form-control" rows="4" required></textarea>
      </div>
      <div class="col-12">
        <button class="btn btn-primary">Send</button>
      </div>
    </form>
  </div>
</div>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<!-- jQuery and Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function(){
    // Initialize Select2 for member selection
    $('#memberSelect').select2({
      theme: 'bootstrap-5',
      placeholder: 'Search and select a member...',
      allowClear: true,
      width: '100%',
    });

    const templateSelect = document.getElementById('templateSelect');
    const channelSelect = document.querySelector('select[name="channel"]');
    const emailSubjectField = document.getElementById('emailSubjectField');
    
    // Show/hide email subject field based on channel
    if(channelSelect && emailSubjectField){
      function toggleEmailSubject(){
        emailSubjectField.style.display = channelSelect.value === 'email' ? 'block' : 'none';
      }
      channelSelect.addEventListener('change', toggleEmailSubject);
      toggleEmailSubject(); // Initial check
    }
    
    // Template selection
    if(templateSelect){
      templateSelect.addEventListener('change', function(){
        const textarea = this.closest('form').querySelector('textarea[name="message"]');
        if(!textarea) return;
        const selected = this.value;
        if(selected){
          const selectedMember = $('#memberSelect').select2('data');
          let name = '';
          if(selectedMember && selectedMember.length > 0){
            name = selectedMember[0].text.split('(')[0].trim().split('[')[0].trim();
          }
          textarea.value = selected.replace('{{"{{"}}name}}', name || 'friend');
        }
      });
    }
  });
</script>
@endsection