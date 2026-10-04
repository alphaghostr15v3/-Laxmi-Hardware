@extends('layouts.admin')

@section('title', 'Add New Category')
@section('page_title', 'Create Product Category')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2 text-warning"></i>New Category Details</h5>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-dark btn-sm">
          <i class="bi bi-arrow-left me-1"></i> Back to Categories
        </a>
      </div>

      <div class="card-body p-4">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Hardware Fittings, Marine Plywood" required>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">Sort Order</label>
              <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Description</label>
              <textarea name="description" class="form-control" rows="3" placeholder="Brief summary of what this category covers...">{{ old('description') }}</textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Icon Class (Bootstrap Icons)</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-tools"></i></span>
                <input type="text" name="icon" class="form-control" value="{{ old('icon', 'bi-tools') }}" placeholder="e.g. bi-tools, bi-layers">
              </div>
              <small class="text-muted">Use any <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icon class</a>.</small>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Category Banner / Image</label>
              <input type="file" name="image" class="form-control" accept="image/*">
              <small class="text-muted">Recommended: SVG, WEBP, or JPG up to 3MB.</small>
            </div>

            <div class="col-12">
              <div class="form-check form-switch pt-2">
                <input class="form-check-input" type="checkbox" name="status" value="1" id="statusSwitch" checked>
                <label class="form-check-label fw-semibold" for="statusSwitch">Visible on website & navigation</label>
              </div>
            </div>
          </div>

          <hr class="my-4">

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-light px-4">Cancel</a>
            <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
              <i class="bi bi-check-lg me-1"></i> Save Category
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection