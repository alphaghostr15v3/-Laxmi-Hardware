@extends('layouts.admin')

@section('title', 'Edit Project — ' . $project->title)
@section('page_title', 'Edit Project: ' . $project->title)

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-9">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Project</h5>
          <small class="text-muted">{{ $project->category }} | {{ $project->location ?? 'Surat' }}</small>
        </div>
        <div class="d-flex gap-2">
          <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-box-arrow-up-right me-1"></i> Preview
          </a>
          <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-dark btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Projects
          </a>
        </div>
      </div>

      <div class="card-body p-4">
        <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row g-3 mb-4">
            <div class="col-md-8">
              <label class="form-label fw-semibold">Project Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control" value="{{ old('title', $project->title) }}" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
              <select name="category" class="form-select" required>
                @foreach($categories as $cat)
                  <option value="{{ $cat }}" {{ old('category', $project->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Location</label>
              <input type="text" name="location" class="form-control" value="{{ old('location', $project->location) }}">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Client / Property Type</label>
              <input type="text" name="client_type" class="form-control" value="{{ old('client_type', $project->client_type) }}">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Project Duration</label>
              <input type="text" name="duration" class="form-control" value="{{ old('duration', $project->duration) }}">
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Project Description</label>
              <textarea name="description" class="form-control" rows="4">{{ old('description', $project->description) }}</textarea>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Materials & Hardware Used</label>
              <input type="text" name="materials" class="form-control" value="{{ old('materials', $project->materials) }}">
            </div>
          </div>

          <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Project Photos</h6>
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Featured Main Cover Photo</label>
              @if($project->featured_image)
                <div class="mb-2 p-2 bg-light rounded text-center" style="max-width: 140px;">
                  <img src="{{ Str::startsWith($project->featured_image, '/images') ? asset($project->featured_image) : asset('storage/' . $project->featured_image) }}" alt="Preview" class="img-fluid rounded">
                </div>
              @endif
              <input type="file" name="featured_image" class="form-control" accept="image/*">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Add More Gallery Images</label>
              <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>

              @if($project->images->count() > 0)
                <div class="mt-3">
                  <span class="small fw-semibold d-block mb-1">Attached Gallery Photos ({{ $project->images->count() }}):</span>
                  <div class="d-flex flex-wrap gap-2">
                    @foreach($project->images as $img)
                      <div class="position-relative border rounded p-1 bg-white" style="width: 70px; height: 70px;">
                        <img src="{{ Str::startsWith($img->image_path, '/images') ? asset($img->image_path) : asset('storage/' . $img->image_path) }}" alt="project img" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                        <button type="button" class="btn btn-danger btn-sm p-0 position-absolute top-0 end-0 rounded-circle d-flex align-items-center justify-content-center" style="width: 20px; height: 20px; font-size: 10px;" onclick="deleteProjectImage('{{ route('admin.projects.image.delete', $img) }}', this)">
                          &times;
                        </button>
                      </div>
                    @endforeach
                  </div>
                </div>
              @endif
            </div>

            <div class="col-md-4">
              <label class="form-label fw-semibold">Sort Order</label>
              <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $project->sort_order) }}">
            </div>
            <div class="col-md-8 d-flex align-items-center">
              <div class="form-check form-switch pt-3">
                <input class="form-check-input" type="checkbox" name="status" value="1" id="projStatus" {{ $project->status ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="projStatus">Visible in Public Portfolio</label>
              </div>
            </div>
          </div>

          <hr class="my-4">

          <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.projects.index') }}" class="btn btn-light px-4">Cancel</a>
            <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
              <i class="bi bi-check-lg me-1"></i> Update Project
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function deleteProjectImage(url, btn) {
    if (!confirm('Are you sure you want to delete this project photo?')) return;
    fetch(url, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      }
    }).then(res => {
      if (res.ok) {
        btn.closest('.position-relative').remove();
      } else {
        alert('Could not delete image.');
      }
    });
  }
</script>
@endpush