<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Dashboard') — Laxmi Hardware Management</title>
  
  <!-- Favicon -->
  @if(\App\Models\Setting::get('favicon'))
    <link rel="icon" href="{{ image_url(\App\Models\Setting::get('favicon')) }}">
  @else
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/placeholder-hardware.svg') }}">
  @endif

  <!-- Google Fonts & Bootstrap 5 & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --admin-sidebar-bg: #0f172a;
      --admin-sidebar-hover: #1e293b;
      --admin-sidebar-active: #d97706;
      --admin-accent: #d97706;
      --admin-bg: #f8fafc;
      --admin-text-dark: #0f172a;
      --admin-font: 'Plus Jakarta Sans', sans-serif;
      --admin-heading: 'Outfit', sans-serif;
    }

    body {
      font-family: var(--admin-font);
      background-color: var(--admin-bg);
      color: #334155;
      min-height: 100vh;
      overflow-x: hidden;
    }

    h1, h2, h3, h4, h5, h6 {
      font-family: var(--admin-heading);
      color: var(--admin-text-dark);
      font-weight: 700;
    }

    /* Sidebar */
    .admin-sidebar {
      width: 270px;
      min-height: 100vh;
      background: var(--admin-sidebar-bg);
      color: #94a3b8;
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      z-index: 1040;
      overflow-y: auto;
      transition: all 0.3s ease;
      border-right: 1px solid rgba(255, 255, 255, 0.05);
    }

    .admin-brand {
      padding: 24px 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
    }

    .admin-brand-icon {
      width: 40px;
      height: 40px;
      background: rgba(217, 119, 6, 0.15);
      border: 1px solid var(--admin-accent);
      border-radius: 8px;
      color: var(--admin-accent);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
    }

    .admin-brand-title {
      font-family: var(--admin-heading);
      font-weight: 800;
      font-size: 1.15rem;
      color: #ffffff;
      line-height: 1.1;
      letter-spacing: -0.01em;
    }

    .admin-brand-sub {
      font-size: 0.65rem;
      font-weight: 700;
      color: var(--admin-accent);
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .admin-menu-heading {
      font-size: 0.68rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      color: #475569;
      padding: 18px 24px 8px;
    }

    .admin-nav-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
      margin: 2px 14px;
      border-radius: 8px;
      color: #cbd5e1;
      text-decoration: none;
      font-size: 0.88rem;
      font-weight: 600;
      transition: all 0.2s ease;
    }

    .admin-nav-item:hover {
      background: var(--admin-sidebar-hover);
      color: #ffffff;
    }

    .admin-nav-item.active {
      background: linear-gradient(135deg, var(--admin-accent), #b45309);
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
    }

    .admin-nav-item i {
      font-size: 1.1rem;
      width: 24px;
    }

    /* Submenu */
    .admin-submenu {
      list-style: none;
      padding-left: 36px;
      margin: 4px 0;
    }

    .admin-submenu a {
      display: block;
      padding: 7px 14px;
      color: #94a3b8;
      text-decoration: none;
      font-size: 0.83rem;
      font-weight: 500;
      border-radius: 6px;
      transition: all 0.2s ease;
    }

    .admin-submenu a:hover, .admin-submenu a.active {
      color: var(--admin-accent);
      background: rgba(217, 119, 6, 0.08);
    }

    /* Main Content Wrapper */
    .admin-main-wrapper {
      margin-left: 270px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      transition: margin 0.3s ease;
    }

    .admin-header {
      background: #ffffff;
      border-bottom: 1px solid #e2e8f0;
      padding: 14px 28px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 1020;
    }

    .admin-content {
      padding: 30px 28px;
      flex-grow: 1;
    }

    .card {
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
    }

    .badge-status {
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 700;
    }

    /* Mobile toggle */
    @media (max-width: 991.98px) {
      .admin-sidebar {
        transform: translateX(-100%);
      }
      .admin-sidebar.show {
        transform: translateX(0);
      }
      .admin-main-wrapper {
        margin-left: 0;
      }
    }
  </style>
  @stack('styles')
</head>
<body>

  <!-- Sidebar -->
  <aside class="admin-sidebar" id="adminSidebar">
    <a href="{{ route('admin.dashboard') }}" class="admin-brand">
      @if(\App\Models\Setting::get('logo'))
        <img src="{{ image_url(\App\Models\Setting::get('logo')) }}" alt="Logo" style="max-height: 38px; max-width: 140px; object-fit: contain;">
      @else
        <div class="admin-brand-icon">
          <i class="bi bi-shield-lock-fill"></i>
        </div>
      @endif
      <div>
        <div class="admin-brand-title">{{ \App\Models\Setting::get('site_name', 'LAXMI HARDWARE') }}</div>
        <div class="admin-brand-sub">Management Portal</div>
      </div>
    </a>

    <div class="py-3">
      <div class="admin-menu-heading">Main</div>
      <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span><i class="bi bi-speedometer2 me-2"></i> Dashboard</span>
      </a>

      <div class="admin-menu-heading">Catalogue Management</div>
      
      <!-- Products dropdown -->
      <a class="admin-nav-item {{ request()->routeIs('admin.products.*') ? 'text-white' : '' }}" data-bs-toggle="collapse" href="#prodMenu" role="button" aria-expanded="{{ request()->routeIs('admin.products.*') ? 'true' : 'false' }}">
        <span><i class="bi bi-box-seam me-2"></i> Products</span>
        <i class="bi bi-chevron-down small"></i>
      </a>
      <div class="collapse {{ request()->routeIs('admin.products.*') ? 'show' : '' }}" id="prodMenu">
        <ul class="admin-submenu">
          <li><a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.index') ? 'active' : '' }}">All Products</a></li>
          <li><a href="{{ route('admin.products.create') }}" class="{{ request()->routeIs('admin.products.create') ? 'active' : '' }}">Add Product</a></li>
        </ul>
      </div>

      <a href="{{ route('admin.categories.index') }}" class="admin-nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <span><i class="bi bi-grid-fill me-2"></i> Categories</span>
      </a>

      <a href="{{ route('admin.subcategories.index') }}" class="admin-nav-item {{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}">
        <span><i class="bi bi-diagram-3-fill me-2"></i> Subcategories</span>
      </a>

      <a href="{{ route('admin.brands.index') }}" class="admin-nav-item {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
        <span><i class="bi bi-award-fill me-2"></i> Brands</span>
      </a>

      <div class="admin-menu-heading">Showcase & Content</div>

      <a href="{{ route('admin.services.index') }}" class="admin-nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
        <span><i class="bi bi-gear-fill me-2"></i> Services</span>
      </a>

      <a href="{{ route('admin.projects.index') }}" class="admin-nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
        <span><i class="bi bi-buildings-fill me-2"></i> Projects</span>
      </a>

      <a href="{{ route('admin.gallery.index') }}" class="admin-nav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
        <span><i class="bi bi-images me-2"></i> Gallery</span>
      </a>

      <!-- Blog dropdown -->
      <a class="admin-nav-item {{ request()->routeIs('admin.blog.*') || request()->routeIs('admin.blog-categories.*') ? 'text-white' : '' }}" data-bs-toggle="collapse" href="#blogMenu" role="button" aria-expanded="{{ request()->routeIs('admin.blog.*') ? 'true' : 'false' }}">
        <span><i class="bi bi-journal-text me-2"></i> Blog CMS</span>
        <i class="bi bi-chevron-down small"></i>
      </a>
      <div class="collapse {{ request()->routeIs('admin.blog.*') || request()->routeIs('admin.blog-categories.*') ? 'show' : '' }}" id="blogMenu">
        <ul class="admin-submenu">
          <li><a href="{{ route('admin.blog.index') }}" class="{{ request()->routeIs('admin.blog.index') ? 'active' : '' }}">Articles</a></li>
          <li><a href="{{ route('admin.blog.create') }}" class="{{ request()->routeIs('admin.blog.create') ? 'active' : '' }}">Add Article</a></li>
          <li><a href="{{ route('admin.blog-categories.index') }}" class="{{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}">Blog Categories</a></li>
        </ul>
      </div>

      <a href="{{ route('admin.testimonials.index') }}" class="admin-nav-item {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
        <span><i class="bi bi-chat-quote-fill me-2"></i> Testimonials</span>
      </a>

      <div class="admin-menu-heading">Lead Inquiries</div>

      @php
        $newEnquiriesCount = \App\Models\Contact::where('status', 'New')->count();
        $newQuotesCount = \App\Models\QuoteRequest::where('status', 'New')->count();
      @endphp

      <a href="{{ route('admin.enquiries.index') }}" class="admin-nav-item {{ request()->routeIs('admin.enquiries.*') ? 'active' : '' }}">
        <span><i class="bi bi-envelope-fill me-2"></i> Enquiries</span>
        @if($newEnquiriesCount > 0)
          <span class="badge bg-danger rounded-pill">{{ $newEnquiriesCount }}</span>
        @endif
      </a>

      <a href="{{ route('admin.quotes.index') }}" class="admin-nav-item {{ request()->routeIs('admin.quotes.*') ? 'active' : '' }}">
        <span><i class="bi bi-file-earmark-text-fill me-2"></i> Quote Requests</span>
        @if($newQuotesCount > 0)
          <span class="badge bg-warning text-dark rounded-pill">{{ $newQuotesCount }}</span>
        @endif
      </a>

      <div class="admin-menu-heading">System & Settings</div>

      <a href="{{ route('admin.settings.index') }}" class="admin-nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
        <span><i class="bi bi-sliders me-2"></i> Website Settings</span>
      </a>

      <a href="{{ route('admin.profile.edit') }}" class="admin-nav-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
        <span><i class="bi bi-person-circle me-2"></i> Admin Profile</span>
      </a>

      <div class="p-3 mt-4">
        <form action="{{ route('admin.logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-outline-danger w-100 btn-sm py-2">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
          </button>
        </form>
      </div>
    </div>
  </aside>

  <!-- Main Wrapper -->
  <div class="admin-main-wrapper">
    <!-- Top Header -->
    <header class="admin-header">
      <div class="d-flex align-items-center gap-3">
        <button class="btn btn-sm btn-light border d-lg-none" id="toggleSidebarBtn">
          <i class="bi bi-list fs-5"></i>
        </button>
        <span class="fw-bold fs-5 text-dark">@yield('page_title', 'Dashboard')</span>
      </div>

      <div class="d-flex align-items-center gap-3">
        <!-- External Website Link -->
        <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1">
          <i class="bi bi-arrow-up-right-square"></i> <span class="d-none d-sm-inline">Visit Website</span>
        </a>

        <!-- Admin user profile dropdown -->
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle gap-2" data-bs-toggle="dropdown">
            <div class="rounded-circle bg-dark text-warning d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px;">
              {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="d-none d-md-block text-start">
              <div class="small fw-bold lh-1">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</div>
              <small class="text-muted" style="font-size: 0.72rem;">{{ Auth::guard('admin')->user()->role ?? 'Administrator' }}</small>
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
            <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}"><i class="bi bi-person me-2"></i> My Profile</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="bi bi-sliders me-2"></i> Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </header>

    <!-- Flash Messages -->
    <div class="container-fluid px-4 pt-3">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
          <i class="bi bi-check-circle-fill me-2 fs-5"></i>
          <div>{{ session('success') }}</div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
          <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
          <div>{{ session('error') }}</div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      @if(isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
          <ul class="mb-0">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
    </div>

    <!-- Admin Content Area -->
    <div class="admin-content">
      @yield('content')
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const toggleBtn = document.getElementById('toggleSidebarBtn');
      const sidebar = document.getElementById('adminSidebar');
      if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
          sidebar.classList.toggle('show');
        });
      }

      // Global Bulk Selection Handler
      const selectAllCb = document.getElementById('selectAll');
      const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
      const selectedCountSpan = document.getElementById('selectedCount');

      function updateBulkUI() {
        const itemCbs = document.querySelectorAll('.select-item');
        const checkedCbs = document.querySelectorAll('.select-item:checked');
        const count = checkedCbs.length;

        if (selectedCountSpan) selectedCountSpan.textContent = count;
        if (bulkDeleteBtn) {
          if (count > 0) {
            bulkDeleteBtn.classList.remove('d-none');
          } else {
            bulkDeleteBtn.classList.add('d-none');
          }
        }

        if (selectAllCb && itemCbs.length > 0) {
          selectAllCb.checked = (itemCbs.length === count);
          selectAllCb.indeterminate = (count > 0 && count < itemCbs.length);
        }
      }

      if (selectAllCb) {
        selectAllCb.addEventListener('change', function () {
          const itemCbs = document.querySelectorAll('.select-item');
          itemCbs.forEach(cb => { cb.checked = selectAllCb.checked; });
          updateBulkUI();
        });
      }

      document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('select-item')) {
          updateBulkUI();
        }
      });

      window.submitBulkDelete = function (formId = 'bulkForm') {
        const checkedCbs = document.querySelectorAll('.select-item:checked');
        if (checkedCbs.length === 0) {
          alert('Please select at least one item to delete.');
          return;
        }
        if (confirm(`Are you sure you want to delete ${checkedCbs.length} selected item(s)? This action cannot be undone.`)) {
          const form = document.getElementById(formId);
          if (form) {
            // Remove any old hidden ids[] inputs from form
            form.querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());
            // Append checked IDs as hidden inputs into form
            checkedCbs.forEach(cb => {
              const hiddenInput = document.createElement('input');
              hiddenInput.type = 'hidden';
              hiddenInput.name = 'ids[]';
              hiddenInput.value = cb.value;
              form.appendChild(hiddenInput);
            });
            form.submit();
          }
        }
      };
    });
  </script>
  @stack('scripts')
</body>
</html>
