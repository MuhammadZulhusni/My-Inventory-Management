<header class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #2563EB;">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand d-flex flex-column flex-md-row align-items-start align-items-md-center" href="{{ route('dashboard') }}">
            <span class="h5 mb-0 text-white">StockMaster</span>
            <small class="text-light opacity-75 ms-md-2 mt-1 mt-md-0">Inventory Control</small>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mt-3 mt-lg-0 d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
                
                <!-- Products Link -->
                <li class="nav-item me-lg-3">
                    <a class="nav-link text-light hover-effect" href="#">
                        <i class="fas fa-boxes me-1"></i>
                        <span>Products</span>
                    </a>
                </li>

                <!-- Add Product Link -->
                <li class="nav-item me-lg-3">
                    <a class="nav-link text-light hover-effect" href="#">
                        <i class="fas fa-plus-circle me-1"></i>
                        <span>Add Product</span>
                    </a>
                </li>

                <!-- Profile Link -->
                <li class="nav-item">
                    <a class="nav-link text-light hover-effect d-flex align-items-center" href="{{ route('admin.profile') }}">
                        <i class="fas fa-user-circle me-1"></i>
                        <span>Profile</span>
                    </a>
                </li>

                <!-- Logout Button -->
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <button class="btn btn-light text-danger fw-bold" onclick="confirmLogout()">
                        <i class="fas fa-sign-out-alt d-sm-none"></i>
                        <span class="d-none d-sm-inline">Logout</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</header>

<!-- Include SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .hover-effect {
        transition: all 0.3s ease;
        position: relative;
        padding: 0.5rem 1rem;
    }

    .hover-effect:hover {
        color: #fff !important;
        transform: translateY(-2px);
    }

    .hover-effect::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 1rem;
        width: calc(100% - 2rem);
        height: 2px;
        background: #fff;
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .hover-effect:hover::after {
        transform: scaleX(1);
    }

    .navbar {
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        padding: 0.5rem 1rem;
    }

    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            padding-top: 1rem;
        }
        .nav-item {
            margin-bottom: 0.5rem;
        }
        .btn-light {
            width: 100%;
            margin-left: 0 !important;
        }
    }

    @media (min-width: 768px) {
        .navbar-brand small {
            display: block !important;
        }
    }
    @media (max-width: 767.98px) {
        .navbar-brand span.h5 {
            font-size: 1.25rem;
        }
        .navbar-brand small {
            font-size: 0.8rem;
        }
        .navbar-collapse {
            padding-top: 1rem;
        }
        .nav-item {
            width: 100%;
        }
        .btn-light {
            font-size: 1rem;
            padding: 0.5rem;
        }
    }
</style>

<script>
function confirmLogout() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to log out from the system!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563EB',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Logout!',
        cancelButtonText: 'Cancel',
        background: '#ffffff',
        backdrop: `
            rgba(0,0,0,0.4)
            url("{{ asset('images/logout-animation.gif') }}")
            left top
            no-repeat
        `
    }).then((result) => {
        if (result.isConfirmed) {
            // Create a hidden form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('logout') }}';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>