@extends('layouts.app')
@section('title', $product->name . ' — Laxmi Hardware')
@section('meta_description', $product->short_description ?? 'View details for ' . $product->name . ' at Laxmi Hardware Surat.')

@section('content')

{{-- BREADCRUMB --}}
<div style="background:#0a0a0a;border-bottom:1px solid rgba(255,255,255,0.06);padding:14px 0;">
  <div class="apple-container" style="display:flex;align-items:center;gap:8px;font-size:12px;color:#6e6e73;flex-wrap:wrap;">
    <a href="{{ route('home') }}" style="color:#6e6e73;text-decoration:none;transition:color .2s;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='#6e6e73'">Home</a>
    <span>›</span>
    <a href="{{ route('products.index') }}" style="color:#6e6e73;text-decoration:none;transition:color .2s;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='#6e6e73'">Products</a>
    @if($product->category)
      <span>›</span>
      <a href="{{ route('categories.show', $product->category->slug) }}" style="color:#6e6e73;text-decoration:none;transition:color .2s;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='#6e6e73'">{{ $product->category->name }}</a>
    @endif
    <span>›</span>
    <span style="color:#f5f5f7;">{{ Str::limit($product->name, 40) }}</span>
  </div>
</div>

{{-- PRODUCT DETAIL --}}
<section class="apple-section apple-section--dark" style="padding-top:48px;">
  <div class="apple-container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:start;">

      {{-- LEFT: IMAGE GALLERY --}}
      <div class="reveal">
        {{-- Main Image --}}
        <div style="background:#0d0d0d;border:1px solid rgba(255,255,255,0.07);border-radius:20px;overflow:hidden;aspect-ratio:1;margin-bottom:12px;display:flex;align-items:center;justify-content:center;">
          <img id="mainProductImg" src="{{ $product->main_image_url }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:contain;padding:20px;transition:opacity 0.2s ease;">
        </div>

        @php
            $galleryItems = collect([$product->main_image_url]);
            if ($product->images) {
                foreach ($product->images as $img) {
                    $url = $img->image_url;
                    if ($url && $url !== $product->main_image_url && !$galleryItems->contains($url)) {
                        $galleryItems->push($url);
                    }
                }
            }
        @endphp

        {{-- Thumbnails --}}
        @if($galleryItems->count() > 1)
          <div style="display:flex;gap:8px;flex-wrap:wrap;" id="productThumbnails">
            @foreach($galleryItems as $index => $imgUrl)
              <div class="prod-thumb {{ $index === 0 ? 'is-active' : '' }}"
                   style="width:72px;height:72px;border-radius:10px;overflow:hidden;border:2px solid {{ $index === 0 ? '#c9a96e' : 'rgba(255,255,255,0.1)' }};cursor:pointer;background:#0a0a0a;transition:all .2s;" 
                   onclick="selectProductThumb('{{ $imgUrl }}', this)">
                <img src="{{ $imgUrl }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;">
              </div>
            @endforeach
          </div>
        @endif
      </div>

      {{-- RIGHT: INFO --}}
      <div class="reveal reveal--delay-1">
        {{-- Badges --}}
        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px;">
          @if($product->brand)
            <span style="font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#000;background:#c9a96e;border-radius:100px;padding:4px 12px;">{{ $product->brand->name }}</span>
          @endif
          @if($product->featured)
            <span style="font-size:10px;font-weight:600;color:#c9a96e;background:rgba(201,169,110,0.15);border:1px solid rgba(201,169,110,0.3);border-radius:100px;padding:4px 12px;">★ Featured</span>
          @endif
          @if($product->category)
            <span style="font-size:10px;font-weight:600;color:#a1a1a6;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:100px;padding:4px 12px;">{{ $product->category->name }}</span>
          @endif
        </div>

        <h1 style="font-size:clamp(24px,3vw,38px);font-weight:700;letter-spacing:-.04em;line-height:1.1;color:#f5f5f7;margin-bottom:12px;">{{ $product->name }}</h1>

        <div style="font-size:12px;color:#6e6e73;margin-bottom:20px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
          <span><i class="bi bi-tag" style="margin-right:4px;"></i>SKU: <strong style="color:#a1a1a6;">{{ $product->sku }}</strong></span>
          @if($product->subcategory)
            <span style="color:#3a3a3a;">|</span>
            <span>{{ $product->subcategory->name }}</span>
          @endif
        </div>

        @if($product->short_description)
          <p style="font-size:16px;color:#a1a1a6;font-weight:300;line-height:1.7;margin-bottom:28px;border-bottom:1px solid rgba(255,255,255,0.06);padding-bottom:28px;">{{ $product->short_description }}</p>
        @endif

        {{-- Specifications --}}
        @if($product->specifications && $product->specifications->count() > 0)
          <div style="margin-bottom:28px;">
            <h3 style="font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#6e6e73;margin-bottom:14px;">Specifications</h3>
            <div style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden;">
              @foreach($product->specifications as $i => $spec)
                <div style="display:grid;grid-template-columns:1fr 1fr;padding:12px 18px;{{ $i < $product->specifications->count()-1 ? 'border-bottom:1px solid rgba(255,255,255,0.05);' : '' }}">
                  <span style="font-size:13px;color:#6e6e73;font-weight:500;">{{ $spec->label }}</span>
                  <span style="font-size:13px;color:#f5f5f7;">{{ $spec->value }}</span>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        {{-- Application tags --}}
        @if($product->application)
          <div style="margin-bottom:28px;">
            <h3 style="font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#6e6e73;margin-bottom:10px;">Application</h3>
            <div style="display:flex;flex-wrap:wrap;gap:6px;">
              @foreach(explode(',', $product->application) as $app)
                <span style="font-size:12px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:100px;padding:4px 12px;">{{ trim($app) }}</span>
              @endforeach
            </div>
          </div>
        @endif

        {{-- CTA Buttons --}}
        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:24px;">
          <button type="button" class="apple-btn apple-btn--primary" style="flex:1;min-width:160px;justify-content:center;"
            onclick="openEnquiryModal('{{ addslashes($product->name) }}','{{ $product->sku }}')">
            <i class="bi bi-envelope-fill"></i> Send Enquiry
          </button>
          <a href="{{ route('quote.index', ['product'=>$product->name]) }}" class="apple-btn apple-btn--ghost" style="flex:1;min-width:160px;justify-content:center;">
            <i class="bi bi-file-earmark-text"></i> Request Quote
          </a>
        </div>

        {{-- WhatsApp --}}
        <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp','919876543210') }}?text=Hello+Laxmi+Hardware%2C+I+am+interested+in+{{ urlencode($product->name) }}+(SKU%3A+{{ $product->sku }})"
           target="_blank"
           style="display:flex;align-items:center;gap:10px;font-size:13px;color:#25d366;padding:12px 18px;background:rgba(37,211,102,0.07);border:1px solid rgba(37,211,102,0.2);border-radius:12px;text-decoration:none;transition:background .2s;"
           onmouseover="this.style.background='rgba(37,211,102,0.12)'" onmouseout="this.style.background='rgba(37,211,102,0.07)'">
          <i class="bi bi-whatsapp" style="font-size:18px;"></i>
          <span>Chat about this product on WhatsApp</span>
          <i class="bi bi-arrow-right" style="margin-left:auto;"></i>
        </a>
      </div>
    </div>

    {{-- FULL DESCRIPTION --}}
    @if($product->description)
      <div style="margin-top:64px;padding-top:64px;border-top:1px solid rgba(255,255,255,0.07);" class="reveal">
        <h2 style="font-size:24px;font-weight:700;letter-spacing:-.03em;color:#f5f5f7;margin-bottom:20px;">Product Details</h2>
        <div style="color:#a1a1a6;font-size:15px;line-height:1.8;font-weight:300;max-width:800px;">
          {!! nl2br(e($product->description)) !!}
        </div>
      </div>
    @endif
  </div>
