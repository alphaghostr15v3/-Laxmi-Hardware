@extends('layouts.app')
@section('title', 'Contact Us — Laxmi Hardware Surat')
@section('meta_description', 'Contact Laxmi Hardware Surat. Visit our showroom, call us, or send an enquiry. Hardware Plaza, Ring Road, Surat, Gujarat.')

@section('content')

<section style="padding:100px 0 64px;background:#000;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-80px;left:50%;transform:translateX(-50%);width:700px;height:700px;background:radial-gradient(ellipse,rgba(201,169,110,0.07) 0%,transparent 70%);pointer-events:none;"></div>
  <div class="apple-container" style="position:relative;">
    <span class="apple-eyebrow reveal">Get In Touch</span>
    <h1 class="apple-title reveal reveal--delay-1" style="max-width:600px;margin:12px auto 20px;">We'd Love to<br>Hear From You</h1>
    <p class="apple-subtitle reveal reveal--delay-2" style="max-width:500px;margin:0 auto;">Visit our showroom, call us directly, or send a message. Our hardware specialists typically respond within 2 hours.</p>
  </div>
</section>

<section class="apple-section apple-section--dark" style="padding-top:32px;">
  <div class="apple-container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:start;">

      {{-- CONTACT FORM --}}
      <div class="reveal">
        <h2 style="font-size:22px;font-weight:700;letter-spacing:-.03em;color:#f5f5f7;margin-bottom:6px;">Send Us a Message</h2>
        <p style="font-size:14px;color:#6e6e73;margin-bottom:28px;">For product enquiries, project quotes, or general questions.</p>

        <form action="{{ route('contact.store') }}" method="POST">
          @csrf
          @if($errors->any())
            <div style="background:rgba(255,69,58,0.1);border:1px solid rgba(255,69,58,0.3);border-radius:12px;padding:14px 18px;margin-bottom:20px;font-size:13px;color:#ff453a;">
              <ul style="margin:0;padding-left:16px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
          @endif

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
            <div class="apple-form-group">
              <label class="apple-form-label">Full Name *</label>
              <input type="text" name="name" value="{{ old('name') }}" class="apple-form-input" placeholder="Your Name" required>
            </div>
            <div class="apple-form-group">
              <label class="apple-form-label">Phone Number *</label>
              <input type="tel" name="phone" value="{{ old('phone') }}" class="apple-form-input" placeholder="+91 98765 43210" required>
            </div>
          </div>
          <div class="apple-form-group" style="margin-bottom:14px;">
            <label class="apple-form-label">Email Address *</label>
            <input type="email" name="email" value="{{ old('email') }}" class="apple-form-input" placeholder="your@email.com" required>
          </div>
          <div class="apple-form-group" style="margin-bottom:14px;">
            <label class="apple-form-label">Subject *</label>
            <input type="text" name="subject" value="{{ old('subject') }}" class="apple-form-input" placeholder="Hardware enquiry, project consultation…" required>
          </div>
          <div class="apple-form-group" style="margin-bottom:24px;">
            <label class="apple-form-label">Message *</label>
            <textarea name="message" class="apple-form-textarea" rows="5" placeholder="Describe your requirements, project type, quantity, location…" required>{{ old('message') }}</textarea>
          </div>
          <button type="submit" class="apple-btn apple-btn--primary" style="width:100%;justify-content:center;font-size:15px;padding:14px;">
            <i class="bi bi-send"></i> Send Message
          </button>
        </form>
      </div>

      {{-- CONTACT INFO --}}
      <div class="reveal reveal--delay-1">
        <h2 style="font-size:22px;font-weight:700;letter-spacing:-.03em;color:#f5f5f7;margin-bottom:28px;">Showroom & Contact</h2>

        {{-- Info Cards --}}
        <div style="display:flex;flex-direction:column;gap:14px;margin-bottom:32px;">
          <div style="background:#111;border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:22px 24px;display:flex;align-items:start;gap:16px;">
            <div style="width:40px;height:40px;border-radius:10px;background:rgba(201,169,110,0.12);border:1px solid rgba(201,169,110,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi bi-geo-alt-fill" style="color:#c9a96e;font-size:16px;"></i></div>
            <div>
              <div style="font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#6e6e73;margin-bottom:6px;">Showroom Address</div>
              <div style="font-size:14px;color:#f5f5f7;line-height:1.6;">{{ \App\Models\Setting::get('address', 'Hardware Plaza, Ring Road, Industrial Area, Surat, Gujarat 395002') }}</div>
              <a href="https://maps.google.com/?q={{ urlencode(\App\Models\Setting::get('address', 'Laxmi Hardware Surat')) }}" target="_blank" style="display:inline-flex;align-items:center;gap:4px;font-size:12px;color:#c9a96e;margin-top:8px;text-decoration:none;" onmouseover="this.style.opacity='.7'" onmouseout="this.style.opacity='1'">Get Directions <i class="bi bi-box-arrow-up-right" style="font-size:10px;"></i></a>
            </div>
          </div>

          <div style="background:#111;border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:22px 24px;display:flex;align-items:start;gap:16px;">
            <div style="width:40px;height:40px;border-radius:10px;background:rgba(201,169,110,0.12);border:1px solid rgba(201,169,110,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi bi-telephone-fill" style="color:#c9a96e;font-size:16px;"></i></div>
            <div>
              <div style="font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#6e6e73;margin-bottom:6px;">Phone</div>
              <a href="tel:{{ str_replace(' ','',\App\Models\Setting::get('phone','+919876543210')) }}" style="font-size:16px;font-weight:600;color:#f5f5f7;text-decoration:none;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='#f5f5f7'">{{ \App\Models\Setting::get('phone','+91 98765 43210') }}</a>
            </div>
          </div>

          <div style="background:#111;border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:22px 24px;display:flex;align-items:start;gap:16px;">
            <div style="width:40px;height:40px;border-radius:10px;background:rgba(201,169,110,0.12);border:1px solid rgba(201,169,110,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi bi-envelope-fill" style="color:#c9a96e;font-size:16px;"></i></div>
            <div>
              <div style="font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#6e6e73;margin-bottom:6px;">Email</div>
              <a href="mailto:{{ \App\Models\Setting::get('email','info@laxmihardware.com') }}" style="font-size:15px;color:#f5f5f7;text-decoration:none;" onmouseover="this.style.color='#c9a96e'" onmouseout="this.style.color='#f5f5f7'">{{ \App\Models\Setting::get('email','info@laxmihardware.com') }}</a>
            </div>
          </div>

          <div style="background:#111;border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:22px 24px;display:flex;align-items:start;gap:16px;">
            <div style="width:40px;height:40px;border-radius:10px;background:rgba(37,211,102,0.1);border:1px solid rgba(37,211,102,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi bi-whatsapp" style="color:#25d366;font-size:16px;"></i></div>
            <div style="flex:1;">
              <div style="font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#6e6e73;margin-bottom:6px;">WhatsApp</div>
              <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp','919876543210') }}?text=Hello+Laxmi+Hardware%2C+I+have+an+enquiry." target="_blank" class="apple-btn" style="background:rgba(37,211,102,0.1);color:#25d366;border:1px solid rgba(37,211,102,0.25);font-size:13px;padding:8px 16px;border-radius:100px;">
                <i class="bi bi-whatsapp"></i> Chat on WhatsApp
              </a>
            </div>
          </div>

          <div style="background:#111;border:1px solid rgba(255,255,255,0.08);border-radius:16px;padding:22px 24px;display:flex;align-items:start;gap:16px;">
            <div style="width:40px;height:40px;border-radius:10px;background:rgba(201,169,110,0.12);border:1px solid rgba(201,169,110,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi bi-clock-fill" style="color:#c9a96e;font-size:16px;"></i></div>
            <div>
              <div style="font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#6e6e73;margin-bottom:6px;">Showroom Hours</div>
              <div style="font-size:14px;color:#f5f5f7;">{{ \App\Models\Setting::get('business_hours','Mon – Sat: 9:00 AM – 8:30 PM') }}</div>
              <div style="font-size:12px;color:#6e6e73;margin-top:4px;">Sundays by appointment only</div>
            </div>
          </div>
        </div>

        {{-- Map Embed placeholder --}}
        <div style="border-radius:16px;overflow:hidden;border:1px solid rgba(255,255,255,0.08);">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.8!2d72.8!3d21.2!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDEyJzAwLjAiTiA3MsKwNDgnMDAuMCJF!5e0!3m2!1sen!2sin!4v1"
            width="100%" height="220" style="border:0;display:block;filter:invert(90%) hue-rotate(180deg);" allowfullscreen loading="lazy">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</section>

@push('styles')
<style>@media(max-width:768px){section .apple-container>div{grid-template-columns:1fr!important;}}</style>
@endpush

@endsection
