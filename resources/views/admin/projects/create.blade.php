@extends('layouts.admin')

@section('title', 'Add New Project')
@section('page_title', 'Create Project Showcase')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-9">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2 text-warning"></i>Project Details</h5>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-dark btn-sm">
          <i class="bi bi-arrow-left me-1"></i> Back to Projects
        </a>
      </div>

      <div class="card-body p-4">
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row g-3 mb-4">
            <div class="col-md-8">
              <label class="form-label fw-semibold">Project Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Luxury Penthouse Modular Kitchen & Wardrobes" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
              <select name="category" class="form-select" required>
                <option value="">Select Category...</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Location</label>
              <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="e.g. Vesu, Surat">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Client / Property Type</label>
              <input type="text" name="client_type" class="form-control" value="{{ old('client_type') }}" placeholder="e.g. 4BHK Luxury Apartment, Architect Firm">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Project Duration</label>
              <input type="text" name="duration" class="form-control" value="{{ old('duration') }}" placeholder="e.g. 45 Days, Completed Oct 2025">
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Project Description</label>
              <textarea name="description" class="form-control" rows="4" placeholder="Overview of architectural hardware used, client requirements, design solution...">{{ old('description') }}</textarea>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Materials & Hardware Used</label>
              <input type="text" name="materials" class="form-control" value="{{ old('materials') }}" placeholder="e.g. Hafele Tandem Box, Blum Soft Close Hinges, Marine Plywood 710 Grade, Jaquar Matt Black">
            </div>
          </div>

          <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Project Photos</h6>
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Featured Main Cover Photo</label>
              <input type="file" name="featured_image" class="form-control" accept="image/*">
              <small class="text-muted">Primary thumbnail for project lists and portfolio cards.</small>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Project Gallery Images (Multiple)</label>
              <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>
              <small class="text-muted">Upload high-res interior photos.</small>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Sort Order</label>
              <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
            </div>
            <div class="col-md-8 d-flex align-items-center">
              <div class="form-check form-switch pt-3">
                <input class="form-check-input" type="checkbox" name="status" value="1" id="projStatus" checked>
                <label class="form-check-label fw-semibold" for="projStatus">Visible in Public Portfolio</label>
              </div>
            </div>
          </div>

          <hr class="my-4">

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.projects.index') }}" class="btn btn-light px-4">Cancel</a>
            <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
              <i class="bi bi-check-lg me-1"></i> Save Project
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection