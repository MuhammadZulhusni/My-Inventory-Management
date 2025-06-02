@extends('admin.admin_dashboard')

@section('admin')

<div class="container-fluid px-4 py-4 mt-3">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-semibold">
                    <i class="fas fa-chart-line me-2"></i> Items Sold
                </h5>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-2">
                    <i class="fas fa-boxes me-1"></i> {{ $soldItems->total() }} items
                </span>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light bg-opacity-50">
                        <tr>
                            <th class="px-4 py-3 text-uppercase fw-semibold small text-muted border-0">Name</th>
                            <th class="px-4 py-3 text-uppercase fw-semibold small text-muted border-0">SKU</th>
                            <th class="px-4 py-3 text-uppercase fw-semibold small text-muted border-0">Total Sold</th>
                            <th class="px-4 py-3 text-uppercase fw-semibold small text-muted border-0">Remaining Stock</th>
                            <th class="px-4 py-3 text-uppercase fw-semibold small text-muted border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($soldItems as $item)
                        <tr class="border-top border-light">
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-3 p-2 me-3">
                                        <i class="fas fa-box text-primary"></i>
                                    </div>
                                    <div>
                                        <span class="d-block fw-semibold text-gray-800">{{ $item->name }}</span>
                                        <small class="text-muted">ID: {{ $item->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-light bg-opacity-75 text-dark border border-light rounded-pill px-3 py-1">
                                    {{ $item->sku }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                                    <i class="fas fa-check-circle me-1"></i> {{ $item->total_sold ?? 0 }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    <i class="fas fa-cubes me-1"></i> {{ $item->quantity }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <button 
                                    class="btn btn-sm btn-primary rounded-pill px-3 open-sell-modal" 
                                    data-item-id="{{ $item->id }}" 
                                    data-item-name="{{ $item->name }}"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#sellModal">
                                    <i class="fas fa-plus-circle me-1"></i> Set Sold Today
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Smart Pagination --}}
            <div class="card-footer bg-white border-top-0 py-3">
                <div class="d-flex justify-content-center">
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            @if ($soldItems->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link rounded-start-pill">&laquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link rounded-start-pill" href="{{ $soldItems->previousPageUrl() }}" rel="prev">&laquo;</a>
                                </li>
                            @endif

                            {{-- First Page --}}
                            @if ($soldItems->currentPage() > 3)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $soldItems->url(1) }}">1</a>
                                </li>
                                @if ($soldItems->currentPage() > 4)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                            @endif

                            {{-- Pages Around Current Page --}}
                            @for ($page = max(1, $soldItems->currentPage() - 2); $page <= min($soldItems->lastPage(), $soldItems->currentPage() + 2); $page++)
                                @if ($page == $soldItems->currentPage())
                                    <li class="page-item active"><span class="page-link bg-primary border-primary">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $soldItems->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @endfor

                            {{-- Last Page --}}
                            @if ($soldItems->currentPage() < $soldItems->lastPage() - 2)
                                @if ($soldItems->currentPage() < $soldItems->lastPage() - 3)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link" href="{{ $soldItems->url($soldItems->lastPage()) }}">{{ $soldItems->lastPage() }}</a>
                                </li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($soldItems->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link rounded-end-pill" href="{{ $soldItems->nextPageUrl() }}" rel="next">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link rounded-end-pill">&raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                <div class="text-center text-muted small mt-2">
                    Showing {{ $soldItems->firstItem() }} to {{ $soldItems->lastItem() }} of {{ $soldItems->total() }} entries
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sellModal" tabindex="-1" aria-labelledby="sellModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white p-4">
                <h5 class="modal-title fw-bold" id="sellModalLabel">
                    <i class="fas fa-cash-register me-2"></i> Record Items Sold Today
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('items.sell') }}">
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" name="item_id" id="modalItemId">
                    <div class="mb-4">
                        <label for="modalItemName" class="form-label fw-semibold text-gray-700 mb-2">Item</label>
                        <div class="input-group border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0">
                                <i class="fas fa-box text-primary"></i>
                            </span>
                            <input type="text" id="modalItemName" class="form-control border-0" disabled>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="quantity" class="form-label fw-semibold text-gray-700 mb-2">Quantity Sold</label>
                        <div class="input-group border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-0">
                                <i class="fas fa-hashtag text-primary"></i>
                            </span>
                            <input type="number" name="quantity" 
                                   class="form-control border-0" 
                                   min="1" 
                                   required
                                   placeholder="Enter quantity sold">
                        </div>
                        <small class="text-muted mt-1 d-block">Please enter a positive number</small>
                    </div>
                </div>
                <div class="modal-footer border-top-0 p-4 bg-light">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                        <i class="fas fa-check-circle me-1"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.open-sell-modal').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('modalItemId').value = this.getAttribute('data-item-id');
                document.getElementById('modalItemName').value = this.getAttribute('data-item-name');
            });
        });
    });
</script>
