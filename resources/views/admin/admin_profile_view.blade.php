@extends('admin.admin_dashboard')
@section('admin')

<div class="container-fluid px-4 px-lg-5 py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-2 text-gray-900 font-weight-bold">Profile Settings</h1>
            <nav aria-label="breadcrumb" class="mt-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-primary">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-header bg-gradient-primary text-white p-4">
                    <h5 class="mb-2 text-white">Personal Information</h5>
                    <p class="mb-0 text-opacity-30">Update your profile details and password</p>
                </div>
                
                <div class="card-body p-4">
                    <form id="profileForm" action="{{ route('admin.update.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Profile Picture Section -->
                        <div class="text-center mb-4">
                            @php
                                $photo = $adminData->photo;
                                $photoPath = public_path('uploads/admin_profiles/' . $photo);
                                $imageUrl = (!empty($photo) && file_exists($photoPath)) 
                                    ? asset('uploads/admin_profiles/' . $photo) 
                                    : asset('uploads/no_image.png');
                            @endphp
                            
                            <div class="position-relative d-inline-block">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' id="image" name="photo" accept="image/*" class="d-none"/>
                                        <label for="image" class="bg-primary text-white rounded-circle shadow-sm">
                                            <i class="ri-camera-line"></i>
                                        </label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview" style="background-image: url('{{ $imageUrl }}');">
                                        </div>
                                    </div>
                                </div>
                                <h4 class="mt-3 mb-0 text-gray-900">{{ $adminData->name }}</h4>
                                <p class="text-muted">{{ $adminData->email }}</p>
                            </div>
                        </div>

                        <!-- Personal Info Section -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label text-gray-700 fw-semibold">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="ri-user-line text-gray-600"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0 ps-2" 
                                               name="name" value="{{ $adminData->name }}" placeholder="Username">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label text-gray-700 fw-semibold">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="ri-mail-line text-gray-600"></i>
                                        </span>
                                        <input type="email" class="form-control border-start-0 ps-2" 
                                               name="email" value="{{ $adminData->email }}" placeholder="Email">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Password Update Section -->
                        <div class="mt-5 pt-4 border-top">
                            <h5 class="mb-3 d-flex align-items-center text-gray-800">
                                <i class="ri-lock-password-line me-2 text-primary"></i> Password Settings
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label text-gray-700 fw-semibold">Current Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="ri-key-2-line text-gray-600"></i>
                                            </span>
                                            <input type="password" class="form-control border-start-0 ps-2 @error('current_password') is-invalid @enderror" 
                                                   name="current_password" placeholder="Current password">
                                            @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label text-gray-700 fw-semibold">New Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="ri-key-line text-gray-600"></i>
                                            </span>
                                            <input type="password" class="form-control border-start-0 ps-2 @error('new_password') is-invalid @enderror" 
                                                   name="new_password" placeholder="New password">
                                            @error('new_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label text-gray-700 fw-semibold">Confirm Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="ri-key-fill text-gray-600"></i>
                                            </span>
                                            <input type="password" class="form-control border-start-0 ps-2 @error('confirm_password') is-invalid @enderror" 
                                                   name="confirm_password" placeholder="Confirm password">
                                            @error('confirm_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info mt-3 d-flex align-items-center">
                                <i class="ri-information-line me-2 fs-5"></i> 
                                <span>Leave password fields blank if you don't want to change it.</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-3 mt-5 pt-4 border-top">
                            <button type="button" id="resetButton" class="btn btn-light px-4 rounded-pill">
                                <i class="ri-refresh-line me-2"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                <i class="ri-save-line me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        // Store original values
        const originalImage = "{{ $imageUrl }}";
        const originalName = "{{ $adminData->name }}";
        const originalEmail = "{{ $adminData->email }}";
        
        // Image preview functionality
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        $("#image").change(function() {
            readURL(this);
        });
        
        // Reset functionality
        $('#resetButton').click(function(){
            // Reset form fields
            $('#profileForm')[0].reset();
            
            // Reset image preview
            $('#imagePreview').css('background-image', 'url('+originalImage+')');
            
            // Manually reset name and email fields
            $('input[name="name"]').val(originalName);
            $('input[name="email"]').val(originalEmail);
            
            // Clear file input
            $('#image').val('');
            
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Reset complete',
                text: 'Form has been reset to original values',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#f8f9fa',
                iconColor: '#28a745'
            });
        });
        
        // Form submission handling
        $('#profileForm').submit(function(e) {
            // You can add additional validation here if needed
        });
    });
</script>

<style>
    :root {
        --primary-color: #4e73df;
        --primary-hover: #2e59d9;
        --secondary-color: #858796;
        --light-gray: #f8f9fc;
        --border-radius: 10px;
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    
    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .card-header.bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid #d1d3e2;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    .input-group-text {
        background-color: var(--light-gray);
        border-color: #d1d3e2;
        color: var(--secondary-color);
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
        transform: translateY(-1px);
    }
    
    .btn-light {
        border-radius: 50px;
        font-weight: 500;
        border: 1px solid #d1d3e2;
    }
    
    .btn-light:hover {
        background-color: #f3f4f8;
    }
    
    /* Avatar Upload Styles */
    .avatar-upload {
        position: relative;
        max-width: 140px;
        margin: 0 auto;
    }
    
    .avatar-edit {
        position: absolute;
        right: 5px;
        bottom: 5px;
        z-index: 1;
    }
    
    .avatar-edit input {
        display: none;
    }
    
    .avatar-edit label {
        display: inline-block;
        width: 36px;
        height: 36px;
        margin-bottom: 0;
        border-radius: 50%;
        background: var(--primary-color);
        border: 3px solid white;
        cursor: pointer;
        font-weight: normal;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .avatar-edit label:hover {
        background: var(--primary-hover);
        transform: scale(1.05);
    }
    
    .avatar-preview {
        width: 140px;
        height: 140px;
        position: relative;
        border-radius: 50%;
        border: 5px solid white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        background-color: #f8f9fa;
    }
    
    .avatar-preview > div {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
    
    /* Breadcrumb Styles */
    .breadcrumb {
        background: transparent;
        padding: 0;
        font-size: 0.9rem;
    }
    
    .breadcrumb-item.active {
        color: var(--secondary-color);
        font-weight: 500;
    }
    
    /* Alert Styles */
    .alert-info {
        background-color: #f0f7ff;
        border-color: #cce5ff;
        color: #004085;
        border-radius: 8px;
    }
    
    /* Form Label Styles */
    .form-label {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    /* Section Header Styles */
    h5.text-gray-800 {
        font-size: 1.1rem;
        position: relative;
        padding-bottom: 8px;
    }
    
    h5.text-gray-800:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 40px;
        height: 3px;
        background: var(--primary-color);
        border-radius: 3px;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .avatar-preview {
            width: 120px;
            height: 120px;
        }
        
        .avatar-upload {
            max-width: 120px;
        }
    }
</style>

@endsection