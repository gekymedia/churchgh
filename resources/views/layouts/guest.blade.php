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
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
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

    .alert-danger {
      background: linear-gradient(135deg, rgba(249, 65, 68, 0.15) 0%, rgba(249, 65, 68, 0.05) 100%);
      border-left: 4px solid var(--danger);
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
      max-width: 500px;
      width: 100%;
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
      font-size: 1.25rem;
    }

    .card-body {
      padding: 2rem;
      background: white;
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
      color: white;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
      color: white;
    }

    /* Form Styles */
    .form-label {
      font-weight: 600;
      color: var(--dark);
      margin-bottom: 0.5rem;
    }

    .form-control {
      border-radius: 8px;
      border: 1px solid var(--gray-light);
      padding: 0.75rem 1rem;
      transition: var(--transition);
    }

    .form-control:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 0.2rem rgba(67, 97, 240, 0.25);
      outline: none;
    }

    .invalid-feedback {
      display: block;
      color: var(--danger);
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }

    .is-invalid {
      border-color: var(--danger);
    }

    /* Container */
    .guest-container {
      width: 100%;
      max-width: 500px;
    }

    /* Logo/Brand */
    .guest-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .guest-logo {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      color: var(--primary);
      text-decoration: none;
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 1rem;
    }

    .guest-logo i {
      font-size: 2.5rem;
      background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      body {
        padding: 1rem;
      }
      
      .card-body {
        padding: 1.5rem;
      }
    }

    /* Animation */
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

    .guest-container > * {
      animation: fadeIn 0.3s ease-out;
    }
  </style>
  
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
  <div class="guest-container">
    <div class="guest-header">
      <a href="{{ route('login') }}" class="guest-logo">
        <i class="fas fa-church"></i>
        <span>ChurchGH</span>
      </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle me-2"></i>
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="fas fa-exclamation-circle me-2"></i>
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
