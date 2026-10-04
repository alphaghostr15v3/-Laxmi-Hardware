@extends('layouts.app')
@section('title', 'Services — Laxmi Hardware')
@section('meta_description', 'Comprehensive interior hardware services — BOQ consultation, project supply, installation guidance, and technical advisory for architects and builders.')

@section('content')

<section style="padding:100px 0 64px;background:#000;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-80px;left:50%;transform:translateX(-50%);width:700px;height:700px;background:radial-gradient(ellipse,rgba(201,169,110,0.07) 0%,transparent 70%);pointer-events:none;"></div>
  <div class="apple-container" style="position:relative;">
    <span class="apple-eyebrow reveal">What We Offer</span>
    <h1 class="apple-title reveal reveal--delay-1" style="max-width:640px;margin:12px auto 20px;">Comprehensive Interior<br>Hardware Services</h1>
    <p class="apple-subtitle reveal reveal--delay-2" style="max-width:540px;margin:0 auto;">From project BOQ estimation to turnkey hardware supply — we handle every specification detail so you can focus on great design.</p>
  </div>
</section>

<section class="apple-section apple-section--dark" style="padding-top:32px;">
  <div class="apple-container">
    @if(isset($services) && $services->count() > 0)
      <div style="display:flex;flex-direction:column;gap:1px;background:rgba(255,255,255,0.06);border-radius:20px;overflow:hidden;border:1px solid rgba(255,255,255,0.08);">
        @foreach($services as $i => $service)
          <div class="reveal" style="background:#0d0d0d;display:grid;grid-template-columns:{{ $service->image ? '1fr 1fr' : '1fr' }};min-height:380px;{{ $i%2==1&&$service->image ? 'direction:rtl;' : '' }}">
            @if($service->image)
              <div style="{{ $i%2==1 ? 'direction:ltr;' : '' }}overflow:hidden;background:#0a0a0a;">
                <img src="{{ $service->image_url }}" alt="{{ $service->title }}" style="width:100%;height:100%;object-fit:cover;min-height:380px;transition:transform .6s;" loading="lazy"
                  onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
              </div>
            @endif
            <div style="{{ $i%2==1&&$service->image ? 'direction:ltr;' : '' }}display:flex;flex-direction:column;justify-content:center;padding:56px 52px;">
              <div style="display:inline-flex;align-items:center;gap:8px;font-size:10px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#c9a96e;background:rgba(201,169,110,0.1);border:1px solid rgba(201,169,110,0.25);padding:5px 14px;border-radius:100px;width:fit-content;margin-bottom:16px;">
                <i class="bi bi-wrench-adjustable"></i> Service {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
              </div>
              <h2 style="font-size:clamp(24px,2.5vw,36px);font-weight:700;letter-spacing:-.04em;line-height:1.1;color:#f5f5f7;margin-bottom:14px;">{{ $service->title }}</h2>
              <p style="font-size:15px;color:#a1a1a6;font-weight:300;line-height:1.7;margin-bottom:24px;">{{ $service->short_description }}</p>
              @if(!empty($service->features_list))
                <ul style="list-style:none;padding:0;margin:0 0 28px;display:flex;flex-direction:column;gap:8px;">
                  @foreach(array_slice($service->features_list, 0, 5) as $feat)
                    <li style="display:flex;align-items:center;gap:10px;font-size:14px;color:#a1a1a6;">
                      <span style="width:18px;height:18px;border-radius:50%;background:rgba(201,169,110,0.12);border:1px solid rgba(201,169,110,0.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-check" style="color:#c9a96e;font-size:11px;"></i>
                      </span>
                      {{ $feat }}
                    </li>
                  @endforeach
                </ul>
              @endif
              <a href="{{ route('quote.index', ['category'=>$service->title]) }}" class="apple-btn apple-btn--primary" style="width:fit-content;">
                <i class="bi bi-file-earmark-text"></i> Enquire This Service
              </a>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div style="text-align:center;padding:80px 0;">
        <div style="font-size:48px;color:#2a2a2a;margin-bottom:16px;"><i class="bi bi-tools"></i></div>
        <h3 style="color:#f5f5f7;margin-bottom:10px;">Services coming soon</h3>
      </div>
    @endif
  </div>
</section>

{{-- Process Steps --}}
<section class="apple-section apple-section--alt">
  <div class="apple-container">
    <div class="apple-section__header">
      <span class="apple-eyebrow reveal">How We Work</span>
      <h2 class="apple-title reveal reveal--delay-1">Simple, Transparent Process</h2>
    </div>
    <div class="apple-grid apple-grid--4col reveal">
      @php $steps = [
        ['num'=>'01','icon'=>'bi-clipboard2-check','title'=>'Submit Requirements','desc'=>'Share your project BOQ, drawings, or product specifications via our quote form or WhatsApp.'],
        ['num'=>'02','icon'=>'bi-search','title'=>'Expert Review','desc'=>'Our hardware engineers analyze your requirements and suggest optimized specifications.'],
        ['num'=>'03','icon'=>'bi-file-earmark-spreadsheet','title'=>'Competitive Quote','desc'=>'Receive a detailed, itemized quotation with genuine brand pricing within 24 hours.'],
        ['num'=>'04','icon'=>'bi-truck','title'=>'Fast Delivery','desc'=>'Products delivered directly to your project site with quality assurance documentation.'],
      ]; @endphp
      @foreach($steps as $step)
        <div class="apple-card" style="position:relative;">
          <div style="font-size:36px;font-weight:800;letter-spacing:-.04em;color:rgba(201,169,110,0.15);margin-bottom:12px;line-height:1;">{{ $step['num'] }}</div>
          <div class="apple-card__icon"><i class="bi {{ $step['icon'] }}"></i></div>
          <h3 class="apple-card__title">{{ $step['title'] }}</h3>
          <p class="apple-card__desc">{{ $step['desc'] }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<section class="apple-cta-banner">
  <div class="apple-cta-banner__inner reveal">
    <span class="apple-eyebrow" style="display:block;text-align:center;margin-bottom:16px;">Ready to Start?</span>
    <h2 class="apple-cta-banner__title">Get Expert Hardware<br>Consultation Today</h2>
    <p class="apple-cta-banner__sub">Our specialists are ready to help with any project — residential, commercial, or hospitality.</p>
    <div class="apple-cta-banner__actions">
      <a href="{{ route('quote.index') }}" class="apple-btn apple-btn--primary"><i class="bi bi-file-earmark-text"></i> Request a Quote</a>
      <a href="{{ route('contact.index') }}" class="apple-btn apple-btn--ghost"><i class="bi bi-telephone"></i> Call Us</a>
    </div>
  </div>
</section>

@endsection
