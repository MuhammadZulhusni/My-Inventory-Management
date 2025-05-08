@extends('admin.admin_dashboard')

@section('admin')
<div class="container-fluid py-4">
    <!-- Header with Add New button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold text-dark">Product Inventory</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('items.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Add New Product
        </a>
    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Product List</h5>
                <div class="d-flex gap-2">
                    <form method="GET" action="{{ route('items.index') }}" class="d-flex gap-2">
                        <div class="input-group" style="width: 250px;">
                            <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Search products..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" 
                                    type="button" 
                                    id="filterDropdown" 
                                    data-bs-toggle="dropdown">
                                <i class="fas fa-filter"></i> Filters
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end p-3" style="width: 250px;">
                                <li>
                                    <h6 class="dropdown-header">Filter Options</h6>
                                </li>
                                <li>
                                    <div class="mb-3">
                                        <label class="form-label small">Category</label>
                                        <select name="category" class="form-select form-select-sm">
                                            <option value="">All Categories</option>
                                            <option value="1" {{ request('category') == '1' ? 'selected' : '' }}>Beverages</option>
                                            <option value="2" {{ request('category') == '2' ? 'selected' : '' }}>Food</option>
                                            <option value="3" {{ request('category') == '3' ? 'selected' : '' }}>Frozen</option>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="mb-3">
                                        <label class="form-label small">Stock Status</label>
                                        <select name="stock_status" class="form-select form-select-sm">
                                            <option value="">All</option>
                                            <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock (<10)</option>
                                            <option value="critical" {{ request('stock_status') == 'critical' ? 'selected' : '' }}>Critical Stock (<5)</option>
                                            <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex justify-content-between gap-2">
                                        <a href="{{ route('items.index') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
                                        <button type="submit" class="btn btn-sm btn-primary w-100">
                                            Apply
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Product</th>
                            <th class="text-center">SKU</th>
                            <th class="text-center">Stock</th>
                            <th class="text-end">Price (RM)</th>
                            <th class="text-end">Cost (RM)</th>
                            <th class="text-center">Expiry</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Added On</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $index => $item)
                        <tr>
                            <!-- Restock Modal -->
                            <div class="modal fade" id="restockModal{{ $item->id }}" tabindex="-1" aria-labelledby="restockModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg">
                                        <form action="{{ route('items.restock', $item->id) }}" method="POST">
                                            @csrf
                                            <!-- Modal Header -->
                                            <div class="modal-header bg-gradient-primary text-white">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 bg-white bg-opacity-10 p-2 rounded-circle me-3">
                                                        <i class="ri-archive-line fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="modal-title mb-0 text-white" id="restockModalLabel{{ $item->id }}">Restock Product</h5>
                                                        <p class="small mb-0 opacity-75">Add inventory for {{ $item->name }}</p>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            
                                            <!-- Modal Body -->
                                            <div class="modal-body">
                                                <div class="d-flex align-items-center mb-4">
                                                    @if($item->image)
                                                        <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" class="rounded-3 me-3" width="60" height="60">
                                                    @else
                                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                                            <i class="ri-box-3-line text-muted fs-4"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-1">{{ $item->name }}</h6>
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge bg-light text-dark me-2">SKU: {{ $item->sku }}</span>
                                                            <span class="badge {{ $item->quantity < 5 ? 'bg-danger' : ($item->quantity < 10 ? 'bg-warning text-dark' : 'bg-success') }}">
                                                                Stock: {{ $item->quantity }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="quantity{{ $item->id }}" class="form-label fw-semibold">Quantity to Add</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light">
                                                            <i class="ri-number-1 text-primary"></i>
                                                        </span>
                                                        <input type="number" 
                                                            name="quantity" 
                                                            id="quantity{{ $item->id }}" 
                                                            class="form-control form-control-lg"
                                                            min="1" 
                                                            value="10"
                                                            required>
                                                        <span class="input-group-text bg-light">units</span>
                                                    </div>
                                                    <div class="form-text">Current stock will be increased by this amount</div>
                                                </div>
                                            </div>
                                            
                                            <!-- Modal Footer -->
                                            <div class="modal-footer border-top-0">
                                                <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">
                                                    <i class="ri-close-line me-1"></i> Cancel
                                                </button>
                                                <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                                    <i class="ri-add-circle-line me-1"></i> Confirm Restock
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <td class="text-center">{{ $items->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @php
                                        $imagePath = public_path('storage/' . $item->image);
                                        $imageUrl = (!empty($item->image) && file_exists($imagePath))
                                            ? asset('storage/' . $item->image)
                                            : asset('uploads/no-item.png');
                                    @endphp

                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ $imageUrl }}" 
                                            alt="{{ $item->name }}" 
                                            class="rounded" 
                                            width="40" 
                                            height="40">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $item->name }}</h6>
                                        <small class="text-muted text-truncate d-block" style="max-width: 200px;" 
                                               title="{{ $item->description }}">
                                            {{ $item->description ?: 'No description' }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark font-monospace">{{ $item->sku }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $item->quantity < 5 ? 'bg-danger' : ($item->quantity < 10 ? 'bg-warning' : 'bg-success') }}">
                                    {{ $item->quantity }}
                                </span>
                            </td>
                            <td class="text-end fw-bold">{{ number_format($item->price, 2) }}</td>
                            <td class="text-end">
                                <span class="{{ $item->cost_price ? 'text-muted' : 'text-secondary' }}">
                                    {{ $item->cost_price ? number_format($item->cost_price, 2) : 'N/A' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if ($item->expiry_date)
                                <span class="badge {{ \Carbon\Carbon::parse($item->expiry_date)->isPast() ? 'bg-danger' : 'bg-info' }}">
                                    {{ \Carbon\Carbon::parse($item->expiry_date)->format('d M Y') }}
                                </span>
                                @else
                                <span class="badge bg-secondary">N/A</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @php
                                    $categoryColors = [
                                        1 => 'bg-primary', // Beverages
                                        2 => 'bg-success', // Food
                                        3 => 'bg-info'     // Frozen
                                    ];
                                @endphp
                                <span class="badge {{ $categoryColors[$item->category] ?? 'bg-secondary' }}">
                                    @switch($item->category)
                                        @case(1) Beverages @break
                                        @case(2) Food @break
                                        @case(3) Frozen @break
                                        @default Unknown
                                    @endswitch
                                </span>
                            </td>
                            <td class="text-center">
                                <small class="text-muted">{{ $item->created_at->format('d M Y') }}</small>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Edit button --}}
                                    <a href="{{ route('admin.items.edit', $item->id) }}" 
                                    class="btn btn-sm btn-outline-primary" 
                                    data-bs-toggle="tooltip" 
                                    title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Restock link as a button --}}
                                    <a class="btn btn-sm btn-outline-warning" 
                                        title="Restock" 
                                        data-bs-target="#restockModal{{ $item->id }}" 
                                        data-bs-toggle="modal">
                                        <i class="fas fa-plus"></i>
                                    </a>


                                    {{-- Delete button --}}
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="tooltip" 
                                                title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No products found</h5>
                                    <a href="{{ route('items.create') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus-circle me-2"></i> Add Your First Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        
        <!-- Pagination -->
        @if($items->hasPages())
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="mb-2 mb-md-0">
                        <p class="mb-0 text-muted">
                            Showing <span class="fw-bold">{{ $items->firstItem() }}</span> to 
                            <span class="fw-bold">{{ $items->lastItem() }}</span> of 
                            <span class="fw-bold">{{ $items->total() }}</span> results
                        </p>
                    </div>

                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            @if ($items->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $items->previousPageUrl() }}" rel="prev">&laquo;</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @php
                                $currentPage = $items->currentPage();
                                $lastPage = $items->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            {{-- First page --}}
                            @if ($start > 1)
                                <li class="page-item"><a class="page-link" href="{{ $items->url(1) }}">1</a></li>
                                @if ($start > 2)
                                    <li class="page-item disabled"><span class="page-link">…</span></li>
                                @endif
                            @endif

                            {{-- Page window --}}
                            @for ($page = $start; $page <= $end; $page++)
                                @if ($page == $currentPage)
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $items->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @endfor

                            {{-- Last page --}}
                            @if ($end < $lastPage)
                                @if ($end < $lastPage - 1)
                                    <li class="page-item disabled"><span class="page-link">…</span></li>
                                @endif
                                <li class="page-item"><a class="page-link" href="{{ $items->url($lastPage) }}">{{ $lastPage }}</a></li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($items->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $items->nextPageUrl() }}" rel="next">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Tooltip initialization -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Reset form functionality
    document.querySelector('button[type="reset"]').addEventListener('click', function() {
        // Reset all form inputs
        const form = this.closest('form');
        form.querySelector('input[name="search"]').value = '';
        form.querySelector('select[name="category"]').value = '';
        form.querySelector('select[name="stock_status"]').value = '';
        
        // Submit the form to remove all filters
        form.submit();
    });
});

/* For Restock Hovering */
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });
});

</script>

<!-- Show success message after deletion if session has 'success' -->
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Deleted!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
        background-color: #f8f9fa;
        white-space: nowrap;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        letter-spacing: 0.5px;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .breadcrumb {
        font-size: 0.85rem;
        margin-bottom: 0;
    }
    
    .breadcrumb-item.active {
        color: #4a5568;
    }

    .breadcrumb-item a {
        color: #0068b7;
        text-decoration: none;
    }
    
    .breadcrumb-item a:hover {
        text-decoration: underline;
    }
    
    .font-monospace {
        font-family: monospace;
    }
    
    .pagination {
        margin-bottom: 0;
    }
    
    .page-item.active .page-link {
        background-color: #0068b7;
        border-color: #0068b7;
    }
    
    .page-link {
        color: #0068b7;
    }
    
    /* Dropdown filter styling */
    .dropdown-menu {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .dropdown-header {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #6c757d;
    }

    /* SweetAlert customization */
    .swal2-popup {
        border-radius: 12px !important;
    }

    .swal2-title {
        font-size: 1.2rem !important;
    }

    .swal2-confirm {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }

    .swal2-cancel {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
    }


    .modal.fade .modal-dialog {
        transform: translateY(-20px);
        opacity: 0;
        transition: all 0.3s ease-out;
    }
    
    .modal.show .modal-dialog {
        transform: translateY(0);
        opacity: 1;
    }
    
    /* Modal Header Gradient */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border-radius: 0.3rem 0.3rem 0 0 !important;
    }
    
    /* Input Styling */
    .form-control-lg {
        padding: 0.75rem 1rem;
        font-size: 1.05rem;
    }
    
    /* Button Styling */
    .btn.rounded-pill {
        border-radius: 50px !important;
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(78, 115, 223, 0.3);
    }
    
    /* Badge Styling */
    .badge {
        padding: 0.35em 0.65em;
        font-weight: 500;
    }
    
    /* Product Image Container */
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>

@endsection