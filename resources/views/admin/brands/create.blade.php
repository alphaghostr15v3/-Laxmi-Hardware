@extends('layouts.admin')

@section('title', 'Create Brands')
@section('page_title', 'Create New Brands')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0 fw-bold">Add New Brands</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Name / Title</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Save Brands</button>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-light">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection