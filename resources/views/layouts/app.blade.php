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
      --primary-light: #4895ef;
      --secondary: #3a0ca3;
      --accent: #7209b7;
      --accent-light: #f72585;
      --light: #f8f9fa;
      --dark: #212529;
      --gray: #6c757d;
      --gray-light: #e9ecef;
      --success: #4cc9f0;
      --warning: #f8961e;
      --danger: #f94144;
      --sidebar-width: 260px;
      --sidebar-collapsed: 70px;
      --header-height: 70px;
      --border-radius: 12px;
      --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
      min-height: 100vh;
      color: var(--dark);
      overflow-x: hidden;
    }

    /* Modern Sidebar */
    .sidebar {
      position: fixed;
      left: 0;
      top: 0;
      width: var(--sidebar-width);
      height: 100vh;
      background: linear-gradient(180deg, var(--primary) 0%, var(--secondary) 100%);
      color: white;
      padding: 1.5rem 0;
      z-index: 1000;
      transition: var(--transition);
      box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
    }

    .sidebar.collapsed {
      width: var(--sidebar-collapsed);
    }

    .sidebar-header {
      padding: 0 1.5rem 2rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      margin-bottom: 1rem;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 12px;
      color: white;
      text-decoration: none;
      font-size: 1.5rem;
      font-weight: 700;
    }

    .logo i {
      font-size: 2rem;
      background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .sidebar-menu ul {
      list-style: none;
      padding: 0;
    }

    .sidebar-menu li {
      position: relative;
      margin: 4px 1rem;
    }

    .sidebar-menu a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 16px;
      color: rgba(255, 255, 255, 0.9);
      text-decoration: none;
      border-radius: var(--border-radius);
      transition: var(--transition);
      font-weight: 500;
    }

    .sidebar-menu a:hover {
      background: rgba(255, 255, 255, 0.15);
      color: white;
      transform: translateX(4px);
    }

    .sidebar-menu a.active {
      background: rgba(255, 255, 255, 0.2);
      color: white;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .sidebar-menu a i:first-child {
      width: 24px;
      text-align: center;
      font-size: 1.2rem;
    }

    .sidebar-menu .fa-chevron-down {
      margin-left: auto;
      transition: var(--transition);
    }

    .sidebar-menu .collapse.show .fa-chevron-down {
      transform: rotate(180deg);
    }

    .sidebar-menu .collapse ul {
      margin-left: 40px;
      margin-top: 4px;
    }

    .sidebar-menu .collapse a {
      padding: 10px 16px;
      font-size: 0.9rem;
      background: rgba(0, 0, 0, 0.15);
    }

    /* Main Content */
    .main-content {
      margin-left: var(--sidebar-width);
      min-height: 100vh;
      transition: var(--transition);
    }

    .sidebar.collapsed ~ .main-content {
      margin-left: var(--sidebar-collapsed);
    }

    /* Ensure sidebar toggle moves with sidebar */
    body:has(.sidebar.collapsed) .sidebar-toggle {
      left: calc(var(--sidebar-collapsed) - 30px);
    }

    /* Modern Header */
    .header {
      height: var(--header-height);
      background: white;
      padding: 0 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
      position: sticky;
      top: 0;
      z-index: 999;
      backdrop-filter: blur(10px);
    }

    .page-title {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--dark);
      margin: 0;
      background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .breadcrumb {
      background: transparent;
      padding: 0;
      margin-top: 4px;
    }

    .breadcrumb-item a {
      color: var(--gray);
      text-decoration: none;
      transition: var(--transition);
    }

    .breadcrumb-item a:hover {
      color: var(--primary);
    }

    /* User Info */
    .user-info {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 8px 16px;
      background: var(--light);
      border-radius: 50px;
      cursor: pointer;
      transition: var(--transition);
    }

    .user-info:hover {
      background: var(--gray-light);
      transform: translateY(-1px);
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--accent-light) 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 1.1rem;
    }

    /* Content Area */
    .content {
      padding: 2rem;
      min-height: calc(100vh - var(--header-height));
    }

    /* Modern Alerts */
    .alert {
      border: none;
      border-radius: var(--border-radius);
      padding: 1rem 1.25rem;
      margin-bottom: 1.5rem;
      box-shadow: var(--card-shadow);
      backdrop-filter: blur(10px);
    }

    .alert-success {
      background: linear-gradient(135deg, rgba(76, 201, 240, 0.15) 0%, rgba(76, 201, 240, 0.05) 100%);
      border-left: 4px solid var(--success);
    }

    .alert i {
      font-size: 1.2rem;
    }

    /* Modern Cards */
    .card {
      border: none;
      border-radius: var(--border-radius);
      box-shadow: var(--card-shadow);
      transition: var(--transition);
      overflow: hidden;
      margin-bottom: 1.5rem;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .card-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
      color: white;
      border: none;
      padding: 1.25rem 1.5rem;
      font-weight: 600;
    }

    /* Modern Buttons */
    .btn {
      border-radius: 8px;
      padding: 10px 24px;
      font-weight: 600;
      transition: var(--transition);
      border: none;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
      border: none;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
    }

    /* Stats Cards */
    .stat-card {
      background: white;
      border-radius: var(--border-radius);
      padding: 1.5rem;
      box-shadow: var(--card-shadow);
      display: flex;
      align-items: center;
      gap: 1rem;
      transition: var(--transition);
    }

    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .stat-icon {
      width: 60px;
      height: 60px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: white;
    }

    .stat-content h3 {
      font-size: 1.8rem;
      font-weight: 700;
      margin: 0;
      color: var(--dark);
    }

    .stat-content p {
      color: var(--gray);
      margin: 0;
      font-size: 0.9rem;
    }

    /* Modern Table */
    .table {
      border-radius: var(--border-radius);
      overflow: hidden;
      box-shadow: var(--card-shadow);
    }

    .table thead th {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
      color: white;
      border: none;
      padding: 1rem;
      font-weight: 600;
    }

    .table tbody tr {
      transition: var(--transition);
    }

    .table tbody tr:hover {
      background-color: rgba(67, 97, 238, 0.05);
    }

    /* Toggle Button */
    .sidebar-toggle {
      position: fixed;
      bottom: 2rem;
      left: calc(var(--sidebar-width) - 30px);
      width: 40px;
      height: 40px;
      background: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      transition: var(--transition);
      z-index: 1001;
      color: var(--primary);
      font-size: 1.1rem;
    }

    .sidebar.collapsed ~ .sidebar-toggle {
      left: calc(var(--sidebar-collapsed) - 30px);
    }

    .sidebar-toggle:hover {
      background: var(--primary);
      color: white;
      transform: scale(1.1);
    }


    /* Responsive Design */
    @media (max-width: 992px) {
      .sidebar {
        transform: translateX(-100%);
      }
      
      .sidebar.show {
        transform: translateX(0);
      }
      
      .main-content {
        margin-left: 0;
      }
      
      .sidebar-toggle {
        display: none;
      }
    }

    @media (max-width: 768px) {
      .header {
        padding: 0 1rem;
      }
      
      .content {
        padding: 1rem;
      }
      
      .page-title {
        font-size: 1.5rem;
      }
    }

    /* Animation for sidebar collapse */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .content > * {
      animation: fadeIn 0.3s ease-out;
    }
  </style>
  
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
  <!-- Sidebar Toggle -->
  <div class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
    <i class="fas fa-bars"></i>
  </div>

  <!-- Modern Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <a href="{{ route('dashboard') }}" class="logo">
        <i class="fas fa-church"></i>
        <span>ChurchGH</span>
      </a>
    </div>
    <div class="sidebar-menu">
      <ul>
        @auth
          @if(auth()->user()->role !== 'member')
            <li>
              <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
              </a>
            </li>
          @else
            <li>
              <a href="{{ route('member.dashboard') }}" class="{{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
              </a>
            </li>
          @endif
        @else
          <li>
            <a href="{{ route('dashboard') }}" class="active">
              <i class="fas fa-home"></i>
              <span>Dashboard</span>
            </a>
          </li>
        @endauth
        @auth
          @if(auth()->user()->role !== 'member')
            <li>
              <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Members</span>
              </a>
            </li>
            <li>
              <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">
                <i class="fas fa-pray"></i>
                <span>Services</span>
              </a>
            </li>
            <li>
              <a href="{{ route('attendances.index') }}" class="{{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check"></i>
                <span>Attendance</span>
              </a>
            </li>
            <li>
              <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Events</span>
              </a>
            </li>
            <li>
              <a href="#" data-bs-toggle="collapse" data-bs-target="#givingSubmenu" class="{{ request()->routeIs('tithes.*') || request()->routeIs('offerings.*') || request()->routeIs('giving.*') ? 'active' : '' }}">
                <i class="fas fa-hand-holding-usd"></i>
                <span>Giving</span>
                <i class="fas fa-chevron-down ms-auto"></i>
              </a>
              <ul class="collapse {{ request()->routeIs('tithes.*') || request()->routeIs('offerings.*') || request()->routeIs('giving.*') ? 'show' : '' }}" id="givingSubmenu">
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
                <li>
                  <a href="{{ route('giving.index') }}">
                    <i class="fas fa-list"></i>
                    <span>All Givings</span>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#" data-bs-toggle="collapse" data-bs-target="#communicationsSubmenu" class="{{ request()->routeIs('notifications.*') || request()->routeIs('evangelism.*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn"></i>
                <span>Communications</span>
                <i class="fas fa-chevron-down ms-auto"></i>
              </a>
              <ul class="collapse {{ request()->routeIs('notifications.*') || request()->routeIs('evangelism.*') ? 'show' : '' }}" id="communicationsSubmenu">
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
              <a href="{{ route('followups.index') }}" class="{{ request()->routeIs('followups.*') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i>
                <span>Follow Ups</span>
              </a>
            </li>
            <li>
              <a href="{{ route('leads.index') }}" class="{{ request()->routeIs('leads.*') ? 'active' : '' }}">
                <i class="fas fa-user-plus"></i>
                <span>Leads</span>
              </a>
            </li>
          @else
            {{-- Member menu items --}}
            <li>
              <a href="{{ route('giving.create') }}" class="{{ request()->routeIs('giving.*') ? 'active' : '' }}">
                <i class="fas fa-hand-holding-usd"></i>
                <span>Give Online</span>
              </a>
            </li>
          @endif
        @endauth
        @auth
          @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pastor' || auth()->user()->role === 'leader')
            <li>
              <a href="{{ route('church-leaders.index') }}" class="{{ request()->routeIs('church-leaders.*') ? 'active' : '' }}">
                <i class="fas fa-user-tie"></i>
                <span>Church Leaders</span>
              </a>
            </li>
            <li>
              <a href="{{ route('shepherds.assign') }}" class="{{ request()->routeIs('shepherds.*') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i>
                <span>Assign Shepherds</span>
              </a>
            </li>
            <li>
              <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
              </a>
            </li>
          @endif
          @if(auth()->user()->isShepherd())
            <li>
              <a href="{{ route('shepherd.flock') }}" class="{{ request()->routeIs('shepherd.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>My Flock</span>
              </a>
            </li>
          @endif
        @endauth
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
        <div class="user-avatar">
          @auth
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
          @else
            AD
          @endauth
        </div>
        <div>
          <div class="fw-bold">
            @auth
              {{ auth()->user()->name }}
            @else
              Admin User
            @endauth
          </div>
          <small class="text-muted">
            @auth
              {{ ucfirst(auth()->user()->role) }}
            @else
              Administrator
            @endauth
          </small>
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
    // Sidebar toggle functionality
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    
    if (sidebarToggle && sidebar) {
      sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        const icon = this.querySelector('i');
        if (icon) {
          // Toggle between bars and arrow icons
          if (sidebar.classList.contains('collapsed')) {
            icon.className = 'fas fa-arrow-right';
            this.title = 'Expand Sidebar';
          } else {
            icon.className = 'fas fa-bars';
            this.title = 'Collapse Sidebar';
          }
        }
      });
    }

    // Mobile sidebar toggle
    if (window.innerWidth < 992) {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.add('show');
      
      document.querySelectorAll('.sidebar-menu a').forEach(link => {
        link.addEventListener('click', () => {
          if (window.innerWidth < 992) {
            sidebar.classList.remove('show');
          }
        });
      });
    }

    // Active menu highlighting
    document.addEventListener('DOMContentLoaded', function() {
      const currentPath = window.location.pathname;
      const links = document.querySelectorAll('.sidebar-menu a[href]');
      
      links.forEach(link => {
        const href = link.getAttribute('href');
        if (href && (href === currentPath || currentPath.startsWith(href + '/'))) {
          link.classList.add('active');
          // Also mark parent menu items as active
          const parent = link.closest('li');
          if (parent) {
            parent.querySelector('a')?.classList.add('active');
          }
        } else {
          link.classList.remove('active');
        }
      });
    });

    // Smooth animations
    document.querySelectorAll('.sidebar-menu a').forEach(link => {
      link.addEventListener('click', function(e) {
        if (this.getAttribute('href') === '#') return;
        
        const content = document.querySelector('.content');
        content.style.opacity = '0.5';
        
        setTimeout(() => {
          content.style.opacity = '1';
        }, 300);
      });
    });
  </script>
</body>
</html>