<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','ChurchGH - Church Management System')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="sidebar-header">
      <a href="{{ route('dashboard') }}" class="logo">
        <i class="fas fa-church"></i>
        <span>ChurchGH</span>
      </a>
    </div>
    <div class="sidebar-menu">
      <ul>
        <li>
          <a href="{{ route('dashboard') }}" class="active">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="{{ route('members.index') }}">
            <i class="fas fa-users"></i>
            <span>Members</span>
          </a>
        </li>
        <li>
          <a href="{{ route('services.index') }}">
            <i class="fas fa-pray"></i>
            <span>Services</span>
          </a>
        </li>
        <li>
          <a href="{{ route('attendances.index') }}">
            <i class="fas fa-clipboard-check"></i>
            <span>Attendance</span>
          </a>
        </li>
        <li>
          <a href="{{ route('events.index') }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Events</span>
          </a>
        </li>
        <li>
          <a href="#" data-bs-toggle="collapse" data-bs-target="#givingSubmenu">
            <i class="fas fa-hand-holding-usd"></i>
            <span>Giving</span>
            <i class="fas fa-chevron-down ms-auto"></i>
          </a>
          <ul class="collapse" id="givingSubmenu">
            <li>
              <a href="{{ route('tithes.index') }}">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Tithes</span>
              </a>
            </li>
            <li>
              <a href="{{ route('offerings.index') }}">
                <i class="fas fa-donate"></i>
                <span>Offerings</span>
              </a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#" data-bs-toggle="collapse" data-bs-target="#communicationsSubmenu">
            <i class="fas fa-bullhorn"></i>
            <span>Communications</span>
            <i class="fas fa-chevron-down ms-auto"></i>
          </a>
          <ul class="collapse" id="communicationsSubmenu">
            <li>
              <a href="{{ route('notifications.create') }}">
                <i class="fas fa-envelope"></i>
                <span>Member Messages</span>
              </a>
            </li>
            <li>
              <a href="{{ route('evangelism.create') }}">
                <i class="fas fa-cross"></i>
                <span>Evangelism Messages</span>
              </a>
            </li>
          </ul>
        </li>
        <li>
          <a href="{{ route('followups.index') }}">
            <i class="fas fa-tasks"></i>
            <span>Follow Ups</span>
          </a>
        </li>
        <li>
          <a href="{{ route('leads.index') }}">
            <i class="fas fa-user-plus"></i>
            <span>Leads</span>
          </a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header">
      <div>
        <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
            <li class="breadcrumb-item active">@yield('breadcrumb', 'Dashboard')</li>
          </ol>
        </nav>
      </div>
      <div class="user-info">
        <div class="user-avatar">AD</div>
        <div>
          <div class="fw-bold">Admin User</div>
          <small class="text-muted">Administrator</small>
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="content">
      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      
      @yield('content')
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>