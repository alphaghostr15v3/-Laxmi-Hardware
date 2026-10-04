@extends('layouts.app')
@section('title', 'Projects — Laxmi Hardware Portfolio')
@section('meta_description', 'Explore Laxmi Hardware\'s project portfolio — residential villas, commercial offices, luxury kitchens, and wardrobe installations in Surat.')

@section('content')

<section style="padding:100px 0 64px;background:#000;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-80px;left:50%;transform:translateX(-50%);width:700px;height:700px;background:radial-gradient(ellipse,rgba(201,169,110,0.07) 0%,transparent 70%);pointer-events:none;"></div>
  <div class="apple-container" style="position:relative;">
    <span class="apple-eyebrow reveal">Our Work</span>
    <h1 class="apple-title reveal reveal--delay-1" style="max-width:600px;margin:12px auto 20px;">Project Portfolio</h1>
    <p class="apple-subtitle reveal reveal--delay-2" style="max-width:500px;margin:0 auto;">Witness our hardware fitted in premier residential villas, corporate towers, and luxury hospitality spaces.</p>
  </div>
</section>

<section class="apple-section apple-section--dark" style="padding-top:24px;">
  <div class="apple-container">

    {{-- Category Filter --}}
    <div style="display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin-bottom:40px;">
      @foreach($categories as $cat)
        <a href="{{ route('projects.index', ['category' => $cat === 'All' ? '' : $cat]) }}"
           style="font-size:13px;font-weight:500;padding:9px 20px;border-radius:100px;text-decoration:none;transition:all .2s;
           {{ ($category ?? 'All') === $cat || ($cat === 'All' && !$category) ? 'color:#000;background:#c9a96e;border:1px solid #c9a96e;' : 'color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);' }}"
           onmouseover="if(this.style.background!='rgb(201, 169, 110)'){this.style.borderColor='rgba(201,169,110,0.3)';this.style.color='#c9a96e';}"
           onmouseout="if(this.style.background!='rgb(201, 169, 110)'){this.style.borderColor='rgba(255,255,255,0.1)';this.style.color='#a1a1a6';}">
          {{ $cat }}
        </a>
      @endforeach
    </div>

    {{-- Projects Grid --}}
    @if($projects->count() > 0)
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:14px;margin-bottom:48px;">
        @foreach($projects as $project)
          <div class="reveal" style="position:relative;border-radius:20px;overflow:hidden;background:#0a0a0a;border:1px solid rgba(255,255,255,0.07);group-hover:transform:translateY(-4px);transition:transform .3s,border-color .3s;"
            onmouseover="this.style.transform='translateY(-4px)';this.style.borderColor='rgba(255,255,255,0.15)'"
            onmouseout="this.style.transform='translateY(0)';this.style.borderColor='rgba(255,255,255,0.07)'">
            <div style="overflow:hidden;aspect-ratio:4/3;">
              <img src="{{ $project->featured_image_url }}" alt="{{ $project->title }}" style="width:100%;height:100%;object-fit:cover;transition:transform .6s;" loading="lazy"
                onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
            </div>
            <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.85) 0%,rgba(0,0,0,0.2) 50%,transparent 100%);display:flex;flex-direction:column;justify-content:flex-end;padding:28px;">
              <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;flex-wrap:wrap;">
                <span style="font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#c9a96e;background:rgba(201,169,110,0.15);border:1px solid rgba(201,169,110,0.3);padding:3px 10px;border-radius:100px;">{{ $project->category }}</span>
                @if($project->location)
                  <span style="font-size:11px;color:rgba(255,255,255,0.5);"><i class="bi bi-geo-alt" style="margin-right:3px;"></i>{{ $project->location }}</span>
                @endif
              </div>
              <h3 style="font-size:20px;font-weight:700;letter-spacing:-.03em;color:#f5f5f7;margin-bottom:12px;line-height:1.2;">{{ $project->title }}</h3>
              @if($project->description)
                <p style="font-size:13px;color:rgba(255,255,255,0.55);font-weight:300;line-height:1.5;margin-bottom:16px;">{{ Str::limit($project->description, 90) }}</p>
              @endif
              <a href="{{ route('projects.show', $project->slug) }}" class="apple-btn apple-btn--ghost" style="font-size:13px;padding:9px 18px;width:fit-content;backdrop-filter:blur(8px);">
                View Project <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Pagination --}}
      @if($projects->hasPages())
        <div style="display:flex;justify-content:center;gap:6px;flex-wrap:wrap;">
          @if(!$projects->onFirstPage())<a href="{{ $projects->previousPageUrl() }}" style="padding:8px 16px;border-radius:100px;font-size:13px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);text-decoration:none;">‹ Prev</a>@endif
          @foreach($projects->getUrlRange(max(1,$projects->currentPage()-2),min($projects->lastPage(),$projects->currentPage()+2)) as $page => $url)
            @if($page==$projects->currentPage())
              <span style="padding:8px 16px;border-radius:100px;font-size:13px;color:#000;background:#c9a96e;font-weight:600;">{{ $page }}</span>
            @else
              <a href="{{ $url }}" style="padding:8px 16px;border-radius:100px;font-size:13px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);text-decoration:none;">{{ $page }}</a>
            @endif
          @endforeach
          @if($projects->hasMorePages())<a href="{{ $projects->nextPageUrl() }}" style="padding:8px 16px;border-radius:100px;font-size:13px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);text-decoration:none;">Next ›</a>@endif
        </div>
      @endif
    @else
      <div style="text-align:center;padding:80px 0;">
        <div style="font-size:48px;color:#2a2a2a;margin-bottom:16px;"><i class="bi bi-image"></i></div>
        <h3 style="color:#f5f5f7;margin-bottom:10px;">No projects found</h3>
        <a href="{{ route('projects.index') }}" class="apple-btn apple-btn--ghost" style="margin-top:16px;">View All Projects</a>
      </div>
    @endif
  </div>
</section>

<section class="apple-cta-banner">
  <div class="apple-cta-banner__inner reveal">
    <span class="apple-eyebrow" style="display:block;text-align:center;margin-bottom:16px;">Start Your Project</span>
    <h2 class="apple-cta-banner__title">Your Dream Interior<br>Starts Here</h2>
    <p class="apple-cta-banner__sub">Submit your project requirements and receive expert consultation and competitive hardware pricing.</p>
    <div class="apple-cta-banner__actions">
      <a href="{{ route('quote.index') }}" class="apple-btn apple-btn--primary"><i class="bi bi-file-earmark-text"></i> Request a Quote</a>
      <a href="{{ route('contact.index') }}" class="apple-btn apple-btn--ghost"><i class="bi bi-geo-alt"></i> Visit Showroom</a>
    </div>
  </div>
</section>

@endsection
