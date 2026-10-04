@extends('layouts.app')
@section('title', $category->name . ' — Laxmi Hardware')
@section('meta_description', 'Browse ' . $category->name . ' products at Laxmi Hardware — ' . Str::limit($category->description, 120))

@section('content')

{{-- CATEGORY HERO --}}
<section style="padding:100px 0 64px;background:#000;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-100px;left:-100px;width:500px;height:500px;background:radial-gradient(ellipse,rgba(201,169,110,0.08) 0%,transparent 70%);pointer-events:none;"></div>
  <div class="apple-container" style="position:relative;">
    {{-- Breadcrumb --}}
    <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:#6e6e73;margin-bottom:24px;flex-wrap:wrap;">
      <a href="{{ route('home') }}" style="color:#6e6e73;text-decoration:none;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='#6e6e73'">Home</a>
      <span>›</span>
      <a href="{{ route('categories.index') }}" style="color:#6e6e73;text-decoration:none;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='#6e6e73'">Categories</a>
      <span>›</span>
      <span style="color:#f5f5f7;">{{ $category->name }}</span>
    </div>

    <div style="display:grid;grid-template-columns:1fr auto;gap:32px;align-items:end;flex-wrap:wrap;">
      <div>
        <div style="display:inline-flex;align-items:center;gap:8px;font-size:10px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#c9a96e;background:rgba(201,169,110,0.1);border:1px solid rgba(201,169,110,0.25);padding:5px 14px;border-radius:100px;margin-bottom:16px;">
          <i class="bi {{ $category->icon ?: 'bi-tools' }}"></i> Category
        </div>
        <h1 style="font-size:clamp(32px,5vw,56px);font-weight:700;letter-spacing:-.05em;line-height:1.06;color:#f5f5f7;margin-bottom:14px;">{{ $category->name }}</h1>
        @if($category->description)
          <p style="font-size:17px;color:#a1a1a6;font-weight:300;max-width:600px;line-height:1.6;">{{ $category->description }}</p>
        @endif
      </div>
      <div style="text-align:right;">
        <div style="font-size:48px;font-weight:700;letter-spacing:-.04em;color:#c9a96e;line-height:1;">{{ $products->total() }}</div>
        <div style="font-size:12px;color:#6e6e73;letter-spacing:.06em;text-transform:uppercase;">Products</div>
      </div>
    </div>

    {{-- Subcategory Pills --}}
    @if($category->subcategories && $category->subcategories->count() > 0)
      <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:28px;">
        <span style="font-size:11px;color:#6e6e73;align-self:center;margin-right:4px;">Sub-categories:</span>
        @foreach($category->subcategories as $sub)
          <a href="{{ route('products.index', ['category'=>$category->slug,'subcategory'=>$sub->slug]) }}" style="font-size:12px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:100px;padding:5px 14px;text-decoration:none;transition:color .2s,border-color .2s;" onmouseover="this.style.color='#c9a96e';this.style.borderColor='rgba(201,169,110,0.3)'" onmouseout="this.style.color='#a1a1a6';this.style.borderColor='rgba(255,255,255,0.1)'">{{ $sub->name }}</a>
        @endforeach
      </div>
    @endif
  </div>
</section>

{{-- PRODUCTS --}}
<section class="apple-section apple-section--dark" style="padding-top:32px;">
  <div class="apple-container">
    @if($products->count() > 0)
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:14px;margin-bottom:48px;">
        @foreach($products as $product)
          <div class="apple-bento__item reveal" style="border-radius:16px;overflow:hidden;border:1px solid rgba(255,255,255,0.07);">
            <div style="position:relative;overflow:hidden;background:#0a0a0a;">
              <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" style="width:100%;height:200px;object-fit:cover;display:block;transition:transform .5s;" loading="lazy"
                onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
              @if($product->brand)
                <span style="position:absolute;top:10px;left:10px;font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#000;background:#c9a96e;border-radius:100px;padding:3px 9px;">{{ $product->brand->name }}</span>
              @endif
            </div>
            <div style="padding:16px 18px 20px;background:#111;">
              <div style="font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#6e6e73;margin-bottom:5px;">{{ $product->sku }}</div>
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

      {{-- Pagination --}}
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
        <h3 style="color:#f5f5f7;margin-bottom:10px;">No products in this category yet</h3>
        <a href="{{ route('products.index') }}" class="apple-btn apple-btn--ghost" style="margin-top:16px;">Browse All Products</a>
      </div>
    @endif
  </div>
</section>

{{-- OTHER CATEGORIES --}}
@if($otherCategories->count() > 0)
<section class="apple-section apple-section--alt">
  <div class="apple-container">
    <div class="apple-section__header" style="margin-bottom:36px;">
      <span class="apple-eyebrow">Explore More</span>
      <h2 class="apple-title-sm" style="margin-top:8px;">Other Categories</h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:10px;">
      @foreach($otherCategories as $oc)
        <a href="{{ route('categories.show', $oc->slug) }}" style="text-decoration:none;">
          <div class="apple-card reveal" style="padding:24px;text-align:center;">
            <div class="apple-card__icon" style="margin:0 auto 14px;"><i class="bi {{ $oc->icon ?: 'bi-tools' }}"></i></div>
            <div class="apple-card__title" style="font-size:14px;">{{ $oc->name }}</div>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endif

@endsection
