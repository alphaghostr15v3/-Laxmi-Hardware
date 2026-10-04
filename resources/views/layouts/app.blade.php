<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>@yield('title', \App\Models\Setting::get('meta_title', 'Laxmi Hardware — Premium Interior Hardware Solutions'))</title>
  <meta name="description" content="@yield('meta_description', \App\Models\Setting::get('meta_description', 'Premium architectural hardware, modular kitchen fittings, marine plywood, bathroom fittings, and interior solutions in Surat.'))">
  <meta name="keywords" content="{{ \App\Models\Setting::get('meta_keywords', 'interior hardware, cabinet hinges, kitchen tandem drawers, wardrobe fittings, marine plywood, curtain tracks, bathroom fittings, plumbing pipes, Surat') }}">
  <link rel="canonical" href="{{ url()->current() }}">

  <!-- Open Graph -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:title" content="@yield('title', \App\Models\Setting::get('meta_title', 'Laxmi Hardware'))">
  <meta property="og:description" content="@yield('meta_description', \App\Models\Setting::get('meta_description'))">

  <!-- Favicon -->
  @if(\App\Models\Setting::get('favicon'))
    <link rel="icon" href="{{ image_url(\App\Models\Setting::get('favicon')) }}">
  @else
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/placeholder-hardware.svg') }}">
  @endif

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

  <!-- Bootstrap Icons & Font Awesome (for icons only) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

  <!-- Apple-Style Design System -->
  <link href="{{ asset('css/apple-style.css') }}" rel="stylesheet">

  @stack('styles')
</head>
<body>


  <!-- ── Apple-Style Navigation ──────────────────────────── -->
  <nav class="apple-nav" id="mainNav">
    <div class="apple-nav__inner">

      <!-- Logo -->
      <a href="{{ route('home') }}" class="apple-nav__logo">
        @if(\App\Models\Setting::get('logo'))
          <img src="{{ image_url(\App\Models\Setting::get('logo')) }}" alt="{{ \App\Models\Setting::get('site_name', 'Laxmi Hardware') }}" class="apple-nav__logo-img">
        @else
          <div class="apple-nav__logo-icon">L</div>
          <div class="apple-nav__logo-text">
            <span class="apple-nav__logo-name">{{ \App\Models\Setting::get('site_name', 'Laxmi Hardware') }}</span>
            <span class="apple-nav__logo-sub">Interior Solutions</span>
          </div>
        @endif
      </a>

      <!-- Desktop Nav Links -->
      <ul class="apple-nav__links">
        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
        <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
        <li><a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Products</a></li>
        <li><a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">Categories</a></li>
        <li><a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">Services</a></li>
        <li><a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'active' : '' }}">Projects</a></li>
        <li><a href="{{ route('gallery.index') }}" class="{{ request()->routeIs('gallery.index') ? 'active' : '' }}">Gallery</a></li>
        <li><a href="{{ route('brands.index') }}" class="{{ request()->routeIs('brands.*') ? 'active' : '' }}">Brands</a></li>
        <li><a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a></li>
        <li><a href="{{ route('contact.index') }}" class="{{ request()->routeIs('contact.*') ? 'active' : '' }}">Contact</a></li>
      </ul>

      <!-- Actions -->
      <div class="apple-nav__actions">
        <button class="apple-nav__search-btn" id="searchToggle" aria-label="Search">
          <i class="bi bi-search"></i>
        </button>
        <a href="{{ route('quote.index') }}" class="apple-nav__cta">Request a Quote</a>
        <button class="apple-nav__hamburger" id="mobileMenuToggle" aria-label="Menu">
          <span></span><span></span><span></span>
        </button>
      </div>

    </div>
  </nav>

  <!-- ── Mobile Menu ────────────────────────────────────── -->
  <div class="apple-nav__mobile" id="mobileMenu">
    <ul class="apple-nav__mobile-links">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li><a href="{{ route('about') }}">About</a></li>
      <li><a href="{{ route('products.index') }}">Products</a></li>
      <li><a href="{{ route('categories.index') }}">Categories</a></li>
      <li><a href="{{ route('services.index') }}">Services</a></li>
      <li><a href="{{ route('projects.index') }}">Projects</a></li>
      <li><a href="{{ route('gallery.index') }}">Gallery</a></li>
      <li><a href="{{ route('brands.index') }}">Brands</a></li>
      <li><a href="{{ route('blog.index') }}">Blog</a></li>
      <li><a href="{{ route('contact.index') }}">Contact</a></li>
    </ul>
    <a href="{{ route('quote.index') }}" class="apple-nav__mobile-cta">Request a Quote →</a>
  </div>

  <!-- ── Search Overlay ────────────────────────────────── -->
  <div class="apple-search-overlay" id="searchOverlay">
    <div class="apple-search-overlay__inner">
      <form action="{{ route('products.index') }}" method="GET">
        <div class="apple-search-overlay__input-wrap">
          <i class="bi bi-search" style="color:#a1a1a6;font-size:18px;"></i>
          <input
            type="text"
            name="search"
            class="apple-search-overlay__input"
            placeholder="Search hinges, tandem box, plywood, locks…"
            id="searchInput"
            autocomplete="off"
          >
          <button type="button" class="apple-search-overlay__close" id="searchClose">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
      </form>
      <div class="apple-search-overlay__tags">
        <span style="font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:#6e6e73;margin-right:8px;align-self:center;">Popular:</span>
        <a href="{{ route('products.index', ['search' => 'Hinges']) }}" class="apple-search-overlay__tag">Hinges</a>
        <a href="{{ route('products.index', ['search' => 'Tandem']) }}" class="apple-search-overlay__tag">Tandem Box</a>
        <a href="{{ route('products.index', ['search' => 'Plywood']) }}" class="apple-search-overlay__tag">Marine Plywood</a>
        <a href="{{ route('products.index', ['search' => 'Lock']) }}" class="apple-search-overlay__tag">Smart Locks</a>
        <a href="{{ route('products.index', ['search' => 'Basin']) }}" class="apple-search-overlay__tag">Bathroom Faucets</a>
        <a href="{{ route('products.index', ['search' => 'CPVC']) }}" class="apple-search-overlay__tag">CPVC Pipes</a>
      </div>
    </div>
  </div>

  {{-- ── Flash Alerts ──────────────────────────────────── --}}
  @if(session('success') || session('error'))
    <div id="flashToast" style="position:fixed;top:80px;right:24px;z-index:88888;max-width:400px;animation:slideInRight .4s cubic-bezier(.25,.46,.45,.94) both;">
      @if(session('success'))
        <div style="background:#0d1f0d;border:1px solid rgba(52,199,89,0.35);border-radius:14px;padding:16px 20px;display:flex;align-items:flex-start;gap:12px;box-shadow:0 12px 40px rgba(0,0,0,0.6);backdrop-filter:blur(12px);">
          <div style="width:32px;height:32px;border-radius:50%;background:rgba(52,199,89,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
            <i class="bi bi-check-circle-fill" style="color:#34c759;font-size:16px;"></i>
          </div>
          <div style="flex:1;">
            <div style="font-size:13px;font-weight:600;color:#34c759;margin-bottom:3px;">Success!</div>
            <div style="font-size:13px;color:#e5e5ea;line-height:1.5;font-weight:300;">{{ session('success') }}</div>
          </div>
          <button onclick="document.getElementById('flashToast').remove()" style="background:none;border:none;color:#6e6e73;cursor:pointer;padding:2px;line-height:1;flex-shrink:0;">
            <i class="bi bi-x-lg" style="font-size:14px;"></i>
          </button>
        </div>
      @endif
      @if(session('error'))
        <div style="background:#1f0d0d;border:1px solid rgba(255,69,58,0.35);border-radius:14px;padding:16px 20px;display:flex;align-items:flex-start;gap:12px;box-shadow:0 12px 40px rgba(0,0,0,0.6);backdrop-filter:blur(12px);">
          <div style="width:32px;height:32px;border-radius:50%;background:rgba(255,69,58,0.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
            <i class="bi bi-exclamation-triangle-fill" style="color:#ff453a;font-size:16px;"></i>
          </div>
          <div style="flex:1;">
            <div style="font-size:13px;font-weight:600;color:#ff453a;margin-bottom:3px;">Error</div>
            <div style="font-size:13px;color:#e5e5ea;line-height:1.5;font-weight:300;">{{ session('error') }}</div>
          </div>
          <button onclick="document.getElementById('flashToast').remove()" style="background:none;border:none;color:#6e6e73;cursor:pointer;padding:2px;line-height:1;flex-shrink:0;">
            <i class="bi bi-x-lg" style="font-size:14px;"></i>
          </button>
        </div>
      @endif
    </div>
    <style>
      @keyframes slideInRight { from { transform: translateX(120%); opacity:0; } to { transform: translateX(0); opacity:1; } }
      @keyframes slideOutRight { from { transform: translateX(0); opacity:1; } to { transform: translateX(120%); opacity:0; } }
    </style>
    <script>
      setTimeout(function() {
        var t = document.getElementById('flashToast');
        if (t) { t.style.animation = 'slideOutRight .4s ease forwards'; setTimeout(function(){ t && t.remove(); }, 400); }
      }, 5000);
    </script>
  @endif


  <!-- ── Page Content ──────────────────────────────────── -->
  <main>
    @yield('content')
  </main>

  <!-- ── Enquiry Modal ─────────────────────────────────── -->
  <div class="apple-modal-overlay" id="enquiryModalOverlay">
    <div class="apple-modal">
      <button class="apple-modal__close" id="enquiryModalClose">
        <i class="bi bi-x"></i>
      </button>
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
        <div style="width:36px;height:36px;background:rgba(201,169,110,0.15);border:1px solid rgba(201,169,110,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#c9a96e;">
          <i class="bi bi-envelope-paper" style="font-size:16px;"></i>
        </div>
        <h5 class="apple-modal__title">Enquire About Product</h5>
      </div>
      <p class="apple-modal__subtitle">Speak with our hardware technical advisors — typically respond within 2 hours.</p>
      <form action="{{ route('contact.store') }}" method="POST">
        @csrf
        <div class="apple-form-group">
          <label class="apple-form-label">Product / Requirement</label>
          <input type="text" class="apple-form-input" id="modalProductName" name="subject" value="Product Enquiry" required>
        </div>
        <div class="apple-form-row">
          <div class="apple-form-group">
            <label class="apple-form-label">Your Name *</label>
            <input type="text" class="apple-form-input" name="name" placeholder="John Doe" required>
          </div>
          <div class="apple-form-group">
            <label class="apple-form-label">Phone Number *</label>
            <input type="tel" class="apple-form-input" name="phone" placeholder="+91 98765 43210" required>
          </div>
        </div>
        <div class="apple-form-group">
          <label class="apple-form-label">Email Address *</label>
          <input type="email" class="apple-form-input" name="email" placeholder="john@example.com" required>
        </div>
        <div class="apple-form-group">
          <label class="apple-form-label">Message / Requirements</label>
          <textarea class="apple-form-textarea" name="message" placeholder="Please mention quantity, specifications, project location…"></textarea>
        </div>
        <div style="display:flex;gap:10px;margin-top:8px;">
          <button type="button" class="apple-btn apple-btn--ghost" id="enquiryModalCancel" style="flex:1;">Cancel</button>
          <button type="submit" class="apple-btn apple-btn--primary" style="flex:2;">
            <i class="bi bi-send"></i> Submit Enquiry
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- ── Floating WhatsApp ─────────────────────────────── -->
  <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp', '919876543210') }}?text=Hello%20Laxmi%20Hardware%2C%20I%20would%20like%20to%20enquire%20about%20your%20hardware%20products."
     class="apple-whatsapp-fab"
     target="_blank"
     title="Chat on WhatsApp"
     rel="noopener">
    <i class="bi bi-whatsapp"></i>
  </a>

  <!-- ── Footer ────────────────────────────────────────── -->
  <footer class="apple-footer">
    <div class="apple-footer__grid">

      <!-- Brand -->
      <div>
        <div class="apple-footer__logo-wrap">
          @if(\App\Models\Setting::get('logo'))
            <a href="{{ route('home') }}" style="display:inline-block;text-decoration:none;margin-bottom:12px;">
              <img src="{{ image_url(\App\Models\Setting::get('logo')) }}" alt="{{ \App\Models\Setting::get('site_name', 'Laxmi Hardware') }}" style="max-height:44px;max-width:200px;width:auto;height:auto;object-fit:contain;display:block;">
            </a>
          @else
            <div class="apple-nav__logo-icon">L</div>
            <div class="apple-nav__logo-text">
              <span class="apple-nav__logo-name" style="color:#f5f5f7;">{{ \App\Models\Setting::get('site_name', 'Laxmi Hardware') }}</span>
              <span class="apple-nav__logo-sub">Complete Interior Solutions</span>
            </div>
          @endif
        </div>
        <p class="apple-footer__about">
          Your premier authorized destination for precision architectural interior hardware, luxury modular kitchen fittings, certified marine plywood, curtain automation, and premium bathroom & sanitary fittings in Surat.
        </p>
        <div style="font-size:12px;color:#6e6e73;margin-bottom:16px;">
          <i class="bi bi-patch-check-fill" style="color:#c9a96e;margin-right:6px;"></i>
          GSTIN: {{ \App\Models\Setting::get('gst_number', '24AAACL1234P1ZR') }}
          &nbsp;&nbsp;
          <i class="bi bi-award" style="color:#c9a96e;margin-right:6px;"></i>
          100% Genuine Certified Hardware
        </div>
        <div class="apple-footer__socials">
          @if(\App\Models\Setting::get('facebook_url'))
            <a href="{{ \App\Models\Setting::get('facebook_url') }}" target="_blank" class="apple-footer__social-btn"><i class="bi bi-facebook"></i></a>
          @endif
          @if(\App\Models\Setting::get('instagram_url'))
            <a href="{{ \App\Models\Setting::get('instagram_url') }}" target="_blank" class="apple-footer__social-btn"><i class="bi bi-instagram"></i></a>
          @endif
          @if(\App\Models\Setting::get('linkedin_url'))
            <a href="{{ \App\Models\Setting::get('linkedin_url') }}" target="_blank" class="apple-footer__social-btn"><i class="bi bi-linkedin"></i></a>
          @endif
          @if(\App\Models\Setting::get('youtube_url'))
            <a href="{{ \App\Models\Setting::get('youtube_url') }}" target="_blank" class="apple-footer__social-btn"><i class="bi bi-youtube"></i></a>
          @endif
          <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp', '919876543210') }}" target="_blank" class="apple-footer__social-btn"><i class="bi bi-whatsapp"></i></a>
        </div>
      </div>

      <!-- Product Categories -->
      <div>
        <h6 class="apple-footer__col-title">Categories</h6>
        <ul class="apple-footer__links">
          <li><a href="{{ route('products.index', ['category' => 'hardware-fittings']) }}">Hardware Fittings</a></li>
          <li><a href="{{ route('products.index', ['category' => 'kitchen-hardware']) }}">Kitchen Hardware</a></li>
          <li><a href="{{ route('products.index', ['category' => 'wardrobe-fittings']) }}">Wardrobe Fittings</a></li>
          <li><a href="{{ route('products.index', ['category' => 'curtain-fittings']) }}">Curtain Tracks</a></li>
          <li><a href="{{ route('products.index', ['category' => 'plywood']) }}">Marine Plywood</a></li>
          <li><a href="{{ route('products.index', ['category' => 'bathroom-sanitary-fittings']) }}">Bathroom Fittings</a></li>
          <li><a href="{{ route('products.index', ['category' => 'plumbing-pipe-lines']) }}">CPVC / SWR Pipes</a></li>
          <li><a href="{{ route('products.index', ['category' => 'locks-security-hardware']) }}">Smart Locks</a></li>
        </ul>
      </div>

      <!-- Quick Links -->
      <div>
        <h6 class="apple-footer__col-title">Company</h6>
        <ul class="apple-footer__links">
          <li><a href="{{ route('about') }}">About Us</a></li>
          <li><a href="{{ route('services.index') }}">Services</a></li>
          <li><a href="{{ route('projects.index') }}">Projects</a></li>
          <li><a href="{{ route('gallery.index') }}">Gallery</a></li>
          <li><a href="{{ route('brands.index') }}">Our Brands</a></li>
          <li><a href="{{ route('blog.index') }}">Blog & Guides</a></li>
          <li><a href="{{ route('quote.index') }}">Request a Quote</a></li>
          <li><a href="{{ route('contact.index') }}">Contact Us</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div>
        <h6 class="apple-footer__col-title">Contact</h6>
        <div class="apple-footer__contact-item">
          <i class="bi bi-geo-alt-fill"></i>
          <span>{{ \App\Models\Setting::get('address', 'Hardware Plaza, Ring Road, Industrial Area, Surat, Gujarat 395002') }}</span>
        </div>
        <div class="apple-footer__contact-item">
          <i class="bi bi-telephone-fill"></i>
          <a href="tel:{{ str_replace(' ', '', \App\Models\Setting::get('phone', '+919876543210')) }}">
            {{ \App\Models\Setting::get('phone', '+91 98765 43210') }}
          </a>
        </div>
        <div class="apple-footer__contact-item">
          <i class="bi bi-envelope-fill"></i>
          <a href="mailto:{{ \App\Models\Setting::get('email', 'info@laxmihardware.com') }}">
            {{ \App\Models\Setting::get('email', 'info@laxmihardware.com') }}
          </a>
        </div>
        <div class="apple-footer__contact-item">
          <i class="bi bi-clock-fill"></i>
          <span>{{ \App\Models\Setting::get('business_hours', 'Mon – Sat: 9:00 AM – 8:30 PM') }}</span>
        </div>
        <div style="margin-top:20px;">
          <a href="{{ route('quote.index') }}" class="apple-btn apple-btn--primary" style="font-size:13px;padding:10px 20px;width:100%;justify-content:center;">
            <i class="bi bi-file-earmark-spreadsheet"></i> Submit Project BOQ
          </a>
        </div>
      </div>

    </div>

    <!-- Bottom Bar -->
    <div style="border-top:1px solid rgba(255,255,255,0.06);padding:20px 24px;">
      <div style="max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <p style="font-size:12px;color:#6e6e73;margin:0;">
          &copy; {{ date('Y') }} Laxmi Hardware. All Rights Reserved. Complete Interior Hardware Solutions.
        </p>
        <div class="apple-footer__bottom-links">
          <a href="{{ route('privacy') }}">Privacy Policy</a>
          <a href="{{ route('terms') }}">Terms & Conditions</a>
          <a href="{{ route('admin.login') }}" target="_blank"><i class="bi bi-lock-fill"></i> Staff Login</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- ── Scripts ────────────────────────────────────────── -->
  <script>
    (function() {
      // ── Nav scroll effect ──
      const nav = document.getElementById('mainNav');
      window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 10);
      }, { passive: true });

      // ── Mobile menu toggle ──
      const hamburger = document.getElementById('mobileMenuToggle');
      const mobileMenu = document.getElementById('mobileMenu');
      hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('open');
        mobileMenu.classList.toggle('open');
      });

      // ── Search overlay ──
      const searchToggle  = document.getElementById('searchToggle');
      const searchOverlay = document.getElementById('searchOverlay');
      const searchClose   = document.getElementById('searchClose');
      const searchInput   = document.getElementById('searchInput');

      searchToggle.addEventListener('click', () => {
        searchOverlay.classList.add('open');
        setTimeout(() => searchInput.focus(), 300);
      });
      searchClose.addEventListener('click', () => searchOverlay.classList.remove('open'));
      searchOverlay.addEventListener('click', (e) => {
        if (e.target === searchOverlay) searchOverlay.classList.remove('open');
      });
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') searchOverlay.classList.remove('open');
      });

      // ── Enquiry Modal ──
      const enquiryOverlay = document.getElementById('enquiryModalOverlay');
      const enquiryClose   = document.getElementById('enquiryModalClose');
      const enquiryCancel  = document.getElementById('enquiryModalCancel');

      window.openEnquiryModal = function(productName, productSku) {
        const inp = document.getElementById('modalProductName');
        if (inp && productName) {
          inp.value = 'Enquiry for: ' + productName + (productSku ? ' (SKU: ' + productSku + ')' : '');
        }
        enquiryOverlay.classList.add('open');
      };

      [enquiryClose, enquiryCancel].forEach(btn => btn && btn.addEventListener('click', () => {
        enquiryOverlay.classList.remove('open');
      }));
      enquiryOverlay.addEventListener('click', (e) => {
        if (e.target === enquiryOverlay) enquiryOverlay.classList.remove('open');
      });

      // ── Scroll reveal ──
      const revealEls = document.querySelectorAll('.reveal');
      const revealObs = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); revealObs.unobserve(e.target); } });
      }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
      revealEls.forEach(el => revealObs.observe(el));

      // ── Hero animation on load ──
      const hero = document.querySelector('.apple-hero');
      if (hero) {
        const bg = hero.querySelector('.apple-hero__bg');
        setTimeout(() => {
          hero.classList.add('visible');
          if (bg) bg.classList.add('loaded');
        }, 100);
      }

      // ── Counter animation ──
      const counters = document.querySelectorAll('[data-count]');
      const countObs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
          if (!e.isIntersecting) return;
          const target = parseInt(e.target.getAttribute('data-count'));
          const suffix = e.target.getAttribute('data-suffix') || '';
          const duration = 1800;
          const step = target / (duration / 16);
          let current = 0;
          const timer = setInterval(() => {
            current = Math.min(current + step, target);
            e.target.textContent = Math.floor(current).toLocaleString() + suffix;
            if (current >= target) clearInterval(timer);
          }, 16);
          countObs.unobserve(e.target);
        });
      }, { threshold: 0.5 });
      counters.forEach(c => countObs.observe(c));

      // ── Auto-dismiss alerts ──
      setTimeout(() => {
        document.querySelectorAll('[data-alert]').forEach(a => {
          a.style.opacity = '0';
          a.style.transition = 'opacity 0.5s';
          setTimeout(() => a.remove(), 500);
        });
      }, 5000);

    })();
  </script>

  @stack('scripts')
</body>
</html>
