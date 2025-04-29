@extends('admin.admin_dashboard')
@section('admin')

<div class="container-fluid">
    <div class="w-100">

        <!-- Page Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between py-3 animate__animated animate__fadeIn">
                    <div>
                        <h1 class="h3 mb-2">Inventory Overview</h1>
                        <nav class="text-sm text-muted">
                            <span>Inventory Control</span> <i class="fas fa-chevron-right mx-2" style="font-size: 0.6rem"></i> 
                            <span class="text-purple-600">Dashboard</span>
                        </nav>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white rounded-lg p-3 shadow-sm border animate__animated animate__fadeInRight">
                            <i class="fas fa-calendar-alt text-purple-600 me-2"></i>
                            <span id="date-display" class="fw-semibold">{{ now()->format('F j, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Section with Animations -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary border-0 overflow-hidden position-relative animate__animated animate__fadeInUp" style="min-height: 220px;">
                    <!-- Animated floating circles -->
                    <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden">
                        <div class="floating-circle" style="top: 20%; left: 10%; width: 80px; height: 80px; animation-delay: 0s;"></div>
                        <div class="floating-circle" style="top: 60%; left: 80%; width: 120px; height: 120px; animation-delay: 2s;"></div>
                        <div class="floating-circle" style="top: 30%; left: 60%; width: 60px; height: 60px; animation-delay: 4s;"></div>
                    </div>
                    
                    <div class="card-body p-4 p-lg-5 position-relative z-index-1">
                        <div class="row align-items-center">
                            <div class="col-md-7 text-white">
                                <div class="mb-4 pe-lg-4">
                                    <h2 class="display-5 fw-bold mb-3 animate__animated animate__fadeInLeft text-white">Welcome back, {{ Auth::user()->name }}!</h2>
                                    <p class="lead mb-4 opacity-90 animate__animated animate__fadeInLeft animate__delay-1s" style="font-size: 1.15rem;">
                                        Your inventory is <span class="fw-bold">98% optimized</span> with 
                                        <span class="fw-bold">127 items</span> needing attention
                                    </p>
                                    <div class="d-flex flex-wrap gap-3">
                                        <button class="btn btn-light btn-lg px-4 rounded-pill fw-medium d-flex align-items-center hover-scale">
                                            <i class="fas fa-boxes me-2"></i> Manage Stock
                                        </button>
                                        <button class="btn btn-outline-light btn-lg px-4 rounded-pill fw-medium d-flex align-items-center hover-scale">
                                            <i class="fas fa-chart-line me-2"></i> View Analytics
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 d-none d-md-block">
                                <div class="position-relative animate__animated animate__fadeIn animate__delay-1s" style="height: 200px;">
                                    <div class="position-absolute floating" style="right: 0; bottom: 0; width: 300px; height: 250px;">
                                        <img src="{{ asset('uploads/dashboard-inventory.png') }}" 
                                            class="img-fluid h-100" 
                                            alt="Inventory Illustration"
                                            style="object-fit: contain; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Performance indicator with loading animation -->
                    <div class="position-absolute bottom-0 start-0 w-100 px-4 pb-3">
                        <div class="d-flex align-items-center">
                            <div class="text-white me-3" style="font-size: 0.85rem;">Inventory Health:</div>
                            <div class="progress flex-grow-1" style="height: 6px; background: rgba(255,255,255,0.2);">
                                <div class="progress-bar bg-white progress-bar-animated" role="progressbar" style="width: 0%; animation: loadProgress 1.5s ease-out forwards;" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="text-white ms-3 fw-bold count-up" style="font-size: 0.85rem;" data-target="98">0%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory Stats Cards with Hover Animations -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-hover h-100 hover-grow">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-purple-50 p-3 rounded-4 me-3 icon-pulse">
                                <i class="fas fa-box fa-2x text-purple-600"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Total Products</h6>
                                <h2 class="mb-0 count-up" data-target="15423">0</h2>
                                <small class="text-success"><i class="fas fa-arrow-up"></i> <span class="count-up" data-target="12">0</span>% from last month</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-hover h-100 hover-grow">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-orange-50 p-3 rounded-4 me-3 icon-pulse">
                                <i class="fas fa-tags fa-2x text-orange-600"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Categories</h6>
                                <h2 class="mb-0 count-up" data-target="24">0</h2>
                                <small class="text-muted"><span class="count-up" data-target="8">0</span> active categories</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-hover h-100 hover-grow">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-red-50 p-3 rounded-4 me-3 icon-pulse">
                                <i class="fas fa-exclamation-triangle fa-2x text-red-600"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Low Stock</h6>
                                <h2 class="mb-0 count-up" data-target="127">0</h2>
                                <small class="text-danger"><i class="fas fa-arrow-down"></i> <span class="count-up" data-target="23">0</span>% need restock</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-hover h-100 hover-grow">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-green-50 p-3 rounded-4 me-3 icon-pulse">
                                <i class="fas fa-truck fa-2x text-green-600"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Suppliers</h6>
                                <h2 class="mb-0 count-up" data-target="58">0</h2>
                                <small class="text-success"><i class="fas fa-check"></i> <span class="count-up" data-target="42">0</span> active</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* Base Styles */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 16px;
    }

    /* Hover Effects */
    .shadow-hover:hover {
        box-shadow: 0 12px 24px rgba(124, 58, 237, 0.1) !important;
    }
    
    .hover-grow {
        transition: transform 0.3s ease;
    }
    .hover-grow:hover {
        transform: scale(1.03);
    }
    
    .hover-scale {
        transition: transform 0.2s ease;
    }
    .hover-scale:hover {
        transform: scale(1.05);
    }

    /* Backgrounds */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%);
    }

    .bg-purple-50 { background-color: #F5F3FF; }
    .bg-orange-50 { background-color: #FFF7ED; }
    .bg-red-50 { background-color: #FEF2F2; }
    .bg-green-50 { background-color: #F0FDF4; }
    
    .text-purple-600 { color: #6366F1; }
    .text-orange-600 { color: #F97316; }
    .text-red-600 { color: #EF4444; }
    .text-green-600 { color: #22C55E; }

    .btn-light {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .rounded-4 { border-radius: 12px; }

    /* Animations */
    .floating {
        animation: floating 6s ease-in-out infinite;
    }
    
    .floating-circle {
        position: absolute;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        animation: floating 8s ease-in-out infinite;
    }
    
    .icon-pulse {
        animation: pulse 2s infinite;
    }
    
    .progress-bar-animated {
        animation: loadProgress 1.5s ease-out forwards;
    }
    
    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    
    @keyframes loadProgress {
        from { width: 0%; }
        to { width: 98%; }
    }
</style>

<!-- Add Animate.css for entrance animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<script>
// Count-up animation for statistics
document.addEventListener('DOMContentLoaded', function() {
    const countUpElements = document.querySelectorAll('.count-up');
    
    const animateCountUp = (element) => {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 1500; // 1.5 seconds
        const step = target / (duration / 16); // 60fps
        
        let current = 0;
        const increment = () => {
            current += step;
            if (current < target) {
                element.textContent = Math.floor(current);
                requestAnimationFrame(increment);
            } else {
                element.textContent = target + (element.textContent.includes('%') ? '%' : '');
            }
        };
        
        increment();
    };
    
    // Intersection Observer to trigger animations when elements come into view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCountUp(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    countUpElements.forEach(element => {
        observer.observe(element);
    });
});
</script>

@endsection