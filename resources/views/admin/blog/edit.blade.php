@extends('layouts.admin')

@section('title', 'Edit Article — ' . $blog->title)
@section('page_title', 'Edit Blog Post: ' . $blog->title)

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-9">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Article</h5>
          <small class="text-muted">Published: {{ $blog->published_at ? $blog->published_at->format('d M, Y') : $blog->created_at->format('d M, Y') }}</small>
        </div>
        <div class="d-flex gap-2">
          <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-box-arrow-up-right me-1"></i> Preview
          </a>
          <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-dark btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Articles
          </a>
        </div>
      </div>

      <div class="card-body p-4">
        <form action="{{ route('admin.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row g-3 mb-4">
            <div class="col-md-8">
              <label class="form-label fw-semibold">Article Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Blog Category <span class="text-danger">*</span></label>
              <select name="category_id" class="form-select" required>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" {{ old('category_id', $blog->category_id) == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Author Name</label>
              <input type="text" name="author" class="form-control" value="{{ old('author', $blog->author) }}">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Featured Cover Image</label>
              @if($blog->featured_image)
                <div class="mb-2 p-2 bg-light border rounded d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center gap-2">
                    <img src="{{ $blog->featured_image_url }}" alt="Preview" style="height: 50px; width: 50px; object-fit: cover; border-radius: 6px;" class="border">
                    <div>
                      <small class="text-dark fw-semibold d-block">Current Cover</small>
                      <small class="text-muted">{{ Str::limit(basename($blog->featured_image), 25) }}</small>
                    </div>
                  </div>
                  <div class="form-check form-check-inline m-0">
                    <input class="form-check-input" type="checkbox" name="remove_image" id="removeImage" value="1">
                    <label class="form-check-label text-danger small fw-semibold" for="removeImage">Remove</label>
                  </div>
                </div>
              @endif
              <input type="file" name="featured_image" id="editImageInput" class="form-control" accept="image/*" onchange="previewEditImage(this)">
              <div id="newImagePreviewContainer" class="mt-2" style="display: none;">
                <img id="newImagePreview" src="" alt="New Preview" style="height: 60px; width: 60px; object-fit: cover; border-radius: 6px;" class="border shadow-sm">
                <small class="text-success d-block mt-1 fw-semibold">New image ready to upload</small>
              </div>
              <small class="text-muted">Leave empty to keep current image</small>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Excerpt / Summary</label>
              <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $blog->excerpt) }}</textarea>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Article Body Content <span class="text-danger">*</span></label>
              <textarea name="content" class="form-control font-monospace" rows="12" required>{{ old('content', $blog->content) }}</textarea>
            </div>
          </div>

          <!-- SEO Settings -->
          <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-google me-2 text-warning"></i>SEO Meta Settings</h6>
          <div class="row g-3 mb-4">
            <div class="col-12">
              <label class="form-label fw-semibold">SEO Meta Title</label>
              <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title', $blog->seo_title) }}">
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">SEO Meta Description</label>
              <textarea name="seo_description" class="form-control" rows="2">{{ old('seo_description', $blog->seo_description) }}</textarea>
            </div>
            <div class="col-12">
              <div class="form-check form-switch pt-2">
                <input class="form-check-input" type="checkbox" name="status" value="1" id="postStatus" {{ $blog->status ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="postStatus">Published on website</label>
              </div>
            </div>
          </div>

          <hr class="my-4">

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.blog.index') }}" class="btn btn-light px-4">Cancel</a>
            <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
              <i class="bi bi-check-lg me-1"></i> Update Article
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function previewEditImage(input) {
  const container = document.getElementById('newImagePreviewContainer');
  const preview = document.getElementById('newImagePreview');
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
      container.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    container.style.display = 'none';
  }
}
</script>
@endpush

@endsection