@extends('layouts.admin')

@section('title', 'Edit Brands')
@section('page_title', 'Edit Brands')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0 fw-bold">Edit Brands Details</h5>
    </div>
    <div class="card-body">
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Name / Title</label>
                <input type="text" name="name" class="form-control" value="Sample" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">Sample description</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update Brands</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection