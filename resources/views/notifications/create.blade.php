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
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Member (leave blank to broadcast)</label>
        <select name="member_id" class="form-select">
          <option value="">-- Select Member --</option>
          @foreach($members as $m)
            <option value="{{ $m->id }}">{{ $m->first_name }} {{ $m->last_name }} ({{ $m->phone }})</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="broadcast" value="1" id="broadcast">
          <label class="form-check-label" for="broadcast">Broadcast to all members</label>
        </div>
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

<!-- Inline script: populate message textarea from template -->
<script>
  (function(){
    const templateSelect = document.getElementById('templateSelect');
    if(templateSelect){
      templateSelect.addEventListener('change', function(){
        const textarea = this.closest('form').querySelector('textarea[name="message"]');
        if(!textarea) return;
        const selected = this.value;
        if(selected){
          const memberSelect = this.closest('form').querySelector('select[name="member_id"]');
          let name = '';
          if(memberSelect && memberSelect.value){
            // Get selected option text and extract name (before first parenthesis)
            const opt = memberSelect.options[memberSelect.selectedIndex].text;
            name = opt.split('(')[0].trim();
          }
          textarea.value = selected.replace('{{"{{"}}name}}', name || 'friend');
        }
      });
    }
  })();
</script>
@endsection