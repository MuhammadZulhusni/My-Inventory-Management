@extends('admin.admin_dashboard')

@section('admin')

@push('styles')
    <link href="{{ asset('css/indexItem.css') }}" rel="stylesheet" />
@endpush

@if ($showExpiringSoonModal)
<!-- Expiring Soon Modal -->
<div class="modal fade" id="expiringSoonModal" tabindex="-1" aria-labelledby="expiringSoonModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-gradient-warning text-dark">
        <div class="d-flex align-items-center">
          <div class="flex-shrink-0 bg-white bg-opacity-25 p-2 rounded-circle me-3">
            <i class="ri-alarm-warning-fill fs-4"></i>
          </div>
          <div>
            <h5 class="modal-title mb-0" id="expiringSoonModalLabel">Items Expiring Soon</h5>
            <p class="small mb-0 opacity-75">Products expiring within 7 days</p>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning bg-light-warning border-0 mb-4">
          <div class="d-flex align-items-center">
            <i class="ri-information-line me-2 fs-4"></i>
            <div>
              <h6 class="mb-1">Action Required</h6>
              <p class="mb-0 small">These items will expire soon and may need attention</p>
            </div>
          </div>
        </div>
        
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>Product</th>
                <th>Expiry Date</th>
                <th>Stock</th>
                <th>Days Left</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($items as $item)
                @php
                $expiryDate = \Carbon\Carbon::parse($item->expiry_date)->startOfDay();
                $daysLeft = now()->startOfDay()->diffInDays($expiryDate, false); // signed, rounded
                $isCritical = $daysLeft <= 3 && $daysLeft >= 0;
                @endphp
                <tr class="{{ $isCritical ? 'table-danger' : '' }}">
                  <td>
                    <div class="d-flex align-items-center">
                      @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" class="rounded me-2" width="40" height="40">
                      @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                          <i class="ri-box-3-line text-muted"></i>
                        </div>
                      @endif
                      <div>
                        <h6 class="mb-0">{{ $item->name }}</h6>
                        <small class="text-muted">{{ $item->sku }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="{{ $isCritical ? 'fw-bold text-danger' : '' }}">
                      {{ $expiryDate->format('d M Y') }}
                    </span>
                  </td>
                  <td>
                    <span class="badge {{ $item->quantity < 5 ? 'bg-danger' : ($item->quantity < 10 ? 'bg-warning text-dark' : 'bg-success') }}">
                      {{ $item->quantity }} units
                    </span>
                  </td>
                  <td>
                    @if ($daysLeft < 0)
                        <span class="badge bg-secondary">
                        Expired {{ abs($daysLeft) }} {{ Str::plural('day', abs($daysLeft)) }} ago
                        </span>
                    @elseif ($daysLeft === 0)
                        <span class="badge bg-warning text-dark">Expires today</span>
                    @else
                        <span class="badge {{ $isCritical ? 'bg-danger' : 'bg-warning text-dark' }}">
                        {{ $daysLeft }} {{ Str::plural('day', $daysLeft) }} left
                        </span>
                    @endif
                    </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center py-4 text-muted">
                    <i class="ri-checkbox-circle-line fs-3 text-success"></i>
                    <p class="mb-0 mt-2">No items expiring soon</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer border-top-0">
        <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">
          <i class="ri-close-line me-1"></i> Dismiss
        </button>
      </div>
    </div>
  </div>
</div>
@endif

@if ($showUrgentStockModal)
<!-- Urgent Stock Modal -->
<div class="modal fade" id="urgentStockModal" tabindex="-1" aria-labelledby="urgentStockModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-gradient-danger text-white">
        <div class="d-flex align-items-center">
          <div class="flex-shrink-0 bg-white bg-opacity-25 p-2 rounded-circle me-3">
            <i class="ri-error-warning-fill fs-4"></i>
          </div>
          <div>
            <h5 class="modal-title mb-0" id="urgentStockModalLabel">Urgent Stock Alert</h5>
            <p class="small mb-0 opacity-75">Critical inventory levels</p>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger bg-light-danger border-0 mb-4">
          <div class="d-flex align-items-center">
            <i class="ri-alert-line me-2 fs-4"></i>
            <div>
              <h6 class="mb-1">Immediate Attention Required</h6>
              <p class="mb-0 small">These items are dangerously low in stock</p>
            </div>
          </div>
        </div>
        
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>Product</th>
                <th>Current Stock</th>
                <th>Last Restocked</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @php $hasCriticalItems = false; @endphp
              @foreach ($items as $item)
                @if ($item->quantity < 5)
                  @php $hasCriticalItems = true; @endphp
                  <tr>
                    <td>
                      <div class="d-flex align-items-center">
                        @if($item->image)
                          <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" class="rounded me-2" width="40" height="40">
                        @else
                          <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                            <i class="ri-box-3-line text-muted"></i>
                          </div>
                        @endif
                        <div>
                          <h6 class="mb-0">{{ $item->name }}</h6>
                          <small class="text-muted">{{ $item->sku }}</small>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="badge bg-danger">
                        {{ $item->quantity }} units
                      </span>
                    </td>
                    <td>
                      @if($item->updated_at)
                        {{ $item->updated_at->diffForHumans() }}
                      @else
                        <span class="text-muted">Never</span>
                      @endif
                    </td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                          <div class="spinner-grow spinner-grow-sm text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                          </div>
                        </div>
                        <div>
                          @if($item->quantity <= 2)
                            <span class="text-danger fw-bold">Critical</span>
                          @else
                            <span class="text-warning fw-bold">Low</span>
                          @endif
                        </div>
                      </div>
                    </td>
                  </tr>
                @endif
              @endforeach
              
              @unless($hasCriticalItems)
                <tr>
                  <td colspan="4" class="text-center py-4 text-muted">
                    <i class="ri-checkbox-circle-line fs-3 text-success"></i>
                    <p class="mb-0 mt-2">No urgent stock issues</p>
                  </td>
                </tr>
              @endunless
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer border-top-0">
        <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">
          <i class="ri-close-line me-1"></i> Dismiss
        </button>
      </div>
    </div>
  </div>
</div>
@endif


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

                            <!-- Modal file -->
                            @include('admin.restock-modal', ['item' => $item])
                            
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
                                    {{-- Edit button (only visible on the base admin.items.index route) --}}
                                    @if(Route::is('items.index') && !request()->hasAny(['stock_status', 'urgent', 'expiring']))
                                        <a href="{{ route('admin.items.edit', $item->id) }}" 
                                          class="btn btn-sm btn-outline-primary" 
                                          data-bs-toggle="tooltip" 
                                          title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    <!-- Restock Link as a Button -->
                                    <a class="btn btn-sm btn-outline-warning" 
                                      title="Restock" 
                                      data-bs-toggle="modal" 
                                      data-bs-target="#restockModal{{ $item->id }}">
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

<script>
  document.addEventListener('DOMContentLoaded', function () {
    @if ($showExpiringSoonModal)
      const expModal = new bootstrap.Modal(document.getElementById('expiringSoonModal'));
      expModal.show();
    @endif

    @if ($showUrgentStockModal)
      const urgentModal = new bootstrap.Modal(document.getElementById('urgentStockModal'));
      urgentModal.show();
    @endif
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
@endsection

