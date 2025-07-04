@extends('admin.admin_dashboard')

@section('admin')

@push('styles')
    <link href="{{ asset('css/adminProfile.css') }}" rel="stylesheet" />
@endpush

<div class="container-fluid px-4 px-lg-5 py-5 mt-3"> 
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="h3 mb-2 text-gray-900 fw-bold">Profile Settings</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
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
                    <p class="mb-0 opacity-75">Update your profile details and password</p>
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

                                <!-- Display validation error for photo -->
                                @error('photo')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Profile Updated!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    </script>
@endif
@endsection