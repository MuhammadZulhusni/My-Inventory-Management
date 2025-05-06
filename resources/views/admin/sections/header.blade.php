<header class="navbar navbar-expand-lg fixed-top" style="background-color: #00AEEF;">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand d-flex flex-column flex-md-row align-items-start align-items-md-center" href="{{ route('dashboard') }}">
            <span class="h5 mb-0 text-white fw-bold">FamilyMart</span>
            <small class="text-white opacity-75 ms-md-2 mt-1 mt-md-0">Inventory Control</small>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mt-3 mt-lg-0 d-flex flex-column flex-lg-row align-items-start align-items-lg-center">

                <!-- Profile -->
                <li class="nav-item me-lg-3">
                    <a class="nav-link nav-fm" href="{{ route('admin.profile') }}">
                        <i class="fas fa-user-circle me-1"></i> Profile
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item mt-2 mt-lg-0">
                    <button class="btn btn-white text-danger fw-semibold rounded-pill px-3" onclick="confirmLogout()">
                        <i class="fas fa-sign-out-alt d-sm-none"></i>
                        <span class="d-none d-sm-inline">Logout</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</header>


<style>
.navbar {
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 0.6rem 1.2rem;
    font-family: 'Segoe UI', sans-serif;
}

.nav-fm {
    color: white !important;
    position: relative;
    transition: all 0.3s ease;
    font-weight: 500;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
}

.nav-fm:hover {
    background-color: #8BC53F;
    color: #fff !important;
}

.btn-white {
    background-color: #fff;
    border: none;
    transition: background-color 0.3s ease;
}

.btn-white:hover {
    background-color: #f0f0f0;
}

/* Mobile Adjustments */
@media (max-width: 991.98px) {
    .navbar-collapse {
        padding-top: 1rem;
    }
    .nav-item {
        margin-bottom: 0.5rem;
    }
    .btn-white {
        width: 100%;
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