<header class="navbar navbar-expand-md navbar-dark" style="background-color: #2563EB;">
    <div class="container-fluid">
        <!-- Brand/Name -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <div class="d-none d-md-block">
                <span class="h4 mb-0 text-white">StockMaster Pro</span>
                <small class="d-block text-light opacity-75">Inventory Control System</small>
            </div>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                
                <!-- Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-light hover-effect" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i>
                        Profile
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="#">Update Profile</a></li>
                        <li><a class="dropdown-item" href="#">Change Password</a></li>
                    </ul>
                </li>

                <!-- Logout Button -->
                <li class="nav-item">
                    <button class="btn btn-light text-red-500 fw-bold ms-3" onclick="confirmLogout()">
                        Logout
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


<!-- Letak sini jap -->
<style>
    .hover-effect {
        transition: all 0.3s ease;
        position: relative;
    }

    .hover-effect:hover {
        color: #fff !important;
        transform: translateY(-2px);
    }

    .hover-effect::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background: #fff;
        transition: width 0.3s ease;
    }

    .hover-effect:hover::after {
        width: 100%;
    }

    .navbar {
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        padding: 0.5rem 1rem;
    }

    .dropdown-menu {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px);}
        to { opacity: 1; transform: translateY(0);}
    }
</style>

<script>
function confirmLogout() {
    var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
    logoutModal.show();
}
</script>

