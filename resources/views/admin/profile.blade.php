@extends('layouts.admin')

@section('title', 'Admin Profile')
@section('page_title', 'Admin Profile & Security')

@section('content')
<div class="row g-4">
  <div class="col-lg-4">
    <!-- Profile Card -->
    <div class="card border-0 shadow-sm text-center p-4">
      <div class="position-relative d-inline-block mx-auto mb-3">
        @if($admin->avatar)
          <img src="{{ asset('storage/' . $admin->avatar) }}" alt="{{ $admin->name }}" class="rounded-circle shadow-sm" style="width: 110px; height: 110px; object-fit: cover;">
        @else
          <div class="rounded-circle bg-dark text-warning d-flex align-items-center justify-content-center fw-bold fs-1 mx-auto shadow-sm" style="width: 110px; height: 110px;">
            {{ strtoupper(substr($admin->name, 0, 1)) }}
          </div>
        @endif
      </div>
      <h5 class="fw-bold mb-1">{{ $admin->name }}</h5>
      <p class="text-muted small mb-2">{{ $admin->email }}</p>
      <span class="badge bg-warning text-dark px-3 py-2 text-uppercase fw-bold align-self-center">{{ $admin->role ?? 'Superadmin' }}</span>
      <hr class="my-3">
      <div class="text-start small text-muted">
        <div class="d-flex justify-content-between mb-2">
          <span>Joined:</span>
          <span class="fw-semibold text-dark">{{ $admin->created_at ? $admin->created_at->format('d M, Y') : 'N/A' }}</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>Last Updated:</span>
          <span class="fw-semibold text-dark">{{ $admin->updated_at ? $admin->updated_at->diffForHumans() : 'N/A' }}</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="card border-0 shadow-sm p-4">
      <h5 class="fw-bold mb-3"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Profile Information</h5>
      <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Profile Avatar / Photo</label>
            <input type="file" name="avatar" class="form-control" accept="image/*">
            <small class="text-muted">Recommended: Square PNG/JPG up to 2MB.</small>
          </div>
        </div>

        <h6 class="fw-bold text-dark pt-3 border-top mb-3"><i class="bi bi-shield-lock me-2 text-warning"></i>Change Password <small class="text-muted fw-normal">(Leave blank to keep current password)</small></h6>
        <div class="row g-3 mb-4">
          <div class="col-12">
            <label class="form-label fw-semibold">Current Password</label>
            <input type="password" name="current_password" class="form-control" placeholder="Enter current password to verify">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">New Password</label>
            <input type="password" name="new_password" class="form-control" placeholder="Min. 6 characters">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" class="form-control" placeholder="Repeat new password">
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
            <i class="bi bi-check-lg me-1"></i> Update Profile
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
