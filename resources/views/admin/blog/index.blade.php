@extends('layouts.admin')

@section('title', 'Blog Articles')
@section('page_title', 'Hardware Knowledge Articles & Blog CMS')

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
    <div>
      <h5 class="mb-0 fw-bold"><i class="bi bi-journal-text me-2 text-warning"></i>Published Articles & Guides</h5>
      <small class="text-muted">Manage interior design guides, hardware maintenance articles, and architectural trends.</small>
    </div>
    <div class="d-flex gap-2 align-items-center">
      <button type="button" id="bulkDeleteBtn" class="btn btn-danger text-white btn-sm fw-bold d-none" onclick="submitBulkDelete()">
        <i class="bi bi-trash me-1"></i> Delete Selected (<span id="selectedCount">0</span>)
      </button>
      <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-outline-dark btn-sm">
        <i class="bi bi-tag me-1"></i> Manage Categories
      </a>
      <a href="{{ route('admin.blog.create') }}" class="btn btn-warning text-dark fw-bold btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Write New Article
      </a>
    </div>
  </div>

  <div class="card-body p-0">
    <form action="{{ route('admin.blog.bulk-delete') }}" method="POST" id="bulkForm" class="d-none">
      @csrf
    </form>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 40px;" class="text-center"><input type="checkbox" class="form-check-input" id="selectAll"></th>
              <th style="width: 50px;" class="text-center">#</th>
              <th style="width: 70px;">Cover</th>
              <th>Article Title</th>
              <th>Category</th>
              <th>Author</th>
              <th>Published</th>
              <th class="text-center" style="width: 100px;">Status</th>
              <th class="text-end pe-4" style="width: 130px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($posts as $idx => $post)
              <tr>
                <td class="text-center"><input type="checkbox" name="ids[]" value="{{ $post->id }}" class="form-check-input select-item"></td>
                <td class="text-center text-muted fw-bold">{{ $posts->firstItem() + $idx }}</td>
              <td>
                <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center overflow-hidden" style="width: 50px; height: 50px;">
                  @if($post->featured_image)
                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                  @else
                    <i class="bi bi-journal-text text-muted fs-4"></i>
                  @endif
                </div>
              </td>
              <td>
                <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="fw-bold text-dark text-decoration-none">
                  {{ $post->title }} <i class="bi bi-box-arrow-up-right small text-muted"></i>
                </a>
                <small class="text-muted d-block font-monospace">{{ $post->slug }}</small>
              </td>
              <td>
                <span class="badge bg-secondary bg-opacity-10 text-dark border">
                  {{ $post->category->name ?? 'Uncategorized' }}
                </span>
              </td>
              <td>
                <small class="text-muted"><i class="bi bi-person me-1"></i>{{ $post->author ?? 'Admin' }}</small>
              </td>
              <td>
                <small class="text-muted">{{ $post->published_at ? $post->published_at->format('d M, Y') : $post->created_at->format('d M, Y') }}</small>
              </td>
              <td class="text-center">
                @if($post->status)
                  <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Published</span>
                @else
                  <span class="badge bg-secondary-subtle text-muted border px-2 py-1">Draft</span>
                @endif
              </td>
              <td class="text-end pe-4">
                <div class="btn-group btn-group-sm">
                  <a href="{{ route('admin.blog.edit', $post) }}" class="btn btn-outline-dark" title="Edit">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" onsubmit="return confirm('Delete this blog post?')" class="d-inline">
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
                <i class="bi bi-journal-x fs-1 d-block mb-2 text-warning"></i>
                No blog articles published yet.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if($posts->hasPages())
    <div class="card-footer bg-white border-top py-3">
      {{ $posts->links() }}
    </div>
  @endif
</div>
@endsection