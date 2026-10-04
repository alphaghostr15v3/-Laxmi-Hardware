@extends('layouts.app')

@section('title', \App\Models\Setting::get('meta_title', 'Laxmi Hardware — Premium Interior Hardware Solutions'))
@section('meta_description', 'Premium architectural hardware, modular kitchen fittings, certified marine plywood, luxury bathroom fittings, and interior solutions. Authorized dealer in Surat.')

@section('content')

{{-- ═══════════════════════════════════════════════════════════
     HERO — Full viewport, Apple-style cinematic
═══════════════════════════════════════════════════════════ --}}
<section class="apple-hero" id="heroSection">
  <div class="apple-hero__bg" id="heroBg"></div>
  <div class="apple-hero__overlay"></div>

  <div class="apple-hero__content">
    <span class="apple-hero__eyebrow">Authorized Dealer &bull; 10+ Years Excellence</span>

    <h1 class="apple-hero__title">
      Hardware That<br><span>Elevates Interiors</span>
    </h1>

    <p class="apple-hero__subtitle">
      Precision architectural hardware, luxury modular kitchen fittings, certified marine plywood & premium bathroom solutions — all under one roof in Surat.
    </p>

    <div class="apple-hero__actions">
      <a href="{{ route('products.index') }}" class="apple-btn apple-btn--primary">
        <i class="bi bi-grid-3x3-gap-fill"></i> Explore Products
      </a>
      <a href="{{ route('quote.index') }}" class="apple-btn apple-btn--ghost">
        <i class="bi bi-file-earmark-text"></i> Request a Quote
      </a>
    </div>
  </div>

  <div class="apple-hero__scroll">
    <span class="apple-hero__scroll-text">Scroll</span>
    <div class="apple-hero__scroll-line"></div>
  </div>
</section>


{{-- ═══════════════════════════════════════════════════════════
     STATS BAR
═══════════════════════════════════════════════════════════ --}}
<section class="apple-stats">
  <div class="apple-container">
    <div class="apple-stats__grid">
      <div class="apple-stats__item reveal">
        <div class="apple-stats__num" data-count="{{ (int) filter_var(\App\Models\Setting::get('stat_experience', '10'), FILTER_SANITIZE_NUMBER_INT) }}" data-suffix="+">10+</div>
        <div class="apple-stats__label">Years of Excellence</div>
      </div>
      <div class="apple-stats__item reveal reveal--delay-1">
        <div class="apple-stats__num" data-count="{{ (int) filter_var(\App\Models\Setting::get('stat_products', '750'), FILTER_SANITIZE_NUMBER_INT) }}" data-suffix="+">750+</div>
        <div class="apple-stats__label">Hardware Products</div>
      </div>
      <div class="apple-stats__item reveal reveal--delay-2">
        <div class="apple-stats__num" data-count="{{ (int) filter_var(\App\Models\Setting::get('stat_categories', '120'), FILTER_SANITIZE_NUMBER_INT) }}" data-suffix="+">120+</div>
        <div class="apple-stats__label">Product Categories</div>
      </div>
      <div class="apple-stats__item reveal reveal--delay-3">
        <div class="apple-stats__num" data-count="{{ (int) filter_var(\App\Models\Setting::get('stat_customers', '1500'), FILTER_SANITIZE_NUMBER_INT) }}" data-suffix="+">1500+</div>
        <div class="apple-stats__label">Happy Clients & Architects</div>
      </div>
    </div>
  </div>
</section>


{{-- ═══════════════════════════════════════════════════════════
     FEATURE #1 — Kitchen Hardware
═══════════════════════════════════════════════════════════ --}}
<section class="apple-feature">
  <div class="apple-feature__media">
    <img src="{{ asset('images/hero_interior.jpg') }}" alt="Premium Kitchen Hardware — Laxmi Hardware Surat" loading="lazy">
  </div>
  <div class="apple-feature__body">
    <span class="apple-feature__tag">Kitchen Hardware</span>
    <h2 class="apple-feature__title">Precision-Engineered<br>Kitchen Solutions</h2>
    <p class="apple-feature__desc">
      From soft-close tandem box drawers to full-extension pull-out systems — our kitchen hardware range from Hettich, Hafele, and Blum sets the benchmark for German engineering in Indian interiors.
    </p>
    <ul class="apple-feature__bullets">
      <li>Soft-close tandem box & drawer systems</li>
      <li>Corner solutions & carousel units</li>
      <li>Modular cabinet hinges (30,000+ cycle rated)</li>
      <li>Architectural pulls & handles</li>
    </ul>
    <a href="{{ route('products.index', ['category' => 'kitchen-hardware']) }}" class="apple-btn apple-btn--text">
      Shop Kitchen Hardware
    </a>
  </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     FEATURE #2 — Bathroom (Reversed)
═══════════════════════════════════════════════════════════ --}}
<section class="apple-feature apple-feature--reverse">
  <div class="apple-feature__media">
    <img src="{{ asset('images/feature_2.jpg') }}" alt="Luxury Bathroom Fittings — Laxmi Hardware" loading="lazy">
  </div>
  <div class="apple-feature__body">
    <span class="apple-feature__tag">Bathroom & Sanitary</span>
    <h2 class="apple-feature__title">Luxury Bathroom<br>Collections</h2>
    <p class="apple-feature__desc">
      Curate your spa-like sanctuary with our Jaquar, Hindware, and Cera premium collections. Brushed gold faucets, rain showers, wall-hung WCs, and designer vanity basins — all in stock.
    </p>
    <ul class="apple-feature__bullets">
      <li>Wall-hung & floor-standing WCs</li>
      <li>Rain showers & thermostatic systems</li>
      <li>Brushed gold & matte black faucets</li>
      <li>Marble & stone vessel basins</li>
    </ul>
    <a href="{{ route('products.index', ['category' => 'bathroom-sanitary-fittings']) }}" class="apple-btn apple-btn--text">
      Explore Bathroom Range
    </a>
  </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     FEATURE #3 — Wardrobe / Closet
═══════════════════════════════════════════════════════════ --}}
<section class="apple-feature">
  <div class="apple-feature__media">
    <img src="{{ asset('images/feature_3.jpg') }}" alt="Premium Wardrobe Fittings — Laxmi Hardware" loading="lazy">
  </div>
  <div class="apple-feature__body">
    <span class="apple-feature__tag">Wardrobe Systems</span>
    <h2 class="apple-feature__title">Walk-In Closet<br>Hardware Systems</h2>
    <p class="apple-feature__desc">
      Transform ordinary wardrobes into organized luxury spaces. Our Hettich and Hafele wardrobe lift systems, soft-close sliding doors, and LED profile lighting bring walk-in closets to life.
    </p>
    <ul class="apple-feature__bullets">
      <li>Flap-up & pull-down wardrobe lifts</li>
      <li>Soft-close sliding door systems</li>
      <li>Aluminium profile LED strips</li>
      <li>Accessory organizers & valet rods</li>
    </ul>
    <a href="{{ route('products.index', ['category' => 'wardrobe-fittings']) }}" class="apple-btn apple-btn--text">
      See Wardrobe Systems
    </a>
  </div>
</section>


