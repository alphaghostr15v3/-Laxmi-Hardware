@extends('layouts.app')
@section('title', 'About Us — Laxmi Hardware')
@section('meta_description', 'Learn about Laxmi Hardware — Surat\'s premier authorized dealer for architectural hardware, kitchen fittings, plywood, bathroom fittings and interior solutions.')

@section('content')

{{-- PAGE HERO --}}
<section style="position:relative;padding:120px 0 80px;background:#000;overflow:hidden;text-align:center;">
  <div style="position:absolute;top:-100px;left:50%;transform:translateX(-50%);width:700px;height:700px;background:radial-gradient(ellipse,rgba(201,169,110,0.08) 0%,transparent 70%);pointer-events:none;"></div>
  <div class="apple-container" style="position:relative;">
    <span class="apple-eyebrow reveal">Our Story</span>
    <h1 class="apple-title reveal reveal--delay-1" style="max-width:700px;margin:12px auto 20px;">A Decade of Interior<br>Hardware Excellence</h1>
    <p class="apple-subtitle reveal reveal--delay-2" style="max-width:560px;margin:0 auto;">Laxmi Hardware is Surat's most trusted authorized destination for precision interior hardware, luxury modular kitchen fittings, and premium bathroom solutions.</p>
  </div>
</section>

{{-- MISSION + IMAGE SPLIT --}}
<section class="apple-feature">
  <div class="apple-feature__media">
    <img src="{{ asset('images/feature_1.jpg') }}" alt="Laxmi Hardware Showroom Interior" loading="lazy">
  </div>
  <div class="apple-feature__body">
    <span class="apple-feature__tag">Our Mission</span>
    <h2 class="apple-feature__title">Elevating Every Interior, One Fitting at a Time</h2>
    <p class="apple-feature__desc">Founded with a single vision — to bring world-class hardware quality to Indian interiors — we've grown into Surat's most comprehensive interior hardware destination, serving architects, contractors, and homeowners alike.</p>
    <ul class="apple-feature__bullets">
      <li>100% genuine certified hardware from global brands</li>
      <li>Complete technical advisory and BOQ support</li>
      <li>Wholesale project pricing for bulk requirements</li>
      <li>Showroom with live product demonstrations</li>
    </ul>
  </div>
</section>

{{-- VISION (reversed) --}}
<section class="apple-feature apple-feature--reverse">
  <div class="apple-feature__media">
    <img src="{{ asset('images/feature_3.jpg') }}" alt="Premium Interior Hardware Solutions" loading="lazy">
  </div>
  <div class="apple-feature__body">
    <span class="apple-feature__tag">Our Vision</span>
    <h2 class="apple-feature__title">Where Engineering Meets Aesthetics</h2>
    <p class="apple-feature__desc">We believe beautiful interiors are built on reliable foundations. Every hinge, every handle, every pipe fitting matters. Our curated selection of hardware from Hettich, Hafele, Blum, Jaquar, and Astral ensures your projects stand the test of time.</p>
    <ul class="apple-feature__bullets">
      <li>Authorized partner for 15+ global brands</li>
      <li>10+ years of hardware expertise</li>
      <li>500+ completed residential & commercial projects</li>
      <li>1500+ satisfied architects & interior designers</li>
    </ul>
  </div>
</section>

{{-- CORE VALUES --}}
<section class="apple-section apple-section--alt">
  <div class="apple-container">
    <div class="apple-section__header">
      <span class="apple-eyebrow reveal">Core Values</span>
      <h2 class="apple-title reveal reveal--delay-1">What Sets Us Apart</h2>
    </div>
    <div class="apple-grid apple-grid--4col reveal">
      <div class="apple-card">
        <div class="apple-card__icon"><i class="bi bi-award-fill"></i></div>
        <h3 class="apple-card__title">Authenticity</h3>
        <p class="apple-card__desc">Every product carries original manufacturer warranty. Zero counterfeits. Zero compromises on quality.</p>
      </div>
      <div class="apple-card">
        <div class="apple-card__icon"><i class="bi bi-lightbulb-fill"></i></div>
        <h3 class="apple-card__title">Expertise</h3>
        <p class="apple-card__desc">Our team includes trained hardware engineers who guide architects and designers through complex specifications.</p>
      </div>
      <div class="apple-card">
        <div class="apple-card__icon"><i class="bi bi-people-fill"></i></div>
        <h3 class="apple-card__title">Partnership</h3>
        <p class="apple-card__desc">Long-term relationships with architects, contractors, and developers built on trust and consistent supply.</p>
      </div>
      <div class="apple-card">
        <div class="apple-card__icon"><i class="bi bi-graph-up-arrow"></i></div>
        <h3 class="apple-card__title">Innovation</h3>
        <p class="apple-card__desc">Always introducing the latest hardware innovations — from motorized systems to smart lock technology.</p>
      </div>
    </div>
  </div>
</section>

{{-- STATS --}}
<section class="apple-stats">
  <div class="apple-container">
    <div class="apple-stats__grid">
      <div class="apple-stats__item reveal">
        <div class="apple-stats__num" data-count="10" data-suffix="+">10+</div>
        <div class="apple-stats__label">Years Experience</div>
      </div>
      <div class="apple-stats__item reveal reveal--delay-1">
        <div class="apple-stats__num" data-count="500" data-suffix="+">500+</div>
        <div class="apple-stats__label">Projects Completed</div>
      </div>
      <div class="apple-stats__item reveal reveal--delay-2">
        <div class="apple-stats__num" data-count="15" data-suffix="+">15+</div>
        <div class="apple-stats__label">Global Brand Partners</div>
      </div>
      <div class="apple-stats__item reveal reveal--delay-3">
        <div class="apple-stats__num" data-count="1500" data-suffix="+">1500+</div>
        <div class="apple-stats__label">Happy Clients</div>
      </div>
    </div>
  </div>
</section>

{{-- AUTHORIZED BRANDS --}}
@if(isset($brands) && $brands->count() > 0)
<section class="apple-brands">
  <p class="apple-brands__label">Our Authorized Brand Partners</p>
  <div style="overflow:hidden;">
    @php $doubled = array_merge($brands->pluck('name')->toArray(), $brands->pluck('name')->toArray()); @endphp
    <div class="apple-brands__track">
      @foreach($doubled as $brand)
        <span class="apple-brands__item">{{ $brand }}</span>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- TESTIMONIALS --}}
@if(isset($testimonials) && $testimonials->count() > 0)
<section class="apple-section apple-section--dark">
  <div class="apple-container">
    <div class="apple-section__header">
      <span class="apple-eyebrow reveal">Testimonials</span>
      <h2 class="apple-title reveal reveal--delay-1">Trusted by Architects<br>& Builders</h2>
    </div>
    <div class="apple-testimonials__grid reveal">
      @foreach($testimonials->take(3) as $t)
        <div class="apple-testimonial">
          <div class="apple-testimonial__stars">
            @for($i=0;$i<($t->rating??5);$i++)<span>★</span>@endfor
          </div>
          <p class="apple-testimonial__text">"{{ $t->review }}"</p>
          <div class="apple-testimonial__author">
            <div class="apple-testimonial__avatar">{{ strtoupper(substr($t->name,0,1)) }}</div>
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

{{-- CTA --}}
<section class="apple-cta-banner">
  <div class="apple-cta-banner__inner reveal">
    <span class="apple-eyebrow" style="display:block;text-align:center;margin-bottom:16px;">Visit Our Showroom</span>
    <h2 class="apple-cta-banner__title">Experience Hardware Excellence<br>In Person</h2>
    <p class="apple-cta-banner__sub">Visit our Surat showroom with live product demonstrations, or contact us for project consultation.</p>
    <div class="apple-cta-banner__actions">
      <a href="{{ route('contact.index') }}" class="apple-btn apple-btn--primary"><i class="bi bi-geo-alt"></i> Get Directions</a>
      <a href="{{ route('quote.index') }}" class="apple-btn apple-btn--ghost"><i class="bi bi-file-earmark-text"></i> Request a Quote</a>
    </div>
  </div>
</section>

@endsection
