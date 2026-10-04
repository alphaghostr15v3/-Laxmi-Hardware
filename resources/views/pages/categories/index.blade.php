@extends('layouts.app')
@section('title', 'Categories — Laxmi Hardware')
@section('meta_description', 'Browse all hardware categories — kitchen fittings, wardrobe systems, bathroom fittings, marine plywood, smart locks and more.')

@section('content')

<section style="padding:100px 0 60px;background:#000;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-80px;left:50%;transform:translateX(-50%);width:600px;height:600px;background:radial-gradient(ellipse,rgba(201,169,110,0.07) 0%,transparent 70%);pointer-events:none;"></div>
  <div class="apple-container" style="position:relative;">
    <span class="apple-eyebrow">Explore</span>
    <h1 class="apple-title" style="margin:12px auto 16px;max-width:600px;">Product Categories</h1>
    <p class="apple-subtitle" style="max-width:500px;margin:0 auto;">Find hardware by category — from kitchen systems to bathroom fittings, each curated for quality and performance.</p>
  </div>
</section>

<section class="apple-section apple-section--dark" style="padding-top:32px;">
  <div class="apple-container">
    @if($categories->count() > 0)
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:14px;">
        @foreach($categories as $cat)
          <a href="{{ route('categories.show', $cat->slug) }}" style="text-decoration:none;" class="reveal">
            <div class="apple-card" style="height:100%;transition:transform .3s,border-color .3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
              <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <div class="apple-card__icon"><i class="bi {{ $cat->icon ?: 'bi-tools' }}"></i></div>
                <span style="font-size:11px;color:#6e6e73;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:100px;padding:4px 12px;">{{ $cat->products_count }} products</span>
              </div>
              <h2 class="apple-card__title" style="font-size:19px;margin-bottom:10px;">{{ $cat->name }}</h2>
              <p class="apple-card__desc" style="margin-bottom:0;">{{ Str::limit($cat->description, 100) }}</p>
              @if($cat->subcategories && $cat->subcategories->count() > 0)
                <div style="margin-top:16px;display:flex;flex-wrap:wrap;gap:6px;">
                  @foreach($cat->subcategories->take(4) as $sub)
                    <span style="font-size:11px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:100px;padding:3px 10px;">{{ $sub->name }}</span>
                  @endforeach
                  @if($cat->subcategories->count() > 4)
                    <span style="font-size:11px;color:#6e6e73;padding:3px 6px;">+{{ $cat->subcategories->count()-4 }} more</span>
                  @endif
                </div>
              @endif
              <div class="apple-card__link" style="margin-top:20px;">Browse Category <i class="bi bi-arrow-right"></i></div>
            </div>
          </a>
        @endforeach
      </div>
    @else
      <div style="text-align:center;padding:80px 0;">
        <div style="font-size:48px;color:#2a2a2a;margin-bottom:16px;"><i class="bi bi-grid"></i></div>
        <h3 style="color:#f5f5f7;margin-bottom:10px;">No categories yet</h3>
        <p style="color:#6e6e73;">Categories will appear here once added by the admin.</p>
      </div>
    @endif
  </div>
</section>

<section class="apple-cta-banner">
  <div class="apple-cta-banner__inner reveal">
    <span class="apple-eyebrow" style="display:block;text-align:center;margin-bottom:16px;">Can't Find What You Need?</span>
    <h2 class="apple-cta-banner__title">Talk to Our Hardware<br>Specialists</h2>
    <p class="apple-cta-banner__sub">Our technical team can help you find the right specification for your project.</p>
    <div class="apple-cta-banner__actions">
      <a href="{{ route('contact.index') }}" class="apple-btn apple-btn--primary"><i class="bi bi-chat-dots"></i> Contact Us</a>
      <a href="{{ route('quote.index') }}" class="apple-btn apple-btn--ghost"><i class="bi bi-file-earmark-text"></i> Get a Quote</a>
    </div>
  </div>
</section>

@endsection
