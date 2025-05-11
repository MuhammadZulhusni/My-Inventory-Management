@extends('admin.admin_dashboard')

@section('admin')

@push('styles')
    <link href="{{ asset('css/create.css') }}" rel="stylesheet" />
@endpush

<div class="container-fluid py-4">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New Product</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-primary"><i class="fas fa-cube me-2"></i> Add New Product</h4>
                <a href="javascript:history.back();" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Products
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <form action="{{ route('items.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <!-- Left Column -->
                    <div class="col-lg-6">
                        <!-- Product Information -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light py-3">
                                <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Product Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control form-control-lg" placeholder="Enter product name" required>
                                    <div class="invalid-feedback">Please provide a product name.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-semibold">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Short product description"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="sku" class="form-label fw-semibold">SKU Code <span class="text-danger">*</span></label>
                                        <input type="text" name="sku" id="sku" class="form-control form-control-lg" placeholder="FM-1001" required>
                                        <div class="invalid-feedback">Please provide a SKU code.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light py-3">
                                <h5 class="mb-0"><i class="fas fa-tag me-2 text-primary"></i>Pricing</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="price" class="form-label fw-semibold">Selling Price (RM) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">RM</span>
                                            <input type="number" step="0.01" name="price" id="price" class="form-control form-control-lg" required>
                                        </div>
                                        <div class="invalid-feedback">Please provide a valid price.</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cost_price" class="form-label fw-semibold">Cost Price (RM)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">RM</span>
                                            <input type="number" step="0.01" name="cost_price" id="cost_price" class="form-control form-control-lg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-6">
                        <!-- Inventory -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light py-3">
                                <h5 class="mb-0"><i class="fas fa-boxes me-2 text-primary"></i>Inventory</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="quantity" class="form-label fw-semibold">Quantity <span class="text-danger">*</span></label>
                                        <input type="number" name="quantity" id="quantity" class="form-control form-control-lg" min="0" required>
                                        <div class="invalid-feedback">Please provide stock quantity.</div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="expiry_date" class="form-label fw-semibold">Expiry Date</label>
                                    <input type="date" name="expiry_date" id="expiry_date" class="form-control form-control-lg">
                                </div>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light py-3">
                                <h5 class="mb-0"><i class="fas fa-tags me-2 text-primary"></i>Categories</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="category" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                                    <select name="category" id="category" class="form-select form-select-lg" required>
                                        <option value="">Select Category</option>
                                        <option value="1">Beverages</option>
                                        <option value="2">Food</option>
                                        <option value="3">Frozen</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a category.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Image -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light py-3">
                                <h5 class="mb-0"><i class="fas fa-image me-2 text-primary"></i>Product Image</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="product_image" class="form-label fw-semibold">Upload Image</label>
                                    <input type="file" class="form-control form-control-lg" id="product_image" name="image" accept="image/*">
                                    <small class="text-muted">Recommended size: 500x500px (max 2MB)</small>
                                </div>
                                <div id="image-preview" class="mt-2 border p-2 text-center" style="display:none;">
                                    <img id="preview-image" src="#" alt="Preview" class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 gap-3">
                    <button type="button" id="reset-btn" class="btn btn-light px-4 py-2">
                        <i class="fas fa-eraser me-2"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-save me-2"></i> Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection