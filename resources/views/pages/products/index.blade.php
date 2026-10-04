@extends('layouts.app')
@section('title', 'Products — Laxmi Hardware')
@section('meta_description', 'Browse our complete catalogue of interior hardware products — hinges, drawer systems, plywood, bathroom fittings, smart locks and more.')

@section('content')

{{-- PAGE HERO --}}
<section style="padding:100px 0 60px;background:#000;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-80px;left:50%;transform:translateX(-50%);width:600px;height:600px;background:radial-gradient(ellipse,rgba(201,169,110,0.07) 0%,transparent 70%);pointer-events:none;"></div>
  <div class="apple-container" style="position:relative;">
    <span class="apple-eyebrow">Hardware Catalogue</span>
    <h1 class="apple-title" style="margin:12px auto 16px;max-width:600px;">All Products</h1>
    <p class="apple-subtitle" style="max-width:500px;margin:0 auto;">Filter by category, brand, or search to find the exact hardware specification you need.</p>
  </div>
</section>

{{-- FILTER + PRODUCT GRID --}}
<section class="apple-section apple-section--dark" style="padding-top:0;">
  <div class="apple-container">

    {{-- FILTER BAR --}}
    <form method="GET" action="{{ route('products.index') }}" id="filterForm">
      <div style="display:flex;flex-wrap:wrap;gap:10px;align-items:center;padding:24px 0 32px;border-bottom:1px solid rgba(255,255,255,0.07);margin-bottom:32px;">

        {{-- Search --}}
        <div style="flex:1;min-width:200px;display:flex;align-items:center;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:100px;padding:0 16px;gap:10px;transition:border-color .2s;" onfocusin="this.style.borderColor='#c9a96e'" onfocusout="this.style.borderColor='rgba(255,255,255,0.1)'">
          <i class="bi bi-search" style="color:#6e6e73;font-size:13px;"></i>
          <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search products…" style="background:none;border:none;outline:none;color:#f5f5f7;font-size:14px;width:100%;padding:10px 0;font-family:inherit;">
        </div>

        {{-- Category --}}
        <select name="category" onchange="this.form.submit()" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:100px;color:#a1a1a6;font-size:13px;padding:10px 20px;outline:none;cursor:pointer;font-family:inherit;">
          <option value="">All Categories</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->slug }}" {{ ($filters['category'] ?? '') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
          @endforeach
        </select>

        {{-- Brand --}}
        <select name="brand" onchange="this.form.submit()" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:100px;color:#a1a1a6;font-size:13px;padding:10px 20px;outline:none;cursor:pointer;font-family:inherit;">
          <option value="">All Brands</option>
          @foreach($brands as $b)
            <option value="{{ $b->slug }}" {{ ($filters['brand'] ?? '') == $b->slug ? 'selected' : '' }}>{{ $b->name }}</option>
          @endforeach
        </select>

        {{-- Sort --}}
        <select name="sort" onchange="this.form.submit()" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:100px;color:#a1a1a6;font-size:13px;padding:10px 20px;outline:none;cursor:pointer;font-family:inherit;">
          <option value="latest" {{ $sort=='latest'?'selected':'' }}>Latest</option>
          <option value="featured" {{ $sort=='featured'?'selected':'' }}>Featured First</option>
          <option value="name_asc" {{ $sort=='name_asc'?'selected':'' }}>Name A–Z</option>
          <option value="name_desc" {{ $sort=='name_desc'?'selected':'' }}>Name Z–A</option>
        </select>

        <button type="submit" class="apple-btn apple-btn--primary" style="padding:10px 20px;font-size:13px;">
          <i class="bi bi-funnel"></i> Filter
        </button>

        @if(array_filter($filters))
          <a href="{{ route('products.index') }}" style="font-size:13px;color:#6e6e73;display:flex;align-items:center;gap:6px;transition:color .2s;" onmouseover="this.style.color='#f5f5f7'" onmouseout="this.style.color='#6e6e73'">
            <i class="bi bi-x-circle"></i> Clear
          </a>
        @endif
      </div>
    </form>

    {{-- Active Filters --}}
    @if($currentCategory || $currentBrand || !empty($filters['search']))
      <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:24px;align-items:center;">
        <span style="font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:#6e6e73;">Filtered by:</span>
        @if($currentCategory)
          <a href="{{ route('products.index', array_merge($filters, ['category'=>''])) }}" style="display:inline-flex;align-items:center;gap:6px;font-size:12px;color:#c9a96e;background:rgba(201,169,110,0.1);border:1px solid rgba(201,169,110,0.25);padding:4px 12px;border-radius:100px;">
            {{ $currentCategory->name }} <i class="bi bi-x"></i>
          </a>
        @endif
        @if($currentBrand)
          <a href="{{ route('products.index', array_merge($filters, ['brand'=>''])) }}" style="display:inline-flex;align-items:center;gap:6px;font-size:12px;color:#c9a96e;background:rgba(201,169,110,0.1);border:1px solid rgba(201,169,110,0.25);padding:4px 12px;border-radius:100px;">
            {{ $currentBrand->name }} <i class="bi bi-x"></i>
          </a>
        @endif
        @if(!empty($filters['search']))
          <span style="font-size:12px;color:#a1a1a6;">"{{ $filters['search'] }}"</span>
        @endif
      </div>
    @endif

    {{-- Results count --}}
    <div style="font-size:13px;color:#6e6e73;margin-bottom:28px;">
      Showing <strong style="color:#f5f5f7;">{{ $products->total() }}</strong> products
      @if($products->total() > 0) &nbsp;·&nbsp; Page {{ $products->currentPage() }} of {{ $products->lastPage() }} @endif
    </div>

    {{-- PRODUCTS GRID --}}
    @if($products->count() > 0)
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:14px;margin-bottom:48px;">
        @foreach($products as $product)
          <div class="apple-bento__item reveal" style="border-radius:16px;overflow:hidden;border:1px solid rgba(255,255,255,0.07);">
            <div style="position:relative;overflow:hidden;background:#0a0a0a;">
              <img src="{{ $product->main_image_url }}" alt="{{ $product->name }}" style="width:100%;height:220px;object-fit:cover;display:block;transition:transform .5s;" loading="lazy"
                onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
              @if($product->brand)
                <span style="position:absolute;top:12px;left:12px;font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#000;background:#c9a96e;border-radius:100px;padding:3px 10px;">{{ $product->brand->name }}</span>
              @endif
              @if($product->featured)
                <span style="position:absolute;top:12px;right:12px;font-size:10px;font-weight:600;color:#c9a96e;background:rgba(201,169,110,0.15);border:1px solid rgba(201,169,110,0.3);border-radius:100px;padding:3px 10px;">★ Featured</span>
              @endif
            </div>
            <div style="padding:18px 20px 22px;background:#111;">
              <div style="font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#6e6e73;margin-bottom:6px;">
                {{ $product->category->name ?? 'Hardware' }} &nbsp;·&nbsp; {{ $product->sku }}
              </div>
              <h3 style="font-size:15px;font-weight:600;letter-spacing:-.02em;color:#f5f5f7;margin-bottom:8px;line-height:1.3;">
                <a href="{{ route('products.show', $product->slug) }}" style="color:inherit;text-decoration:none;">{{ $product->name }}</a>
              </h3>
              <p style="font-size:13px;color:#6e6e73;font-weight:300;line-height:1.6;margin-bottom:16px;">{{ Str::limit($product->short_description, 80) }}</p>
              <div style="display:flex;gap:8px;">
                <a href="{{ route('products.show', $product->slug) }}" class="apple-btn apple-btn--ghost" style="font-size:12px;padding:8px 14px;flex:1;justify-content:center;">
                  <i class="bi bi-eye"></i> Details
                </a>
                <button type="button" class="apple-btn apple-btn--primary" style="font-size:12px;padding:8px 14px;flex:1;justify-content:center;"
                  onclick="openEnquiryModal('{{ addslashes($product->name) }}','{{ $product->sku }}')">
                  <i class="bi bi-envelope"></i> Enquire
                </button>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- PAGINATION --}}
      @if($products->hasPages())
        <div style="display:flex;justify-content:center;gap:6px;flex-wrap:wrap;">
          @if($products->onFirstPage())
            <span style="padding:8px 16px;border-radius:100px;font-size:13px;color:#3a3a3a;background:#111;border:1px solid rgba(255,255,255,0.06);">‹ Prev</span>
          @else
            <a href="{{ $products->previousPageUrl() }}" style="padding:8px 16px;border-radius:100px;font-size:13px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);text-decoration:none;transition:color .2s,border-color .2s;">‹ Prev</a>
          @endif
          @foreach($products->getUrlRange(max(1,$products->currentPage()-2), min($products->lastPage(),$products->currentPage()+2)) as $page => $url)
            @if($page == $products->currentPage())
              <span style="padding:8px 16px;border-radius:100px;font-size:13px;color:#000;background:#c9a96e;border:1px solid #c9a96e;font-weight:600;">{{ $page }}</span>
            @else
              <a href="{{ $url }}" style="padding:8px 16px;border-radius:100px;font-size:13px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);text-decoration:none;">{{ $page }}</a>
            @endif
          @endforeach
          @if($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}" style="padding:8px 16px;border-radius:100px;font-size:13px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);text-decoration:none;">Next ›</a>
          @else
            <span style="padding:8px 16px;border-radius:100px;font-size:13px;color:#3a3a3a;background:#111;border:1px solid rgba(255,255,255,0.06);">Next ›</span>
          @endif
        </div>
      @endif

    @else
      <div style="text-align:center;padding:80px 0;">
        <div style="font-size:48px;color:#2a2a2a;margin-bottom:16px;"><i class="bi bi-search"></i></div>
        <h3 style="font-size:22px;font-weight:600;color:#f5f5f7;margin-bottom:10px;">No products found</h3>
        <p style="color:#6e6e73;margin-bottom:24px;">Try adjusting your filters or search term.</p>
        <a href="{{ route('products.index') }}" class="apple-btn apple-btn--ghost">Clear All Filters</a>
      </div>
    @endif
  </div>
</section>

@endsection
