@extends('layouts.app')
@section('title', 'Blog — Hardware Guides & Interior Tips — Laxmi Hardware')
@section('meta_description', 'Read expert guides on interior hardware, installation tips, product comparisons, and design inspiration from Laxmi Hardware Surat.')

@section('content')

<section style="padding:100px 0 64px;background:#000;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-80px;left:50%;transform:translateX(-50%);width:700px;height:700px;background:radial-gradient(ellipse,rgba(201,169,110,0.07) 0%,transparent 70%);pointer-events:none;"></div>
  <div class="apple-container" style="position:relative;">
    <span class="apple-eyebrow reveal">Hardware Guides</span>
    <h1 class="apple-title reveal reveal--delay-1" style="max-width:600px;margin:12px auto 20px;">Insights & Tips<br>for Better Interiors</h1>
    <p class="apple-subtitle reveal reveal--delay-2" style="max-width:500px;margin:0 auto;">Expert articles on hardware selection, installation best practices, product comparisons, and interior design inspiration.</p>
  </div>
</section>

<section class="apple-section apple-section--dark" style="padding-top:24px;">
  <div class="apple-container">
    <div style="display:grid;grid-template-columns:1fr 320px;gap:48px;align-items:start;">

      {{-- MAIN CONTENT --}}
      <div>
        {{-- Search + Filter --}}
        <form method="GET" action="{{ route('blog.index') }}" style="display:flex;gap:10px;margin-bottom:32px;flex-wrap:wrap;">
          <div style="flex:1;min-width:200px;display:flex;align-items:center;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:100px;padding:0 16px;gap:10px;">
            <i class="bi bi-search" style="color:#6e6e73;font-size:13px;"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles…" style="background:none;border:none;outline:none;color:#f5f5f7;font-size:14px;width:100%;padding:10px 0;font-family:inherit;">
          </div>
          <button type="submit" class="apple-btn apple-btn--primary" style="padding:10px 20px;font-size:13px;"><i class="bi bi-search"></i></button>
          @if(request('search') || request('category'))
            <a href="{{ route('blog.index') }}" style="display:flex;align-items:center;gap:6px;font-size:13px;color:#6e6e73;padding:10px;" onmouseover="this.style.color='#f5f5f7'" onmouseout="this.style.color='#6e6e73'"><i class="bi bi-x-circle"></i> Clear</a>
          @endif
        </form>

        {{-- POSTS --}}
        @if($posts->count() > 0)
          <div style="display:flex;flex-direction:column;gap:1px;background:rgba(255,255,255,0.06);border-radius:20px;overflow:hidden;border:1px solid rgba(255,255,255,0.08);margin-bottom:40px;">
            @foreach($posts as $post)
              <article class="reveal" style="background:#0d0d0d;display:grid;grid-template-columns:220px 1fr;transition:background .25s;" onmouseover="this.style.background='#121212'" onmouseout="this.style.background='#0d0d0d'">
                @if($post->featured_image)
                  <a href="{{ route('blog.show', $post->slug) }}" style="overflow:hidden;display:block;background:#0a0a0a;">
                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" style="width:100%;height:100%;min-height:180px;object-fit:cover;transition:transform .5s;" loading="lazy"
                      onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                  </a>
                @else
                  <div style="background:#111;display:flex;align-items:center;justify-content:center;min-height:180px;">
                    <i class="bi bi-newspaper" style="font-size:36px;color:#2a2a2a;"></i>
                  </div>
                @endif
                <div style="padding:28px 32px;display:flex;flex-direction:column;justify-content:center;">
                  <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;flex-wrap:wrap;">
                    @if($post->category)
                      <a href="{{ route('blog.index', ['category'=>$post->category->slug]) }}" style="font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#c9a96e;background:rgba(201,169,110,0.1);border:1px solid rgba(201,169,110,0.25);padding:3px 10px;border-radius:100px;text-decoration:none;">{{ $post->category->name }}</a>
                    @endif
                    <span style="font-size:12px;color:#6e6e73;"><i class="bi bi-calendar3" style="margin-right:4px;"></i>{{ $post->published_at ? $post->published_at->format('d M Y') : '' }}</span>
                    @if($post->read_time)
                      <span style="font-size:12px;color:#6e6e73;"><i class="bi bi-clock" style="margin-right:4px;"></i>{{ $post->read_time }} min read</span>
                    @endif
                  </div>
                  <h2 style="font-size:20px;font-weight:700;letter-spacing:-.03em;line-height:1.25;color:#f5f5f7;margin-bottom:10px;">
                    <a href="{{ route('blog.show', $post->slug) }}" style="color:inherit;text-decoration:none;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='#f5f5f7'">{{ $post->title }}</a>
                  </h2>
                  @if($post->excerpt)
                    <p style="font-size:14px;color:#6e6e73;font-weight:300;line-height:1.65;margin-bottom:16px;">{{ Str::limit($post->excerpt, 120) }}</p>
                  @endif
                  <a href="{{ route('blog.show', $post->slug) }}" style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:#c9a96e;font-weight:500;transition:gap .2s;" onmouseover="this.style.gap='10px'" onmouseout="this.style.gap='6px'">
                    Read Article <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </article>
            @endforeach
          </div>

          {{-- Pagination --}}
          @if($posts->hasPages())
            <div style="display:flex;justify-content:center;gap:6px;flex-wrap:wrap;">
              @if(!$posts->onFirstPage())<a href="{{ $posts->previousPageUrl() }}" style="padding:8px 16px;border-radius:100px;font-size:13px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);text-decoration:none;">‹ Prev</a>@endif
              @foreach($posts->getUrlRange(max(1,$posts->currentPage()-2),min($posts->lastPage(),$posts->currentPage()+2)) as $page => $url)
                @if($page==$posts->currentPage())
                  <span style="padding:8px 16px;border-radius:100px;font-size:13px;color:#000;background:#c9a96e;font-weight:600;">{{ $page }}</span>
                @else
                  <a href="{{ $url }}" style="padding:8px 16px;border-radius:100px;font-size:13px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);text-decoration:none;">{{ $page }}</a>
                @endif
              @endforeach
              @if($posts->hasMorePages())<a href="{{ $posts->nextPageUrl() }}" style="padding:8px 16px;border-radius:100px;font-size:13px;color:#a1a1a6;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);text-decoration:none;">Next ›</a>@endif
            </div>
          @endif
        @else
          <div style="text-align:center;padding:80px 0;">
            <div style="font-size:48px;color:#2a2a2a;margin-bottom:16px;"><i class="bi bi-newspaper"></i></div>
            <h3 style="color:#f5f5f7;margin-bottom:10px;">No articles found</h3>
            <a href="{{ route('blog.index') }}" class="apple-btn apple-btn--ghost" style="margin-top:16px;">Clear Filters</a>
          </div>
        @endif
      </div>

      {{-- SIDEBAR --}}
      <div style="position:sticky;top:72px;">
        {{-- Categories --}}
        <div style="background:#111;border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:24px;margin-bottom:14px;">
          <h3 style="font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#6e6e73;margin-bottom:16px;">Categories</h3>
          <div style="display:flex;flex-direction:column;gap:0;">
            <a href="{{ route('blog.index') }}" style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid rgba(255,255,255,0.05);font-size:14px;color:{{ !request('category') ? '#c9a96e' : '#a1a1a6' }};text-decoration:none;">
              All Articles
            </a>
            @foreach($categories as $cat)
              <a href="{{ route('blog.index', ['category'=>$cat->slug]) }}" style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;{{ !$loop->last ? 'border-bottom:1px solid rgba(255,255,255,0.05);' : '' }}font-size:14px;color:{{ request('category')==$cat->slug ? '#c9a96e' : '#a1a1a6' }};text-decoration:none;" onmouseover="this.style.color='#f5f5f7'" onmouseout="this.style.color='{{ request('category')==$cat->slug ? '#c9a96e' : '#a1a1a6' }}'">
                <span>{{ $cat->name }}</span>
                <span style="font-size:11px;background:rgba(255,255,255,0.06);border-radius:100px;padding:2px 8px;">{{ $cat->posts_count }}</span>
              </a>
            @endforeach
          </div>
        </div>

        {{-- Recent Posts --}}
        <div style="background:#111;border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:24px;margin-bottom:14px;">
          <h3 style="font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#6e6e73;margin-bottom:16px;">Recent Articles</h3>
          <div style="display:flex;flex-direction:column;gap:16px;">
            @foreach($recentPosts as $rp)
              <a href="{{ route('blog.show', $rp->slug) }}" style="display:flex;gap:12px;text-decoration:none;align-items:start;" onmouseover="this.querySelector('.rp-title').style.color='#c9a96e'" onmouseout="this.querySelector('.rp-title').style.color='#f5f5f7'">
                @if($rp->featured_image)
                  <div style="width:52px;height:52px;border-radius:8px;overflow:hidden;flex-shrink:0;background:#0a0a0a;">
                    <img src="{{ $rp->featured_image_url }}" alt="{{ $rp->title }}" style="width:100%;height:100%;object-fit:cover;">
                  </div>
                @else
                  <div style="width:52px;height:52px;border-radius:8px;background:#1a1a1a;flex-shrink:0;display:flex;align-items:center;justify-content:center;"><i class="bi bi-newspaper" style="color:#3a3a3a;"></i></div>
                @endif
                <div>
                  <div class="rp-title" style="font-size:13px;font-weight:600;color:#f5f5f7;line-height:1.3;margin-bottom:4px;transition:color .2s;">{{ Str::limit($rp->title, 55) }}</div>
                  <div style="font-size:11px;color:#6e6e73;">{{ $rp->published_at ? $rp->published_at->format('d M Y') : '' }}</div>
                </div>
              </a>
            @endforeach
          </div>
        </div>

        {{-- CTA --}}
        <div style="background:linear-gradient(135deg,rgba(201,169,110,0.12),rgba(201,169,110,0.04));border:1px solid rgba(201,169,110,0.25);border-radius:16px;padding:24px;text-align:center;">
          <div style="font-size:28px;margin-bottom:10px;">📋</div>
          <h4 style="font-size:15px;font-weight:700;color:#f5f5f7;margin-bottom:8px;">Need Hardware Help?</h4>
          <p style="font-size:13px;color:#a1a1a6;font-weight:300;line-height:1.6;margin-bottom:16px;">Submit your project BOQ and get expert advice from our hardware specialists.</p>
          <a href="{{ route('quote.index') }}" class="apple-btn apple-btn--primary" style="font-size:13px;padding:10px 18px;width:100%;justify-content:center;">Request a Quote</a>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
