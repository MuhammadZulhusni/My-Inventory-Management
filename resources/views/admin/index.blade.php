@extends('admin.admin_dashboard')

@section('admin')

@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet" />
@endpush

@php
    use App\Models\Item;
    use App\Models\Sale;
    use Carbon\Carbon;

    // Get the authenticated admin's data
    $adminData = App\Models\User::findOrFail(Illuminate\Support\Facades\Auth::user()->id);

    // Fetch total items count
    $totalItems = Item::count();

    // Today's date
    $today = Carbon::today();
    $yesterday = Carbon::yesterday();

    // Count of items created today and yesterday
    $todayCount = Item::whereDate('created_at', $today)->count();
    $yesterdayCount = Item::whereDate('created_at', $yesterday)->count();

    // Calculate growth percentage
    $growth = $yesterdayCount > 0 ? round((($todayCount - $yesterdayCount) / $yesterdayCount) * 100) : ($todayCount > 0 ? 100 : 0);

    // Fetch low stock items (below 10) and urgent restock (below 5)
    $lowStockCount = Item::where('quantity', '<', 10)->count();
    $urgentRestockCount = Item::where('quantity', '<', 5)->count();

    // Get today's date and the date 7 days from now
    $today = Carbon::today();
    $sevenDaysLater = Carbon::today()->addDays(7);

    // Get count of items expiring in the next 7 days
    $expiringSoonCount = Item::whereBetween('expiry_date', [$today, $sevenDaysLater])
                          ->count();

    // Fetch total and weekly sold items from Sale table
    $totalItemsSold = Sale::sum('quantity_sold');

    // Fetch 5 low stock items 
    $lowStockItems = Item::where('quantity', '<', 10)
                     ->orderBy('quantity')
                     ->limit(5)
                     ->get();

    // Get the most frequent category ID from items table
    $topCategoryId = Item::select('category')
        ->groupBy('category')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(1)
        ->pluck('category')
        ->first();

    // Convert category ID to readable name
    $topCategory = match ($topCategoryId) {
        1 => 'Beverages',
        2 => 'Food',
        3 => 'Frozen',
        default => 'Unknown'
    };

    // Get count of items sold today
    $itemsSoldToday = Sale::whereDate('sold_at', Carbon::today())->sum('quantity_sold');
@endphp

