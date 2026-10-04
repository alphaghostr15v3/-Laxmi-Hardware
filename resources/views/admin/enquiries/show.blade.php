@extends('layouts.admin')

@section('title', 'Enquiry Details — ' . $enquiry->name)
@section('page_title', 'Customer Enquiry Details')

@section('content')
<div class="row g-4 justify-content-center">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-0 fw-bold"><i class="bi bi-envelope-paper me-2 text-warning"></i>Message from {{ $enquiry->name }}</h5>
          <small class="text-muted">Received on {{ $enquiry->created_at->format('d M, Y \a\t h:i A') }} ({{ $enquiry->created_at->diffForHumans() }})</small>
        </div>
        <a href="{{ route('admin.enquiries.index') }}" class="btn btn-outline-dark btn-sm">
          <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
      </div>

      <div class="card-body p-4">
        <!-- Contact Highlights -->
        <div class="row g-3 p-3 bg-light rounded-3 mb-4">
          <div class="col-sm-6">
            <small class="text-muted d-block">Customer Name</small>
            <span class="fw-bold text-dark fs-5">{{ $enquiry->name }}</span>
          </div>
          <div class="col-sm-6 text-sm-end">
            <small class="text-muted d-block">Current Lead Status</small>
            <span class="badge bg-warning text-dark px-3 py-2 fs-6">{{ $enquiry->status }}</span>
          </div>
          <div class="col-sm-6">
            <small class="text-muted d-block">Phone Number</small>
            <a href="tel:{{ $enquiry->phone }}" class="fw-bold text-decoration-none text-dark fs-6">
              <i class="bi bi-telephone text-warning me-1"></i> {{ $enquiry->phone }}
            </a>
          </div>
          <div class="col-sm-6">
            <small class="text-muted d-block">Email Address</small>
            <a href="mailto:{{ $enquiry->email }}" class="fw-bold text-decoration-none text-dark fs-6">
              <i class="bi bi-envelope text-warning me-1"></i> {{ $enquiry->email }}
            </a>
          </div>
        </div>

        <!-- Quick Communication Actions -->
        <div class="d-flex flex-wrap gap-2 mb-4">
          <a href="tel:{{ $enquiry->phone }}" class="btn btn-sm btn-outline-dark">
            <i class="bi bi-telephone-fill me-1 text-primary"></i> Direct Call
          </a>
          <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $enquiry->phone) }}?text=Hello%20{{ urlencode($enquiry->name) }}%2C%20thank%20you%20for%20contacting%20Laxmi%20Hardware." target="_blank" class="btn btn-sm btn-outline-success">
            <i class="bi bi-whatsapp me-1"></i> Reply via WhatsApp
          </a>
          <a href="mailto:{{ $enquiry->email }}?subject=RE:%20{{ urlencode($enquiry->subject) }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-envelope-at me-1"></i> Send Email
          </a>
        </div>

        <!-- Subject & Body -->
        <div class="mb-4">
          <label class="form-label fw-bold text-muted small text-uppercase">Subject / Interested Item</label>
          <div class="p-3 border rounded bg-white fw-bold text-dark fs-6">
            {{ $enquiry->subject }}
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-bold text-muted small text-uppercase">Customer Requirement / Message</label>
          <div class="p-3 border rounded bg-white text-dark" style="white-space: pre-wrap; line-height: 1.6;">{{ $enquiry->message }}</div>
        </div>

        <hr class="my-4">

        <!-- Status & Internal Follow-up Notes -->
        <form action="{{ route('admin.enquiries.update-status', $enquiry) }}" method="POST">
          @csrf
          <h6 class="fw-bold text-dark mb-3"><i class="bi bi-clipboard-check me-2 text-warning"></i>Update Status & Internal Follow-up Notes</h6>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Lead Status</label>
              <select name="status" class="form-select">
                <option value="New" {{ $enquiry->status === 'New' ? 'selected' : '' }}>New</option>
                <option value="Read" {{ $enquiry->status === 'Read' ? 'selected' : '' }}>Read</option>
                <option value="Contacted" {{ $enquiry->status === 'Contacted' ? 'selected' : '' }}>Contacted / In Discussion</option>
                <option value="Closed" {{ $enquiry->status === 'Closed' ? 'selected' : '' }}>Closed / Completed</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Internal Team Notes (Only visible to admin staff)</label>
              <textarea name="admin_notes" class="form-control" rows="3" placeholder="e.g. Called client on 12th Oct, requested quote for 50 Hafele hinges...">{{ $enquiry->admin_notes }}</textarea>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
              <i class="bi bi-save me-1"></i> Update Lead Status
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection