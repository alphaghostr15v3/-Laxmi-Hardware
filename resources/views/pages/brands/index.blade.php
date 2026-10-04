@extends('layouts.app')
@section('title', 'Brands — Laxmi Hardware Authorized Dealers')
@section('meta_description', 'Authorized dealer for Hettich, Hafele, Blum, Godrej, Jaquar, Astral, CenturyPly and more premium interior hardware brands.')

@section('content')

<section style="padding:100px 0 64px;background:#000;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-80px;left:50%;transform:translateX(-50%);width:700px;height:700px;background:radial-gradient(ellipse,rgba(201,169,110,0.07) 0%,transparent 70%);pointer-events:none;"></div>
  <div class="apple-container" style="position:relative;">
    <span class="apple-eyebrow reveal">Authorized Partners</span>
    <h1 class="apple-title reveal reveal--delay-1" style="max-width:640px;margin:12px auto 20px;">World-Class Brands,<br>All in One Place</h1>
    <p class="apple-subtitle reveal reveal--delay-2" style="max-width:540px;margin:0 auto;">We are the authorized dealer for {{ $brands->count() }}+ global hardware brands, ensuring you get genuine products with factory warranties.</p>
  </div>
</section>

<section class="apple-section apple-section--dark" style="padding-top:32px;">
  <div class="apple-container">
    @if($brands->count() > 0)
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:14px;">
        @foreach($brands as $brand)
          <a href="{{ route('brands.show', $brand->slug) }}" style="text-decoration:none;" class="reveal">
            <div class="apple-card" style="text-align:center;transition:transform .3s,border-color .3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
              @if($brand->logo)
                <div style="width:80px;height:80px;border-radius:16px;overflow:hidden;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);margin:0 auto 16px;display:flex;align-items:center;justify-content:center;padding:8px;">
                  <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" style="max-width:100%;max-height:100%;object-fit:contain;">
                </div>
              @else
                <div style="width:80px;height:80px;border-radius:16px;background:linear-gradient(135deg,rgba(201,169,110,0.15),rgba(201,169,110,0.05));border:1px solid rgba(201,169,110,0.2);margin:0 auto 16px;display:flex;align-items:center;justify-content:center;">
                  <span style="font-size:22px;font-weight:800;color:#c9a96e;letter-spacing:-.02em;">{{ strtoupper(substr($brand->name, 0, 2)) }}</span>
                </div>
              @endif
              <h2 style="font-size:18px;font-weight:700;letter-spacing:-.02em;color:#f5f5f7;margin-bottom:6px;">{{ $brand->name }}</h2>
              @if($brand->country)
                <p style="font-size:12px;color:#6e6e73;margin-bottom:8px;"><i class="bi bi-globe" style="margin-right:4px;"></i>{{ $brand->country }}</p>
              @endif
              <div style="font-size:12px;color:#c9a96e;background:rgba(201,169,110,0.1);border:1px solid rgba(201,169,110,0.2);border-radius:100px;padding:4px 14px;display:inline-block;margin-bottom:12px;">
                {{ $brand->products_count }} products
              </div>
              @if($brand->description)
                <p style="font-size:13px;color:#6e6e73;line-height:1.6;font-weight:300;margin-bottom:0;">{{ Str::limit($brand->description, 80) }}</p>
              @endif
              <div style="margin-top:16px;font-size:13px;color:#c9a96e;display:flex;align-items:center;justify-content:center;gap:6px;font-weight:500;transition:gap .2s;">
                Browse Products <i class="bi bi-arrow-right"></i>
              </div>
            </div>
          </a>
        @endforeach
      </div>
    @else
      <div style="text-align:center;padding:80px 0;">
        <div style="font-size:48px;color:#2a2a2a;margin-bottom:16px;"><i class="bi bi-award"></i></div>
        <h3 style="color:#f5f5f7;">No brands listed yet</h3>
      </div>
    @endif
  </div>
</section>

{{-- Why Authenticity Matters --}}
<section class="apple-section apple-section--alt">
  <div class="apple-container">
    <div class="apple-section__header">
      <span class="apple-eyebrow reveal">Our Promise</span>
      <h2 class="apple-title reveal reveal--delay-1">Why Authenticity<br>Matters</h2>
    </div>
    <div class="apple-grid apple-grid--4col reveal">
      <div class="apple-card">
        <div class="apple-card__icon"><i class="bi bi-patch-check-fill"></i></div>
        <h3 class="apple-card__title">Factory Warranty</h3>
        <p class="apple-card__desc">Every product comes with the original manufacturer's warranty — no grey market goods.</p>
      </div>
      <div class="apple-card">
        <div class="apple-card__icon"><i class="bi bi-shield-fill-check"></i></div>
        <h3 class="apple-card__title">Quality Assured</h3>
        <p class="apple-card__desc">Sourced directly from authorized distributors with batch traceability and certification.</p>
      </div>
      <div class="apple-card">
        <div class="apple-card__icon"><i class="bi bi-headset"></i></div>
        <h3 class="apple-card__title">Brand Support</h3>
        <p class="apple-card__desc">Access to brand technical support and after-sales service through our authorized network.</p>
      </div>
      <div class="apple-card">
        <div class="apple-card__icon"><i class="bi bi-box-seam-fill"></i></div>
        <h3 class="apple-card__title">Ready Stock</h3>
        <p class="apple-card__desc">Maintain deep inventory of fast-moving SKUs for immediate project supply requirements.</p>
      </div>
    </div>
  </div>
</section>

@endsection
