@extends('layouts.app')
@section('title', $project->title . ' — Laxmi Hardware Projects')
@section('meta_description', Str::limit($project->description ?? $project->title, 150))

@section('content')

{{-- BREADCRUMB --}}
<div style="background:#0a0a0a;border-bottom:1px solid rgba(255,255,255,0.06);padding:14px 0;">
  <div class="apple-container" style="display:flex;align-items:center;gap:8px;font-size:12px;color:#6e6e73;flex-wrap:wrap;">
    <a href="{{ route('home') }}" style="color:#6e6e73;text-decoration:none;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='#6e6e73'">Home</a>
    <span>›</span>
    <a href="{{ route('projects.index') }}" style="color:#6e6e73;text-decoration:none;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='#6e6e73'">Projects</a>
    <span>›</span>
    <span style="color:#f5f5f7;">{{ Str::limit($project->title, 40) }}</span>
  </div>
</div>

{{-- HERO IMAGE --}}
<div style="position:relative;overflow:hidden;background:#000;max-height:600px;">
  <img src="{{ $project->featured_image_url }}" alt="{{ $project->title }}" style="width:100%;height:600px;object-fit:cover;opacity:.7;">
  <div style="position:absolute;inset:0;background:linear-gradient(to bottom,transparent 40%,rgba(0,0,0,0.9) 100%);display:flex;flex-direction:column;justify-content:flex-end;padding:60px;">
    <div class="apple-container">
      <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px;">
        <span style="font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#c9a96e;background:rgba(201,169,110,0.15);border:1px solid rgba(201,169,110,0.3);padding:4px 12px;border-radius:100px;">{{ $project->category }}</span>
        @if($project->location)
          <span style="font-size:11px;color:rgba(255,255,255,0.5);display:flex;align-items:center;gap:4px;"><i class="bi bi-geo-alt"></i>{{ $project->location }}</span>
        @endif
      </div>
      <h1 style="font-size:clamp(28px,5vw,56px);font-weight:700;letter-spacing:-.05em;line-height:1.06;color:#f5f5f7;max-width:800px;">{{ $project->title }}</h1>
    </div>
  </div>
</div>