</section>

{{-- RELATED PRODUCTS --}}
@if($relatedProducts->count() > 0)
<section class="apple-section apple-section--alt">
  <div class="apple-container">
    <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:32px;flex-wrap:wrap;gap:12px;">
      <div>
        <span class="apple-eyebrow">You May Also Like</span>
        <h2 class="apple-title-sm" style="margin-top:8px;">Related Products</h2>
      </div>
      <a href="{{ route('products.index', ['category'=>$product->category->slug??'']) }}" class="apple-btn apple-btn--ghost" style="font-size:13px;padding:9px 18px;">View More</a>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:14px;">
      @foreach($relatedProducts as $rp)
        <div class="apple-bento__item reveal" style="border-radius:14px;overflow:hidden;border:1px solid rgba(255,255,255,0.07);">
          <img src="{{ $rp->main_image_url }}" alt="{{ $rp->name }}" style="width:100%;height:180px;object-fit:cover;transition:transform .4s;" loading="lazy"
            onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
          <div style="padding:16px 18px 20px;background:#111;">
            <div style="font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#6e6e73;margin-bottom:5px;">{{ $rp->category->name ?? '' }}</div>
            <h3 style="font-size:14px;font-weight:600;color:#f5f5f7;margin-bottom:12px;line-height:1.3;">
              <a href="{{ route('products.show', $rp->slug) }}" style="color:inherit;text-decoration:none;">{{ $rp->name }}</a>
            </h3>
            <a href="{{ route('products.show', $rp->slug) }}" class="apple-btn apple-btn--ghost" style="font-size:12px;padding:7px 14px;width:100%;justify-content:center;">View Details</a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

@endsection

@push('styles')
<style>
  @media (max-width:768px) {
    .product-grid { grid-template-columns: 1fr !important; }
  }
  .prod-thumb:hover {
    border-color: #c9a96e !important;
    opacity: 0.9;
  }
</style>
@endpush

@push('scripts')
<script>
  function selectProductThumb(imgUrl, el) {
    const mainImg = document.getElementById('mainProductImg');
    if (mainImg) {
      mainImg.style.opacity = '0.4';
      setTimeout(() => {
        mainImg.src = imgUrl;
        mainImg.style.opacity = '1';
      }, 120);
    }
    document.querySelectorAll('#productThumbnails .prod-thumb').forEach(thumb => {
      thumb.style.borderColor = 'rgba(255,255,255,0.1)';
      thumb.classList.remove('is-active');
    });
    el.style.borderColor = '#c9a96e';
    el.classList.add('is-active');
  }
</script>
@endpush
