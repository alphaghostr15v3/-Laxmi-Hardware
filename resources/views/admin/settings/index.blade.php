@extends('layouts.admin')

@section('title', 'Website Settings')
@section('page_title', 'Website Configuration & Brand Settings')

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-bottom py-3">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h5 class="mb-0 fw-bold"><i class="bi bi-sliders me-2 text-warning"></i>Global Website Settings</h5>
        <small class="text-muted">Manage business contact information, branding, social links, stats, and SEO.</small>
      </div>
      <button type="submit" form="settingsForm" class="btn btn-warning text-dark fw-bold px-4">
        <i class="bi bi-save me-1"></i> Save Changes
      </button>
    </div>
  </div>

  <div class="card-body p-4">
    <form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm" enctype="multipart/form-data">
      @csrf

      <!-- Nav Tabs -->
      <ul class="nav nav-pills mb-4 gap-2" id="settingsTabs" role="tablist">
        <li class="nav-item">
          <button class="nav-link active fw-semibold" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contactTab" type="button">
            <i class="bi bi-telephone-outbound me-1"></i> Contact & Address
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link fw-semibold" id="branding-tab" data-bs-toggle="tab" data-bs-target="#brandingTab" type="button">
            <i class="bi bi-palette me-1"></i> Branding & Logos
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link fw-semibold" id="social-tab" data-bs-toggle="tab" data-bs-target="#socialTab" type="button">
            <i class="bi bi-share me-1"></i> Social Media
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link fw-semibold" id="stats-tab" data-bs-toggle="tab" data-bs-target="#statsTab" type="button">
            <i class="bi bi-bar-chart-line me-1"></i> Stats Counters
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link fw-semibold" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seoTab" type="button">
            <i class="bi bi-search me-1"></i> SEO & Meta
          </button>
        </li>
      </ul>

      <!-- Tab Content -->
      <div class="tab-content border rounded-3 p-4 bg-light bg-opacity-50">
        
        <!-- Tab 1: Contact & Address -->
        <div class="tab-pane fade show active" id="contactTab">
          <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-geo-alt me-2 text-warning"></i>Store & Business Contact</h6>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Company / Brand Name</label>
              <input type="text" name="company_name" class="form-control" value="{{ $settings['company_name'] ?? 'Laxmi Hardware' }}">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Tagline / Slogan</label>
              <input type="text" name="tagline" class="form-control" value="{{ $settings['tagline'] ?? '' }}">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Primary Phone</label>
              <input type="text" name="phone" class="form-control" value="{{ $settings['phone'] ?? '+91 98765 43210' }}">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Secondary / Mobile Phone</label>
              <input type="text" name="phone_alt" class="form-control" value="{{ $settings['phone_alt'] ?? '' }}">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">WhatsApp Number (e.g. 919876543210)</label>
              <input type="text" name="whatsapp" class="form-control" value="{{ $settings['whatsapp'] ?? '919876543210' }}">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">General Contact Email</label>
              <input type="email" name="email" class="form-control" value="{{ $settings['email'] ?? 'info@laxmihardware.com' }}">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Sales / Quotation Email</label>
              <input type="email" name="email_sales" class="form-control" value="{{ $settings['email_sales'] ?? 'sales@laxmihardware.com' }}">
            </div>
            <div class="col-md-8">
              <label class="form-label fw-semibold">Physical Store Address</label>
              <input type="text" name="address" class="form-control" value="{{ $settings['address'] ?? '' }}">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">GSTIN Number</label>
              <input type="text" name="gst_number" class="form-control" value="{{ $settings['gst_number'] ?? '24AAACL1234P1ZR' }}">
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Business Operating Hours</label>
              <input type="text" name="business_hours" class="form-control" value="{{ $settings['business_hours'] ?? 'Mon - Sat: 9:00 AM - 8:30 PM | Sunday: 10:00 AM - 2:00 PM' }}">
            </div>
          </div>
        </div>

        <!-- Tab 2: Branding & Logos -->
        <div class="tab-pane fade" id="brandingTab">
          <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-image me-2 text-warning"></i>Visual Identity Assets</h6>
          <div class="row g-4">
            <div class="col-md-6">
              <div class="card p-3 border">
                <label class="form-label fw-semibold">Website Header Logo</label>
                @if(!empty($settings['logo']))
                  <div class="mb-3 p-3 bg-dark rounded text-center">
                    <img src="{{ image_url($settings['logo']) }}" alt="Logo" style="max-height: 50px; max-width: 100%; object-fit: contain;">
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="remove_logo" value="1" id="removeLogo">
                    <label class="form-check-label text-danger small fw-semibold" for="removeLogo">
                      <i class="bi bi-trash me-1"></i> Remove current logo
                    </label>
                  </div>
                @endif
                <input type="file" name="logo" class="form-control" accept="image/*">
                <div class="mt-2 p-2 bg-light border rounded">
                  <small class="text-secondary d-block"><i class="bi bi-info-circle-fill text-warning me-1"></i> <strong>Recommended Header Logo Specs:</strong></small>
                  <small class="text-muted d-block">• <strong>Dimensions:</strong> 200 × 50 px (or Max Height 40–50 px)</small>
                  <small class="text-muted d-block">• <strong>Format:</strong> Transparent PNG or Vector SVG</small>
                  <small class="text-muted d-block">• <strong>Aspect Ratio:</strong> Horizontal Landscape (3:1 to 4:1)</small>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card p-3 border">
                <label class="form-label fw-semibold">Browser Favicon</label>
                @if(!empty($settings['favicon']))
                  <div class="mb-3 p-2 bg-light rounded text-center">
                    <img src="{{ image_url($settings['favicon']) }}" alt="Favicon" style="max-height: 32px; object-fit: contain;">
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="remove_favicon" value="1" id="removeFavicon">
                    <label class="form-check-label text-danger small fw-semibold" for="removeFavicon">
                      <i class="bi bi-trash me-1"></i> Remove current favicon
                    </label>
                  </div>
                @endif
                <input type="file" name="favicon" class="form-control" accept="image/*">
                <div class="mt-2 p-2 bg-light border rounded">
                  <small class="text-secondary d-block"><i class="bi bi-info-circle-fill text-warning me-1"></i> <strong>Recommended Favicon Specs:</strong></small>
                  <small class="text-muted d-block">• <strong>Dimensions:</strong> 32 × 32 px or 64 × 64 px (Square 1:1)</small>
                  <small class="text-muted d-block">• <strong>Format:</strong> PNG, ICO, or SVG</small>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Tab 3: Social Media -->
        <div class="tab-pane fade" id="socialTab">
          <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-globe me-2 text-warning"></i>Official Social Profiles</h6>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold"><i class="bi bi-facebook text-primary me-1"></i> Facebook URL</label>
              <input type="url" name="facebook_url" class="form-control" placeholder="https://facebook.com/..." value="{{ $settings['facebook_url'] ?? '' }}">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold"><i class="bi bi-instagram text-danger me-1"></i> Instagram URL</label>
              <input type="url" name="instagram_url" class="form-control" placeholder="https://instagram.com/..." value="{{ $settings['instagram_url'] ?? '' }}">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold"><i class="bi bi-linkedin text-primary me-1"></i> LinkedIn URL</label>
              <input type="url" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/..." value="{{ $settings['linkedin_url'] ?? '' }}">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold"><i class="bi bi-youtube text-danger me-1"></i> YouTube Channel URL</label>
              <input type="url" name="youtube_url" class="form-control" placeholder="https://youtube.com/..." value="{{ $settings['youtube_url'] ?? '' }}">
            </div>
          </div>
        </div>

        <!-- Tab 4: Stats Counters -->
        <div class="tab-pane fade" id="statsTab">
          <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-trophy me-2 text-warning"></i>Homepage Highlight Numbers</h6>
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label fw-semibold">Years of Experience</label>
              <input type="text" name="stat_experience" class="form-control" value="{{ $settings['stat_experience'] ?? '10+' }}">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Products in Catalogue</label>
              <input type="text" name="stat_products" class="form-control" value="{{ $settings['stat_products'] ?? '750+' }}">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Hardware Categories</label>
              <input type="text" name="stat_categories" class="form-control" value="{{ $settings['stat_categories'] ?? '120+' }}">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Satisfied Clients</label>
              <input type="text" name="stat_customers" class="form-control" value="{{ $settings['stat_customers'] ?? '1500+' }}">
            </div>
          </div>
        </div>

        <!-- Tab 5: SEO & Meta -->
        <div class="tab-pane fade" id="seoTab">
          <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-google me-2 text-warning"></i>Search Engine Optimization</h6>
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label fw-semibold">Global Meta Title</label>
              <input type="text" name="meta_title" class="form-control" value="{{ $settings['meta_title'] ?? '' }}">
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Global Meta Description</label>
              <textarea name="meta_description" class="form-control" rows="3">{{ $settings['meta_description'] ?? '' }}</textarea>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Global Meta Keywords (comma separated)</label>
              <input type="text" name="meta_keywords" class="form-control" value="{{ $settings['meta_keywords'] ?? '' }}">
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Google Maps Embed URL</label>
              <input type="text" name="google_map_embed" class="form-control" value="{{ $settings['google_map_embed'] ?? '' }}">
              <small class="text-muted">Paste the `src` attribute URL from Google Maps Embed iframe.</small>
            </div>
          </div>
        </div>

      </div>

      <div class="mt-4 d-flex justify-content-end">
        <button type="submit" class="btn btn-warning text-dark fw-bold px-4 py-2">
          <i class="bi bi-save me-1"></i> Save All Settings
        </button>
      </div>

    </form>
  </div>
</div>
@endsection