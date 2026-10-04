@extends('layouts.admin')

@section('title', 'Projects Showcase')
@section('page_title', 'Completed Hardware & Interior Projects')

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
    <div>
      <h5 class="mb-0 fw-bold"><i class="bi bi-buildings-fill me-2 text-warning"></i>Project Portfolios</h5>
      <small class="text-muted">Showcase completed modular kitchen, villa, architectural hardware, and plumbing installations.</small>
    </div>
    <div class="d-flex align-items-center gap-2">
      <button type="button" id="bulkDeleteBtn" class="btn btn-danger text-white btn-sm fw-bold d-none" onclick="submitBulkDelete()">
        <i class="bi bi-trash me-1"></i> Delete Selected (<span id="selectedCount">0</span>)
      </button>
      <a href="{{ route('admin.projects.create') }}" class="btn btn-warning text-dark fw-bold">
        <i class="bi bi-plus-lg me-1"></i> Add Project
      </a>
    </div>
  </div>

  <div class="card-body p-0">
    <form action="{{ route('admin.projects.bulk-delete') }}" method="POST" id="bulkForm" class="d-none">
      @csrf
    </form>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 40px;" class="text-center"><input type="checkbox" class="form-check-input" id="selectAll"></th>
              <th style="width: 60px;" class="text-center">#</th>
              <th style="width: 80px;">Cover</th>
              <th>Project Title</th>
              <th>Category</th>
              <th>Location & Client</th>
              <th class="text-center">Gallery</th>
              <th class="text-center" style="width: 100px;">Status</th>
              <th class="text-end pe-4" style="width: 130px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($projects as $idx => $proj)
              <tr>
                <td class="text-center"><input type="checkbox" name="ids[]" value="{{ $proj->id }}" class="form-check-input select-item"></td>
                <td class="text-center text-muted fw-bold">{{ $projects->firstItem() + $idx }}</td>
                <td>
                  <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center overflow-hidden" style="width: 54px; height: 54px;">
                    @if($proj->featured_image)
                      <img src="{{ image_url($proj->featured_image) }}" alt="{{ $proj->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                    <i class="bi bi-image text-muted fs-4"></i>
                  @endif
                </div>
              </td>
              <td>
                <a href="{{ route('projects.show', $proj->slug) }}" target="_blank" class="fw-bold text-dark text-decoration-none">
                  {{ $proj->title }} <i class="bi bi-box-arrow-up-right small text-muted"></i>
                </a>
                <small class="text-muted d-block font-monospace">{{ $proj->slug }}</small>
              </td>
              <td>
                <span class="badge bg-secondary bg-opacity-10 text-dark border">
                  {{ $proj->category }}
                </span>
              </td>
              <td>
                <div class="small">
                  @if($proj->location)
                    <span class="text-dark"><i class="bi bi-geo-alt text-danger me-1"></i>{{ $proj->location }}</span>
                  @endif
                  @if($proj->client_type)
                    <small class="text-muted d-block">{{ $proj->client_type }}</small>
                  @endif
                </div>
              </td>
              <td class="text-center">
                <span class="badge bg-warning bg-opacity-20 text-dark px-2 py-1">
                  <i class="bi bi-images me-1"></i> {{ $proj->images_count ?? 0 }} photos
                </span>
              </td>
              <td class="text-center">
                @if($proj->status)
                  <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Active</span>
                @else
                  <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Inactive</span>
                @endif
              </td>
              <td class="text-end pe-4">
                <div class="btn-group btn-group-sm">
                  <a href="{{ route('admin.projects.edit', $proj) }}" class="btn btn-outline-dark" title="Edit">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.projects.destroy', $proj) }}" method="POST" onsubmit="return confirm('Delete this project?')" class="d-inline">
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
                <i class="bi bi-buildings fs-1 d-block mb-2 text-warning"></i>
                No projects showcased yet.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if($projects->hasPages())
    <div class="card-footer bg-white border-top py-3">
      {{ $projects->links() }}
    </div>
  @endif
</div>
@endsection