{{-- ═══════════════════════════════════════════════════════════
     CATEGORIES GRID — Apple card grid style
═══════════════════════════════════════════════════════════ --}}
<section class="apple-section apple-section--alt">
  <div class="apple-container">
    <div class="apple-section__header">
      <span class="apple-eyebrow reveal">Architectural Categories</span>
      <h2 class="apple-title reveal reveal--delay-1">Explore Our Complete<br>Product Range</h2>
      <p class="apple-subtitle reveal reveal--delay-2">From heavy-duty cabinet hinges to certified marine plywood, luxury bathroom fittings, and plumbing pipes.</p>
    </div>

    @if($categories->count() > 0)
      <div class="apple-grid apple-grid--{{ $categories->count() >= 6 ? '3col' : '2col' }} reveal">
        @foreach($categories->take(9) as $category)
          <div class="apple-card">
            <div class="apple-card__icon">
              <i class="bi {{ $category->icon ?: 'bi-tools' }}"></i>
            </div>
            <h3 class="apple-card__title">{{ $category->name }}</h3>
            <p class="apple-card__desc">{{ Str::limit($category->description, 90) }}</p>
            <a href="{{ route('categories.show', $category->slug) }}" class="apple-card__link">
              View Catalogue <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        @endforeach
      </div>
    @else
      {{-- Fallback static categories --}}
      <div class="apple-grid">
        @php
          $defaultCats = [
            ['icon' => 'bi-door-open', 'name' => 'Hardware Fittings', 'desc' => 'Cabinet hinges, drawer slides, door closers, and precision architectural fittings.', 'slug' => 'hardware-fittings'],
            ['icon' => 'bi-grid', 'name' => 'Kitchen Hardware', 'desc' => 'Tandem box drawers, pull-out systems, corner units, and modular kitchen solutions.', 'slug' => 'kitchen-hardware'],
            ['icon' => 'bi-layout-sidebar', 'name' => 'Wardrobe Fittings', 'desc' => 'Wardrobe lifts, sliding doors, LED profiles, and walk-in closet systems.', 'slug' => 'wardrobe-fittings'],
            ['icon' => 'bi-brightness-high', 'name' => 'Curtain Tracks', 'desc' => 'Motorized curtain systems, finials, brackets, and bay window solutions.', 'slug' => 'curtain-fittings'],
            ['icon' => 'bi-layers', 'name' => 'Marine Plywood', 'desc' => 'BWP certified marine grade, commercial, and block-board plywood.', 'slug' => 'plywood'],
            ['icon' => 'bi-droplet-half', 'name' => 'Bathroom Fittings', 'desc' => 'Premium faucets, shower systems, WCs, and luxury sanitaryware.', 'slug' => 'bathroom-sanitary-fittings'],
            ['icon' => 'bi-pipe', 'name' => 'CPVC & SWR Pipes', 'desc' => 'Astral, Supreme pressure pipes, drainage systems, and fittings.', 'slug' => 'plumbing-pipe-lines'],
            ['icon' => 'bi-shield-lock', 'name' => 'Smart Locks', 'desc' => 'Digital smart locks, mortise locks, cylindrical locks, and security hardware.', 'slug' => 'locks-security-hardware'],
            ['icon' => 'bi-house-door', 'name' => 'Door Hardware', 'desc' => 'Door handles, knobs, hinges, pivots, and architectural door accessories.', 'slug' => 'door-hardware'],
          ];
        @endphp
        @foreach($defaultCats as $cat)
          <div class="apple-card">
            <div class="apple-card__icon"><i class="bi {{ $cat['icon'] }}"></i></div>
            <h3 class="apple-card__title">{{ $cat['name'] }}</h3>
            <p class="apple-card__desc">{{ $cat['desc'] }}</p>
            <a href="{{ route('products.index', ['category' => $cat['slug']]) }}" class="apple-card__link">
              View Catalogue <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        @endforeach
      </div>
    @endif

    <div style="text-align:center;margin-top:40px;" class="reveal">
      <a href="{{ route('categories.index') }}" class="apple-btn apple-btn--ghost">
        View All Categories <i class="bi bi-arrow-right"></i>
      </a>
    </div>
  </div>
</section>


{{-- ═══════════════════════════════════════════════════════════
     FEATURED PRODUCTS — Apple bento grid
═══════════════════════════════════════════════════════════ --}}
@if(isset($featuredProducts) && $featuredProducts->count() > 0)
<section class="apple-section apple-section--dark">
  <div class="apple-container">
    <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:16px;margin-bottom:48px;">
      <div>
        <span class="apple-eyebrow reveal">Product Showcase</span>
        <h2 class="apple-title reveal reveal--delay-1" style="margin-bottom:0;">Featured<br>Hardware Fittings</h2>
      </div>
      <a href="{{ route('products.index') }}" class="apple-btn apple-btn--ghost reveal" style="align-self:flex-end;">
        View All <i class="bi bi-arrow-right"></i>
      </a>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:14px;">
      @foreach($featuredProducts->take(8) as $product)
        <div class="apple-bento__item reveal" style="border-radius:16px;overflow:hidden;">
          <div style="position:relative;overflow:hidden;background:#0a0a0a;">
            <img
              src="{{ $product->main_image_url }}"
              alt="{{ $product->name }}"
              style="width:100%;height:220px;object-fit:cover;display:block;transition:transform 0.5s ease;"
              loading="lazy"
              onmouseover="this.style.transform='scale(1.04)'"
              onmouseout="this.style.transform='scale(1)'"
            >
            @if($product->brand)
              <span style="position:absolute;top:12px;left:12px;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#000;background:#c9a96e;border-radius:100px;padding:3px 10px;">{{ $product->brand->name }}</span>
            @endif
            @if($product->featured)
              <span style="position:absolute;top:12px;right:12px;font-size:10px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:#c9a96e;background:rgba(201,169,110,0.15);border:1px solid rgba(201,169,110,0.3);border-radius:100px;padding:3px 10px;">Featured</span>
            @endif
          </div>
          <div style="padding:20px 20px 24px;background:#111;">
            <div style="font-size:10px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#6e6e73;margin-bottom:6px;">{{ $product->category->name ?? 'Hardware' }} &nbsp;·&nbsp; {{ $product->sku }}</div>
            <h3 style="font-size:15px;font-weight:600;letter-spacing:-.02em;color:#f5f5f7;margin-bottom:8px;line-height:1.3;">
              <a href="{{ route('products.show', $product->slug) }}" style="color:inherit;text-decoration:none;">{{ $product->name }}</a>
            </h3>
            <p style="font-size:13px;color:#6e6e73;font-weight:300;line-height:1.6;margin-bottom:16px;">{{ Str::limit($product->short_description, 80) }}</p>
            <div style="display:flex;gap:8px;">
              <a href="{{ route('products.show', $product->slug) }}" class="apple-btn apple-btn--ghost" style="font-size:12px;padding:8px 16px;flex:1;justify-content:center;">
                <i class="bi bi-eye"></i> Details
              </a>
              <button
                type="button"
                class="apple-btn apple-btn--primary"
                style="font-size:12px;padding:8px 16px;flex:1;justify-content:center;"
                onclick="openEnquiryModal('{{ addslashes($product->name) }}', '{{ $product->sku }}')"
              >
                <i class="bi bi-envelope"></i> Enquire
              </button>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════════
     WHY CHOOSE US — Feature Highlight
═══════════════════════════════════════════════════════════ --}}
<section class="apple-section apple-section--alt">
  <div class="apple-container">
    <div class="apple-section__header">
      <span class="apple-eyebrow reveal">Why Choose Us</span>
      <h2 class="apple-title reveal reveal--delay-1">Complete Hardware Solutions<br>Under One Roof</h2>
      <p class="apple-subtitle reveal reveal--delay-2">We bridge the gap between architectural vision and tangible execution with 100% certified hardware, full technical advisory, and wholesale project pricing.</p>
    </div>

    <div class="apple-grid apple-grid--4col reveal">
      <div class="apple-card">
        <div class="apple-card__icon"><i class="bi bi-award-fill"></i></div>
        <h3 class="apple-card__title">Authorized Distributor</h3>
        <p class="apple-card__desc">Genuine factory warranties from Hettich, Hafele, Blum, Godrej, CenturyPly, Astral, and Jaquar.</p>
      </div>
      <div class="apple-card">
        <div class="apple-card__icon"><i class="bi bi-box-seam-fill"></i></div>
        <h3 class="apple-card__title">Ready Inventory</h3>
        <p class="apple-card__desc">Immediate showroom availability for soft-close hinges, drawer channels, marine plywood, and faucets.</p>
      </div>
      <div class="apple-card">
        <div class="apple-card__icon"><i class="bi bi-calculator-fill"></i></div>
        <h3 class="apple-card__title">BOQ Support</h3>
        <p class="apple-card__desc">Our hardware engineers review architectural drawings to optimize quantities and recommend ideal fittings.</p>
      </div>
      <div class="apple-card">
        <div class="apple-card__icon"><i class="bi bi-truck"></i></div>
        <h3 class="apple-card__title">Site Delivery</h3>
        <p class="apple-card__desc">Fast doorstep delivery across Surat and South Gujarat for residential, commercial, and hospitality projects.</p>
      </div>
    </div>
  </div>
</section>


{{-- ═══════════════════════════════════════════════════════════
     SERVICES
═══════════════════════════════════════════════════════════ --}}
@if(isset($services) && $services->count() > 0)
<section class="apple-section apple-section--dark">
  <div class="apple-container">
    <div class="apple-section__header">
      <span class="apple-eyebrow reveal">Specialized Services</span>
      <h2 class="apple-title reveal reveal--delay-1">Comprehensive<br>Hardware Services</h2>
      <p class="apple-subtitle reveal reveal--delay-2">Turnkey solutions for architects, interior designers, contractors, and luxury home builders.</p>
    </div>

    <div class="apple-grid reveal">
      @foreach($services->take(6) as $service)
        <div class="apple-card" style="padding:0;overflow:hidden;">
          @if($service->image)
            <img src="{{ $service->image_url }}" alt="{{ $service->title }}" style="width:100%;height:180px;object-fit:cover;">
          @else
            <div style="width:100%;height:180px;background:linear-gradient(135deg,#1a1a1a,#222);display:flex;align-items:center;justify-content:center;font-size:40px;color:rgba(201,169,110,0.3);">
              <i class="bi bi-wrench-adjustable"></i>
            </div>
          @endif
          <div style="padding:24px 24px 28px;">
            <h3 class="apple-card__title">{{ $service->title }}</h3>
            <p class="apple-card__desc" style="margin-bottom:16px;">{{ Str::limit($service->short_description, 100) }}</p>
            @if(!empty($service->features_list))
              <ul style="list-style:none;padding:0;margin:0 0 16px;display:flex;flex-direction:column;gap:6px;">
                @foreach(array_slice($service->features_list, 0, 3) as $feat)
                  <li style="font-size:12px;color:#6e6e73;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-check2" style="color:#c9a96e;"></i>{{ $feat }}
                  </li>
                @endforeach
              </ul>
            @endif
            <a href="{{ route('quote.index', ['category' => $service->title]) }}" class="apple-card__link">
              Enquire Service <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════════
     PROJECTS — Bento grid portfolio
═══════════════════════════════════════════════════════════ --}}
@if(isset($projects) && $projects->count() > 0)
<section class="apple-section apple-section--alt">
  <div class="apple-container">
    <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:16px;margin-bottom:48px;">
      <div>
        <span class="apple-eyebrow reveal">Portfolio</span>
        <h2 class="apple-title reveal reveal--delay-1" style="margin-bottom:0;">Featured<br>Interior Projects</h2>
      </div>
      <a href="{{ route('projects.index') }}" class="apple-btn apple-btn--ghost reveal">
        View All <i class="bi bi-arrow-right"></i>
      </a>
    </div>

    <div class="apple-bento reveal">
      @php $pIdx = 0; @endphp
      @foreach($projects->take(5) as $project)
        @php
          $colClass = match($pIdx) {
            0 => 'apple-bento__item--span8',
            1 => 'apple-bento__item--span4',
            2, 3, 4 => 'apple-bento__item--span4',
            default => 'apple-bento__item--span4',
          };
          $pIdx++;
        @endphp
        <div class="apple-bento__item {{ $colClass }}" style="position:relative;overflow:hidden;">
          <img
            src="{{ $project->featured_image_url }}"
            alt="{{ $project->title }}"
            loading="lazy"
          >
          <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.8) 0%,transparent 60%);display:flex;flex-direction:column;justify-content:flex-end;padding:24px 28px;">
            <span style="display:inline-block;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#c9a96e;background:rgba(201,169,110,0.15);border:1px solid rgba(201,169,110,0.3);border-radius:100px;padding:3px 10px;width:fit-content;margin-bottom:8px;">{{ $project->category }}</span>
            <h3 style="font-size:18px;font-weight:700;letter-spacing:-.03em;color:#f5f5f7;margin-bottom:4px;line-height:1.2;">{{ $project->title }}</h3>
            <p style="font-size:12px;color:rgba(255,255,255,0.5);margin-bottom:16px;"><i class="bi bi-geo-alt" style="margin-right:4px;"></i>{{ $project->location ?? 'Surat, Gujarat' }}</p>
            <a href="{{ route('projects.show', $project->slug) }}" class="apple-btn apple-btn--ghost" style="font-size:12px;padding:8px 18px;width:fit-content;">
              View Project <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════════
     BRANDS — Infinite scroll strip
═══════════════════════════════════════════════════════════ --}}
<section class="apple-brands">
  <p class="apple-brands__label">Authorized Dealer for World-Class Brands</p>
  <div style="overflow:hidden;">
    @php
      $brandNames = ['Hettich', 'Hafele', 'Blum', 'Godrej', 'Greenply', 'CenturyPly', 'Astral Pipes', 'Jaquar', 'Cera', 'Hindware', 'Supreme', 'Wavin'];
      if(isset($brands) && $brands->count() > 0) {
        $brandNames = $brands->pluck('name')->toArray();
      }
      $doubled = array_merge($brandNames, $brandNames);
    @endphp
    <div class="apple-brands__track">
      @foreach($doubled as $brand)
        <a href="{{ route('brands.index') }}" class="apple-brands__item">{{ $brand }}</a>
      @endforeach
    </div>
  </div>
</section>


{{-- ═══════════════════════════════════════════════════════════
     TESTIMONIALS
═══════════════════════════════════════════════════════════ --}}
@if(isset($testimonials) && $testimonials->count() > 0)
<section class="apple-section apple-section--dark">
  <div class="apple-container">
    <div class="apple-section__header">
      <span class="apple-eyebrow reveal">Client Reviews</span>
      <h2 class="apple-title reveal reveal--delay-1">What Architects<br>& Builders Say</h2>
    </div>

    <div class="apple-testimonials__grid reveal">
      @foreach($testimonials->take(6) as $t)
        <div class="apple-testimonial">
          <div class="apple-testimonial__stars">
            @for($i = 0; $i < ($t->rating ?? 5); $i++)
              <span>★</span>
            @endfor
          </div>
          <p class="apple-testimonial__text">"{{ $t->review }}"</p>
          <div class="apple-testimonial__author">
            <div class="apple-testimonial__avatar">{{ strtoupper(substr($t->name, 0, 1)) }}</div>
            <div>
              <div class="apple-testimonial__name">{{ $t->name }}</div>
              <div class="apple-testimonial__role">{{ $t->designation ?? $t->company ?? 'Client' }}</div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════════
     CALL TO ACTION BANNER
═══════════════════════════════════════════════════════════ --}}
<section class="apple-cta-banner">
  <div class="apple-cta-banner__inner reveal">
    <span class="apple-eyebrow" style="display:block;text-align:center;margin-bottom:16px;">Turnkey Supply Consultation</span>
    <h2 class="apple-cta-banner__title">Planning a Kitchen,<br>Villa or Commercial Project?</h2>
    <p class="apple-cta-banner__sub">
      Send us your Architectural BOQ or product list. Our consultants will provide a comprehensive competitive quotation within 24 hours.
    </p>
    <div class="apple-cta-banner__actions">
      <a href="{{ route('quote.index') }}" class="apple-btn apple-btn--primary">
        <i class="bi bi-file-earmark-text"></i> Request a Project Quote
      </a>
      <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp', '919876543210') }}" class="apple-btn apple-btn--ghost" target="_blank" rel="noopener">
        <i class="bi bi-whatsapp" style="color:#25d366;"></i> WhatsApp Us
      </a>
    </div>
  </div>
</section>

@endsection
