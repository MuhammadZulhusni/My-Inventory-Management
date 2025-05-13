<div class="modal fade" id="restockModal{{ $item->id }}" tabindex="-1" aria-labelledby="restockModalLabel{{ $item->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content rounded-3 border-0 shadow-sm">
      <form action="{{ route('items.restock', $item->id) }}" method="POST">
        @csrf

        <!-- Modal Header -->
        <div class="modal-header bg-white border-0">
          <div class="w-100">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="modal-title fw-bold text-dark" id="restockModalLabel{{ $item->id }}">
                <i class="ri-add-box-line text-primary me-2"></i> Restock Inventory
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <p class="text-muted mt-1 mb-0">Add quantity to <strong>{{ $item->name }}</strong></p>
          </div>
        </div>

        <!-- Modal Body -->
        <div class="modal-body pt-0">
          <!-- Item Card -->
          <div class="card border-0 bg-light bg-opacity-10 mb-4">
            <div class="card-body d-flex align-items-center p-3 gap-3">
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
              <div>
                <h6 class="fw-semibold mb-1">{{ $item->name }}</h6>
                <div class="d-flex flex-wrap gap-2">
                  <span class="badge bg-secondary-subtle text-dark">SKU: {{ $item->sku }}</span>
                  <span class="badge {{ $item->quantity < 5 ? 'bg-danger' : ($item->quantity < 10 ? 'bg-warning text-dark' : 'bg-success') }}">
                    Current: {{ $item->quantity }} units
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Quantity Input -->
          <div class="mb-4">
            <label for="quantity{{ $item->id }}" class="form-label fw-semibold">Quantity to Add</label>
            <div class="input-group input-group-lg">
              <button class="btn btn-outline-secondary decrement-btn" type="button"><i class="ri-subtract-line"></i></button>
              <input type="number" 
                     name="quantity" 
                     id="quantity{{ $item->id }}" 
                     class="form-control text-center fw-bold" 
                     min="1" value="10" required>
              <button class="btn btn-outline-secondary increment-btn" type="button"><i class="ri-add-line"></i></button>
            </div>
            <div class="d-flex justify-content-between mt-2">
              <small class="text-muted">Minimum: 1 unit</small>
              <small class="text-primary fw-semibold">New total: {{ $item->quantity + 10 }} units</small>
            </div>
          </div>

          <!-- Quick Add Buttons -->
          <div class="mb-3">
            <label class="form-label text-muted">Quick Add</label>
            <div class="d-flex flex-wrap gap-2">
              @foreach([5, 10, 25, 50, 100] as $amount)
                <button type="button" class="btn btn-sm btn-outline-primary quick-amount" data-amount="{{ $amount }}">+{{ $amount }}</button>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer bg-light rounded-bottom-3 border-0">
          <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
            <i class="ri-close-line me-1"></i> Cancel
          </button>
          <button type="submit" class="btn btn-primary px-4">
            <i class="ri-check-line me-1"></i> Confirm Restock
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

