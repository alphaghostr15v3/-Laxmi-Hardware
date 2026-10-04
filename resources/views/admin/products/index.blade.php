@extends('layouts.admin')

@section('title', 'Products Catalogue')
@section('page_title', 'Hardware Products Catalogue')

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-bottom py-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
      <div>
        <h5 class="mb-0 fw-bold"><i class="bi bi-box-seam me-2 text-warning"></i>Products Master Catalogue</h5>
        <small class="text-muted">Manage items, technical specifications, gallery photos, and visibility.</small>
      </div>
      <div class="d-flex align-items-center gap-2">
        <button type="button" id="bulkDeleteBtn" class="btn btn-danger text-white fw-bold d-none" onclick="submitBulkDelete()">
          <i class="bi bi-trash me-1"></i> Delete Selected (<span id="selectedCount">0</span>)
        </button>
        <a href="{{ route('admin.products.create') }}" class="btn btn-warning text-dark fw-bold">
          <i class="bi bi-plus-lg me-1"></i> Add New Product
        </a>
      </div>
    </div>

    <!-- Filter Bar -->
    <form action="{{ route('admin.products.index') }}" method="GET" class="row g-2 mt-2 pt-2 border-top">
      <div class="col-md-4">
        <div class="input-group input-group-sm">
          <span class="input-group-text"><i class="bi bi-search"></i></span>
          <input type="text" name="search" class="form-control" placeholder="Search by Product Name or SKU..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-md-3">
        <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">All Categories</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
              {{ $cat->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <select name="brand" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">All Brands</option>
          @foreach($brands as $b)
            <option value="{{ $b->id }}" {{ request('brand') == $b->id ? 'selected' : '' }}>
              {{ $b->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">All Statuses</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
        </select>
      </div>
      <div class="col-md-1 d-flex gap-1">
        <button type="submit" class="btn btn-sm btn-dark w-100">Filter</button>
        @if(request()->anyFilled(['search', 'category', 'brand', 'status']))
          <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset Filters"><i class="bi bi-x"></i></a>
        @endif
      </div>
    </form>
  </div>

  <div class="card-body p-0">
    <form action="{{ route('admin.products.bulk-delete') }}" method="POST" id="bulkForm" class="d-none">
      @csrf
    </form>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 40px;" class="text-center"><input type="checkbox" class="form-check-input" id="selectAll"></th>
              <th style="width: 40px;" class="text-center">#</th>
              <th style="width: 70px;">Image</th>
              <th>Product Name & SKU</th>
              <th>Category & Subcategory</th>
              <th>Brand</th>
              <th class="text-center" style="width: 100px;">Featured</th>
              <th class="text-center" style="width: 100px;">Status</th>
              <th class="text-end pe-4" style="width: 140px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products as $idx => $prod)
              <tr>
                <td class="text-center"><input type="checkbox" name="ids[]" value="{{ $prod->id }}" class="form-check-input select-item"></td>
                <td class="text-center text-muted fw-bold">{{ $products->firstItem() + $idx }}</td>
              <td>
                <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center overflow-hidden" style="width: 52px; height: 52px;">
                  @if($prod->main_image)
                    <img src="{{ $prod->main_image_url }}" alt="{{ $prod->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                  @else
                    <i class="bi bi-box text-muted fs-4"></i>
                  @endif
                </div>
              </td>
              <td>
                <a href="{{ route('products.show', $prod->slug) }}" target="_blank" class="fw-bold text-dark text-decoration-none">
                  {{ $prod->name }} <i class="bi bi-box-arrow-up-right small text-muted"></i>
                </a>
                <div class="d-flex align-items-center gap-2 mt-1">
                  <span class="badge bg-light text-dark border font-monospace">SKU: {{ $prod->sku }}</span>
                </div>
              </td>
              <td>
                <div>
                  <span class="fw-semibold text-dark">{{ $prod->category->name ?? 'Unassigned' }}</span>
                  @if($prod->subcategory)
                    <small class="text-muted d-block"><i class="bi bi-arrow-return-right"></i> {{ $prod->subcategory->name }}</small>
                  @endif
                </div>
              </td>
              <td>
                @if($prod->brand)
                  <span class="badge bg-secondary bg-opacity-10 text-dark border">
                    {{ $prod->brand->name }}
                  </span>
                @else
                  <span class="text-muted small">—</span>
                @endif
              </td>
              <td class="text-center">
                <form action="{{ route('admin.products.toggle-featured', $prod) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-sm border-0" title="Toggle Featured">
                    @if($prod->featured)
                      <span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i>Featured</span>
                    @else
                      <span class="badge bg-light text-muted border">Standard</span>
                    @endif
                  </button>
                </form>
              </td>
              <td class="text-center">
                <form action="{{ route('admin.products.toggle-status', $prod) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-sm border-0" title="Toggle Visibility">
                    @if($prod->status)
                      <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Active</span>
                    @else
                      <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Inactive</span>
                    @endif
                  </button>
                </form>
              </td>
              <td class="text-end pe-4">
                <div class="btn-group btn-group-sm">
                  <a href="{{ route('admin.products.edit', $prod) }}" class="btn btn-outline-dark" title="Edit">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.products.destroy', $prod) }}" method="POST" onsubmit="return confirm('Delete this product permanently?')" class="d-inline">
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
              <td colspan="9" class="text-center py-5 text-muted">
                <i class="bi bi-box-seam fs-1 d-block mb-2 text-warning"></i>
                No products found matching your search.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if($products->hasPages())
    <div class="card-footer bg-white border-top py-3">
      {{ $products->links() }}
    </div>
  @endif
</div>
@endsection