@extends('layouts.admin')

@section('title', 'Subcategories Management')
@section('page_title', 'Product Subcategories')

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-bottom py-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
      <div>
        <h5 class="mb-0 fw-bold"><i class="bi bi-diagram-3-fill me-2 text-warning"></i>Subcategories</h5>
        <small class="text-muted">Manage product sub-classifications nested under parent categories.</small>
      </div>

      <div class="d-flex align-items-center gap-2">
        <!-- Category Filter -->
        <form action="{{ route('admin.subcategories.index') }}" method="GET" class="d-flex align-items-center gap-2">
          <select name="category_id" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width: 200px;">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
          @if(request('category_id'))
            <a href="{{ route('admin.subcategories.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
          @endif
        </form>

        <button type="button" id="bulkDeleteBtn" class="btn btn-danger text-white btn-sm fw-bold d-none" onclick="submitBulkDelete()">
          <i class="bi bi-trash me-1"></i> Delete Selected (<span id="selectedCount">0</span>)
        </button>

        <button type="button" class="btn btn-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#createSubcategoryModal">
          <i class="bi bi-plus-lg me-1"></i> Add Subcategory
        </button>
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <form action="{{ route('admin.subcategories.bulk-delete') }}" method="POST" id="bulkForm" class="d-none">
      @csrf
    </form>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 40px;" class="text-center"><input type="checkbox" class="form-check-input" id="selectAll"></th>
              <th style="width: 60px;" class="text-center">#</th>
              <th>Subcategory Name</th>
              <th>Parent Category</th>
              <th>Description</th>
              <th class="text-center" style="width: 110px;">Status</th>
              <th class="text-end pe-4" style="width: 140px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($subcategories as $idx => $sub)
              <tr>
                <td class="text-center"><input type="checkbox" name="ids[]" value="{{ $sub->id }}" class="form-check-input select-item"></td>
                <td class="text-center text-muted fw-bold">{{ $subcategories->firstItem() + $idx }}</td>
              <td>
                <span class="fw-bold text-dark">{{ $sub->name }}</span>
                <small class="text-muted d-block font-monospace">{{ $sub->slug }}</small>
              </td>
              <td>
                <span class="badge bg-warning bg-opacity-15 text-dark border px-2 py-1">
                  <i class="bi bi-folder2-open me-1"></i> {{ $sub->category->name ?? 'Unassigned' }}
                </span>
              </td>
              <td>
                <span class="text-muted small">{{ Str::limit($sub->description ?? '—', 60) }}</span>
              </td>
              <td class="text-center">
                @if($sub->status)
                  <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Active</span>
                @else
                  <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Inactive</span>
                @endif
              </td>
              <td class="text-end pe-4">
                <div class="btn-group btn-group-sm">
                  <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editModal{{ $sub->id }}" title="Edit">
                    <i class="bi bi-pencil"></i>
                  </button>
                  <form action="{{ route('admin.subcategories.destroy', $sub) }}" method="POST" onsubmit="return confirm('Delete this subcategory?')" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade text-start" id="editModal{{ $sub->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content border-0 shadow">
                      <form action="{{ route('admin.subcategories.update', $sub) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header border-bottom">
                          <h6 class="modal-title fw-bold">Edit Subcategory: {{ $sub->name }}</h6>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                          <div class="mb-3">
                            <label class="form-label fw-semibold">Parent Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                              @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $sub->category_id == $cat->id ? 'selected' : '' }}>
                                  {{ $cat->name }}
                                </option>
                              @endforeach
                            </select>
                          </div>
                          <div class="mb-3">
                            <label class="form-label fw-semibold">Subcategory Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $sub->name }}" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="2">{{ $sub->description }}</textarea>
                          </div>
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" value="1" id="editStatus{{ $sub->id }}" {{ $sub->status ? 'checked' : '' }}>
                            <label class="form-check-label" for="editStatus{{ $sub->id }}">Active & Visible</label>
                          </div>
                        </div>
                        <div class="modal-footer border-top bg-light">
                          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-warning text-dark fw-bold">Update Subcategory</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-5 text-muted">
                <i class="bi bi-diagram-3 fs-1 d-block mb-2 text-warning"></i>
                No subcategories found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if($subcategories->hasPages())
    <div class="card-footer bg-white border-top py-3">
      {{ $subcategories->links() }}
    </div>
  @endif
</div>

<!-- Create Modal -->
<div class="modal fade" id="createSubcategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow">
      <form action="{{ route('admin.subcategories.store') }}" method="POST">
        @csrf
        <div class="modal-header border-bottom">
          <h6 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2 text-warning"></i>Add New Subcategory</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label fw-semibold">Parent Category <span class="text-danger">*</span></label>
            <select name="category_id" class="form-select" required>
              <option value="">Select Category...</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                  {{ $cat->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Subcategory Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="e.g. Soft Close Hinges, CPVC Ball Valves" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="2" placeholder="Brief details..."></textarea>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="status" value="1" id="newSubStatus" checked>
            <label class="form-check-label" for="newSubStatus">Active & Visible</label>
          </div>
        </div>
        <div class="modal-footer border-top bg-light">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning text-dark fw-bold">Save Subcategory</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection