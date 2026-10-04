@extends('layouts.admin')

@section('title', 'Gallery Management')
@section('page_title', 'Photo & Installation Gallery')

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-bottom py-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
      <div>
        <h5 class="mb-0 fw-bold"><i class="bi bi-images me-2 text-warning"></i>Visual Gallery Management</h5>
        <small class="text-muted">Upload and categorize real site photos, fittings, showroom displays, and product closeups.</small>
      </div>
      <div class="d-flex align-items-center gap-2">
        <form action="{{ route('admin.gallery.index') }}" method="GET" class="d-flex align-items-center gap-2">
          <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
              <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
          </select>
          @if(request('category'))
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
          @endif
        </form>
        <div class="form-check d-inline-flex align-items-center me-2">
          <input type="checkbox" class="form-check-input me-1" id="selectAll">
          <label class="form-check-label fw-semibold text-dark small" for="selectAll">Select All</label>
        </div>
        <button type="button" id="bulkDeleteBtn" class="btn btn-danger text-white btn-sm fw-bold d-none" onclick="submitBulkDelete()">
          <i class="bi bi-trash me-1"></i> Delete Selected (<span id="selectedCount">0</span>)
        </button>
        <button type="button" class="btn btn-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#uploadGalleryModal">
          <i class="bi bi-cloud-arrow-up me-1"></i> Upload Photos
        </button>
      </div>
    </div>
  </div>

  <div class="card-body p-4">
    <form action="{{ route('admin.gallery.bulk-delete') }}" method="POST" id="bulkForm" class="d-none">
      @csrf
    </form>
    <div class="row g-3">
        @forelse($items as $item)
          <div class="col-sm-6 col-md-4 col-xl-3">
            <div class="card border h-100 overflow-hidden shadow-sm">
              <div class="position-relative bg-dark" style="height: 180px;">
                <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="form-check-input select-item position-absolute bottom-0 start-0 m-2 shadow" style="z-index: 10; width: 22px; height: 22px; cursor: pointer;">
                <img src="{{ image_url($item->image_path) }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
              <span class="badge bg-dark bg-opacity-75 position-absolute top-0 start-0 m-2">{{ $item->category }}</span>
              <form action="{{ route('admin.gallery.toggle-status', $item) }}" method="POST" class="position-absolute top-0 end-0 m-2">
                @csrf
                <button type="submit" class="badge {{ $item->status ? 'bg-success' : 'bg-danger' }} border-0" title="Click to toggle status">
                  {{ $item->status ? 'Active' : 'Hidden' }}
                </button>
              </form>
            </div>
            <div class="card-body p-3">
              <h6 class="fw-bold mb-1 text-truncate" title="{{ $item->title }}">{{ $item->title }}</h6>
              <p class="text-muted small mb-0 text-truncate">{{ $item->description ?? 'No description' }}</p>
            </div>
            <div class="card-footer bg-white border-top p-2 d-flex justify-content-between align-items-center">
              <small class="text-muted">{{ $item->created_at->format('d M, Y') }}</small>
              <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editGalleryModal{{ $item->id }}">
                  <i class="bi bi-pencil"></i>
                </button>
                <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this image?')" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>

          <!-- Edit Item Modal -->
          <div class="modal fade text-start" id="editGalleryModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content border-0 shadow">
                <form action="{{ route('admin.gallery.update', $item) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="modal-header border-bottom">
                    <h6 class="modal-title fw-bold">Edit Gallery Item</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body p-4">
                    <div class="mb-3">
                      <label class="form-label fw-semibold">Photo Title <span class="text-danger">*</span></label>
                      <input type="text" name="title" class="form-control" value="{{ $item->title }}" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                      <select name="category" class="form-select" required>
                        @foreach($categories as $cat)
                          <option value="{{ $cat }}" {{ $item->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label fw-semibold">Description</label>
                      <textarea name="description" class="form-control" rows="2">{{ $item->description }}</textarea>
                    </div>
                    <div class="mb-3">
                      <label class="form-label fw-semibold">Current Photo</label>
                      <div class="d-flex align-items-center gap-3 p-2 bg-light rounded border mb-2">
                        <img src="{{ image_url($item->image_path) }}" alt="{{ $item->title }}" style="width: 55px; height: 55px; object-fit: cover; border-radius: 6px;">
                        <small class="text-muted text-break">{{ basename($item->image_path) }}</small>
                      </div>
                      <label class="form-label fw-semibold">Replace Photo (Optional)</label>
                      <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                      <label class="form-label fw-semibold">Display Order</label>
                      <input type="number" name="sort_order" class="form-control" value="{{ $item->sort_order ?? 0 }}" min="0">
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" name="status" value="1" id="galStat{{ $item->id }}" {{ $item->status ? 'checked' : '' }}>
                      <label class="form-check-label" for="galStat{{ $item->id }}">Active & Visible</label>
                    </div>
                  </div>
                  <div class="modal-footer border-top bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold">Update Photo</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        </div>
      @empty
        <div class="col-12 text-center py-5 text-muted">
          <i class="bi bi-images fs-1 d-block mb-2 text-warning"></i>
          No photos found. Click "Upload Photos" to add images to the gallery.
        </div>
      @endforelse
    </div>
  </div>

  @if($items->hasPages())
    <div class="card-footer bg-white border-top py-3">
      {{ $items->links() }}
    </div>
  @endif
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadGalleryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow">
      <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header border-bottom">
          <h6 class="modal-title fw-bold"><i class="bi bi-cloud-arrow-up me-2 text-warning"></i>Upload Gallery Photos</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label fw-semibold">Photo Title / Caption <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" placeholder="e.g. Modern Concealed Kitchen Tandem Setup" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
            <select name="category" class="form-select" required>
              <option value="">Select Category...</option>
              @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Select Images (Multiple allowed) <span class="text-danger">*</span></label>
            <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
            <small class="text-muted">You can select several files at once. Each image will be created as a gallery item.</small>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="2" placeholder="Optional notes..."></textarea>
          </div>
        </div>
        <div class="modal-footer border-top bg-light">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning text-dark fw-bold">Upload to Gallery</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection