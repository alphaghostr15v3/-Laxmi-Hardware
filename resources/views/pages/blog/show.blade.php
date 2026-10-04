@extends('layouts.app')
@section('title', $post->title . ' — Laxmi Hardware Blog')
@section('meta_description', $post->excerpt ?? Str::limit(strip_tags($post->content), 150))

@section('content')

{{-- BREADCRUMB --}}
<div style="background:#0a0a0a;border-bottom:1px solid rgba(255,255,255,0.06);padding:14px 0;">
  <div class="apple-container" style="display:flex;align-items:center;gap:8px;font-size:12px;color:#6e6e73;flex-wrap:wrap;">
    <a href="{{ route('home') }}" style="color:#6e6e73;text-decoration:none;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='#6e6e73'">Home</a>
    <span>›</span>
    <a href="{{ route('blog.index') }}" style="color:#6e6e73;text-decoration:none;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='#6e6e73'">Blog</a>
    @if($post->category)
      <span>›</span>
      <a href="{{ route('blog.index', ['category'=>$post->category->slug]) }}" style="color:#6e6e73;text-decoration:none;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='#6e6e73'">{{ $post->category->name }}</a>
    @endif
    <span>›</span>
    <span style="color:#f5f5f7;">{{ Str::limit($post->title, 40) }}</span>
  </div>
</div>

{{-- HERO IMAGE --}}
@if($post->featured_image)
  <div style="position:relative;overflow:hidden;background:#000;max-height:520px;">
    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" style="width:100%;height:520px;object-fit:cover;opacity:.6;">
    <div style="position:absolute;inset:0;background:linear-gradient(to bottom,transparent 30%,rgba(0,0,0,0.95) 100%);"></div>
  </div>
@endif

{{-- ARTICLE --}}
<section class="apple-section apple-section--dark" style="padding-top:{{ $post->featured_image ? '48px' : '80px' }};" >
  <div class="apple-container">
    <div style="display:grid;grid-template-columns:1fr 300px;gap:56px;align-items:start;">

      {{-- CONTENT --}}
      <article class="reveal">
        {{-- Meta --}}
        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:20px;">
          @if($post->category)
            <a href="{{ route('blog.index', ['category'=>$post->category->slug]) }}" style="font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#c9a96e;background:rgba(201,169,110,0.1);border:1px solid rgba(201,169,110,0.25);padding:4px 12px;border-radius:100px;text-decoration:none;">{{ $post->category->name }}</a>
          @endif
          @if($post->published_at)
            <span style="font-size:12px;color:#6e6e73;"><i class="bi bi-calendar3" style="margin-right:4px;"></i>{{ $post->published_at->format('d M Y') }}</span>
          @endif
          @if($post->read_time)
            <span style="font-size:12px;color:#6e6e73;"><i class="bi bi-clock" style="margin-right:4px;"></i>{{ $post->read_time }} min read</span>
          @endif
        </div>

        <h1 style="font-size:clamp(28px,4vw,46px);font-weight:700;letter-spacing:-.05em;line-height:1.08;color:#f5f5f7;margin-bottom:20px;">{{ $post->title }}</h1>

        @if($post->excerpt)
          <p style="font-size:18px;color:#a1a1a6;font-weight:300;line-height:1.7;margin-bottom:32px;padding-bottom:32px;border-bottom:1px solid rgba(255,255,255,0.07);">{{ $post->excerpt }}</p>
        @endif

        {{-- Body --}}
        <div style="color:#a1a1a6;font-size:16px;line-height:1.85;font-weight:300;">
          {!! $post->content !!}
        </div>

        {{-- Share --}}
        <div style="margin-top:48px;padding-top:32px;border-top:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
          <span style="font-size:13px;color:#6e6e73;font-weight:500;">Share:</span>
          <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:#25d366;background:rgba(37,211,102,0.08);border:1px solid rgba(37,211,102,0.2);border-radius:100px;padding:6px 14px;text-decoration:none;transition:background .2s;"><i class="bi bi-whatsapp"></i> WhatsApp</a>
          <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:#1877f2;background:rgba(24,119,242,0.08);border:1px solid rgba(24,119,242,0.2);border-radius:100px;padding:6px 14px;text-decoration:none;"><i class="bi bi-facebook"></i> Facebook</a>
          <button onclick="navigator.clipboard.writeText(window.location.href);this.textContent='Copied!';setTimeout(()=>this.textContent='Copy Link',2000)" style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:100px;padding:6px 14px;cursor:pointer;transition:color .2s;"><i class="bi bi-link-45deg"></i> Copy Link</button>
        </div>
      </article>

      {{-- SIDEBAR --}}
      <div style="position:sticky;top:72px;" class="reveal reveal--delay-1">

        {{-- CTA --}}
        <div style="background:linear-gradient(135deg,rgba(201,169,110,0.12),rgba(201,169,110,0.04));border:1px solid rgba(201,169,110,0.25);border-radius:16px;padding:24px;margin-bottom:14px;text-align:center;">
          <div style="font-size:28px;margin-bottom:10px;">🛠️</div>
          <h4 style="font-size:15px;font-weight:700;color:#f5f5f7;margin-bottom:8px;">Need This Hardware?</h4>
          <p style="font-size:13px;color:#a1a1a6;font-weight:300;line-height:1.6;margin-bottom:16px;">Get competitive pricing and availability for your project.</p>
          <a href="{{ route('quote.index') }}" class="apple-btn apple-btn--primary" style="font-size:13px;padding:10px 18px;width:100%;justify-content:center;">Request a Quote</a>
        </div>

        {{-- Categories --}}
        <div style="background:#111;border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:24px;margin-bottom:14px;">
          <h3 style="font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#6e6e73;margin-bottom:16px;">Categories</h3>
          <div style="display:flex;flex-wrap:wrap;gap:7px;">
            @foreach($categories as $cat)
              <a href="{{ route('blog.index', ['category'=>$cat->slug]) }}" style="font-size:12px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:100px;padding:4px 12px;text-decoration:none;transition:color .2s,border-color .2s;" onmouseover="this.style.color='#c9a96e';this.style.borderColor='rgba(201,169,110,0.3)'" onmouseout="this.style.color='#a1a1a6';this.style.borderColor='rgba(255,255,255,0.1)'">{{ $cat->name }} ({{ $cat->posts_count }})</a>
            @endforeach
          </div>
        </div>

        {{-- Related Posts --}}
        @if($relatedPosts->count() > 0)
          <div style="background:#111;border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:24px;">
            <h3 style="font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#6e6e73;margin-bottom:16px;">Related Articles</h3>
            <div style="display:flex;flex-direction:column;gap:16px;">
              @foreach($relatedPosts as $rp)
                <a href="{{ route('blog.show', $rp->slug) }}" style="display:flex;gap:12px;text-decoration:none;" onmouseover="this.querySelector('.rp-t').style.color='#c9a96e'" onmouseout="this.querySelector('.rp-t').style.color='#f5f5f7'">
                  @if($rp->featured_image)
                    <div style="width:52px;height:52px;border-radius:8px;overflow:hidden;flex-shrink:0;background:#0a0a0a;"><img src="{{ $rp->featured_image_url }}" alt="{{ $rp->title }}" style="width:100%;height:100%;object-fit:cover;"></div>
                  @else
                    <div style="width:52px;height:52px;border-radius:8px;background:#1a1a1a;flex-shrink:0;display:flex;align-items:center;justify-content:center;"><i class="bi bi-newspaper" style="color:#3a3a3a;"></i></div>
                  @endif
                  <div>
                    <div class="rp-t" style="font-size:13px;font-weight:600;color:#f5f5f7;line-height:1.3;margin-bottom:4px;transition:color .2s;">{{ Str::limit($rp->title,55) }}</div>
                    <div style="font-size:11px;color:#6e6e73;">{{ $rp->published_at?->format('d M Y') }}</div>
                  </div>
                </a>
              @endforeach
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>

@push('styles')
<style>
/* Blog content styling */
article h2,article h3,article h4{color:#f5f5f7;font-weight:700;margin-top:2em;margin-bottom:.8em;letter-spacing:-.03em;}
article h2{font-size:1.6rem;}article h3{font-size:1.3rem;}
article p{margin-bottom:1.4em;color:#a1a1a6;line-height:1.85;}
article ul,article ol{padding-left:1.5em;margin-bottom:1.4em;color:#a1a1a6;}
article li{margin-bottom:.5em;line-height:1.7;}
article strong,article b{color:#f5f5f7;font-weight:600;}
article a{color:#c9a96e;text-decoration:underline;text-underline-offset:3px;}
article blockquote{border-left:3px solid #c9a96e;padding-left:20px;margin:1.5em 0;color:#6e6e73;font-style:italic;}
article img{border-radius:12px;max-width:100%;height:auto;margin:1.5em 0;}
article table{width:100%;border-collapse:collapse;margin:1.5em 0;}
article th,article td{border:1px solid rgba(255,255,255,0.1);padding:10px 14px;text-align:left;}
article th{background:rgba(255,255,255,0.05);color:#f5f5f7;font-weight:600;}
article code{background:rgba(255,255,255,0.08);border-radius:4px;padding:2px 6px;font-size:.85em;}
@media(max-width:768px){section .apple-container>div{grid-template-columns:1fr!important;}}
</style>
@endpush

@endsection
