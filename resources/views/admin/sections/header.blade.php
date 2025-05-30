<header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top py-2">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand d-flex flex-column fw-bold text-primary" href="{{ route('dashboard') }}">
            <span class="fs-5">Inventory</span>
            <small class="text-muted fw-normal">Management System</small>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse justify-content-end" id="mainNav">
            <ul class="navbar-nav align-items-lg-center gap-2">
                <!-- Profile -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ route('admin.profile') }}">
                        <i class="fas fa-user-circle me-2"></i> 
                        <span>Profile</span>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <button class="btn btn-outline-danger d-flex align-items-center" onclick="confirmLogout()">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        <span>Logout</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</header>
