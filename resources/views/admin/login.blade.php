<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — Laxmi Hardware Management</title>
  <link rel="icon" type="image/svg+xml" href="{{ asset('images/placeholder-hardware.svg') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: linear-gradient(135deg, #090e1a 0%, #0f172a 60%, #1e293b 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #f8fafc;
    }
    .login-card {
      background: #ffffff;
      color: #1e293b;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
      width: 100%;
      max-width: 440px;
    }
    .btn-gold {
      background: linear-gradient(135deg, #d97706, #b45309);
      color: #ffffff;
      font-weight: 700;
      border: none;
      padding: 12px;
      border-radius: 8px;
    }
    .btn-gold:hover {
      background: #b45309;
      color: #ffffff;
    }
  </style>
</head>
<body>

  <div class="container p-3">
    <div class="login-card mx-auto">
      <div class="bg-dark text-white p-4 text-center border-bottom border-warning border-4">
        <div class="rounded-circle bg-warning text-dark d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px;">
          <i class="bi bi-shield-lock-fill fs-4"></i>
        </div>
        <h4 class="fw-bold mb-0 text-white font-monospace">LAXMI HARDWARE</h4>
        <small class="text-warning text-uppercase fw-bold letter-spacing-1">Admin Management Portal</small>
      </div>

      <div class="p-4 p-md-5">
        @if(session('success'))
          <div class="alert alert-success small mb-3">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger small mb-3">{{ session('error') }}</div>
        @endif
        @if($errors->any())
          <div class="alert alert-danger small mb-3">
            <ul class="mb-0 ps-3">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label small fw-bold text-muted text-uppercase">Email Address</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
              <input type="email" name="email" class="form-control" placeholder="admin@laxmihardware.com" value="{{ old('email', 'admin@laxmihardware.com') }}" required autofocus>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-bold text-muted text-uppercase">Password</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted"><i class="bi bi-key"></i></span>
              <input type="password" name="password" class="form-control" placeholder="••••••••" value="Admin@12345" required>
            </div>
          </div>

          <div class="mb-4 form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="rememberMe" checked>
            <label class="form-check-label small text-muted" for="rememberMe">Remember my login</label>
          </div>

          <button type="submit" class="btn btn-gold w-100">
            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In to Portal
          </button>
        </form>

        <div class="text-center mt-4 pt-3 border-top small text-muted">
          <a href="{{ route('home') }}" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Return to Public Showcase
          </a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