<div class="dashboard-content">
    <div class="container-fluid">
        <!-- Dashboard Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <div class="me-3">
                            @php
                                $photo = $adminData->photo;
                                $photoPath = public_path('uploads/admin_profiles/' . $photo);
                                $imageUrl = (!empty($photo) && file_exists($photoPath)) 
                                    ? asset('uploads/admin_profiles/' . $photo) 
                                    : asset('uploads/no_image.png');
                            @endphp
                            <img src="{{ $imageUrl }}" alt="User Avatar" class="user-avatar">
                        </div>
                        <div>
                            <h2 class="h4 mb-1 fw-bold">Inventory Dashboard</h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item active" aria-current="page">Overview</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    
                    <div class="d-flex">
                        <div class="badge bg-light text-dark me-2">
                            <i class="fas fa-store me-1 text-success"></i>
                            Store #{{ rand(1000,9999) }}
                        </div>
                        <div class="badge bg-light text-dark">
                            <i class="fas fa-clock me-1 text-primary"></i>
                            <span id="date-display">{{ now()->format('M d, Y - H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card border-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2 small fw-bold">Total Items</h6>
                                <h3 class="mb-0 fw-bold" id="totalItems">0</h3>
                                <p class="mb-0 text-muted small mt-2">
                                    <i class="fas fa-tag text-primary me-1"></i>
                                    Top Category: <span class="fw-semibold">{{ $topCategory }}</span>
                                </p>
                            </div>
                            <div class="icon-wrapper bg-primary-light">
                                <i class="fas fa-boxes text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card stat-card border-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2 small fw-bold">Low Stock</h6>
                                <h3 class="mb-0 fw-bold" id="lowStockCount">0</h3>
                                <p class="mb-0 text-danger small mt-2">
                                    <i class="fas fa-bolt me-1"></i>
                                    <span class="fw-semibold">{{ $urgentRestockCount }}</span> urgent
                                </p>
                            </div>
                            <div class="icon-wrapper bg-warning-light">
                                <i class="fas fa-exclamation-triangle text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card stat-card border-danger">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2 small fw-bold">Expiring Soon</h6>
                                <h3 class="mb-0 fw-bold" id="expiringSoonCount">0</h3>
                                <p class="mb-0 text-warning small mt-2">
                                    <i class="fas fa-calendar-week me-1"></i>
                                    Next 7 days
                                </p>
                            </div>
                            <div class="icon-wrapper bg-danger-light">
                                <i class="fas fa-hourglass-half text-danger fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card stat-card border-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2 small fw-bold">Items Sold</h6>
                                <h3 class="mb-0 fw-bold" id="itemsSold">0</h3>
                                <p class="mb-0 text-muted small mt-2">
                                    <i class="fas fa-shopping-bag me-1"></i>
                                    <span class="fw-semibold">{{ $itemsSoldToday }}</span> today
                                </p>
                            </div>
                            <div class="icon-wrapper bg-success-light">
                                <i class="fas fa-shopping-cart text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row g-4 mb-4">
            <!-- Chart Column -->
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-bold">Inventory Overview</h5>
                    </div>
                    <div class="card-body pt-0">
                        <canvas id="inventoryChart" height="250"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0 fw-bold">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('items.index') }}" class="quick-action-card bg-primary-light text-primary">
                                <div class="action-icon bg-primary text-white">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">Add New Item</h6>
                                    <p class="mb-0 small text-muted">Create inventory record</p>
                                </div>
                                <i class="fas fa-chevron-right text-primary"></i>
                            </a>
                            
                            <a href="{{ route('items.index', ['stock_status' => 'low']) }}" class="quick-action-card bg-warning-light text-warning">
                                <div class="action-icon bg-warning text-white">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">Low Stock</h6>
                                    <p class="mb-0 small text-muted">{{ $lowStockCount }} items</p>
                                </div>
                                <i class="fas fa-chevron-right text-warning"></i>
                            </a>
                            
                            <a href="{{ route('items.index', ['stock_status' => 'critical', 'urgent' => 'true']) }}" class="quick-action-card bg-danger-light text-danger">
                                <div class="action-icon bg-danger text-white">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">Urgent Restock</h6>
                                    <p class="mb-0 small text-muted">{{ $urgentRestockCount }} critical</p>
                                </div>
                                <i class="fas fa-chevron-right text-danger"></i>
                            </a>
                            
                            <a href="{{ route('items.index') }}?expiring=soon&expire=true" class="quick-action-card bg-danger-light text-danger">
                                <div class="action-icon bg-danger text-white">
                                    <i class="fas fa-hourglass-end"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">Expiring Soon</h6>
                                    <p class="mb-0 small text-muted">{{ $expiringSoonCount }} items</p>
                                </div>
                                <i class="fas fa-chevron-right text-danger"></i>
                            </a>
                            
                            <a href="{{ route('items.sold') }}" class="quick-action-card bg-primary-light text-primary">
                                <div class="action-icon bg-primary text-white">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">Items Sold</h6>
                                    <p class="mb-0 small text-muted">View sales records</p>
                                </div>
                                <i class="fas fa-chevron-right text-primary"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Low Stock Alerts</h5>
                        <a href="{{ route('items.index', ['stock_status' => 'low']) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye me-1"></i> View All
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;"></th>
                                        <th>Item</th>
                                        <th>Category</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lowStockItems as $item)
                                        <tr>
                                            <td>
                                                @php
                                                    $imagePath = public_path('storage/' . $item->image);
                                                    $imageUrl = (!empty($item->image) && file_exists($imagePath))
                                                        ? asset('storage/' . $item->image)
                                                        : asset('uploads/no-item.png');
                                                @endphp
                                                <img src="{{ $imageUrl }}" 
                                                    alt="{{ $item->name }}" 
                                                    class="rounded border" 
                                                    width="40" 
                                                    height="40">
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $item->name }}</strong>
                                                    <small class="d-block text-muted">SKU: {{ $item->sku }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $item->category }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{ $item->quantity }}</span> units
                                            </td>
                                            <td>
                                                @if($item->quantity < 5)
                                                    <span class="badge bg-danger">Critical</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Low</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#restockModal{{ $item->id }}">
                                                    <i class="fas fa-plus me-1"></i> Restock
                                                </button>
                                                @include('admin.restock-modal', ['item' => $item])
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                <i class="fas fa-inbox fs-4 d-block mb-2"></i>
                                                No low stock items
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Chart with real data
        const ctx = document.getElementById('inventoryChart').getContext('2d');
        
        // Fetch data from server (alternative approach)
        const chartData = {
            totalItems: {{ $totalItems }},
            lowStockCount: {{ $lowStockCount }},
            expiringSoonCount: {{ $expiringSoonCount }},
            totalItemsSold: {{ $totalItemsSold }}
        };

        // Create a bar chart instead of doughnut for better data comparison
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Items', 'Low Stock', 'Expiring Soon', 'Items Sold'],
                datasets: [{
                    label: 'Inventory Metrics',
                    data: [
                        chartData.totalItems,
                        chartData.lowStockCount,
                        chartData.expiringSoonCount,
                        chartData.totalItemsSold
                    ],
                    backgroundColor: [
                        'rgba(67, 97, 238, 0.7)',
                        'rgba(248, 150, 30, 0.7)',
                        'rgba(247, 37, 133, 0.7)',
                        'rgba(76, 201, 240, 0.7)'
                    ],
                    borderColor: [
                        'rgba(67, 97, 238, 1)',
                        'rgba(248, 150, 30, 1)',
                        'rgba(247, 37, 133, 1)',
                        'rgba(76, 201, 240, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Alternative: Time-based chart for sales data
        // This would require additional data from your controller
        @if(false) // Change to true if you want to implement time-based chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        
        // Example data - replace with actual data from your controller
        const salesData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            data: [120, 190, 170, 210, 230, 250]
        };
        
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: salesData.labels,
                datasets: [{
                    label: 'Monthly Sales',
                    data: salesData.data,
                    fill: false,
                    borderColor: 'rgba(67, 97, 238, 1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
        @endif

        // Update live date
        function updateDateTime() {
            const now = new Date();
            document.getElementById('date-display').textContent = 
                now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) + ' - ' + 
                now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        }
        setInterval(updateDateTime, 60000);
        updateDateTime();
    });
</script>
@endpush


<script>
    document.addEventListener("DOMContentLoaded", function () {
        function countUp(elementId, target) {
            const el = document.getElementById(elementId);
            let start = 0;
            const duration = 1500;
            const step = Math.max(20, Math.floor(duration / target));

            const timer = setInterval(() => {
                start++;
                el.textContent = start.toLocaleString();
                if (start >= target) clearInterval(timer);
            }, step);
        }

        countUp("totalItems", {{ $totalItems }});
        countUp("lowStockCount", {{ $lowStockCount }});
        countUp("expiringSoonCount", {{ $expiringSoonCount }});
        countUp("itemsSold", {{ $totalItemsSold }});
    });
</script>

@endsection