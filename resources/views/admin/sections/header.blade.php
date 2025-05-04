<header class="navbar navbar-expand-lg navbar-dark" style="background-color: #2563EB;">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand d-flex flex-column flex-md-row align-items-start align-items-md-center" href="#">
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

                <!-- Profile Dropdown -->
                <li class="nav-item dropdown w-100 w-lg-auto">
                    <a class="nav-link dropdown-toggle text-light hover-effect d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i>
                        <span>Profile</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="#">Update Profile</a></li>
                        <li><a class="dropdown-item" href="#">Change Password</a></li>
                    </ul>
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

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-4">Are you sure you want to log out?</p>
                    <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger me-2">Yes, Logout</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>


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

    .dropdown-menu {
        animation: fadeIn 0.3s ease;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px);}
        to { opacity: 1; transform: translateY(0);}
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
    var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
    logoutModal.show();
}
</script>


