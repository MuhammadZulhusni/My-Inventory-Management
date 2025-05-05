@extends('admin.admin_dashboard')
@section('admin')

<div class="container-fluid px-4 mt-4">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div class="mb-3 mb-md-0">
                    <h1 class="h3 mb-1 text-gray-800">Admin Profile</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Admin</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <!-- Profile Picture -->
                        @php
                            $photo = $adminData->photo;
                            $photoPath = public_path('uploads/admin_profiles/' . $photo);
                            $imageUrl = (!empty($photo) && file_exists($photoPath)) 
                                ? asset('uploads/admin_profiles/' . $photo) 
                                : asset('uploads/no_image.png');
                            $originalImage = $imageUrl;
                        @endphp
                        
                        <div class="position-relative d-inline-block mb-3">
                            <img id="ShowImage" src="{{ $imageUrl }}" alt="Profile Photo" 
                                 class="rounded-circle shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                            <label for="image" class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow-sm cursor-pointer">
                                <i class="ri-camera-line text-primary"></i>
                                <input type="file" id="image" name="photo" accept="image/*" class="d-none">
                            </label>
                        </div>
                        <h4 class="mb-1">{{ $adminData->name }}</h4>
                        <p class="text-muted mb-0">{{ $adminData->email }}</p>
                    </div>

                    <form id="profileForm" action="{{ route('admin.update.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Username Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="username" name="name" 
                                           value="{{ $adminData->name }}" placeholder="Username">
                                    <label for="username" class="text-muted">
                                        <i class="ri-user-line me-1"></i> Username
                                    </label>
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ $adminData->email }}" placeholder="Email Address">
                                    <label for="email" class="text-muted">
                                        <i class="ri-mail-line me-1"></i> Email Address
                                    </label>
                                </div>
                            </div>

                            <!-- Password Update Section -->
                            <div class="col-12 mt-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body p-4">
                                        <h5 class="mb-3 d-flex align-items-center">
                                            <i class="ri-lock-line me-2 text-primary"></i> Password Update
                                        </h5>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="password" class="form-control" id="current_password" 
                                                           name="current_password" placeholder="Current Password">
                                                    <label for="current_password">Current Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="password" class="form-control" id="new_password" 
                                                           name="new_password" placeholder="New Password">
                                                    <label for="new_password">New Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="password" class="form-control" id="confirm_password" 
                                                           name="confirm_password" placeholder="Confirm Password">
                                                    <label for="confirm_password">Confirm Password</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" id="resetButton" class="btn btn-outline-secondary px-4">
                                        <i class="ri-refresh-line me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="ri-save-line me-1"></i> Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        // Store original image source
        const originalImage = "{{ $originalImage }}";
        const originalName = "{{ $adminData->name }}";
        const originalEmail = "{{ $adminData->email }}";
        
        // Image preview functionality
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#ShowImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
        
        // Reset functionality
        $('#resetButton').click(function(){
            // Reset form fields
            $('#profileForm')[0].reset();
            
            // Reset image preview
            $('#ShowImage').attr('src', originalImage);
            
            // Manually reset name and email fields (since they're pre-populated)
            $('#username').val(originalName);
            $('#email').val(originalEmail);
            
            // Clear file input
            $('#image').val('');
            
            // Show success message
            toastr.success('Form has been reset to original values');
        });
    });
</script>

<style>
    body {
        background-color: #f5f7fa;
    }
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.03);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px rgba(0,0,0,0.05);
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 12px 16px;
        border: 1px solid #e0e0e0;
    }
    .form-control:focus, .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .form-floating label {
        color: #6b7280;
    }
    .form-floating>.form-control:focus~label, 
    .form-floating>.form-control:not(:placeholder-shown)~label {
        color: #6366f1;
    }
    .btn-primary {
        background-color: #6366f1;
        border-color: #6366f1;
        padding: 10px 20px;
        border-radius: 8px;
    }
    .btn-primary:hover {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>

@endsection