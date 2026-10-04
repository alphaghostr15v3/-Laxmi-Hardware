@extends('layouts.admin')

@section('title', 'Edit Product — ' . $product->name)
@section('page_title', 'Edit Product: ' . $product->name)

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Product Details</h5>
          <small class="text-muted">SKU: {{ $product->sku }} | Last modified: {{ $product->updated_at->diffForHumans() }}</small>
        </div>
        <div class="d-flex gap-2">
          <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-box-arrow-up-right me-1"></i> Preview on Site
          </a>
          <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to List
          </a>
        </div>
      </div>

      <div class="card-body p-4">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <!-- Basic Information -->
          <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">1. Basic Details & Classification</h6>
          <div class="row g-3 mb-4">
            <div class="col-md-8">
              <label class="form-label fw-semibold">Product Title / Name <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">SKU / Model Number <span class="text-danger">*</span></label>
              <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
              <select name="category_id" id="categorySelect" class="form-select" required>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Subcategory</label>
              <select name="subcategory_id" id="subcategorySelect" class="form-select">
                <option value="">Select Subcategory (optional)...</option>
                @foreach($subcategories ?? [] as $sub)
                  <option value="{{ $sub->id }}" {{ old('subcategory_id', $product->subcategory_id) == $sub->id ? 'selected' : '' }}>
                    {{ $sub->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Brand / Manufacturer</label>
              <select name="brand_id" class="form-select">
                <option value="">Select Brand (optional)...</option>
                @foreach($brands as $brand)
                  <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
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
              @if($product->main_image)
                <div class="mb-2 p-2 bg-light rounded text-center" style="max-width: 140px;">
                  <img src="{{ $product->main_image_url }}" alt="Preview" class="img-fluid rounded" style="max-height: 120px; object-fit: contain;">
                </div>
              @endif
              <input type="file" name="main_image" class="form-control" accept="image/*">
              <small class="text-muted">Upload a new file to replace current main image.</small>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Upload Additional Gallery Images</label>
              <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>
              <small class="text-muted">Upload more gallery images to append.</small>

              @if($product->images && $product->images->count() > 0)
                <div class="mt-3">
                  <span class="small fw-semibold d-block mb-1">Existing Gallery Photos ({{ $product->images->count() }}):</span>
                  <div class="d-flex flex-wrap gap-2">
                    @foreach($product->images as $img)
                      <div class="position-relative border rounded p-1 bg-white" style="width: 70px; height: 70px;">
                        <img src="{{ $img->image_url }}" alt="gallery" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                        <button type="button" class="btn btn-danger btn-sm p-0 position-absolute top-0 end-0 rounded-circle d-flex align-items-center justify-content-center" style="width: 20px; height: 20px; font-size: 10px;" onclick="deleteGalleryImage('{{ route('admin.products.image.delete', $img) }}', this)">
                          &times;
                        </button>
                      </div>
                    @endforeach
                  </div>
                </div>
              @endif
            </div>
          </div>

          <!-- Description & Details -->
          <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">3. Descriptions & Technical Guide</h6>
          <div class="row g-3 mb-4">
            <div class="col-12">
              <label class="form-label fw-semibold">Short Summary / Highlights</label>
              <textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $product->short_description) }}</textarea>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Detailed Description</label>
              <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Key Features</label>
              <textarea name="features" class="form-control" rows="3">{{ old('features', $product->features) }}</textarea>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Applications / Use Cases</label>
              <textarea name="applications" class="form-control" rows="3">{{ old('applications', $product->applications) }}</textarea>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Installation Instructions</label>
              <textarea name="installation" class="form-control" rows="3">{{ old('installation', $product->installation) }}</textarea>
            </div>
          </div>

          <!-- Technical Specifications Repeater -->
          <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">4. Technical Specifications</h6>
          <div id="specificationsContainer" class="mb-3">
            @forelse($product->specifications as $spec)
              <div class="row g-2 mb-2 spec-row">
                <div class="col-5">
                  <input type="text" name="spec_keys[]" class="form-control form-control-sm" value="{{ $spec->spec_key }}">
                </div>
                <div class="col-6">
                  <input type="text" name="spec_values[]" class="form-control form-control-sm" value="{{ $spec->spec_value }}">
                </div>
                <div class="col-1">
                  <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-spec-btn"><i class="bi bi-trash"></i></button>
                </div>
              </div>
            @empty
              <div class="row g-2 mb-2 spec-row">
                <div class="col-5">
                  <input type="text" name="spec_keys[]" class="form-control form-control-sm" placeholder="Spec Name">
                </div>
                <div class="col-6">
                  <input type="text" name="spec_values[]" class="form-control form-control-sm" placeholder="Spec Value">
                </div>
                <div class="col-1">
                  <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-spec-btn"><i class="bi bi-trash"></i></button>
                </div>
              </div>
            @endforelse
          </div>
          <button type="button" class="btn btn-sm btn-outline-dark mb-4" id="addSpecBtn">
            <i class="bi bi-plus-circle me-1"></i> Add Another Specification Row
          </button>

          <!-- Settings & Visibility -->
          <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">5. Visibility & Highlights</h6>
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="status" value="1" id="prodStatus" {{ $product->status ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="prodStatus">Visible on Website Catalogue</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="featured" value="1" id="prodFeatured" {{ $product->featured ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="prodFeatured">Highlight as Featured Product on Home Page</label>
              </div>
            </div>
          </div>

          <hr class="my-4">

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.products.index') }}" class="btn btn-light px-4">Cancel</a>
            <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
              <i class="bi bi-check-lg me-1"></i> Update Product
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
  function deleteGalleryImage(url, btn) {
    if (!confirm('Are you sure you want to delete this gallery photo?')) return;
    fetch(url, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      }
    }).then(res => {
      if (res.ok) {
        btn.closest('.position-relative').remove();
      } else {
        alert('Could not delete image. Please try again.');
      }
    });
  }

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

    if (categorySelect && subcategorySelect) {
      categorySelect.addEventListener('change', function() {
        updateSubcategories(this.value);
      });
    }

    const container = document.getElementById('specificationsContainer');
    document.getElementById('addSpecBtn').addEventListener('click', function() {
      const row = document.createElement('div');
      row.className = 'row g-2 mb-2 spec-row';
      row.innerHTML = `
        <div class="col-5">
          <input type="text" name="spec_keys[]" class="form-control form-control-sm" placeholder="Spec Name">
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