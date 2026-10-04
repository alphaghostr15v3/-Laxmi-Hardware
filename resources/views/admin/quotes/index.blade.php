@extends('layouts.admin')

@section('title', 'Quote Requests')
@section('page_title', 'BOQ & Hardware Quotation Requests')

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-bottom py-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
      <div>
        <h5 class="mb-0 fw-bold"><i class="bi bi-file-earmark-text-fill me-2 text-warning"></i>Project Quotation Requests</h5>
        <small class="text-muted">High-intent project leads and BOQ spreadsheet submissions from contractors, architects, and homeowners.</small>
      </div>

      <!-- Filters -->
      <div class="d-flex align-items-center gap-2">
        <button type="button" id="bulkDeleteBtn" class="btn btn-sm btn-danger d-none" onclick="submitBulkDelete('bulkForm')">
          <i class="bi bi-trash me-1"></i> Delete Selected (<span id="selectedCount">0</span>)
        </button>
        <form action="{{ route('admin.quotes.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
          <div class="input-group input-group-sm" style="width: 220px;">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" name="search" class="form-control" placeholder="Search client / company..." value="{{ request('search') }}">
          </div>
          <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 150px;">
            <option value="">All Statuses</option>
            <option value="New" {{ request('status') === 'New' ? 'selected' : '' }}>New</option>
            <option value="Contacted" {{ request('status') === 'Contacted' ? 'selected' : '' }}>Contacted</option>
            <option value="Quotation Sent" {{ request('status') === 'Quotation Sent' ? 'selected' : '' }}>Quotation Sent</option>
            <option value="Converted" {{ request('status') === 'Converted' ? 'selected' : '' }}>Converted</option>
            <option value="Closed" {{ request('status') === 'Closed' ? 'selected' : '' }}>Closed</option>
          </select>
          @if(request()->anyFilled(['search', 'status', 'project_type']))
            <a href="{{ route('admin.quotes.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
          @endif
        </form>
      </div>
    </div>
  </div>

  <div class="card-body p-0">
    <form action="{{ route('admin.quotes.bulk-delete') }}" method="POST" id="bulkForm" class="d-none">
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
              <th>Client & Company</th>
              <th>Project Type & Category</th>
              <th style="min-width: 200px; max-width: 280px;">Message & Requirements</th>
              <th>Location</th>
              <th class="text-center" style="width: 90px;">BOQ File</th>
              <th>Date</th>
              <th class="text-center" style="width: 130px;">Status</th>
              <th class="text-end pe-4" style="width: 120px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($quotes as $idx => $quote)
              <tr class="{{ $quote->status === 'New' ? 'table-warning bg-opacity-25' : '' }}">
                <td class="text-center">
                  <input type="checkbox" name="ids[]" value="{{ $quote->id }}" class="form-check-input select-item">
                </td>
                <td class="text-center text-muted fw-bold">{{ $quotes->firstItem() + $idx }}</td>
                <td>
                  <span class="fw-bold text-dark">{{ $quote->name }}</span>
                  @if($quote->company)
                    <small class="text-muted d-block"><i class="bi bi-building me-1"></i>{{ $quote->company }}</small>
                  @endif
                  <small class="text-muted d-block"><i class="bi bi-telephone me-1"></i>{{ $quote->phone }}</small>
                </td>
                <td>
                  <span class="badge bg-secondary bg-opacity-10 text-dark border">{{ $quote->project_type ?? 'General' }}</span>
                  @if($quote->product_category)
                    <small class="text-muted d-block mt-1">{{ $quote->product_category }}</small>
                  @endif
                </td>
                <td style="max-width: 280px;">
                  @if($quote->requirement)
                    <div class="fw-semibold text-dark small text-truncate mb-1" title="{{ $quote->requirement }}">
                      <i class="bi bi-tag-fill text-warning me-1"></i>{{ $quote->requirement }}
                    </div>
                  @endif
                  @if($quote->message)
                    <div class="text-muted small text-truncate" title="{{ $quote->message }}" style="max-width: 260px;">
                      <i class="bi bi-chat-left-text text-secondary me-1"></i>{{ $quote->message }}
                    </div>
                    @if(strlen($quote->message) > 40)
                      <a href="javascript:void(0)" class="small text-decoration-none text-warning fw-semibold mt-1 d-inline-block" data-bs-toggle="modal" data-bs-target="#msgModal{{ $quote->id }}">
                        Read full &raquo;
                      </a>
                    @endif
                  @endif
                  @if(!$quote->requirement && !$quote->message)
                    <span class="text-muted small">—</span>
                  @endif
                </td>
                <td>
                  <span class="text-muted small"><i class="bi bi-geo-alt text-danger me-1"></i>{{ $quote->location ?? 'Surat' }}</span>
                </td>
                <td class="text-center">
                  @if($quote->attachment_path)
                    <a href="{{ asset('storage/' . $quote->attachment_path) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2" title="Download Attached File">
                      <i class="bi bi-paperclip"></i> File
                    </a>
                  @else
                    <span class="text-muted small">—</span>
                  @endif
                </td>
                <td>
                  <small class="text-muted">{{ $quote->created_at->format('d M, Y') }}</small>
                </td>
                <td class="text-center">
                  @switch($quote->status)
                    @case('New')
                      <span class="badge bg-danger">New</span>
                      @break
                    @case('Contacted')
                      <span class="badge bg-info text-dark">Contacted</span>
                      @break
                    @case('Quotation Sent')
                      <span class="badge bg-primary">Quotation Sent</span>
                      @break
                    @case('Converted')
                      <span class="badge bg-success">Converted</span>
                      @break
                    @case('Closed')
                      <span class="badge bg-secondary">Closed</span>
                      @break
                    @default
                      <span class="badge bg-light text-dark">{{ $quote->status }}</span>
                  @endswitch
                </td>
                <td class="text-end pe-4">
                  <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.quotes.show', $quote) }}" class="btn btn-outline-dark" title="Review Quote">
                      <i class="bi bi-eye"></i>
                    </a>
                    <form action="{{ route('admin.quotes.destroy', $quote) }}" method="POST" onsubmit="return confirm('Delete this quote request?')" class="d-inline">
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
                  <i class="bi bi-file-earmark-x fs-1 d-block mb-2 text-warning"></i>
                  No quotation requests received yet.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
  </div>

  @if($quotes->hasPages())
    <div class="card-footer bg-white border-top py-3">
      {{ $quotes->links() }}
    </div>
  @endif
</div>

{{-- Message Detail Modals --}}
@foreach($quotes as $quote)
  @if($quote->message)
    <div class="modal fade" id="msgModal{{ $quote->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
          <div class="modal-header bg-light">
            <h6 class="modal-title fw-bold mb-0">
              <i class="bi bi-chat-left-quote-fill text-warning me-2"></i>Quote Message & Scope
            </h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4">
            <div class="d-flex justify-content-between align-items-start pb-3 mb-3 border-bottom">
              <div>
                <strong class="text-dark fs-6">{{ $quote->name }}</strong>
                @if($quote->company)
                  <div class="text-muted small"><i class="bi bi-building me-1"></i>{{ $quote->company }}</div>
                @endif
                <div class="text-muted small"><i class="bi bi-telephone me-1"></i>{{ $quote->phone }} &bull; {{ $quote->email }}</div>
              </div>
              <span class="badge bg-warning text-dark">{{ $quote->status }}</span>
            </div>

            @if($quote->requirement)
              <div class="mb-3 p-3 bg-light rounded border">
                <small class="text-muted fw-bold text-uppercase d-block mb-1">Hardware / Product Requirement</small>
                <div class="text-dark fw-semibold">{{ $quote->requirement }}</div>
              </div>
            @endif

            <div class="mb-2">
              <small class="text-muted fw-bold text-uppercase d-block mb-1">Client Specifications</small>
              <div class="p-3 bg-light rounded border text-dark" style="white-space: pre-wrap; line-height: 1.6;">{{ $quote->message }}</div>
            </div>
          </div>
          <div class="modal-footer bg-light d-flex justify-content-between">
            <a href="{{ route('admin.quotes.show', $quote) }}" class="btn btn-sm btn-warning text-dark fw-bold">
              <i class="bi bi-eye me-1"></i> Open Full Details
            </a>
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  @endif
@endforeach

@endsection