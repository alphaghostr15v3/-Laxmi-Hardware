@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'Overview Dashboard')

@section('content')

  <!-- TOP METRIC CARDS -->
  <div class="row g-4 mb-4">
    <!-- Products -->
    <div class="col-sm-6 col-xl-3">
      <div class="card p-4 border-0 shadow-sm bg-white h-100">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <span class="text-muted small fw-bold text-uppercase">Total Products</span>
            <h3 class="fw-bold mb-0 text-dark mt-1">{{ $stats['total_products'] }}</h3>
          </div>
          <div class="rounded-3 bg-warning bg-opacity-10 text-warning p-3 fs-4">
            <i class="bi bi-box-seam"></i>
          </div>
        </div>
        <a href="{{ route('admin.products.index') }}" class="small text-warning text-decoration-none fw-semibold">
          Manage Catalogue <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>

    <!-- Quote Requests -->
    <div class="col-sm-6 col-xl-3">
      <div class="card p-4 border-0 shadow-sm bg-white h-100">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <span class="text-muted small fw-bold text-uppercase">Quote Requests</span>
            <h3 class="fw-bold mb-0 text-dark mt-1">
              {{ $stats['total_quotes'] }}
              @if($stats['new_quotes'] > 0)
                <span class="badge bg-warning text-dark fs-6 ms-1">{{ $stats['new_quotes'] }} New</span>
              @endif
            </h3>
          </div>
          <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-3 fs-4">
            <i class="bi bi-file-earmark-text"></i>
          </div>
        </div>
        <a href="{{ route('admin.quotes.index') }}" class="small text-primary text-decoration-none fw-semibold">
          View Quotations <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>

    <!-- Enquiries -->
    <div class="col-sm-6 col-xl-3">
      <div class="card p-4 border-0 shadow-sm bg-white h-100">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <span class="text-muted small fw-bold text-uppercase">Contact Enquiries</span>
            <h3 class="fw-bold mb-0 text-dark mt-1">
              {{ $stats['total_enquiries'] }}
              @if($stats['new_enquiries'] > 0)
                <span class="badge bg-danger fs-6 ms-1">{{ $stats['new_enquiries'] }} New</span>
              @endif
            </h3>
          </div>
          <div class="rounded-3 bg-danger bg-opacity-10 text-danger p-3 fs-4">
            <i class="bi bi-envelope"></i>
          </div>
        </div>
        <a href="{{ route('admin.enquiries.index') }}" class="small text-danger text-decoration-none fw-semibold">
          Review Enquiries <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>

    <!-- Categories & Brands -->
    <div class="col-sm-6 col-xl-3">
      <div class="card p-4 border-0 shadow-sm bg-white h-100">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div>
            <span class="text-muted small fw-bold text-uppercase">Categories / Brands</span>
            <h3 class="fw-bold mb-0 text-dark mt-1">{{ $stats['total_categories'] }} / {{ $stats['total_brands'] }}</h3>
          </div>
          <div class="rounded-3 bg-success bg-opacity-10 text-success p-3 fs-4">
            <i class="bi bi-grid"></i>
          </div>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="small text-success text-decoration-none fw-semibold">
          View Divisions <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>

  <!-- SECONDARY STATS ROW -->
  <div class="row g-4 mb-4">
    <div class="col-6 col-md-3">
      <div class="card p-3 border-0 shadow-sm bg-white text-center">
        <div class="text-muted small">Services</div>
        <div class="fw-bold fs-4 text-dark">{{ $stats['total_services'] }}</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card p-3 border-0 shadow-sm bg-white text-center">
        <div class="text-muted small">Projects</div>
        <div class="fw-bold fs-4 text-dark">{{ $stats['total_projects'] }}</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card p-3 border-0 shadow-sm bg-white text-center">
        <div class="text-muted small">Gallery Photos</div>
        <div class="fw-bold fs-4 text-dark">{{ $stats['total_gallery'] }}</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card p-3 border-0 shadow-sm bg-white text-center">
        <div class="text-muted small">Blog Guides</div>
        <div class="fw-bold fs-4 text-dark">{{ $stats['total_blog_posts'] }}</div>
      </div>
    </div>
  </div>

  <!-- TABLES: RECENT QUOTES & RECENT ENQUIRIES -->
  <div class="row g-4 mb-4">
    <!-- Recent Quote Requests -->
    <div class="col-lg-7">
      <div class="card border-0 shadow-sm bg-white h-100">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
          <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-text text-warning me-2"></i> Recent Project Quote Requests</h5>
          <a href="{{ route('admin.quotes.index') }}" class="btn btn-sm btn-outline-dark">View All</a>
        </div>
        <div class="card-body p-0">
          @if($recentQuotes->count() > 0)
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                  <tr>
                    <th>Customer / Firm</th>
                    <th>Project / Category</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($recentQuotes as $rq)
                    <tr>
                      <td>
                        <div class="fw-bold">{{ $rq->name }}</div>
                        <small class="text-muted">{{ $rq->phone }}</small>
                      </td>
                      <td>
                        <div class="small fw-semibold">{{ $rq->project_type ?? 'Standard' }}</div>
                        <small class="text-muted">{{ $rq->product_category ?? '-' }}</small>
                      </td>
                      <td class="small text-muted">{{ $rq->created_at->format('M d, H:i') }}</td>
                      <td>
                        @php
                          $badgeClass = match($rq->status) {
                            'New' => 'bg-warning text-dark',
                            'Contacted' => 'bg-info text-dark',
                            'Quotation Sent' => 'bg-primary text-white',
                            'Converted' => 'bg-success text-white',
                            default => 'bg-secondary text-white'
                          };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $rq->status }}</span>
                      </td>
                      <td>
                        <a href="{{ route('admin.quotes.show', $rq->id) }}" class="btn btn-sm btn-light border" title="View Quote">
                          <i class="bi bi-eye"></i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="p-4 text-center text-muted small">No quotation requests received yet.</div>
          @endif
        </div>
      </div>
    </div>

    <!-- Recent Enquiries -->
    <div class="col-lg-5">
      <div class="card border-0 shadow-sm bg-white h-100">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
          <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-envelope text-danger me-2"></i> Recent Contact Enquiries</h5>
          <a href="{{ route('admin.enquiries.index') }}" class="btn btn-sm btn-outline-dark">View All</a>
        </div>
        <div class="card-body p-0">
          @if($recentEnquiries->count() > 0)
            <div class="list-group list-group-flush">
              @foreach($recentEnquiries as $enq)
                <a href="{{ route('admin.enquiries.show', $enq->id) }}" class="list-group-item list-group-item-action p-3">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <strong class="text-dark">{{ $enq->name }}</strong>
                    <span class="badge {{ $enq->status == 'New' ? 'bg-danger' : 'bg-light text-muted border' }}">{{ $enq->status }}</span>
                  </div>
                  <div class="text-muted small text-truncate mb-1">{{ $enq->subject }}</div>
                  <div class="text-muted" style="font-size: 0.72rem;">{{ $enq->created_at->diffForHumans() }} • {{ $enq->phone }}</div>
                </a>
              @endforeach
            </div>
          @else
            <div class="p-4 text-center text-muted small">No contact inquiries received yet.</div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- CATEGORY BREAKDOWN -->
  <div class="card border-0 shadow-sm bg-white">
    <div class="card-header bg-white py-3 border-bottom">
      <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pie-chart text-success me-2"></i> Product Distribution Across Key Categories</h5>
    </div>
    <div class="card-body p-4">
      <div class="row g-3">
        @foreach($categoryStats as $cs)
          <div class="col-md-4 col-sm-6">
            <div class="p-3 border rounded-3 bg-light d-flex justify-content-between align-items-center">
              <div>
                <h6 class="fw-bold mb-0 text-dark">{{ $cs->name }}</h6>
                <small class="text-muted">{{ $cs->products_count }} active products</small>
              </div>
              <span class="badge bg-dark text-warning fs-6">{{ $cs->products_count }}</span>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

@endsection
