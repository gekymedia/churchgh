<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','ChurchGH - Church Management System')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --secondary: #3f37c9;
      --accent: #4cc9f0;
      --light: #f8f9fa;
      --dark: #212529;
      --success: #4bb543;
      --warning: #ffc107;
      --danger: #dc3545;
      --sidebar-width: 260px;
      --header-height: 70px;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f7fb;
      color: #333;
      overflow-x: hidden;
    }
    
    /* Sidebar Styles */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: var(--sidebar-width);
      background: linear-gradient(180deg, var(--primary) 0%, var(--secondary) 100%);
      color: white;
      z-index: 1000;
      transition: all 0.3s ease;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    
    .sidebar-header {
      padding: 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      height: var(--header-height);
    }
    
    .sidebar-header .logo {
      font-size: 1.5rem;
      font-weight: 700;
      color: white;
      text-decoration: none;
      display: flex;
      align-items: center;
    }
    
    .sidebar-header .logo i {
      margin-right: 10px;
      font-size: 1.8rem;
    }
    
    .sidebar-menu {
      padding: 15px 0;
      overflow-y: auto;
      height: calc(100vh - var(--header-height));
    }
    
    .sidebar-menu ul {
      list-style: none;
      padding: 0;
    }
    
    .sidebar-menu li {
      margin-bottom: 5px;
    }
    
    .sidebar-menu a {
      display: flex;
      align-items: center;
      padding: 12px 20px;
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      transition: all 0.3s;
      border-left: 3px solid transparent;
    }
    
    .sidebar-menu a:hover, .sidebar-menu a.active {
      background-color: rgba(255, 255, 255, 0.1);
      color: white;
      border-left: 3px solid var(--accent);
    }
    
    .sidebar-menu a i {
      margin-right: 12px;
      font-size: 1.1rem;
      width: 20px;
      text-align: center;
    }
    
    .sidebar-menu .dropdown-menu {
      background-color: rgba(0, 0, 0, 0.2);
      border: none;
      border-radius: 0;
      padding: 0;
      margin: 0;
    }
    
    .sidebar-menu .dropdown-menu a {
      padding-left: 50px;
    }
    
    /* Main Content Styles */
    .main-content {
      margin-left: var(--sidebar-width);
      padding: 20px;
      transition: all 0.3s;
    }
    
    .header {
      background-color: white;
      padding: 15px 30px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      margin-bottom: 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .page-title {
      font-size: 1.8rem;
      font-weight: 600;
      color: var(--dark);
      margin: 0;
    }
    
    .breadcrumb {
      background: transparent;
      padding: 0;
      margin: 0;
    }
    
    .breadcrumb-item a {
      color: var(--primary);
      text-decoration: none;
    }
    
    .user-info {
      display: flex;
      align-items: center;
    }
    
    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: var(--primary);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 10px;
      font-weight: bold;
    }
    
    /* Cards */
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      margin-bottom: 25px;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
      background-color: white;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      padding: 15px 20px;
      border-radius: 10px 10px 0 0 !important;
    }
    
    .card-title {
      font-size: 1.2rem;
      font-weight: 600;
      margin: 0;
      color: var(--dark);
    }
    
    /* Stats Cards */
    .stat-card {
      text-align: center;
      padding: 20px;
    }
    
    .stat-icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 15px;
      font-size: 1.5rem;
    }
    
    .stat-value {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 5px;
    }
    
    .stat-label {
      color: #6c757d;
      font-size: 0.9rem;
    }
    
    /* Buttons */
    .btn-primary {
      background-color: var(--primary);
      border-color: var(--primary);
    }
    
    .btn-primary:hover {
      background-color: var(--secondary);
      border-color: var(--secondary);
    }
    
    /* Alerts */
    .alert {
      border: none;
      border-radius: 10px;
      padding: 15px 20px;
    }
    
    /* Tables */
    .table {
      border-radius: 10px;
      overflow: hidden;
    }
    
    .table thead th {
      background-color: var(--primary);
      color: white;
      border: none;
      padding: 15px;
    }
    
    .table tbody td {
      padding: 15px;
      vertical-align: middle;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
      .sidebar {
        width: 70px;
        overflow: hidden;
      }
      
      .sidebar-header .logo span {
        display: none;
      }
      
      .sidebar-menu a span {
        display: none;
      }
      
      .sidebar-menu a i {
        margin-right: 0;
        font-size: 1.3rem;
      }
      
      .main-content {
        margin-left: 70px;
      }
    }
    
    @media (max-width: 768px) {
      .sidebar {
        width: 0;
      }
      
      .main-content {
        margin-left: 0;
      }
      
      .header {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .user-info {
        margin-top: 15px;
      }
    }
  </style>
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
  <script>
    // Add active class to current page in sidebar
    document.addEventListener('DOMContentLoaded', function() {
      const currentPath = window.location.pathname;
      const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
      
      sidebarLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
          link.classList.add('active');
          
          // Expand parent dropdown if this link is in a dropdown
          const parentDropdown = link.closest('.collapse');
          if (parentDropdown) {
            parentDropdown.classList.add('show');
          }
        }
      });
    });
  </script>
</body>
</html>