@extends('layouts.admin')

@section('title', 'Add New Service')
@section('page_title', 'Create Hardware Service')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2 text-warning"></i>Service Information</h5>
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-dark btn-sm">
          <i class="bi bi-arrow-left me-1"></i> Back to Services
        </a>
      </div>

      <div class="card-body p-4">
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label fw-semibold">Service Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Architectural Hardware Consultation" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Sort Order</label>
              <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Short Summary</label>
              <textarea name="short_description" class="form-control" rows="2" placeholder="Quick 1-2 sentence overview">{{ old('short_description') }}</textarea>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Full Description</label>
              <textarea name="description" class="form-control" rows="4" placeholder="Detailed service process, what is included, etc.">{{ old('description') }}</textarea>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Key Deliverables / Features (one per line)</label>
              <textarea name="features" class="form-control" rows="3" placeholder="Free Site Measurement&#10;BOQ Bill Estimation&#10;Dedicated Hardware Advisor">{{ old('features') }}</textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Bootstrap Icon Class</label>
              <input type="text" name="icon" class="form-control" value="{{ old('icon', 'bi-tools') }}" placeholder="e.g. bi-shield-check, bi-gear, bi-rulers">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Cover Image</label>
              <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="col-12">
              <div class="form-check form-switch pt-2">
                <input class="form-check-input" type="checkbox" name="status" value="1" id="srvStatus" checked>
                <label class="form-check-label fw-semibold" for="srvStatus">Active and displayed on website</label>
              </div>
            </div>
          </div>

          <hr class="my-4">

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.services.index') }}" class="btn btn-light px-4">Cancel</a>
            <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
              <i class="bi bi-check-lg me-1"></i> Save Service
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection