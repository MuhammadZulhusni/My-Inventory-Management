@extends('admin.admin_dashboard')

@section('admin')

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
    $itemsSoldThisWeek = Sale::where('sold_at', '>=', Carbon::now()->startOfWeek())->sum('quantity_sold');
@endphp

@if(request('stock_status') == 'low')
    <h4 class="mb-4 text-warning">Low Stock Items (quantity < 10)</h4>
@elseif(request('stock_status') == 'critical')
    <h4 class="mb-4 text-danger">Urgent Restock Items (quantity < 5)</h4>
@endif


<div class="container-fluid">
    <div class="w-100">
        <!-- Header with FamilyMart-style branding -->
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between py-2 animate__animated animate__fadeIn">
                    <div class="d-flex align-items-center">
                        <div class="bg-white rounded-circle p-1 me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            @php
                                $photo = $adminData->photo;
                                $photoPath = public_path('uploads/admin_profiles/' . $photo);
                                $imageUrl = (!empty($photo) && file_exists($photoPath)) 
                                    ? asset('uploads/admin_profiles/' . $photo) 
                                    : asset('uploads/no_image.png');
                            @endphp
                            <img src="{{ $imageUrl }}" alt="User Avatar" 
                                class="rounded-circle border border-white" 
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>

                        <div>
                            <h1 class="h4 mb-2 mt-4 text-dark" style="font-weight: 700;">INVENTORY CONTROL</h1>
                            <nav class="text-xs text-muted">
                                <span>Dashboard</span> <i class="fas fa-chevron-right mx-1" style="font-size: 0.5rem"></i> 
                                <span class="text-primary">Overview</span>
                            </nav>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-white rounded p-2 shadow-sm border animate__animated animate__fadeInRight d-flex align-items-center">
                            <i class="fas fa-store me-2 text-success" style="font-size: 0.9rem;"></i>
                            <span class="fw-semibold" style="font-size: 0.9rem;">Store #{{ rand(1000,9999) }}</span>
                        </div>
                        <div class="bg-white rounded p-2 shadow-sm border animate__animated animate__fadeInRight">
                            <span id="date-display" class="fw-semibold" style="font-size: 0.9rem;">{{ now()->format('m/d (D) H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Cards (FamilyMart blue/green color scheme) -->
        <div class="row mt-4 g-3">
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0068b7;">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2" style="font-size: 0.8rem;">TOTAL ITEMS</h6>
                                <h3 class="mb-0 count-up" data-target="{{ $totalItems }}">0</h3>
                            </div>
                            <div class="bg-blue-50 p-2 rounded" style="background-color: #e6f2ff;">
                                <i class="fas fa-boxes text-primary" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-top">
                            <small class="{{ $growth >= 0 ? 'text-success' : 'text-danger' }}">
                                <i class="fas {{ $growth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i> 
                                <span class="count-up" data-target="{{ $growth }}">0</span>% from last week
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #00a650;">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2" style="font-size: 0.8rem;">LOW STOCK</h6>
                                <h3 class="mb-0 count-up" data-target="{{ $lowStockCount }}">0</h3>
                            </div>
                            <div class="bg-green-50 p-2 rounded" style="background-color: #e6f7ed;">
                                <i class="fas fa-exclamation-triangle text-success" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-top">
                            <small class="text-danger">
                                <i class="fas fa-clock"></i> <span class="count-up" data-target="{{ $urgentRestockCount }}">0</span> need urgent restock
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expiring Soon Section -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #ff8200;">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2" style="font-size: 0.8rem;">EXPIRING SOON</h6>
                                <h3 class="mb-0 count-up" data-target="{{ $expiringSoonCount }}">0</h3>
                            </div>
                            <div class="bg-orange-50 p-2 rounded" style="background-color: #fff5e6;">
                                <i class="fas fa-hourglass-half text-warning" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-top">
                            <small class="text-warning">
                                <i class="fas fa-calendar-week"></i> Next 7 days
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #22c55e;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2" style="font-size: 0.8rem;">ITEM SOLD</h6>
                            <h3 class="mb-0 count-up" data-target="{{ $totalItemsSold }}">0</h3>
                        </div>
                        <div class="p-2 rounded" style="background-color: #dcfce7;">
                            <i class="fas fa-shopping-cart text-success" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                <div class="mt-2 pt-2 border-top">
                <small class="text-muted">
                    {{ $itemsSoldThisWeek }} sold this week
                </small>
            </div>
        </div>
    </div>
</div>

        </div>

        <!-- Main Content Area -->
        <div class="row mt-4">
        <!-- Inventory Summary Chart -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="font-weight: 600;">Inventory Movement</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="chartDropdown" data-bs-toggle="dropdown">
                                Last 30 Days
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                                <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                                <li><a class="dropdown-item" href="#">Last 90 Days</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="inventoryChart" height="250"></canvas>
                </div>
            </div>
        </div>
            
        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3 d-flex align-items-center">
                    <h5 class="mb-0" style="font-weight: 600;">
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body p-3">
                    <div class="d-grid gap-3">
                        <!-- Add New Item -->
                        <a href="{{ route('items.index') }}" class="quick-action-card bg-primary bg-opacity-10 text-primary">
                            <div class="action-icon bg-primary text-white">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="action-content">
                                <h6 class="mb-1 fw-semibold">Total Items</h6>
                                <p class="mb-0 small text-muted">Add a new item</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>

                        <!-- Low Stock -->
                        <a href="{{ route('items.index', ['stock_status' => 'low']) }}" class="quick-action-card bg-warning bg-opacity-10 text-warning">
                            <div class="action-icon bg-warning text-white">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="action-content">
                                <h6 class="mb-1 fw-semibold">Low Stock</h6>
                                <p class="mb-0 small text-muted">{{ $lowStockCount }} items need attention</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>

                        <!-- Urgent Restock -->
                        <a href="{{ route('items.index', ['stock_status' => 'critical', 'urgent' => 'true']) }}" class="quick-action-card bg-danger bg-opacity-10 text-danger">
                            <div class="action-icon bg-danger text-white">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div class="action-content">
                                <h6 class="mb-1 fw-semibold">Urgent Restock</h6>
                                <p class="mb-0 small text-muted">{{ $urgentRestockCount }} items critically low</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>

                        <!-- Expiring Soon -->
                        <a href="{{ route('items.index') }}?expiring=soon&expire=true" class="quick-action-card bg-danger bg-opacity-10 text-danger">
                            <div class="action-icon bg-danger text-white">
                                <i class="fas fa-hourglass-end"></i>
                            </div>
                            <div class="action-content">
                                <h6 class="mb-1 fw-semibold">Expiring Soon</h6>
                                <p class="mb-0 small text-muted">{{ $expiringSoonCount }} items expiring</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>

                        <!-- Item Sold -->
                        <a href="{{ route('items.sold') }}" class="quick-action-card bg-primary bg-opacity-10 text-primary">
                            <div class="action-icon bg-primary text-white">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="action-content">
                                <h6 class="mb-1 fw-semibold">Item Sold</h6>
                                <p class="mb-0 small text-muted">Check total items sold</p>
                            </div>
                            <div class="action-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        </div>

        <!-- Low Stock Alerts -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="font-weight: 600;">Low Stock Alerts</h5>
                        <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="width: 50px;"></th>
                                        <th>Item</th>
                                        <th>Category</th>
                                        <th>Current Stock</th>
                                        <th>Threshold</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img src="{{ asset('uploads/products/chocolate-milk.png') }}" width="40" height="40" class="rounded"></td>
                                        <td>Chocolate Milk 250ml</td>
                                        <td>Beverages</td>
                                        <td>3</td>
                                        <td>12</td>
                                        <td><span class="badge bg-danger">Critical</span></td>
                                        <td><button class="btn btn-sm btn-outline-primary">Order</button></td>
                                    </tr>
                                    <tr>
                                        <td><img src="{{ asset('uploads/products/egg-sandwich.png') }}" width="40" height="40" class="rounded"></td>
                                        <td>Egg Sandwich</td>
                                        <td>Food</td>
                                        <td>5</td>
                                        <td>15</td>
                                        <td><span class="badge bg-warning">Low</span></td>
                                        <td><button class="btn btn-sm btn-outline-primary">Order</button></td>
                                    </tr>
                                    <tr>
                                        <td><img src="{{ asset('uploads/products/ice-cream.png') }}" width="40" height="40" class="rounded"></td>
                                        <td>Vanilla Ice Cream</td>
                                        <td>Frozen</td>
                                        <td>2</td>
                                        <td>10</td>
                                        <td><span class="badge bg-danger">Critical</span></td>
                                        <td><button class="btn btn-sm btn-outline-primary">Order</button></td>
                                    </tr>
                                    <tr>
                                        <td><img src="{{ asset('uploads/products/water-bottle.png') }}" width="40" height="40" class="rounded"></td>
                                        <td>Mineral Water 500ml</td>
                                        <td>Beverages</td>
                                        <td>8</td>
                                        <td>20</td>
                                        <td><span class="badge bg-warning">Low</span></td>
                                        <td><button class="btn btn-sm btn-outline-primary">Order</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection