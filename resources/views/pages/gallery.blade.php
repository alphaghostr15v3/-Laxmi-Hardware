@extends('layouts.app')
@section('title', 'Gallery — Laxmi Hardware')
@section('meta_description', 'Browse our installation gallery — kitchen hardware, wardrobe systems, bathroom fittings, curtain tracks, and plywood projects.')

@section('content')

{{-- HERO SECTION --}}
<section style="padding:100px 0 50px;background:#000;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-100px;left:50%;transform:translateX(-50%);width:750px;height:750px;background:radial-gradient(ellipse,rgba(201,169,110,0.1) 0%,transparent 70%);pointer-events:none;"></div>
  <div class="apple-container" style="position:relative;z-index:2;">
    <span class="apple-eyebrow reveal">Visual Showcase</span>
    <h1 class="apple-title reveal reveal--delay-1" style="max-width:650px;margin:12px auto 18px;">Installation Gallery</h1>
    <p class="apple-subtitle reveal reveal--delay-2" style="max-width:560px;margin:0 auto;">Explore real architectural & modular interior installations across Surat and South Gujarat.</p>
  </div>
</section>

{{-- GALLERY CONTENT --}}
<section class="apple-section apple-section--dark" style="padding-top:16px;">
  <div class="apple-container">

    {{-- Category Filter Pills --}}
    <div style="display:flex;flex-wrap:wrap;gap:10px;justify-content:center;margin-bottom:36px;">
      @foreach($categories as $cat)
        @php
          $isActive = ($selectedCategory === $cat) || ($cat === 'All' && ($selectedCategory === 'All' || empty($selectedCategory)));
        @endphp
        <a href="{{ route('gallery.index', ['category' => $cat === 'All' ? '' : $cat]) }}"
           class="gallery-filter-pill {{ $isActive ? 'active' : '' }}"
           style="font-size:13px;font-weight:500;padding:8px 20px;border-radius:100px;text-decoration:none;transition:all .25s;
           {{ $isActive ? 'color:#000;background:#c9a96e;border:1px solid #c9a96e;box-shadow:0 4px 15px rgba(201,169,110,0.3);font-weight:600;' : 'color:#a1a1a6;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.09);' }}">
          {{ $cat }}
        </a>
      @endforeach
    </div>

    {{-- Gallery Grid --}}
    @if($items->count() > 0)
      <div id="galleryGrid" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));gap:20px;margin-bottom:48px;">
        @foreach($items as $index => $item)
          @php
            $imgUrl = $item->image_url ?? asset($item->image_path ?? 'images/placeholder-hardware.svg');
            $title = $item->title ?? 'Installation Photo';
            $category = $item->category ?? 'Showcase';
            $description = $item->description ?? '';
          @endphp
          <div class="gallery-card reveal" 
               style="border-radius:16px;overflow:hidden;background:#0d0d0d;border:1px solid rgba(255,255,255,0.07);position:relative;cursor:pointer;transition:transform .35s ease, border-color .35s ease, box-shadow .35s ease;"
               onclick="openLightboxIndex({{ $index }})"
               data-index="{{ $index }}">
            
            <div style="position:relative;overflow:hidden;aspect-ratio:4/3;background:#080808;">
              <img src="{{ $imgUrl }}" 
                   alt="{{ $title }}" 
                   class="gallery-card__img"
                   loading="lazy"
                   style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);">
              
              {{-- Hover Overlay --}}
              <div class="gallery-card__overlay" 
                   style="position:absolute;inset:0;background:linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);opacity:0;transition:opacity .35s ease;display:flex;flex-direction:column;justify-content:space-between;padding:20px;">
                <div style="display:flex;justify-content:flex-end;">
                  <span style="width:36px;height:36px;border-radius:50%;background:rgba(201,169,110,0.9);color:#000;display:flex;align-items:center;justify-content:center;font-size:16px;box-shadow:0 4px 12px rgba(0,0,0,0.4);">
                    <i class="bi bi-arrows-fullscreen"></i>
                  </span>
                </div>
                <div>
                  <span style="display:inline-block;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#c9a96e;background:rgba(201,169,110,0.15);border:1px solid rgba(201,169,110,0.3);border-radius:100px;padding:3px 10px;margin-bottom:8px;">{{ $category }}</span>
                  <h4 style="font-size:15px;font-weight:600;color:#fff;margin:0;line-height:1.3;">{{ $title }}</h4>
                </div>
              </div>
            </div>

            {{-- Card Footer Details --}}
            <div style="padding:14px 18px 16px;background:#111;display:flex;align-items:center;justify-content:space-between;gap:12px;">
              <div style="overflow:hidden;">
                <span style="display:block;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#c9a96e;margin-bottom:3px;">{{ $category }}</span>
                <span style="display:block;font-size:13px;font-weight:600;color:#f5f5f7;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $title }}</span>
              </div>
              <button type="button" 
                      class="apple-btn apple-btn--ghost" 
                      style="font-size:11px;padding:6px 12px;border-radius:100px;flex-shrink:0;" 
                      onclick="event.stopPropagation(); openLightboxIndex({{ $index }})">
                <i class="bi bi-zoom-in me-1"></i> View
              </button>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Pagination --}}
      @if($items->hasPages())
        <div style="display:flex;justify-content:center;gap:8px;flex-wrap:wrap;margin-top:24px;">
          @if(!$items->onFirstPage())
            <a href="{{ $items->previousPageUrl() }}" class="apple-btn apple-btn--ghost" style="padding:8px 18px;font-size:13px;">‹ Prev</a>
          @endif
          @foreach($items->getUrlRange(max(1,$items->currentPage()-2),min($items->lastPage(),$items->currentPage()+2)) as $page => $url)
            @if($page == $items->currentPage())
              <span class="apple-btn apple-btn--primary" style="padding:8px 18px;font-size:13px;">{{ $page }}</span>
            @else
              <a href="{{ $url }}" class="apple-btn apple-btn--ghost" style="padding:8px 18px;font-size:13px;">{{ $page }}</a>
            @endif
          @endforeach
          @if($items->hasMorePages())
            <a href="{{ $items->nextPageUrl() }}" class="apple-btn apple-btn--ghost" style="padding:8px 18px;font-size:13px;">Next ›</a>
          @endif
        </div>
      @endif
    @else
      <div style="text-align:center;padding:80px 0;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.05);border-radius:24px;">
        <div style="width:72px;height:72px;margin:0 auto 16px;border-radius:50%;background:rgba(201,169,110,0.1);display:flex;align-items:center;justify-content:center;color:#c9a96e;font-size:32px;">
          <i class="bi bi-images"></i>
        </div>
        <h3 style="color:#f5f5f7;font-size:20px;font-weight:600;margin-bottom:8px;">No gallery images found</h3>
        <p style="color:#6e6e73;font-size:14px;max-width:380px;margin:0 auto 20px;">There are currently no photos in the selected category. Please explore other categories.</p>
        <a href="{{ route('gallery.index') }}" class="apple-btn apple-btn--ghost">View All Photos</a>
      </div>
    @endif
  </div>
</section>

{{-- ADVANCED LIGHTBOX MODAL --}}
<div id="advancedLightbox" 
     class="advanced-lightbox" 
     style="display:none;" 
     role="dialog" 
     aria-modal="true" 
     aria-label="Image Gallery Lightbox">

  {{-- Backdrop --}}
  <div class="advanced-lightbox__backdrop" onclick="closeLightbox()"></div>

  {{-- Top Navigation Bar --}}
  <div class="advanced-lightbox__header">
    <div class="advanced-lightbox__info">
      <span id="lbCounter" class="advanced-lightbox__counter">1 / 1</span>
      <span id="lbCategory" class="advanced-lightbox__category-badge">Category</span>
    </div>
    
    <div class="advanced-lightbox__actions">
      <button type="button" class="lb-btn" id="lbSlideshowBtn" title="Play Slideshow (Space)" onclick="toggleSlideshow()">
        <i class="bi bi-play-fill" id="lbPlayIcon"></i>
      </button>
      <button type="button" class="lb-btn" title="Zoom Out (-)" onclick="zoomImage(-0.25)">
        <i class="bi bi-zoom-out"></i>
      </button>
      <button type="button" class="lb-btn" id="lbZoomResetBtn" title="Reset Zoom (0)" onclick="resetZoom()">
        <span style="font-size:11px;font-weight:600;">100%</span>
      </button>
      <button type="button" class="lb-btn" title="Zoom In (+)" onclick="zoomImage(0.25)">
        <i class="bi bi-zoom-in"></i>
      </button>
      <button type="button" class="lb-btn" title="Toggle Fullscreen (F)" onclick="toggleFullscreen()">
        <i class="bi bi-fullscreen" id="lbFullscreenIcon"></i>
      </button>
      <button type="button" class="lb-btn lb-btn--close" title="Close (Esc)" onclick="closeLightbox()">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>
  </div>

  {{-- Main Stage Area --}}
  <div class="advanced-lightbox__stage" id="lbStage" onclick="handleStageClick(event)">
    {{-- Prev Button --}}
    <button type="button" class="lb-nav-btn lb-nav-btn--prev" title="Previous Image (Left Arrow)" onclick="prevImage()">
      <i class="bi bi-chevron-left"></i>
    </button>

    {{-- Image Wrapper --}}
    <div class="advanced-lightbox__img-container" id="lbImgContainer">
      <div id="lbSpinner" class="advanced-lightbox__spinner">
        <div class="spinner-border text-warning" role="status" style="width:2.5rem;height:2.5rem;"></div>
      </div>
      <img id="lbMainImage" 
           src="" 
           alt="Gallery Preview" 
           class="advanced-lightbox__img"
           ondblclick="toggleDoubleTapZoom(event)">
    </div>

    {{-- Next Button --}}
    <button type="button" class="lb-nav-btn lb-nav-btn--next" title="Next Image (Right Arrow)" onclick="nextImage()">
      <i class="bi bi-chevron-right"></i>
    </button>
  </div>

  {{-- Caption & Details --}}
  <div class="advanced-lightbox__footer">
    <div class="advanced-lightbox__caption">
      <h3 id="lbTitle" class="advanced-lightbox__title">Installation Title</h3>
      <p id="lbDescription" class="advanced-lightbox__description">Installation description...</p>
    </div>

    {{-- Thumbnail Filmstrip --}}
    <div class="advanced-lightbox__filmstrip-wrap">
      <div class="advanced-lightbox__filmstrip" id="lbFilmstrip">
        {{-- Populated dynamically via JS --}}
      </div>
    </div>
  </div>
