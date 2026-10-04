@extends('layouts.admin')

@section('title', 'Categories Management')
@section('page_title', 'Hardware Categories')

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
    <div>
      <h5 class="mb-0 fw-bold"><i class="bi bi-grid-fill me-2 text-warning"></i>Product Categories</h5>
      <small class="text-muted">Manage main hardware divisions and navigation sections.</small>
    </div>
    <div class="d-flex align-items-center gap-2">
      <button type="button" id="bulkDeleteBtn" class="btn btn-danger text-white fw-bold d-none" onclick="submitBulkDelete()">
        <i class="bi bi-trash me-1"></i> Delete Selected (<span id="selectedCount">0</span>)
      </button>
      <a href="{{ route('admin.categories.create') }}" class="btn btn-warning text-dark fw-bold">
        <i class="bi bi-plus-lg me-1"></i> Add Category
      </a>
    </div>
  </div>

  <div class="card-body p-0">
    <form action="{{ route('admin.categories.bulk-delete') }}" method="POST" id="bulkForm" class="d-none">
      @csrf
    </form>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 40px;" class="text-center"><input type="checkbox" class="form-check-input" id="selectAll"></th>
              <th style="width: 50px;" class="text-center">#</th>
              <th style="width: 80px;">Icon / Image</th>
              <th>Category Name</th>
              <th>Description</th>
              <th class="text-center">Subcategories</th>
              <th class="text-center">Products</th>
              <th class="text-center" style="width: 100px;">Sort Order</th>
              <th class="text-center" style="width: 100px;">Status</th>
              <th class="text-end pe-4" style="width: 140px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $idx => $cat)
              <tr>
                <td class="text-center"><input type="checkbox" name="ids[]" value="{{ $cat->id }}" class="form-check-input select-item"></td>
                <td class="text-center text-muted fw-bold">{{ $idx + 1 }}</td>
                <td>
                  <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center overflow-hidden" style="width: 48px; height: 48px;">
                    @if($cat->image)
                      <img src="{{ image_url($cat->image) }}" alt="{{ $cat->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                      <i class="bi {{ $cat->icon ?? 'bi-tools' }} fs-4 text-warning"></i>
                    @endif
                  </div>
                </td>
                <td>
                  <a href="{{ route('categories.show', $cat->slug) }}" target="_blank" class="fw-bold text-dark text-decoration-none d-flex align-items-center gap-1">
                    {{ $cat->name }} <i class="bi bi-box-arrow-up-right small text-muted"></i>
                  </a>
                  <small class="text-muted font-monospace">{{ $cat->slug }}</small>
                </td>
                <td>
                  <span class="text-muted small">{{ Str::limit($cat->description ?? 'No description provided', 60) }}</span>
                </td>
                <td class="text-center">
                  <a href="{{ route('admin.subcategories.index', ['category_id' => $cat->id]) }}" class="badge bg-secondary bg-opacity-10 text-secondary text-decoration-none px-2 py-1">
                    {{ $cat->all_subcategories_count ?? 0 }} Subcategories
                  </a>
                </td>
                <td class="text-center">
                  <a href="{{ route('admin.products.index', ['category' => $cat->id]) }}" class="badge bg-warning bg-opacity-20 text-dark text-decoration-none px-2 py-1">
                    {{ $cat->products_count ?? 0 }} Products
                  </a>
                </td>
                <td class="text-center fw-semibold text-muted">
                  {{ $cat->sort_order }}
                </td>
                <td class="text-center">
                  <form action="{{ route('admin.categories.toggle-status', $cat) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm border-0 {{ $cat->status ? 'text-success' : 'text-danger' }}" title="Click to toggle status">
                      @if($cat->status)
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-check-circle-fill me-1"></i>Active</span>
                      @else
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1"><i class="bi bi-x-circle-fill me-1"></i>Inactive</span>
                      @endif
                    </button>
                  </form>
                </td>
                <td class="text-end pe-4">
                  <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-outline-dark" title="Edit">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Are you sure? Deleting this category is only allowed if it has no products.')" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-outline-danger" title="Delete">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="10" class="text-center py-5 text-muted">
                  <i class="bi bi-grid fs-1 d-block mb-2 text-warning"></i>
                  No categories found. Click "Add Category" to create one.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
  </div>
</div>
@endsection