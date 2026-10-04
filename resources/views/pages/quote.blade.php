@extends('layouts.app')
@section('title', 'Request a Quote — Laxmi Hardware')
@section('meta_description', 'Submit your project BOQ or hardware requirement list. Get competitive quotations from Laxmi Hardware Surat within 24 hours.')

@section('content')

{{-- ══════════ SUCCESS CONFIRMATION ══════════ --}}
@if(session('success'))
<section style="min-height:80vh;display:flex;align-items:center;justify-content:center;background:#000;padding:80px 20px;position:relative;overflow:hidden;">
  <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:700px;height:700px;background:radial-gradient(ellipse,rgba(201,169,110,0.08) 0%,transparent 70%);pointer-events:none;"></div>
  <div style="text-align:center;position:relative;max-width:560px;" class="reveal">

    {{-- Animated checkmark --}}
    <div style="width:96px;height:96px;border-radius:50%;background:rgba(52,199,89,0.12);border:2px solid rgba(52,199,89,0.4);display:flex;align-items:center;justify-content:center;margin:0 auto 28px;animation:popIn .5s cubic-bezier(.34,1.56,.64,1) both;">
      <i class="bi bi-check-lg" style="font-size:44px;color:#34c759;"></i>
    </div>

    <span class="apple-eyebrow" style="display:block;margin-bottom:12px;">Quote Submitted ✓</span>
    <h1 style="font-size:clamp(28px,4vw,44px);font-weight:700;letter-spacing:-.04em;line-height:1.1;color:#f5f5f7;margin-bottom:16px;">
      We've Received<br>Your Request!
    </h1>
    <p style="font-size:16px;color:#a1a1a6;font-weight:300;line-height:1.7;margin-bottom:36px;">
      {{ session('success') }}
    </p>

    {{-- Details card --}}
    <div style="background:#111;border:1px solid rgba(255,255,255,0.09);border-radius:18px;padding:24px 28px;margin-bottom:32px;text-align:left;">
      <div style="display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid rgba(255,255,255,0.06);">
        <div style="width:36px;height:36px;border-radius:10px;background:rgba(201,169,110,0.12);border:1px solid rgba(201,169,110,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi bi-clock" style="color:#c9a96e;font-size:14px;"></i></div>
        <div><div style="font-size:13px;font-weight:600;color:#f5f5f7;">Response within 24 hours</div><div style="font-size:12px;color:#6e6e73;">Our hardware consultants will review your project and send a detailed quotation.</div></div>
      </div>
      <div style="display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid rgba(255,255,255,0.06);">
        <div style="width:36px;height:36px;border-radius:10px;background:rgba(201,169,110,0.12);border:1px solid rgba(201,169,110,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi bi-telephone" style="color:#c9a96e;font-size:14px;"></i></div>
        <div><div style="font-size:13px;font-weight:600;color:#f5f5f7;">We'll call you directly</div><div style="font-size:12px;color:#6e6e73;">Expect a call from our team to discuss your requirements and timeline.</div></div>
      </div>
      <div style="display:flex;align-items:center;gap:14px;padding:12px 0;">
        <div style="width:36px;height:36px;border-radius:10px;background:rgba(201,169,110,0.12);border:1px solid rgba(201,169,110,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi bi-patch-check" style="color:#c9a96e;font-size:14px;"></i></div>
        <div><div style="font-size:13px;font-weight:600;color:#f5f5f7;">100% Genuine Products</div><div style="font-size:12px;color:#6e6e73;">All quotations include original manufacturer warranties.</div></div>
      </div>
    </div>

    {{-- CTA Buttons --}}
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
      <a href="{{ route('products.index') }}" class="apple-btn apple-btn--primary">
        <i class="bi bi-grid-3x3-gap-fill"></i> Browse Products
      </a>
      <a href="{{ route('quote.index') }}" class="apple-btn apple-btn--ghost">
        <i class="bi bi-plus-circle"></i> Submit Another
      </a>
    </div>

    {{-- WhatsApp Nudge --}}
    <p style="margin-top:24px;font-size:13px;color:#6e6e73;">
      Need immediate help?
      <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp','919876543210') }}" target="_blank" style="color:#25d366;font-weight:600;text-decoration:none;">
        <i class="bi bi-whatsapp"></i> Chat on WhatsApp
      </a>
    </p>
  </div>
</section>

@push('styles')
<style>
@keyframes popIn {
  0%   { transform: scale(0.4); opacity: 0; }
  100% { transform: scale(1);   opacity: 1; }
}
</style>
@endpush

{{-- ══════════ QUOTE FORM ══════════ --}}
@else
<section style="padding:100px 0 64px;background:#000;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-80px;left:50%;transform:translateX(-50%);width:700px;height:700px;background:radial-gradient(ellipse,rgba(201,169,110,0.07) 0%,transparent 70%);pointer-events:none;"></div>
  <div class="apple-container" style="position:relative;">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:start;">

      {{-- LEFT: FORM --}}
      <div class="reveal">
        <span class="apple-eyebrow">Project Consultation</span>
        <h1 class="apple-title" style="margin:12px 0 10px;">Request a<br>Project Quote</h1>
        <p style="font-size:15px;color:#6e6e73;font-weight:300;margin-bottom:32px;line-height:1.6;">Submit your hardware requirements and our specialists will send a competitive quotation within 24 hours.</p>

        <form action="{{ route('quote.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @if($errors->any())
            <div style="background:rgba(255,69,58,0.1);border:1px solid rgba(255,69,58,0.3);border-radius:12px;padding:14px 18px;margin-bottom:20px;font-size:13px;color:#ff453a;">
              <ul style="margin:0;padding-left:16px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
          @endif


          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
            <div class="apple-form-group">
              <label class="apple-form-label">Full Name *</label>
              <input type="text" name="name" value="{{ old('name') }}" class="apple-form-input" placeholder="Your Name" required>
            </div>
            <div class="apple-form-group">
              <label class="apple-form-label">Phone *</label>
              <input type="tel" name="phone" value="{{ old('phone') }}" class="apple-form-input" placeholder="+91 98765 43210" required>
            </div>
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
            <div class="apple-form-group">
              <label class="apple-form-label">Email *</label>
              <input type="email" name="email" value="{{ old('email') }}" class="apple-form-input" placeholder="your@email.com" required>
            </div>
            <div class="apple-form-group">
              <label class="apple-form-label">Company / Firm</label>
              <input type="text" name="company" value="{{ old('company') }}" class="apple-form-input" placeholder="ABC Architects">
            </div>
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
            <div class="apple-form-group">
              <label class="apple-form-label">Project Type</label>
              <select name="project_type" class="apple-form-input" style="cursor:pointer;">
                <option value="">Select Type</option>
                @foreach(['Residential Villa','Apartment / Flat','Commercial Office','Retail / Showroom','Hospitality / Hotel','Industrial','Other'] as $pt)
                  <option value="{{ $pt }}" {{ old('project_type')==$pt?'selected':'' }}>{{ $pt }}</option>
                @endforeach
              </select>
            </div>
            <div class="apple-form-group">
              <label class="apple-form-label">Hardware Category</label>
              <select name="product_category" class="apple-form-input" style="cursor:pointer;">
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->name }}" {{ (old('product_category')==$cat->name || $selectedCategory==$cat->name)?'selected':'' }}>{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
            <div class="apple-form-group">
              <label class="apple-form-label">Project Location</label>
              <input type="text" name="location" value="{{ old('location') }}" class="apple-form-input" placeholder="Surat, Gujarat">
            </div>
            <div class="apple-form-group">
              <label class="apple-form-label">Specific Product / SKU</label>
              <input type="text" name="requirement" value="{{ old('requirement', $selectedProduct) }}" class="apple-form-input" placeholder="e.g. Hettich Tandem Box">
            </div>
          </div>

          <div class="apple-form-group" style="margin-bottom:12px;">
            <label class="apple-form-label">Project Requirements / Message</label>
            <textarea name="message" class="apple-form-textarea" rows="5" placeholder="Describe your requirements — product names, quantities, specifications, project timeline, or attach your BOQ…">{{ old('message') }}</textarea>
          </div>

          <div class="apple-form-group" style="margin-bottom:24px;">
            <label class="apple-form-label">Attach BOQ / Drawings (Optional)</label>
            <div id="dropZone" style="background:rgba(255,255,255,0.03);border:1px dashed rgba(255,255,255,0.18);border-radius:14px;padding:24px 20px;text-align:center;cursor:pointer;transition:border-color .2s, background .2s;" onclick="document.getElementById('fileInput').click()">
              <div id="uploadPrompt">
                <i class="bi bi-cloud-arrow-up" style="font-size:28px;color:#c9a96e;display:block;margin-bottom:8px;"></i>
                <div style="font-size:14px;color:#f5f5f7;font-weight:500;">Click to attach file or drag & drop</div>
                <div style="font-size:11px;color:#86868b;margin-top:4px;">Supported: PDF, JPG, PNG, WEBP, ZIP, DWG, DXF (max 10MB)</div>
              </div>
              <div id="filePreview" style="display:none;align-items:center;justify-content:center;gap:10px;padding:6px;">
                <i class="bi bi-file-earmark-check-fill" style="font-size:22px;color:#34c759;"></i>
                <div style="text-align:left;">
                  <div id="fileName" style="font-size:13px;color:#f5f5f7;font-weight:600;max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"></div>
                  <div id="fileSize" style="font-size:11px;color:#86868b;"></div>
                </div>
                <button type="button" id="removeFileBtn" style="background:none;border:none;color:#ff453a;font-size:16px;cursor:pointer;padding:4px 8px;margin-left:8px;" title="Remove file">
                  <i class="bi bi-x-circle-fill"></i>
                </button>
              </div>
              <input type="file" id="fileInput" name="attachment" style="display:none;" accept=".pdf,.jpg,.jpeg,.png,.webp,.zip,.dwg,.dxf">
            </div>
          </div>

          <button type="submit" id="quoteSubmitBtn" class="apple-btn apple-btn--primary" style="width:100%;justify-content:center;font-size:15px;padding:16px;">
            <i class="bi bi-file-earmark-text"></i> <span id="submitBtnText">Submit Quote Request</span>
          </button>
          <p style="font-size:12px;color:#6e6e73;text-align:center;margin-top:12px;">We typically respond within 2–24 business hours.</p>
        </form>
      </div>

      {{-- RIGHT: INFO --}}
      <div class="reveal reveal--delay-1">
        <div style="position:sticky;top:72px;">

          {{-- Why Request --}}
          <div style="background:#111;border:1px solid rgba(255,255,255,0.08);border-radius:20px;padding:32px;margin-bottom:14px;">
            <h3 style="font-size:16px;font-weight:700;letter-spacing:-.02em;color:#f5f5f7;margin-bottom:20px;">Why Request a Quote?</h3>
            @php $whys = [
              ['icon'=>'bi-currency-rupee','title'=>'Competitive Wholesale Pricing','desc'=>'Special rates for architects, contractors, and bulk buyers.'],
              ['icon'=>'bi-calculator-fill','title'=>'BOQ Optimization','desc'=>'Our engineers review drawings to optimize hardware quantities.'],
              ['icon'=>'bi-clock-history','title'=>'Fast 24-Hour Response','desc'=>'Detailed itemized quotation delivered within one business day.'],
              ['icon'=>'bi-patch-check-fill','title'=>'100% Genuine Products','desc'=>'All products come with original manufacturer warranties.'],
            ]; @endphp
            <div style="display:flex;flex-direction:column;gap:20px;">
              @foreach($whys as $w)
                <div style="display:flex;gap:14px;align-items:start;">
                  <div style="width:36px;height:36px;border-radius:10px;background:rgba(201,169,110,0.12);border:1px solid rgba(201,169,110,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="bi {{ $w['icon'] }}" style="color:#c9a96e;font-size:14px;"></i></div>
                  <div>
                    <div style="font-size:14px;font-weight:600;color:#f5f5f7;margin-bottom:3px;">{{ $w['title'] }}</div>
                    <div style="font-size:13px;color:#6e6e73;font-weight:300;line-height:1.5;">{{ $w['desc'] }}</div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          {{-- Quick Contact --}}
          <div style="background:linear-gradient(135deg,rgba(201,169,110,0.12),rgba(201,169,110,0.04));border:1px solid rgba(201,169,110,0.25);border-radius:20px;padding:28px;">
            <h3 style="font-size:15px;font-weight:700;color:#f5f5f7;margin-bottom:6px;">Prefer to Talk Directly?</h3>
            <p style="font-size:13px;color:#a1a1a6;font-weight:300;margin-bottom:20px;line-height:1.6;">Our hardware specialists are available during showroom hours.</p>
            <div style="display:flex;flex-direction:column;gap:10px;">
              <a href="tel:{{ str_replace(' ','',\App\Models\Setting::get('phone','+919876543210')) }}" class="apple-btn apple-btn--ghost" style="justify-content:center;font-size:13px;"><i class="bi bi-telephone"></i> {{ \App\Models\Setting::get('phone','+91 98765 43210') }}</a>
              <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp','919876543210') }}?text=Hello+Laxmi+Hardware%2C+I+need+a+project+quote." target="_blank" style="display:flex;align-items:center;justify-content:center;gap:8px;font-size:13px;color:#25d366;background:rgba(37,211,102,0.08);border:1px solid rgba(37,211,102,0.2);border-radius:100px;padding:11px 20px;text-decoration:none;transition:background .2s;"><i class="bi bi-whatsapp"></i> Chat on WhatsApp</a>
            </div>
            <div style="margin-top:16px;padding-top:16px;border-top:1px solid rgba(255,255,255,0.07);font-size:12px;color:#6e6e73;text-align:center;"><i class="bi bi-clock" style="margin-right:4px;"></i>{{ \App\Models\Setting::get('business_hours','Mon – Sat: 9:00 AM – 8:30 PM') }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@push('styles')
<style>
@media(max-width:768px){section .apple-container>div{grid-template-columns:1fr!important;}}
.dragover-active { border-color: #c9a96e !important; background: rgba(201,169,110,0.08) !important; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const dropZone = document.getElementById('dropZone');
  const fileInput = document.getElementById('fileInput');
  const uploadPrompt = document.getElementById('uploadPrompt');
  const filePreview = document.getElementById('filePreview');
  const fileName = document.getElementById('fileName');
  const fileSize = document.getElementById('fileSize');
  const removeBtn = document.getElementById('removeFileBtn');
  const form = document.querySelector('form[action*="quote"]');
  const submitBtn = document.getElementById('quoteSubmitBtn');
  const submitText = document.getElementById('submitBtnText');

  function formatBytes(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
  }

  function handleFile(file) {
    if (!file) return;
    fileName.textContent = file.name;
    fileSize.textContent = formatBytes(file.size);
    uploadPrompt.style.display = 'none';
    filePreview.style.display = 'flex';
  }

  if (fileInput) {
    fileInput.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        handleFile(this.files[0]);
      }
    });
  }

  if (dropZone) {
    ['dragenter', 'dragover'].forEach(eventName => {
      dropZone.addEventListener(eventName, e => {
        e.preventDefault();
        e.stopPropagation();
        dropZone.classList.add('dragover-active');
      });
    });

    ['dragleave', 'drop'].forEach(eventName => {
      dropZone.addEventListener(eventName, e => {
        e.preventDefault();
        e.stopPropagation();
        dropZone.classList.remove('dragover-active');
      });
    });

    dropZone.addEventListener('drop', e => {
      const dt = e.dataTransfer;
      const files = dt.files;
      if (files && files.length > 0) {
        fileInput.files = files;
        handleFile(files[0]);
      }
    });
  }

  if (removeBtn) {
    removeBtn.addEventListener('click', e => {
      e.stopPropagation();
      fileInput.value = '';
      uploadPrompt.style.display = 'block';
      filePreview.style.display = 'none';
    });
  }

  if (form && submitBtn) {
    form.addEventListener('submit', function () {
      submitBtn.disabled = true;
      submitBtn.style.opacity = '0.7';
      submitBtn.style.cursor = 'not-allowed';
      if (submitText) submitText.textContent = 'Submitting Quote Request...';
    });
  }
});
</script>
@endpush

@endif

@endsection
