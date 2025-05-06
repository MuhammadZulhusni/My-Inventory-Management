@extends('admin.admin_dashboard')
@section('admin')

<div class="container-fluid">
    <div class="w-100">
        <!-- Header with FamilyMart-style branding -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between py-2 animate__animated animate__fadeIn">
                    <div class="d-flex align-items-center">
                        <div class="bg-white rounded-circle p-2 me-3 shadow-sm" style="width: 50px; height: 50px;">
                            <img src="{{ asset('uploads/familymart-logo.png') }}" alt="FamilyMart" class="img-fluid">
                        </div>
                        <div>
                            <h1 class="h4 mb-0 text-dark" style="font-weight: 700;">INVENTORY CONTROL</h1>
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
                                <h3 class="mb-0 count-up" data-target="15423">0</h3>
                            </div>
                            <div class="bg-blue-50 p-2 rounded" style="background-color: #e6f2ff;">
                                <i class="fas fa-boxes text-primary" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-top">
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> <span class="count-up" data-target="12">0</span>% from last month
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
                                <h3 class="mb-0 count-up" data-target="127">0</h3>
                            </div>
                            <div class="bg-green-50 p-2 rounded" style="background-color: #e6f7ed;">
                                <i class="fas fa-exclamation-triangle text-success" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-top">
                            <small class="text-danger">
                                <i class="fas fa-clock"></i> <span class="count-up" data-target="23">0</span> need urgent restock
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #ff8200;">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2" style="font-size: 0.8rem;">EXPIRING SOON</h6>
                                <h3 class="mb-0 count-up" data-target="58">0</h3>
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
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #e31937;">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2" style="font-size: 0.8rem;">SUPPLIERS</h6>
                                <h3 class="mb-0 count-up" data-target="24">0</h3>
                            </div>
                            <div class="bg-red-50 p-2 rounded" style="background-color: #fde8ea;">
                                <i class="fas fa-truck text-danger" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-top">
                            <small class="text-muted">
                                <span class="count-up" data-target="8">0</span> primary suppliers
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
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0" style="font-weight: 600;">Quick Actions</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary text-start py-3 d-flex align-items-center">
                                <i class="fas fa-barcode me-3" style="font-size: 1.2rem;"></i>
                                <div>
                                    <div style="font-weight: 600;">Scan New Item</div>
                                    <small class="opacity-75">Add inventory via barcode</small>
                                </div>
                            </button>
                            
                            <button class="btn btn-success text-start py-3 d-flex align-items-center">
                                <i class="fas fa-clipboard-list me-3" style="font-size: 1.2rem;"></i>
                                <div>
                                    <div style="font-weight: 600;">Stock Count</div>
                                    <small class="opacity-75">Perform inventory audit</small>
                                </div>
                            </button>
                            
                            <button class="btn btn-warning text-start py-3 d-flex align-items-center">
                                <i class="fas fa-exchange-alt me-3" style="font-size: 1.2rem;"></i>
                                <div>
                                    <div style="font-weight: 600;">Transfer Items</div>
                                    <small class="opacity-75">Move between locations</small>
                                </div>
                            </button>
                            
                            <button class="btn btn-danger text-start py-3 d-flex align-items-center">
                                <i class="fas fa-trash-alt me-3" style="font-size: 1.2rem;"></i>
                                <div>
                                    <div style="font-weight: 600;">Waste Log</div>
                                    <small class="opacity-75">Record damaged/expired</small>
                                </div>
                            </button>
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

<style>
    /* FamilyMart Color Scheme */
    .bg-primary { background-color: #0068b7 !important; }
    .bg-success { background-color: #00a650 !important; }
    .bg-danger { background-color: #e31937 !important; }
    .bg-warning { background-color: #ff8200 !important; }
    
    .btn-primary { background-color: #0068b7; border-color: #0068b7; }
    .btn-success { background-color: #00a650; border-color: #00a650; }
    .btn-danger { background-color: #e31937; border-color: #e31937; }
    .btn-warning { background-color: #ff8200; border-color: #ff8200; }
    
    .text-primary { color: #0068b7 !important; }
    .text-success { color: #00a650 !important; }
    .text-danger { color: #e31937 !important; }
    .text-warning { color: #ff8200 !important; }
    
    /* Card styling */
    .card {
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    
    .card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    /* Table styling */
    .table th {
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    /* Badge styling */
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
    }
    
    /* Button hover effects */
    .btn {
        transition: all 0.2s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
    }
</style>

<!-- Chart.js for inventory movement graph -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Count-up animation
    const countUpElements = document.querySelectorAll('.count-up');
    countUpElements.forEach(el => {
        const target = parseInt(el.getAttribute('data-target'));
        let count = 0;
        const duration = 1000;
        const increment = target / (duration / 16);
        
        const updateCount = () => {
            count += increment;
            if (count < target) {
                el.textContent = Math.floor(count);
                requestAnimationFrame(updateCount);
            } else {
                el.textContent = target;
            }
        };
        
        updateCount();
    });
    
    // Inventory Movement Chart
    const ctx = document.getElementById('inventoryChart').getContext('2d');
    const inventoryChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan 1', 'Jan 5', 'Jan 10', 'Jan 15', 'Jan 20', 'Jan 25', 'Jan 30'],
            datasets: [
                {
                    label: 'Items Received',
                    data: [120, 190, 170, 210, 180, 220, 240],
                    borderColor: '#00a650',
                    backgroundColor: 'rgba(0, 166, 80, 0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Items Sold',
                    data: [80, 150, 140, 180, 160, 200, 210],
                    borderColor: '#0068b7',
                    backgroundColor: 'rgba(0, 104, 183, 0.1)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

@endsection