@extends('layouts.admin')

@section('title', 'Customer Enquiries')
@section('page_title', 'Contact Enquiries & Product Questions')

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-bottom py-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
      <div>
        <h5 class="mb-0 fw-bold"><i class="bi bi-envelope-fill me-2 text-warning"></i>Customer Inquiries</h5>
        <small class="text-muted">Messages received from contact forms and product detail enquiry popups.</small>
      </div>

      <!-- Filters -->
      <div class="d-flex align-items-center gap-2">
        <button type="button" id="bulkDeleteBtn" class="btn btn-sm btn-danger d-none" onclick="submitBulkDelete('bulkForm')">
          <i class="bi bi-trash me-1"></i> Delete Selected (<span id="selectedCount">0</span>)
        </button>
        <form action="{{ route('admin.enquiries.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
          <div class="input-group input-group-sm" style="width: 220px;">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" name="search" class="form-control" placeholder="Search name/email/phone..." value="{{ request('search') }}">
          </div>
          <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 140px;">
            <option value="">All Statuses</option>
            <option value="New" {{ request('status') === 'New' ? 'selected' : '' }}>New</option>
            <option value="Read" {{ request('status') === 'Read' ? 'selected' : '' }}>Read</option>
            <option value="Contacted" {{ request('status') === 'Contacted' ? 'selected' : '' }}>Contacted</option>
            <option value="Closed" {{ request('status') === 'Closed' ? 'selected' : '' }}>Closed</option>
          </select>
          @if(request()->anyFilled(['search', 'status']))
            <a href="{{ route('admin.enquiries.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
          @endif
        </form>
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <form action="{{ route('admin.enquiries.bulk-delete') }}" method="POST" id="bulkForm" class="d-none">
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
              <th>Customer Name</th>
              <th>Contact Details</th>
              <th>Subject / Product</th>
              <th>Date</th>
              <th class="text-center" style="width: 110px;">Status</th>
              <th class="text-end pe-4" style="width: 120px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($enquiries as $idx => $enq)
              <tr class="{{ $enq->status === 'New' ? 'table-warning bg-opacity-25' : '' }}">
                <td class="text-center">
                  <input type="checkbox" name="ids[]" value="{{ $enq->id }}" class="form-check-input select-item">
                </td>
                <td class="text-center text-muted fw-bold">{{ $enquiries->firstItem() + $idx }}</td>
                <td>
                  <span class="fw-bold text-dark">{{ $enq->name }}</span>
                  @if($enq->status === 'New')
                    <span class="badge bg-danger ms-1" style="font-size: 0.65rem;">NEW</span>
                  @endif
                </td>
                <td>
                  <div class="small">
                    <div><i class="bi bi-telephone text-muted me-1"></i><a href="tel:{{ $enq->phone }}" class="text-decoration-none text-dark">{{ $enq->phone }}</a></div>
                    <div><i class="bi bi-envelope text-muted me-1"></i><a href="mailto:{{ $enq->email }}" class="text-decoration-none text-muted">{{ $enq->email }}</a></div>
                  </div>
                </td>
                <td>
                  <span class="fw-semibold text-dark">{{ Str::limit($enq->subject, 40) }}</span>
                  <small class="text-muted d-block">{{ Str::limit($enq->message, 50) }}</small>
                </td>
                <td>
                  <small class="text-muted">{{ $enq->created_at->format('d M, Y h:i A') }}</small>
                </td>
                <td class="text-center">
                  @switch($enq->status)
                    @case('New')
                      <span class="badge bg-danger">New</span>
                      @break
                    @case('Read')
                      <span class="badge bg-primary">Read</span>
                      @break
                    @case('Contacted')
                      <span class="badge bg-info text-dark">Contacted</span>
                      @break
                    @case('Closed')
                      <span class="badge bg-secondary">Closed</span>
                      @break
                    @default
                      <span class="badge bg-light text-dark">{{ $enq->status }}</span>
                  @endswitch
                </td>
                <td class="text-end pe-4">
                  <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.enquiries.show', $enq) }}" class="btn btn-outline-dark" title="View Details">
                      <i class="bi bi-eye"></i>
                    </a>
                    <form action="{{ route('admin.enquiries.destroy', $enq) }}" method="POST" onsubmit="return confirm('Delete this enquiry?')" class="d-inline">
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
                  <i class="bi bi-envelope-open fs-1 d-block mb-2 text-warning"></i>
                  No customer enquiries found.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
  </div>

  @if($enquiries->hasPages())
    <div class="card-footer bg-white border-top py-3">
      {{ $enquiries->links() }}
    </div>
  @endif
</div>
@endsection