{{-- PROJECT DETAIL --}}
<section class="apple-section apple-section--dark" style="padding-top:64px;">
  <div class="apple-container">
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:64px;align-items:start;">

      {{-- Description --}}
      <div class="reveal">
        @if($project->description)
          <h2 style="font-size:24px;font-weight:700;letter-spacing:-.03em;color:#f5f5f7;margin-bottom:20px;">About This Project</h2>
          <div style="color:#a1a1a6;font-size:16px;line-height:1.8;font-weight:300;">
            {!! nl2br(e($project->description)) !!}
          </div>
        @endif

        {{-- Image Gallery --}}
        @if($project->images && $project->images->count() > 0)
          <div style="margin-top:48px;">
            <h3 style="font-size:16px;font-weight:700;letter-spacing:-.02em;color:#f5f5f7;margin-bottom:20px;">Project Gallery</h3>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:10px;">
              @foreach($project->images as $img)
                <div style="border-radius:12px;overflow:hidden;aspect-ratio:4/3;background:#0a0a0a;cursor:pointer;" onclick="openLightbox('{{ $img->image_url }}')">
                  <img src="{{ $img->image_url }}" alt="{{ $project->title }}" style="width:100%;height:100%;object-fit:cover;transition:transform .4s;" loading="lazy"
                    onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                </div>
              @endforeach
            </div>
          </div>
        @endif
      </div>

      {{-- Sidebar --}}
      <div class="reveal reveal--delay-1">
        <div style="background:#111;border:1px solid rgba(255,255,255,0.08);border-radius:20px;padding:28px;position:sticky;top:72px;">
          <h3 style="font-size:13px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#6e6e73;margin-bottom:20px;">Project Info</h3>
          <div style="display:flex;flex-direction:column;gap:0;">
            @if($project->category)
              <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid rgba(255,255,255,0.06);">
                <span style="font-size:13px;color:#6e6e73;">Category</span>
                <span style="font-size:13px;color:#f5f5f7;font-weight:500;">{{ $project->category }}</span>
              </div>
            @endif
            @if($project->location)
              <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid rgba(255,255,255,0.06);">
                <span style="font-size:13px;color:#6e6e73;">Location</span>
                <span style="font-size:13px;color:#f5f5f7;font-weight:500;">{{ $project->location }}</span>
              </div>
            @endif
            @if($project->client)
              <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid rgba(255,255,255,0.06);">
                <span style="font-size:13px;color:#6e6e73;">Client</span>
                <span style="font-size:13px;color:#f5f5f7;font-weight:500;">{{ $project->client }}</span>
              </div>
            @endif
            @if($project->year)
              <div style="display:flex;justify-content:space-between;padding:12px 0;">
                <span style="font-size:13px;color:#6e6e73;">Year</span>
                <span style="font-size:13px;color:#f5f5f7;font-weight:500;">{{ $project->year }}</span>
              </div>
            @endif
          </div>
          <div style="margin-top:24px;display:flex;flex-direction:column;gap:10px;">
            <a href="{{ route('quote.index') }}" class="apple-btn apple-btn--primary" style="justify-content:center;font-size:13px;">
              <i class="bi bi-file-earmark-text"></i> Request Similar Quote
            </a>
            <button onclick="openEnquiryModal('{{ addslashes($project->title) }} — Project Enquiry', '')" class="apple-btn apple-btn--ghost" style="justify-content:center;font-size:13px;">
              <i class="bi bi-envelope"></i> Send Enquiry
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- RELATED PROJECTS --}}
@if($relatedProjects->count() > 0)
<section class="apple-section apple-section--alt">
  <div class="apple-container">
    <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:32px;flex-wrap:wrap;gap:12px;">
      <h2 class="apple-title-sm">More Projects</h2>
      <a href="{{ route('projects.index') }}" class="apple-btn apple-btn--ghost" style="font-size:13px;padding:9px 18px;">View All</a>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:14px;">
      @foreach($relatedProjects as $rp)
        <div class="reveal" style="position:relative;border-radius:16px;overflow:hidden;aspect-ratio:4/3;background:#0a0a0a;transition:transform .3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
          <img src="{{ $rp->featured_image_url }}" alt="{{ $rp->title }}" style="width:100%;height:100%;object-fit:cover;transition:transform .6s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
          <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.8) 0%,transparent 60%);display:flex;flex-direction:column;justify-content:flex-end;padding:22px;">
            <span style="font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#c9a96e;margin-bottom:6px;">{{ $rp->category }}</span>
            <h3 style="font-size:17px;font-weight:700;color:#f5f5f7;margin-bottom:10px;line-height:1.2;">{{ $rp->title }}</h3>
            <a href="{{ route('projects.show', $rp->slug) }}" class="apple-btn apple-btn--ghost" style="font-size:12px;padding:7px 14px;width:fit-content;backdrop-filter:blur(8px);">View Project</a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- Lightbox --}}
<div id="lightboxOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.95);z-index:99999;display:flex;align-items:center;justify-content:center;padding:40px;cursor:zoom-out;" onclick="closeLightbox()">
  <img id="lightboxImg" src="" style="max-width:100%;max-height:100%;object-fit:contain;border-radius:12px;">
</div>

@push('scripts')
<script>
function openLightbox(src) {
  document.getElementById('lightboxImg').src = src;
  document.getElementById('lightboxOverlay').style.display = 'flex';
  document.body.style.overflow = 'hidden';
}
function closeLightbox() {
  document.getElementById('lightboxOverlay').style.display = 'none';
  document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if(e.key==='Escape') closeLightbox(); });
</script>
@endpush

@endsection
