@extends('layouts.admin')

@section('title', 'Client Testimonials')
@section('page_title', 'Customer Reviews & Architect Testimonials')

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
    <div>
      <h5 class="mb-0 fw-bold"><i class="bi bi-chat-quote-fill me-2 text-warning"></i>Customer Reviews & Endorsements</h5>
      <small class="text-muted">Manage testimonials from interior designers, builders, and clients featured on the homepage.</small>
    </div>
    <div class="d-flex align-items-center gap-2">
      <button type="button" id="bulkDeleteBtn" class="btn btn-sm btn-danger d-none" onclick="submitBulkDelete('bulkForm')">
        <i class="bi bi-trash me-1"></i> Delete Selected (<span id="selectedCount">0</span>)
      </button>
      <button type="button" class="btn btn-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#createTestimonialModal">
        <i class="bi bi-plus-lg me-1"></i> Add Testimonial
      </button>
    </div>
  </div>

  <div class="card-body p-0">
    <form action="{{ route('admin.testimonials.bulk-delete') }}" method="POST" id="bulkForm">
      @csrf
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 40px;" class="text-center">
                <input type="checkbox" id="selectAll" class="form-check-input">
              </th>
              <th style="width: 50px;" class="text-center">#</th>
              <th style="width: 70px;">Photo</th>
              <th>Client Name & Designation</th>
              <th>Review</th>
              <th class="text-center" style="width: 120px;">Rating</th>
              <th class="text-center" style="width: 90px;">Order</th>
              <th class="text-center" style="width: 100px;">Status</th>
              <th class="text-end pe-4" style="width: 130px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($testimonials as $idx => $t)
              <tr>
                <td class="text-center">
                  <input type="checkbox" name="ids[]" value="{{ $t->id }}" class="form-check-input select-item">
                </td>
                <td class="text-center text-muted fw-bold">{{ $idx + 1 }}</td>
                <td>
                  <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center overflow-hidden" style="width: 44px; height: 44px;">
                    @if($t->photo)
                      <img src="{{ Str::startsWith($t->photo, '/images') ? asset($t->photo) : asset('storage/' . $t->photo) }}" alt="{{ $t->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                      <span class="fw-bold text-muted">{{ strtoupper(substr($t->name, 0, 1)) }}</span>
                    @endif
                  </div>
                </td>
                <td>
                  <span class="fw-bold text-dark">{{ $t->name }}</span>
                  @if($t->designation || $t->company)
                    <small class="text-muted d-block">{{ $t->designation }}{{ $t->designation && $t->company ? ' at ' : '' }}{{ $t->company }}</small>
                  @endif
                </td>
                <td>
                  <span class="text-muted small">"{{ Str::limit($t->review, 80) }}"</span>
                </td>
                <td class="text-center text-warning">
                  @for($i = 1; $i <= 5; $i++)
                    <i class="bi {{ $i <= $t->rating ? 'bi-star-fill' : 'bi-star' }} small"></i>
                  @endfor
                </td>
                <td class="text-center text-muted fw-semibold">{{ $t->sort_order }}</td>
                <td class="text-center">
                  <form action="{{ route('admin.testimonials.toggle-status', $t) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm border-0" title="Toggle visibility">
                      @if($t->status)
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Active</span>
                      @else
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Hidden</span>
                      @endif
                    </button>
                  </form>
                </td>
                <td class="text-end pe-4">
                  <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editModal{{ $t->id }}">
                      <i class="bi bi-pencil"></i>
                    </button>
                    <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" onsubmit="return confirm('Delete this review?')" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </div>

                  <!-- Edit Modal -->
                  <div class="modal fade text-start" id="editModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content border-0 shadow">
                        <form action="{{ route('admin.testimonials.update', $t) }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          @method('PUT')
                          <div class="modal-header border-bottom">
                            <h6 class="modal-title fw-bold">Edit Review from {{ $t->name }}</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body p-4">
                            <div class="row g-3">
                              <div class="col-md-6">
                                <label class="form-label fw-semibold">Client Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $t->name }}" required>
                              </div>
                              <div class="col-md-6">
                                <label class="form-label fw-semibold">Company / Firm</label>
                                <input type="text" name="company" class="form-control" value="{{ $t->company }}">
                              </div>
                              <div class="col-md-6">
                                <label class="form-label fw-semibold">Designation / Role</label>
                                <input type="text" name="designation" class="form-control" value="{{ $t->designation }}">
                              </div>
                              <div class="col-md-6">
                                <label class="form-label fw-semibold">Star Rating (1-5)</label>
                                <select name="rating" class="form-select">
                                  @for($r = 5; $r >= 1; $r--)
                                    <option value="{{ $r }}" {{ $t->rating == $r ? 'selected' : '' }}>{{ $r }} Stars</option>
                                  @endfor
                                </select>
                              </div>
                              <div class="col-12">
                                <label class="form-label fw-semibold">Testimonial Review <span class="text-danger">*</span></label>
                                <textarea name="review" class="form-control" rows="4" required>{{ $t->review }}</textarea>
                              </div>
                              <div class="col-md-6">
                                <label class="form-label fw-semibold">Client Photo</label>
                                <input type="file" name="photo" class="form-control" accept="image/*">
                              </div>
                              <div class="col-md-6">
                                <label class="form-label fw-semibold">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="{{ $t->sort_order }}">
                              </div>
                              <div class="col-12">
                                <div class="form-check form-switch">
                                  <input class="form-check-input" type="checkbox" name="status" value="1" id="tStat{{ $t->id }}" {{ $t->status ? 'checked' : '' }}>
                                  <label class="form-check-label" for="tStat{{ $t->id }}">Active & Displayed on Website</label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer border-top bg-light">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning text-dark fw-bold">Update Review</button>
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
                  <i class="bi bi-chat-quote fs-1 d-block mb-2 text-warning"></i>
                  No testimonials added yet.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </form>
  </div>
  </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createTestimonialModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow">
      <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header border-bottom">
          <h6 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2 text-warning"></i>Add Client Review</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Client Name <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" placeholder="e.g. Rajesh Mehta" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Company / Firm</label>
              <input type="text" name="company" class="form-control" placeholder="e.g. Mehta Architects">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Designation / Role</label>
              <input type="text" name="designation" class="form-control" placeholder="e.g. Principal Architect">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Star Rating (1-5)</label>
              <select name="rating" class="form-select">
                <option value="5" selected>5 Stars</option>
                <option value="4">4 Stars</option>
                <option value="3">3 Stars</option>
                <option value="2">2 Stars</option>
                <option value="1">1 Star</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Testimonial Review <span class="text-danger">*</span></label>
              <textarea name="review" class="form-control" rows="4" placeholder="Client comments on product quality, timely delivery, and service..." required></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Client Photo</label>
              <input type="file" name="photo" class="form-control" accept="image/*">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Sort Order</label>
              <input type="number" name="sort_order" class="form-control" value="0">
            </div>
            <div class="col-12">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="status" value="1" id="newTStat" checked>
                <label class="form-check-label" for="newTStat">Active & Displayed on Website</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer border-top bg-light">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning text-dark fw-bold">Save Testimonial</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection