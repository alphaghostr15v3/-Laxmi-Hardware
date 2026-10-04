@extends('layouts.admin')

@section('title', 'Blog Categories')
@section('page_title', 'Blog Article Categories')

@section('content')
<div class="row g-4">
  <div class="col-md-5">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3">
        <h6 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2 text-warning"></i>Add Blog Category</h6>
      </div>
      <div class="card-body p-4">
        <form action="{{ route('admin.blog-categories.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="e.g. Hardware Guides, Kitchen Tips, Materials" required>
          </div>
          <button type="submit" class="btn btn-warning text-dark fw-bold w-100">
            <i class="bi bi-check-lg me-1"></i> Save Category
          </button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-7">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold"><i class="bi bi-tag-fill me-2 text-warning"></i>Existing Categories</h6>
        <div class="d-flex align-items-center gap-2">
          <button type="button" id="bulkDeleteBtn" class="btn btn-sm btn-danger d-none" onclick="submitBulkDelete('bulkForm')">
            <i class="bi bi-trash me-1"></i> Delete Selected (<span id="selectedCount">0</span>)
          </button>
          <a href="{{ route('admin.blog.index') }}" class="btn btn-sm btn-outline-dark">
            <i class="bi bi-journal-text me-1"></i> All Articles
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        <form action="{{ route('admin.blog-categories.bulk-delete') }}" method="POST" id="bulkForm" class="d-none">
          @csrf
        </form>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th style="width: 40px;" class="text-center">
                    <input type="checkbox" id="selectAll" class="form-check-input">
                  </th>
                  <th style="width: 50px;" class="text-center">#</th>
                  <th>Category Name</th>
                  <th class="text-center">Articles</th>
                  <th class="text-end pe-4" style="width: 120px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($categories as $idx => $cat)
                  <tr>
                    <td class="text-center">
                      <input type="checkbox" name="ids[]" value="{{ $cat->id }}" class="form-check-input select-item">
                    </td>
                    <td class="text-center text-muted fw-bold">{{ $idx + 1 }}</td>
                    <td>
                      <span class="fw-bold text-dark">{{ $cat->name }}</span>
                      <small class="text-muted d-block font-monospace">{{ $cat->slug }}</small>
                    </td>
                    <td class="text-center">
                      <span class="badge bg-warning bg-opacity-20 text-dark px-2 py-1">
                        {{ $cat->posts_count }} articles
                      </span>
                    </td>
                    <td class="text-end pe-4">
                      <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editCatModal{{ $cat->id }}">
                          <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('admin.blog-categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Delete this blog category?')" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash"></i>
                          </button>
                        </form>
                      </div>

                      <!-- Edit Modal -->
                      <div class="modal fade text-start" id="editCatModal{{ $cat->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content border-0 shadow">
                            <form action="{{ route('admin.blog-categories.update', $cat) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <div class="modal-header border-bottom">
                                <h6 class="modal-title fw-bold">Edit Category: {{ $cat->name }}</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body p-4">
                                <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
                              </div>
                              <div class="modal-footer border-top bg-light">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-warning text-dark fw-bold">Update Category</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center py-4 text-muted">No categories created yet.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
