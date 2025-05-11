@extends('admin.admin_dashboard')

@section('admin')

@push('styles')
    <link href="{{ asset('css/edit.css') }}" rel="stylesheet" />
@endpush

<div class="container-fluid px-4 px-lg-5 py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-2 text-gray-900 font-weight-bold">Update Product</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-primary">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('items.index') }}" class="text-decoration-none text-primary">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-header bg-gradient-primary text-white p-4">
                    <h5 class="mb-2 text-white">Edit Product Details</h5>
                    <p class="mb-0 opacity-75">Update the product information below</p>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('admin.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information Section -->
                        <div class="mb-4 pb-3 border-bottom">
                            <h6 class="mb-3 d-flex align-items-center text-gray-800">
                                <i class="ri-information-line me-2 text-primary"></i> Basic Information
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-gray-700 fw-semibold">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" value="{{ old('name', $item->name) }}" 
                                               class="form-control @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-gray-700 fw-semibold">SKU <span class="text-danger">*</span></label>
                                        <input type="text" name="sku" value="{{ old('sku', $item->sku) }}" 
                                               class="form-control @error('sku') is-invalid @enderror" required>
                                        @error('sku')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label text-gray-700 fw-semibold">Description</label>
                                        <textarea name="description" rows="3" 
                                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $item->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing & Inventory Section -->
                        <div class="mb-4 pb-3 border-bottom">
                            <h6 class="mb-3 d-flex align-items-center text-gray-800">
                                <i class="ri-price-tag-3-line me-2 text-primary"></i> Pricing & Inventory
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label text-gray-700 fw-semibold">Quantity <span class="text-danger">*</span></label>
                                        <input type="number" name="quantity" value="{{ old('quantity', $item->quantity) }}" 
                                               class="form-control @error('quantity') is-invalid @enderror" required>
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label text-gray-700 fw-semibold">Price ($) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" name="price" value="{{ old('price', $item->price) }}" 
                                                   class="form-control @error('price') is-invalid @enderror" required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label text-gray-700 fw-semibold">Cost Price ($)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" name="cost_price" value="{{ old('cost_price', $item->cost_price) }}" 
                                                   class="form-control @error('cost_price') is-invalid @enderror">
                                            @error('cost_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="mb-4">
                            <h6 class="mb-3 d-flex align-items-center text-gray-800">
                                <i class="ri-folder-info-line me-2 text-primary"></i> Additional Information
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-gray-700 fw-semibold">Category <span class="text-danger">*</span></label>
                                        <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                            <option value="">Select Category</option>
                                            <option value="1" {{ old('category', $item->category) == '1' ? 'selected' : '' }}>Beverages</option>
                                            <option value="2" {{ old('category', $item->category) == '2' ? 'selected' : '' }}>Food</option>
                                            <option value="3" {{ old('category', $item->category) == '3' ? 'selected' : '' }}>Frozen</option>
                                            <option value="4" {{ old('category', $item->category) == '4' ? 'selected' : '' }}>Dry Goods</option>
                                            <option value="5" {{ old('category', $item->category) == '5' ? 'selected' : '' }}>Household</option>
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label text-gray-700 fw-semibold">Expiry Date</label>
                                        <input type="date" name="expiry_date" value="{{ old('expiry_date', $item->expiry_date) }}" 
                                            class="form-control @error('expiry_date') is-invalid @enderror">
                                        @error('expiry_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Image Upload with Preview -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label text-gray-700 fw-semibold">Product Image</label>
                                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="previewImage(event)">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <!-- Current Image -->
                                        @if($item->image)
                                            <div class="mt-3 text-center">
                                                <label class="form-label d-block">Current Image:</label>
                                                <img src="{{ asset('storage/'.$item->image) }}" alt="Current Image" class="img-thumbnail" style="max-height: 100px;">
                                            </div>
                                        @endif

                                        <!-- Preview Image -->
                                        <div class="mt-3 text-center" id="preview-container" style="display: none;">
                                            <label class="form-label d-block">Preview:</label>
                                            <img id="preview-image" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="javascript:history.back();" class="btn btn-outline-secondary px-4 rounded-pill">
                                <i class="ri-arrow-left-line me-2"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                <i class="ri-save-line me-2"></i> Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection