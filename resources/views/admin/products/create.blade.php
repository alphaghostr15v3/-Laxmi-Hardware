@extends('layouts.admin')

@section('title', 'Add New Product')
@section('page_title', 'Create Product Catalogue Item')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2 text-warning"></i>Product Information</h5>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark btn-sm">
          <i class="bi bi-arrow-left me-1"></i> Back to Products
        </a>
      </div>

      <div class="card-body p-4">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <!-- Basic Information -->
          <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">1. Basic Details & Classification</h6>
          <div class="row g-3 mb-4">
            <div class="col-md-8">
              <label class="form-label fw-semibold">Product Title / Name <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Soft Close Hydraulic Concealed Hinge 110°" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">SKU / Model Number <span class="text-danger">*</span></label>
              <input type="text" name="sku" class="form-control" value="{{ old('sku') }}" placeholder="e.g. LH-HNG-110" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
              <select name="category_id" id="categorySelect" class="form-select" required>
                <option value="">Select Category...</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Subcategory</label>
              <select name="subcategory_id" id="subcategorySelect" class="form-select">
                <option value="">Select Subcategory (optional)...</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Brand / Manufacturer</label>
              <select name="brand_id" class="form-select">
                <option value="">Select Brand (optional)...</option>
                @foreach($brands as $brand)
                  <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- Media Uploads -->
          <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">2. Images & Gallery</h6>
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Primary Featured Image</label>
              <input type="file" name="main_image" class="form-control" accept="image/*">
              <small class="text-muted">Main thumbnail displayed on catalogues & cards.</small>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Additional Gallery Images</label>
              <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>
              <small class="text-muted">Select multiple images for the detail slider.</small>
            </div>
          </div>

          <!-- Description & Details -->
          <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">3. Descriptions & Technical Guide</h6>
          <div class="row g-3 mb-4">
            <div class="col-12">
              <label class="form-label fw-semibold">Short Summary / Highlights</label>
              <textarea name="short_description" class="form-control" rows="2" placeholder="Brief 1-2 sentence overview">{{ old('short_description') }}</textarea>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Detailed Description</label>
              <textarea name="description" class="form-control" rows="4" placeholder="Full product description, material composition, certifications...">{{ old('description') }}</textarea>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Key Features</label>
              <textarea name="features" class="form-control" rows="3" placeholder="Features or bullet points...">{{ old('features') }}</textarea>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Applications / Use Cases</label>
              <textarea name="applications" class="form-control" rows="3" placeholder="Suitable for kitchens, wardrobes, doors...">{{ old('applications') }}</textarea>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Installation Instructions</label>
              <textarea name="installation" class="form-control" rows="3" placeholder="Recommended mounting guide...">{{ old('installation') }}</textarea>
            </div>
          </div>

          <!-- Technical Specifications Repeater -->
          <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">4. Technical Specifications</h6>
          <div id="specificationsContainer" class="mb-3">
            <div class="row g-2 mb-2 spec-row">
              <div class="col-5">
                <input type="text" name="spec_keys[]" class="form-control form-control-sm" placeholder="Spec Name (e.g. Material, Finish, Load Capacity)">
              </div>
              <div class="col-6">
                <input type="text" name="spec_values[]" class="form-control form-control-sm" placeholder="Spec Value (e.g. Stainless Steel 304, Matt Black, 45 KG)">
              </div>
              <div class="col-1">
                <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-spec-btn"><i class="bi bi-trash"></i></button>
              </div>
            </div>
          </div>
          <button type="button" class="btn btn-sm btn-outline-dark mb-4" id="addSpecBtn">
            <i class="bi bi-plus-circle me-1"></i> Add Another Specification Row
          </button>

          <!-- Settings & Visibility -->
          <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">5. Visibility & Highlights</h6>
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="status" value="1" id="prodStatus" checked>
                <label class="form-check-label fw-semibold" for="prodStatus">Visible on Website Catalogue</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="featured" value="1" id="prodFeatured">
                <label class="form-check-label fw-semibold" for="prodFeatured">Highlight as Featured Product on Home Page</label>
              </div>
            </div>
          </div>

          <hr class="my-4">

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.products.index') }}" class="btn btn-light px-4">Cancel</a>
            <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
              <i class="bi bi-check-lg me-1"></i> Save Product
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Dynamic Subcategory dropdown mapping
    const categoriesData = @json($categories);
    const categorySelect = document.getElementById('categorySelect');
    const subcategorySelect = document.getElementById('subcategorySelect');

    function updateSubcategories(catId) {
      subcategorySelect.innerHTML = '<option value="">Select Subcategory (optional)...</option>';
      if (!catId) return;

      const cat = categoriesData.find(c => c.id == catId);
      if (cat && cat.subcategories && cat.subcategories.length > 0) {
        cat.subcategories.forEach(sub => {
          const opt = document.createElement('option');
          opt.value = sub.id;
          opt.textContent = sub.name;
          subcategorySelect.appendChild(opt);
        });
      }
    }

    categorySelect.addEventListener('change', function() {
      updateSubcategories(this.value);
    });

    // Specifications repeater
    const container = document.getElementById('specificationsContainer');
    document.getElementById('addSpecBtn').addEventListener('click', function() {
      const row = document.createElement('div');
      row.className = 'row g-2 mb-2 spec-row';
      row.innerHTML = `
        <div class="col-5">
          <input type="text" name="spec_keys[]" class="form-control form-control-sm" placeholder="Spec Name (e.g. Thickness, Warranty)">
        </div>
        <div class="col-6">
          <input type="text" name="spec_values[]" class="form-control form-control-sm" placeholder="Spec Value">
        </div>
        <div class="col-1">
          <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-spec-btn"><i class="bi bi-trash"></i></button>
        </div>
      `;
      container.appendChild(row);
    });

    container.addEventListener('click', function(e) {
      if (e.target.closest('.remove-spec-btn')) {
        const row = e.target.closest('.spec-row');
        if (container.querySelectorAll('.spec-row').length > 1) {
          row.remove();
        } else {
          row.querySelectorAll('input').forEach(i => i.value = '');
        }
      }
    });
  });
</script>
@endpush