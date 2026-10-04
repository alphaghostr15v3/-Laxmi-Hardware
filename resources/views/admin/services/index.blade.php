@extends('layouts.admin')

@section('title', 'Services Management')
@section('page_title', 'Interior & Hardware Services')

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
    <div>
      <h5 class="mb-0 fw-bold"><i class="bi bi-gear-fill me-2 text-warning"></i>Hardware Services & Consultation</h5>
      <small class="text-muted">Manage turnkey hardware consultation, custom wardrobe fittings, and installation support.</small>
    </div>
    <div class="d-flex align-items-center gap-2">
      <button type="button" id="bulkDeleteBtn" class="btn btn-danger text-white btn-sm fw-bold d-none" onclick="submitBulkDelete()">
        <i class="bi bi-trash me-1"></i> Delete Selected (<span id="selectedCount">0</span>)
      </button>
      <a href="{{ route('admin.services.create') }}" class="btn btn-warning text-dark fw-bold">
        <i class="bi bi-plus-lg me-1"></i> Add Service
      </a>
    </div>
  </div>

  <div class="card-body p-0">
    <form action="{{ route('admin.services.bulk-delete') }}" method="POST" id="bulkForm" class="d-none">
      @csrf
    </form>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 40px;" class="text-center"><input type="checkbox" class="form-check-input" id="selectAll"></th>
              <th style="width: 60px;" class="text-center">#</th>
              <th style="width: 80px;">Icon / Image</th>
              <th>Service Title</th>
              <th>Summary</th>
              <th class="text-center" style="width: 100px;">Sort Order</th>
              <th class="text-center" style="width: 100px;">Status</th>
              <th class="text-end pe-4" style="width: 130px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($services as $idx => $srv)
              <tr>
                <td class="text-center"><input type="checkbox" name="ids[]" value="{{ $srv->id }}" class="form-check-input select-item"></td>
                <td class="text-center text-muted fw-bold">{{ $idx + 1 }}</td>
                <td>
                  <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center overflow-hidden" style="width: 48px; height: 48px;">
                    @if($srv->image)
                      <img src="{{ image_url($srv->image) }}" alt="{{ $srv->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                    <i class="bi {{ $srv->icon ?? 'bi-gear' }} fs-4 text-warning"></i>
                  @endif
                </div>
              </td>
              <td>
                <span class="fw-bold text-dark">{{ $srv->title }}</span>
                <small class="text-muted d-block font-monospace">{{ $srv->slug }}</small>
              </td>
              <td>
                <span class="text-muted small">{{ Str::limit($srv->short_description ?? 'No summary provided', 70) }}</span>
              </td>
              <td class="text-center text-muted fw-semibold">{{ $srv->sort_order }}</td>
              <td class="text-center">
                @if($srv->status)
                  <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Active</span>
                @else
                  <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Inactive</span>
                @endif
              </td>
              <td class="text-end pe-4">
                <div class="btn-group btn-group-sm">
                  <a href="{{ route('admin.services.edit', $srv) }}" class="btn btn-outline-dark" title="Edit">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.services.destroy', $srv) }}" method="POST" onsubmit="return confirm('Delete this service?')" class="d-inline">
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
              <td colspan="8" class="text-center py-5 text-muted">
                <i class="bi bi-gear fs-1 d-block mb-2 text-warning"></i>
                No services created yet.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection