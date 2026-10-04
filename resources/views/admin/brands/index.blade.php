@extends('layouts.admin')

@section('title', 'Brand Partners')
@section('page_title', 'Authorized Hardware Brands')

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
    <div>
      <h5 class="mb-0 fw-bold"><i class="bi bi-award-fill me-2 text-warning"></i>Hardware & Sanitary Brands</h5>
      <small class="text-muted">Manage manufacturers and authorized hardware partners showcased on the website.</small>
    </div>
    <div class="d-flex align-items-center gap-2">
      <button type="button" id="bulkDeleteBtn" class="btn btn-danger text-white btn-sm fw-bold d-none" onclick="submitBulkDelete()">
        <i class="bi bi-trash me-1"></i> Delete Selected (<span id="selectedCount">0</span>)
      </button>
      <button type="button" class="btn btn-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#createBrandModal">
        <i class="bi bi-plus-lg me-1"></i> Add Brand
      </button>
    </div>
  </div>

  <div class="card-body p-0">
    <form action="{{ route('admin.brands.bulk-delete') }}" method="POST" id="bulkForm" class="d-none">
      @csrf
    </form>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 40px;" class="text-center"><input type="checkbox" class="form-check-input" id="selectAll"></th>
              <th style="width: 60px;" class="text-center">#</th>
              <th style="width: 100px;">Logo</th>
              <th>Brand Name</th>
              <th>Website</th>
              <th class="text-center">Products</th>
              <th class="text-center" style="width: 100px;">Featured</th>
              <th class="text-center" style="width: 100px;">Status</th>
              <th class="text-end pe-4" style="width: 130px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($brands as $idx => $brand)
              <tr>
                <td class="text-center"><input type="checkbox" name="ids[]" value="{{ $brand->id }}" class="form-check-input select-item"></td>
                <td class="text-center text-muted fw-bold">{{ $idx + 1 }}</td>
                <td>
                  <div class="rounded-3 bg-light border p-1 d-flex align-items-center justify-content-center" style="width: 70px; height: 46px;">
                    @if($brand->logo)
                      <img src="{{ image_url($brand->logo) }}" alt="{{ $brand->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    @else
                    <i class="bi bi-award text-muted fs-4"></i>
                  @endif
                </div>
              </td>
              <td>
                <a href="{{ route('brands.show', $brand->slug) }}" target="_blank" class="fw-bold text-dark text-decoration-none">
                  {{ $brand->name }} <i class="bi bi-box-arrow-up-right small text-muted"></i>
                </a>
                <small class="text-muted d-block font-monospace">{{ $brand->slug }}</small>
              </td>
              <td>
                @if($brand->website)
                  <a href="{{ $brand->website }}" target="_blank" class="text-decoration-none small text-primary d-flex align-items-center gap-1">
                    <i class="bi bi-link-45deg"></i> {{ parse_url($brand->website, PHP_URL_HOST) ?? $brand->website }}
                  </a>
                @else
                  <span class="text-muted small">—</span>
                @endif
              </td>
              <td class="text-center">
                <a href="{{ route('admin.products.index', ['brand' => $brand->id]) }}" class="badge bg-warning bg-opacity-20 text-dark text-decoration-none px-2 py-1">
                  {{ $brand->products_count ?? 0 }} Products
                </a>
              </td>
              <td class="text-center">
                @if($brand->featured)
                  <span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i>Featured</span>
                @else
                  <span class="text-muted small">Standard</span>
                @endif
              </td>
              <td class="text-center">
                <form action="{{ route('admin.brands.toggle-status', $brand) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-sm border-0" title="Toggle status">
                    @if($brand->status)
                      <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Active</span>
                    @else
                      <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Inactive</span>
                    @endif
                  </button>
                </form>
              </td>
              <td class="text-end pe-4">
                <div class="btn-group btn-group-sm">
                  <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editBrandModal{{ $brand->id }}" title="Edit">
                    <i class="bi bi-pencil"></i>
                  </button>
                  <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('Delete this brand?')" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>

                <!-- Edit Brand Modal -->
                <div class="modal fade text-start" id="editBrandModal{{ $brand->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content border-0 shadow">
                      <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header border-bottom">
                          <h6 class="modal-title fw-bold">Edit Brand: {{ $brand->name }}</h6>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                          <div class="mb-3">
                            <label class="form-label fw-semibold">Brand Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $brand->name }}" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label fw-semibold">Official Website</label>
                            <input type="url" name="website" class="form-control" value="{{ $brand->website }}" placeholder="https://...">
                          </div>
                          <div class="mb-3">
                            <label class="form-label fw-semibold">Brand Logo</label>
                            @if($brand->logo)
                              <div class="mb-2 p-2 bg-light rounded text-center">
                                <img src="{{ Str::startsWith($brand->logo, '/images') ? asset($brand->logo) : asset('storage/' . $brand->logo) }}" alt="Logo" style="max-height: 40px;">
                              </div>
                            @endif
                            <input type="file" name="logo" class="form-control" accept="image/*">
                          </div>
                          <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="2">{{ $brand->description }}</textarea>
                          </div>
                          <div class="d-flex gap-4">
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" name="featured" value="1" id="editFeat{{ $brand->id }}" {{ $brand->featured ? 'checked' : '' }}>
                              <label class="form-check-label" for="editFeat{{ $brand->id }}">Featured on Homepage</label>
                            </div>
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" name="status" value="1" id="editStat{{ $brand->id }}" {{ $brand->status ? 'checked' : '' }}>
                              <label class="form-check-label" for="editStat{{ $brand->id }}">Active</label>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer border-top bg-light">
                          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-warning text-dark fw-bold">Update Brand</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center py-5 text-muted">
                <i class="bi bi-award fs-1 d-block mb-2 text-warning"></i>
                No brands found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Create Brand Modal -->
<div class="modal fade" id="createBrandModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow">
      <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header border-bottom">
          <h6 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2 text-warning"></i>Add New Brand</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label fw-semibold">Brand Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="e.g. Hafele, Blum, Hettich, Jaquar, Astral" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Official Website</label>
            <input type="url" name="website" class="form-control" placeholder="https://...">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Brand Logo</label>
            <input type="file" name="logo" class="form-control" accept="image/*">
            <small class="text-muted">High-res PNG with transparent background or SVG.</small>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="2" placeholder="Brief manufacturer summary..."></textarea>
          </div>
          <div class="d-flex gap-4">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="featured" value="1" id="newBrandFeat" checked>
              <label class="form-check-label" for="newBrandFeat">Featured on Homepage</label>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="status" value="1" id="newBrandStat" checked>
              <label class="form-check-label" for="newBrandStat">Active</label>
            </div>
          </div>
        </div>
        <div class="modal-footer border-top bg-light">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning text-dark fw-bold">Save Brand</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection