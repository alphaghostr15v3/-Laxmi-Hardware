@extends('layouts.app')
@section('title', $brand->name . ' Products — Laxmi Hardware')
@section('meta_description', 'Browse all ' . $brand->name . ' products available at Laxmi Hardware — authorized dealer in Surat.')

@section('content')

{{-- BREADCRUMB --}}
<div style="background:#0a0a0a;border-bottom:1px solid rgba(255,255,255,0.06);padding:14px 0;">
  <div class="apple-container" style="display:flex;align-items:center;gap:8px;font-size:12px;color:#6e6e73;flex-wrap:wrap;">
    <a href="{{ route('home') }}" style="color:#6e6e73;text-decoration:none;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='#6e6e73'">Home</a>
    <span>›</span>
    <a href="{{ route('brands.index') }}" style="color:#6e6e73;text-decoration:none;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='#6e6e73'">Brands</a>
    <span>›</span>
    <span style="color:#f5f5f7;">{{ $brand->name }}</span>
  </div>
</div>

{{-- BRAND HERO --}}
<section style="padding:80px 0 56px;background:#000;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-100px;right:-100px;width:500px;height:500px;background:radial-gradient(ellipse,rgba(201,169,110,0.07) 0%,transparent 70%);pointer-events:none;"></div>
  <div class="apple-container" style="position:relative;">
    <div style="display:flex;align-items:center;gap:28px;flex-wrap:wrap;">
      @if($brand->logo)
        <div style="width:100px;height:100px;border-radius:20px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;padding:12px;flex-shrink:0;">
          <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" style="max-width:100%;max-height:100%;object-fit:contain;">
        </div>
      @else
        <div style="width:100px;height:100px;border-radius:20px;background:linear-gradient(135deg,rgba(201,169,110,0.2),rgba(201,169,110,0.05));border:1px solid rgba(201,169,110,0.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <span style="font-size:28px;font-weight:800;color:#c9a96e;">{{ strtoupper(substr($brand->name,0,2)) }}</span>
        </div>
      @endif
      <div>
        <div style="font-size:10px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#c9a96e;margin-bottom:8px;">
          <i class="bi bi-patch-check-fill" style="margin-right:4px;"></i>Authorized Dealer
          @if($brand->country) &nbsp;·&nbsp; {{ $brand->country }} @endif
        </div>
        <h1 style="font-size:clamp(32px,5vw,52px);font-weight:700;letter-spacing:-.05em;line-height:1.06;color:#f5f5f7;margin-bottom:10px;">{{ $brand->name }}</h1>
        @if($brand->description)
          <p style="font-size:16px;color:#a1a1a6;font-weight:300;max-width:600px;line-height:1.6;">{{ $brand->description }}</p>
        @endif
      </div>
      <div style="margin-left:auto;text-align:right;">
        <div style="font-size:42px;font-weight:700;letter-spacing:-.04em;color:#c9a96e;line-height:1;">{{ $products->total() }}</div>
        <div style="font-size:12px;color:#6e6e73;letter-spacing:.06em;text-transform:uppercase;">Products</div>
      </div>
    </div>
  </div>
</section>

{{-- PRODUCTS --}}
<section class="apple-section apple-section--dark" style="padding-top:32px;">
  <div class="apple-container">
    @if($products->count() > 0)
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:14px;margin-bottom:48px;">
        @foreach($products as $product)
          <div class="apple-bento__item reveal" style="border-radius:16px;overflow:hidden;border:1px solid rgba(255,255,255,0.07);">
            <div style="overflow:hidden;background:#0a0a0a;">
              <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" style="width:100%;height:200px;object-fit:cover;transition:transform .5s;" loading="lazy"
                onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </div>
            <div style="padding:16px 18px 20px;background:#111;">
              <div style="font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#6e6e73;margin-bottom:5px;">{{ $product->category->name ?? '' }} &nbsp;·&nbsp; {{ $product->sku }}</div>
              <h3 style="font-size:15px;font-weight:600;letter-spacing:-.02em;color:#f5f5f7;margin-bottom:8px;line-height:1.3;">
                <a href="{{ route('products.show', $product->slug) }}" style="color:inherit;text-decoration:none;">{{ $product->name }}</a>
              </h3>
              <p style="font-size:13px;color:#6e6e73;font-weight:300;line-height:1.6;margin-bottom:14px;">{{ Str::limit($product->short_description, 80) }}</p>
              <div style="display:flex;gap:8px;">
                <a href="{{ route('products.show', $product->slug) }}" class="apple-btn apple-btn--ghost" style="font-size:12px;padding:8px 14px;flex:1;justify-content:center;"><i class="bi bi-eye"></i> View</a>
                <button onclick="openEnquiryModal('{{ addslashes($product->name) }}','{{ $product->sku }}')" class="apple-btn apple-btn--primary" style="font-size:12px;padding:8px 14px;flex:1;justify-content:center;"><i class="bi bi-envelope"></i> Enquire</button>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      @if($products->hasPages())
        <div style="display:flex;justify-content:center;gap:6px;flex-wrap:wrap;">
          @if(!$products->onFirstPage())<a href="{{ $products->previousPageUrl() }}" style="padding:8px 16px;border-radius:100px;font-size:13px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);text-decoration:none;">‹ Prev</a>@endif
          @foreach($products->getUrlRange(max(1,$products->currentPage()-2),min($products->lastPage(),$products->currentPage()+2)) as $page => $url)
            @if($page==$products->currentPage())
              <span style="padding:8px 16px;border-radius:100px;font-size:13px;color:#000;background:#c9a96e;font-weight:600;">{{ $page }}</span>
            @else
              <a href="{{ $url }}" style="padding:8px 16px;border-radius:100px;font-size:13px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);text-decoration:none;">{{ $page }}</a>
            @endif
          @endforeach
          @if($products->hasMorePages())<a href="{{ $products->nextPageUrl() }}" style="padding:8px 16px;border-radius:100px;font-size:13px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);text-decoration:none;">Next ›</a>@endif
        </div>
      @endif
    @else
      <div style="text-align:center;padding:80px 0;">
        <div style="font-size:48px;color:#2a2a2a;margin-bottom:16px;"><i class="bi bi-inbox"></i></div>
        <h3 style="color:#f5f5f7;margin-bottom:10px;">No products for this brand yet</h3>
        <a href="{{ route('products.index') }}" class="apple-btn apple-btn--ghost" style="margin-top:16px;">Browse All Products</a>
      </div>
    @endif
  </div>
</section>

{{-- Other Brands --}}
@if($otherBrands->count() > 0)
<section class="apple-section apple-section--alt">
  <div class="apple-container">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
      <h2 class="apple-title-sm">Other Brands</h2>
      <a href="{{ route('brands.index') }}" class="apple-btn apple-btn--ghost" style="font-size:13px;padding:9px 18px;">All Brands</a>
    </div>
    <div style="display:flex;flex-wrap:wrap;gap:10px;">
      @foreach($otherBrands as $ob)
        <a href="{{ route('brands.show', $ob->slug) }}" style="display:flex;align-items:center;gap:10px;font-size:13px;color:#a1a1a6;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.09);border-radius:12px;padding:10px 16px;text-decoration:none;transition:all .2s;" onmouseover="this.style.borderColor='rgba(201,169,110,0.3)';this.style.color='#c9a96e'" onmouseout="this.style.borderColor='rgba(255,255,255,0.09)';this.style.color='#a1a1a6'">
          <span style="font-weight:600;">{{ $ob->name }}</span>
          <i class="bi bi-arrow-right" style="font-size:12px;"></i>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

@endsection
