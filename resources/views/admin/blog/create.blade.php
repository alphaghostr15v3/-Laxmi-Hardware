@extends('layouts.admin')

@section('title', 'Write New Article')
@section('page_title', 'Create Blog Post')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-9">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2 text-warning"></i>Write Article</h5>
        <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-dark btn-sm">
          <i class="bi bi-arrow-left me-1"></i> Back to Articles
        </a>
      </div>

      <div class="card-body p-4">
        <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row g-3 mb-4">
            <div class="col-md-8">
              <label class="form-label fw-semibold">Article Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. How to Choose the Right Hinges for Modular Kitchens" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Blog Category <span class="text-danger">*</span></label>
              <select name="category_id" class="form-select" required>
                <option value="">Select Category...</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Author Name</label>
              <input type="text" name="author" class="form-control" value="{{ old('author', 'Laxmi Hardware Team') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Featured Cover Image</label>
              <input type="file" name="featured_image" id="featuredImageInput" class="form-control" accept="image/*" onchange="previewImage(this)">
              <div id="imagePreviewContainer" class="mt-2" style="display: none;">
                <img id="imagePreview" src="" alt="Preview" style="height: 60px; width: 60px; object-fit: cover; border-radius: 6px;" class="border shadow-sm">
                <small class="text-muted d-block mt-1">Image selected</small>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Excerpt / Summary</label>
              <textarea name="excerpt" class="form-control" rows="2" placeholder="Brief teaser paragraph displayed on blog list cards...">{{ old('excerpt') }}</textarea>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Article Body Content <span class="text-danger">*</span></label>
              <textarea name="content" class="form-control font-monospace" rows="12" placeholder="Write full article text here. Supports HTML formatting or paragraphs..." required>{{ old('content') }}</textarea>
            </div>
          </div>

          <!-- SEO Settings -->
          <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-google me-2 text-warning"></i>SEO Meta Settings (Optional)</h6>
          <div class="row g-3 mb-4">
            <div class="col-12">
              <label class="form-label fw-semibold">SEO Meta Title</label>
              <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title') }}" placeholder="Leave blank to use article title">
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">SEO Meta Description</label>
              <textarea name="seo_description" class="form-control" rows="2" placeholder="Leave blank to use excerpt">{{ old('seo_description') }}</textarea>
            </div>
            <div class="col-12">
              <div class="form-check form-switch pt-2">
                <input class="form-check-input" type="checkbox" name="status" value="1" id="postStatus" checked>
                <label class="form-check-label fw-semibold" for="postStatus">Publish immediately on website</label>
              </div>
            </div>
          </div>

          <hr class="my-4">

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.blog.index') }}" class="btn btn-light px-4">Cancel</a>
            <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
              <i class="bi bi-check-lg me-1"></i> Publish Article
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
  const container = document.getElementById('imagePreviewContainer');
  const preview = document.getElementById('imagePreview');
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