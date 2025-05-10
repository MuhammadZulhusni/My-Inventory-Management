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

<style>
:root {
    --fm-primary: #00AEEF;
    --fm-secondary: #8BC53F;
    --fm-white: #ffffff;
    --fm-light: #f8f9fa;
    --fm-dark: #212529;
    --fm-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    --fm-transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

/* Navbar Base Styles */
.fm-navbar {
    background-color: var(--fm-primary);
    box-shadow: var(--fm-shadow);
    padding: 0.5rem 1.5rem;
    font-family: 'Poppins', 'Segoe UI', sans-serif;
    transition: var(--fm-transition);
    z-index: 1030;
}

/* Brand Styles */
.fm-brand {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    padding: 0.5rem 0;
}

.fm-brand-main {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--fm-white);
    line-height: 1.2;
    transition: var(--fm-transition);
}

.fm-brand-sub {
    font-size: 0.75rem;
    font-weight: 400;
    color: rgba(255, 255, 255, 0.85);
    margin-top: 0.1rem;
    transition: var(--fm-transition);
}

/* Navigation Items */
.fm-nav {
    gap: 0.5rem;
}

.fm-nav-item {
    position: relative;
}

.fm-nav-link {
    color: var(--fm-white) !important;
    font-weight: 500;
    padding: 0.5rem 1rem !important;
    border-radius: 8px;
    transition: var(--fm-transition);
    display: flex;
    align-items: center;
    position: relative;
}

.fm-nav-link:hover, .fm-nav-link:focus {
    background-color: var(--fm-secondary);
    transform: translateY(-2px);
}

.fm-nav-icon {
    margin-right: 0.5rem;
    font-size: 1.1rem;
}

/* Logout Button */
.fm-logout-btn {
    background-color: var(--fm-white);
    color: #dc3545 !important;
    font-weight: 600;
    border: none;
    border-radius: 50px;
    padding: 0.5rem 1.25rem;
    transition: var(--fm-transition);
    display: flex;
    align-items: center;
    cursor: pointer;
}

.fm-logout-btn:hover {
    background-color: #f0f0f0;
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.fm-logout-icon {
    margin-right: 0.5rem;
    display: inline-block;
}

/* Toggler Styles */
.fm-toggler {
    border: none !important;
    padding: 0.5rem;
    box-shadow: none !important;
}

.fm-toggler-icon {
    display: block;
    width: 24px;
    height: 2px;
    background-color: var(--fm-white);
    margin: 5px 0;
    transition: var(--fm-transition);
    position: relative;
}

/* Animation for toggler when active */
.navbar-toggler[aria-expanded="true"] .fm-toggler-icon:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}

.navbar-toggler[aria-expanded="true"] .fm-toggler-icon:nth-child(2) {
    opacity: 0;
}

.navbar-toggler[aria-expanded="true"] .fm-toggler-icon:nth-child(3) {
    transform: rotate(-45deg) translate(5px, -5px);
}

/* Mobile Adjustments */
@media (max-width: 991.98px) {
    .fm-navbar {
        padding: 0.5rem 1rem;
    }
    
    .fm-collapse {
        padding: 1rem 0;
        background-color: var(--fm-primary);
        border-radius: 0 0 12px 12px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .fm-nav {
        gap: 0.75rem;
    }
    
    .fm-nav-item {
        width: 100%;
    }
    
    .fm-nav-link {
        padding: 0.75rem 1rem !important;
    }
    
    .fm-logout-btn {
        width: 100%;
        justify-content: center;
        padding: 0.75rem;
    }
    
    .fm-brand {
        flex-direction: row;
        align-items: center;
    }
    
    .fm-brand-sub {
        margin-top: 0;
        margin-left: 0.75rem;
    }
}

/* Desktop Adjustments */
@media (min-width: 992px) {
    .fm-brand {
        flex-direction: row;
        align-items: center;
    }
    
    .fm-brand-sub {
        margin-top: 0;
        margin-left: 0.75rem;
    }
    
    .fm-nav-link::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%) scaleX(0);
        width: 20px;
        height: 2px;
        background-color: var(--fm-secondary);
        transition: var(--fm-transition);
    }
    
    .fm-nav-link:hover::after {
        transform: translateX(-50%) scaleX(1);
    }
}

/* Animation for navbar items */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.fm-nav-item {
    animation: fadeIn 0.4s ease forwards;
}

.fm-nav-item:nth-child(1) { animation-delay: 0.1s; }
.fm-nav-item:nth-child(2) { animation-delay: 0.2s; }
</style>

<script>
function confirmLogout() {
    Swal.fire({
        title: 'Ready to leave?',
        text: "You're about to sign out from the system.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#00AEEF',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Logout',
        cancelButtonText: 'Cancel',
        background: '#ffffff',
        backdrop: `
            rgba(0,174,239,0.1)
            url("{{ asset('images/logout-animation.gif') }}")
            left top
            no-repeat
        `,
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        }
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