</div>

@endsection

@push('styles')
<style>
  /* Gallery Card Hover Effects */
  .gallery-card:hover {
    transform: translateY(-5px);
    border-color: rgba(201,169,110,0.4) !important;
    box-shadow: 0 12px 30px rgba(0,0,0,0.6), 0 0 20px rgba(201,169,110,0.12);
  }
  .gallery-card:hover .gallery-card__img {
    transform: scale(1.08);
  }
  .gallery-card:hover .gallery-card__overlay {
    opacity: 1 !important;
  }
  .gallery-filter-pill:hover:not(.active) {
    color: #fff !important;
    background: rgba(255,255,255,0.08) !important;
    border-color: rgba(255,255,255,0.2) !important;
  }

  /* ADVANCED LIGHTBOX STYLES */
  .advanced-lightbox {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    user-select: none;
    touch-action: none;
    animation: lbFadeIn 0.25s ease forwards;
  }

  @keyframes lbFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  .advanced-lightbox__backdrop {
    position: absolute;
    inset: 0;
    background: rgba(5, 5, 5, 0.94);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    z-index: 1;
  }

  /* Header */
  .advanced-lightbox__header {
    position: relative;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 24px;
    background: linear-gradient(to bottom, rgba(0,0,0,0.7) 0%, transparent 100%);
  }

  .advanced-lightbox__info {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .advanced-lightbox__counter {
    font-size: 13px;
    font-weight: 600;
    color: #a1a1a6;
    letter-spacing: 0.05em;
    font-family: monospace;
    background: rgba(255,255,255,0.08);
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid rgba(255,255,255,0.1);
  }

  .advanced-lightbox__category-badge {
    font-size: 11px;
    font-weight: 700;
    color: #000;
    background: #c9a96e;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 4px 12px;
    border-radius: 100px;
  }

  .advanced-lightbox__actions {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .lb-btn {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    color: #f5f5f7;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    transition: all 0.2s ease;
  }
  .lb-btn:hover {
    background: rgba(201,169,110,0.2);
    border-color: #c9a96e;
    color: #c9a96e;
    transform: translateY(-1px);
  }
  .lb-btn--close:hover {
    background: rgba(255,59,48,0.2) !important;
    border-color: #ff3b30 !important;
    color: #ff3b30 !important;
  }

  /* Stage */
  .advanced-lightbox__stage {
    position: relative;
    z-index: 5;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    padding: 10px 80px;
  }

  .advanced-lightbox__img-container {
    position: relative;
    max-width: 100%;
    max-height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .advanced-lightbox__img {
    max-width: 86vw;
    max-height: 65vh;
    object-fit: contain;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.8);
    transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease;
    cursor: grab;
  }
  .advanced-lightbox__img.is-zoomed {
    cursor: grab;
    border-radius: 6px;
  }
  .advanced-lightbox__img.is-dragging {
    cursor: grabbing !important;
  }

  .advanced-lightbox__spinner {
    position: absolute;
    inset: 0;
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 2;
  }

  /* Navigation Buttons */
  .lb-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(20,20,20,0.6);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.15);
    color: #f5f5f7;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    cursor: pointer;
    transition: all 0.25s ease;
    z-index: 10;
  }
  .lb-nav-btn--prev { left: 20px; }
  .lb-nav-btn--next { right: 20px; }
  .lb-nav-btn:hover {
    background: #c9a96e;
    color: #000;
    border-color: #c9a96e;
    box-shadow: 0 4px 20px rgba(201,169,110,0.4);
    transform: translateY(-50%) scale(1.08);
  }

  /* Footer */
  .advanced-lightbox__footer {
    position: relative;
    z-index: 10;
    padding: 12px 24px 20px;
    background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
  }

  .advanced-lightbox__caption {
    text-align: center;
    max-width: 650px;
  }
  .advanced-lightbox__title {
    font-size: 16px;
    font-weight: 600;
    color: #f5f5f7;
    margin: 0 0 4px;
    letter-spacing: -0.01em;
  }
  .advanced-lightbox__description {
    font-size: 12px;
    color: #a1a1a6;
    margin: 0;
    line-height: 1.4;
  }

  /* Filmstrip */
  .advanced-lightbox__filmstrip-wrap {
    width: 100%;
    max-width: 750px;
    overflow-x: auto;
    scrollbar-width: thin;
    scrollbar-color: #c9a96e transparent;
    padding: 4px 0 8px;
  }
  .advanced-lightbox__filmstrip-wrap::-webkit-scrollbar {
    height: 4px;
  }
  .advanced-lightbox__filmstrip-wrap::-webkit-scrollbar-thumb {
    background: rgba(201,169,110,0.4);
    border-radius: 4px;
  }

  .advanced-lightbox__filmstrip {
    display: flex;
    gap: 8px;
    justify-content: center;
    align-items: center;
    min-width: max-content;
    padding: 0 10px;
  }

  .lb-filmstrip-thumb {
    width: 54px;
    height: 54px;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid rgba(255,255,255,0.12);
    opacity: 0.55;
    cursor: pointer;
    background: #000;
    flex-shrink: 0;
    transition: all 0.2s ease;
  }
  .lb-filmstrip-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .lb-filmstrip-thumb:hover {
    opacity: 0.9;
    border-color: rgba(201,169,110,0.6);
  }
  .lb-filmstrip-thumb.is-active {
    opacity: 1;
    border-color: #c9a96e;
    box-shadow: 0 0 12px rgba(201,169,110,0.6);
    transform: scale(1.08);
  }

  /* Mobile adjustments */
  @media (max-width: 768px) {
    .advanced-lightbox__stage {
      padding: 10px 10px;
    }
    .advanced-lightbox__img {
      max-width: 95vw;
      max-height: 58vh;
    }
    .lb-nav-btn {
      width: 42px;
      height: 42px;
      font-size: 18px;
    }
    .lb-nav-btn--prev { left: 10px; }
    .lb-nav-btn--next { right: 10px; }
    .lb-btn {
      width: 34px;
      height: 34px;
      font-size: 13px;
    }
    .advanced-lightbox__header {
      padding: 12px 16px;
    }
    .advanced-lightbox__footer {
      padding: 10px 16px 16px;
    }
  }
</style>
@endpush

@push('scripts')
<script>
  // Prepare Gallery Data
  const galleryItems = [
    @foreach($items as $item)
    {
      src: "{{ $item->image_url ?? asset($item->image_path ?? 'images/placeholder-hardware.svg') }}",
      title: "{{ addslashes($item->title ?? 'Installation Photo') }}",
      category: "{{ addslashes($item->category ?? 'Showcase') }}",
      description: "{{ addslashes($item->description ?? '') }}"
    },
    @endforeach
  ];

  let currentIndex = 0;
  let currentZoom = 1;
  let slideshowInterval = null;
  let isDragging = false;
  let startX, startY, translateX = 0, translateY = 0;
  let touchStartX = 0;
  let touchStartY = 0;

  const lightbox = document.getElementById('advancedLightbox');
  const mainImage = document.getElementById('lbMainImage');
  const spinner = document.getElementById('lbSpinner');
  const counterEl = document.getElementById('lbCounter');
  const categoryEl = document.getElementById('lbCategory');
  const titleEl = document.getElementById('lbTitle');
  const descEl = document.getElementById('lbDescription');
  const filmstripEl = document.getElementById('lbFilmstrip');
  const zoomResetBtn = document.getElementById('lbZoomResetBtn');
  const playIcon = document.getElementById('lbPlayIcon');

  // Build Filmstrip once
  function initFilmstrip() {
    if (!filmstripEl) return;
    filmstripEl.innerHTML = '';
    galleryItems.forEach((item, index) => {
      const thumb = document.createElement('div');
      thumb.className = `lb-filmstrip-thumb ${index === 0 ? 'is-active' : ''}`;
      thumb.dataset.index = index;
      thumb.innerHTML = `<img src="${item.src}" alt="${item.title}" loading="lazy">`;
      thumb.onclick = () => openLightboxIndex(index);
      filmstripEl.appendChild(thumb);
    });
  }
  initFilmstrip();

  // Open Lightbox at Index
  function openLightboxIndex(index) {
    if (!galleryItems || galleryItems.length === 0) return;
    if (index < 0) index = 0;
    if (index >= galleryItems.length) index = galleryItems.length - 1;

    currentIndex = index;
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    renderActiveImage();
  }

  // Compatibility helper for legacy calls
  function openLightbox(src, title, cat) {
    const foundIdx = galleryItems.findIndex(i => i.src === src);
    if (foundIdx !== -1) {
      openLightboxIndex(foundIdx);
    } else {
      galleryItems.push({ src, title: title || 'Image', category: cat || 'Showcase', description: '' });
      initFilmstrip();
      openLightboxIndex(galleryItems.length - 1);
    }
  }

  // Render Image and update UI
  function renderActiveImage() {
    const item = galleryItems[currentIndex];
    if (!item) return;

    resetZoom();

    // Show loading spinner
    spinner.style.display = 'flex';
    mainImage.style.opacity = '0.3';

    const tempImg = new Image();
    tempImg.onload = function() {
      mainImage.src = item.src;
      mainImage.alt = item.title;
      mainImage.style.opacity = '1';
      spinner.style.display = 'none';
    };
    tempImg.onerror = function() {
      mainImage.src = item.src;
      mainImage.style.opacity = '1';
      spinner.style.display = 'none';
    };
    tempImg.src = item.src;

    // Update Text Details
    counterEl.textContent = `${String(currentIndex + 1).padStart(2, '0')} / ${String(galleryItems.length).padStart(2, '0')}`;
    categoryEl.textContent = item.category;
    titleEl.textContent = item.title;
    if (descEl) {
      descEl.textContent = item.description || '';
      descEl.style.display = item.description ? 'block' : 'none';
    }

    // Update active thumbnail in filmstrip
    if (filmstripEl) {
      const thumbs = filmstripEl.querySelectorAll('.lb-filmstrip-thumb');
      thumbs.forEach((t, i) => {
        if (i === currentIndex) {
          t.classList.add('is-active');
          t.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        } else {
          t.classList.remove('is-active');
        }
      });
    }
  }

  // Navigation
  function nextImage() {
    if (galleryItems.length <= 1) return;
    currentIndex = (currentIndex + 1) % galleryItems.length;
    renderActiveImage();
  }

  function prevImage() {
    if (galleryItems.length <= 1) return;
    currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
    renderActiveImage();
  }

  // Close Lightbox
  function closeLightbox() {
    lightbox.style.display = 'none';
    document.body.style.overflow = '';
    stopSlideshow();
    resetZoom();
    if (document.fullscreenElement) {
      document.exitFullscreen().catch(() => {});
    }
  }

  // Close when clicking outside image/buttons
  function handleStageClick(e) {
    if (e.target === document.getElementById('lbStage') || e.target === document.getElementById('lbImgContainer')) {
      closeLightbox();
    }
  }

  // Zoom Controls
  function zoomImage(delta) {
    currentZoom = Math.min(Math.max(1, currentZoom + delta), 3.5);
    applyTransform();
  }

  function resetZoom() {
    currentZoom = 1;
    translateX = 0;
    translateY = 0;
    applyTransform();
  }

  function toggleDoubleTapZoom(e) {
    if (currentZoom > 1) {
      resetZoom();
    } else {
      currentZoom = 2;
      applyTransform();
    }
  }

  function applyTransform() {
    if (currentZoom === 1) {
      translateX = 0;
      translateY = 0;
      mainImage.classList.remove('is-zoomed');
    } else {
      mainImage.classList.add('is-zoomed');
    }
    mainImage.style.transform = `scale(${currentZoom}) translate(${translateX}px, ${translateY}px)`;
    if (zoomResetBtn) {
      zoomResetBtn.querySelector('span').textContent = `${Math.round(currentZoom * 100)}%`;
    }
  }

  // Fullscreen toggle
  function toggleFullscreen() {
    const fsIcon = document.getElementById('lbFullscreenIcon');
    if (!document.fullscreenElement) {
      lightbox.requestFullscreen().then(() => {
        if (fsIcon) fsIcon.className = 'bi bi-fullscreen-exit';
      }).catch(err => console.log(err));
    } else {
      document.exitFullscreen().then(() => {
        if (fsIcon) fsIcon.className = 'bi bi-fullscreen';
      }).catch(err => console.log(err));
    }
  }

  // Slideshow
  function toggleSlideshow() {
    if (slideshowInterval) {
      stopSlideshow();
    } else {
      startSlideshow();
    }
  }

  function startSlideshow() {
    if (slideshowInterval) clearInterval(slideshowInterval);
    if (playIcon) playIcon.className = 'bi bi-pause-fill';
    slideshowInterval = setInterval(() => {
      nextImage();
    }, 3500);
  }

  function stopSlideshow() {
    if (slideshowInterval) {
      clearInterval(slideshowInterval);
      slideshowInterval = null;
    }
    if (playIcon) playIcon.className = 'bi bi-play-fill';
  }

  // Keyboard Shortcuts
  document.addEventListener('keydown', (e) => {
    if (lightbox.style.display !== 'flex') return;

    switch (e.key) {
      case 'Escape':
        closeLightbox();
        break;
      case 'ArrowRight':
      case 'ArrowDown':
        nextImage();
        break;
      case 'ArrowLeft':
      case 'ArrowUp':
        prevImage();
        break;
      case '+':
      case '=':
        zoomImage(0.25);
        break;
      case '-':
      case '_':
        zoomImage(-0.25);
        break;
      case '0':
        resetZoom();
        break;
      case ' ':
        e.preventDefault();
        toggleSlideshow();
        break;
      case 'f':
      case 'F':
        toggleFullscreen();
        break;
    }
  });

  // Touch Swipe & Gestures for Mobile
  const stageEl = document.getElementById('lbStage');
  if (stageEl) {
    stageEl.addEventListener('touchstart', (e) => {
      if (e.touches.length === 1) {
        touchStartX = e.touches[0].clientX;
        touchStartY = e.touches[0].clientY;
      }
    }, { passive: true });

    stageEl.addEventListener('touchend', (e) => {
      if (e.changedTouches.length === 1) {
        const touchEndX = e.changedTouches[0].clientX;
        const touchEndY = e.changedTouches[0].clientY;
        const diffX = touchEndX - touchStartX;
        const diffY = touchEndY - touchStartY;

        if (Math.abs(diffX) > 50 && Math.abs(diffX) > Math.abs(diffY)) {
          if (diffX > 0) {
            prevImage();
          } else {
            nextImage();
          }
        }
      }
    }, { passive: true });
  }

  // Pan / Drag image when zoomed in
  mainImage.addEventListener('mousedown', (e) => {
    if (currentZoom <= 1) return;
    isDragging = true;
    startX = e.clientX - translateX;
    startY = e.clientY - translateY;
    mainImage.classList.add('is-dragging');
  });

  window.addEventListener('mousemove', (e) => {
    if (!isDragging) return;
    translateX = (e.clientX - startX);
    translateY = (e.clientY - startY);
    applyTransform();
  });

  window.addEventListener('mouseup', () => {
    if (isDragging) {
      isDragging = false;
      mainImage.classList.remove('is-dragging');
    }
  });

  // Mouse wheel zoom
  stageEl.addEventListener('wheel', (e) => {
    if (lightbox.style.display !== 'flex') return;
    e.preventDefault();
    if (e.deltaY < 0) {
      zoomImage(0.15);
    } else {
      zoomImage(-0.15);
    }
  }, { passive: false });
</script>
@endpush
