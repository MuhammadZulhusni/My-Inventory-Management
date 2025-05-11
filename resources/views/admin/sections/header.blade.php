<header class="navbar navbar-expand-lg fixed-top fm-navbar">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand fm-brand" href="{{ route('dashboard') }}">
            <span class="fm-brand-main">FamilyMart</span>
            <span class="fm-brand-sub">Inventory Control</span>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler fm-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fm-toggler-icon"></span>
            <span class="fm-toggler-icon"></span>
            <span class="fm-toggler-icon"></span>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse fm-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto fm-nav">
                <!-- Profile -->
                <li class="nav-item fm-nav-item">
                    <a class="nav-link fm-nav-link" href="{{ route('admin.profile') }}">
                        <i class="fas fa-user-circle fm-nav-icon"></i> 
                        <span class="fm-nav-text">Profile</span>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item fm-nav-item">
                    <button class="fm-logout-btn" onclick="confirmLogout()">
                        <i class="fas fa-sign-out-alt fm-logout-icon"></i>
                        <span class="fm-logout-text">Logout</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</header>
