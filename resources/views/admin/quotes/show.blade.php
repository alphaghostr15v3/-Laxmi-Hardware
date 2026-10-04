@extends('layouts.admin')

@section('title', 'Quote Request — ' . $quote->name)
@section('page_title', 'Project Quotation Request Details')

@section('content')
<div class="row g-4 justify-content-center">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-0 fw-bold"><i class="bi bi-file-earmark-text me-2 text-warning"></i>Quotation Lead: {{ $quote->name }}</h5>
          <small class="text-muted">Submitted on {{ $quote->created_at->format('d M, Y \a\t h:i A') }} ({{ $quote->created_at->diffForHumans() }})</small>
        </div>
        <a href="{{ route('admin.quotes.index') }}" class="btn btn-outline-dark btn-sm">
          <i class="bi bi-arrow-left me-1"></i> Back to Quote Requests
        </a>
      </div>

      <div class="card-body p-4">
        <!-- Lead Information Card -->
        <div class="row g-3 p-3 bg-light rounded-3 mb-4">
          <div class="col-sm-6">
            <small class="text-muted d-block">Client / Contact Person</small>
            <span class="fw-bold text-dark fs-5">{{ $quote->name }}</span>
            @if($quote->company)
              <div class="text-muted small"><i class="bi bi-building me-1"></i>{{ $quote->company }}</div>
            @endif
          </div>
          <div class="col-sm-6 text-sm-end">
            <small class="text-muted d-block">Current Quotation Stage</small>
            <span class="badge bg-warning text-dark px-3 py-2 fs-6">{{ $quote->status }}</span>
          </div>
          <div class="col-sm-6">
            <small class="text-muted d-block">Phone Number</small>
            <a href="tel:{{ $quote->phone }}" class="fw-bold text-decoration-none text-dark fs-6">
              <i class="bi bi-telephone text-warning me-1"></i> {{ $quote->phone }}
            </a>
          </div>
          <div class="col-sm-6">
            <small class="text-muted d-block">Email Address</small>
            <a href="mailto:{{ $quote->email }}" class="fw-bold text-decoration-none text-dark fs-6">
              <i class="bi bi-envelope text-warning me-1"></i> {{ $quote->email }}
            </a>
          </div>
          <div class="col-sm-6">
            <small class="text-muted d-block">Project Type</small>
            <span class="fw-semibold text-dark">{{ $quote->project_type ?? 'General Interior' }}</span>
          </div>
          <div class="col-sm-6">
            <small class="text-muted d-block">Hardware Category</small>
            <span class="fw-semibold text-dark">{{ $quote->product_category ?? 'Comprehensive Package' }}</span>
          </div>
          <div class="col-12">
            <small class="text-muted d-block">Site / Project Location</small>
            <span class="fw-semibold text-dark"><i class="bi bi-geo-alt text-danger me-1"></i>{{ $quote->location ?? 'Surat, Gujarat' }}</span>
          </div>
        </div>

        <!-- Quick Communication Actions -->
        <div class="d-flex flex-wrap gap-2 mb-4">
          <a href="tel:{{ $quote->phone }}" class="btn btn-sm btn-outline-dark">
            <i class="bi bi-telephone-fill me-1 text-primary"></i> Direct Call
          </a>
          <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $quote->phone) }}?text=Hello%20{{ urlencode($quote->name) }}%2C%20regarding%20your%20quotation%20request%20with%20Laxmi%20Hardware." target="_blank" class="btn btn-sm btn-outline-success">
            <i class="bi bi-whatsapp me-1"></i> WhatsApp Message
          </a>
          <a href="mailto:{{ $quote->email }}?subject=Quotation%20Estimation%20-%20Laxmi%20Hardware" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-envelope-at me-1"></i> Send Official Email
          </a>
        </div>

        <!-- Attached File / BOQ Document -->
        @if($quote->attachment_path)
          <div class="alert alert-info border-info d-flex align-items-center justify-content-between p-3 mb-4">
            <div>
              <i class="bi bi-file-earmark-arrow-down-fill fs-4 me-2"></i>
              <strong>Attached BOQ / Specification Document</strong>
              <div class="small text-muted">{{ basename($quote->attachment_path) }}</div>
            </div>
            <a href="{{ asset('storage/' . $quote->attachment_path) }}" target="_blank" download class="btn btn-primary btn-sm px-3">
              <i class="bi bi-download me-1"></i> Download File
            </a>
          </div>
        @endif

        <!-- Client Requirements & Message -->
        @if($quote->requirement)
          <div class="mb-4">
            <label class="form-label fw-bold text-muted small text-uppercase">Hardware Requirement Summary</label>
            <div class="p-3 border rounded bg-white fw-semibold text-dark">{{ $quote->requirement }}</div>
          </div>
        @endif

        @if($quote->message)
          <div class="mb-4">
            <label class="form-label fw-bold text-muted small text-uppercase">Client Specifications / Project Scope</label>
            <div class="p-3 border rounded bg-white text-dark" style="white-space: pre-wrap; line-height: 1.6;">{{ $quote->message }}</div>
          </div>
        @endif

        <hr class="my-4">

        <!-- Status & Internal Pipeline Notes -->
        <form action="{{ route('admin.quotes.update-status', $quote) }}" method="POST">
          @csrf
          <h6 class="fw-bold text-dark mb-3"><i class="bi bi-clipboard-check me-2 text-warning"></i>Quotation Pipeline Status & Follow-up Notes</h6>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Quotation Stage</label>
              <select name="status" class="form-select">
                <option value="New" {{ $quote->status === 'New' ? 'selected' : '' }}>New</option>
                <option value="Contacted" {{ $quote->status === 'Contacted' ? 'selected' : '' }}>Contacted / Requirements Clarified</option>
                <option value="Quotation Sent" {{ $quote->status === 'Quotation Sent' ? 'selected' : '' }}>Quotation Sent to Client</option>
                <option value="Converted" {{ $quote->status === 'Converted' ? 'selected' : '' }}>Converted / Deal Closed</option>
                <option value="Closed" {{ $quote->status === 'Closed' ? 'selected' : '' }}>Closed / Lost</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Internal Estimator Notes</label>
              <textarea name="admin_notes" class="form-control" rows="3" placeholder="e.g. Sent PDF quotation with 15% contractor discount on Hafele hinges...">{{ $quote->admin_notes }}</textarea>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
              <i class="bi bi-save me-1"></i> Update Quotation Status
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection