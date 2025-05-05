<!-- Next buat toas message -->

@extends('admin.admin_dashboard')
@section('admin')

<div class="container-fluid">
    <!-- Start Page Title -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-weight-bold text-primary">Admin Profile</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);" class="text-muted">Admin</a></li>
                        <li class="breadcrumb-item active text-primary">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <hr class="mt-2 mb-4" style="border-top: 1px dashed #e0e0e0;">

    <!-- Profile Update Section -->
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-3">
                    <div class="d-flex align-items-center">
                        <i class="ri-user-3-line fs-3 text-primary me-2"></i>
                        <div>
                            <h5 class="mb-0 text-dark">Update Admin Profile</h5>
                            <p class="text-muted mb-0">Manage your personal information and keep it up-to-date</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.update.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <!-- Username Field -->
                            <div class="col-md-6">
                                <label for="username" class="form-label fw-semibold">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary bg-opacity-10 text-primary border-end-0">
                                        <i class="ri-user-line"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" id="username" name="name" value="{{$adminData->name}}" placeholder="Enter username">
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary bg-opacity-10 text-primary border-end-0">
                                        <i class="ri-mail-line"></i>
                                    </span>
                                    <input type="email" class="form-control border-start-0" id="email" name="email" value="{{$adminData->email}}" placeholder="Enter email">
                                </div>
                            </div>

                            <!-- Photo Upload -->
                            <div class="col-12 mt-3">
                                <label for="photo" class="form-label fw-semibold">Profile Photo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary bg-opacity-10 text-primary border-end-0">
                                        <i class="ri-image-line"></i>
                                    </span>
                                    <input type="file" class="form-control border-start-0" id="image" name="photo" accept="image/*">
                                </div>

                                <!-- Image Preview -->
                                @php
                                    $photo = $adminData->photo;
                                    $photoPath = public_path('uploads/admin_profiles/' . $photo);
                                    $imageUrl = (!empty($photo) && file_exists($photoPath)) 
                                        ? asset('uploads/admin_profiles/' . $photo) 
                                        : asset('uploads/no_image.png');
                                @endphp

                                <div class="mt-4 text-center">
                                    <div class="position-relative d-inline-block">
                                        <img id="ShowImage" src="{{ $imageUrl }}" alt="Profile Photo" class="rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;">
                                        <div class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2 border border-3 border-white">
                                            <i class="ri-camera-line text-white"></i>
                                        </div>
                                    </div>
                                    <p class="text-muted mt-3">Current profile picture. Upload a new one to update.</p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-12 mt-4">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="reset" class="btn btn-outline-secondary px-4 me-md-2">
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
    // Image preview functionality
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#ShowImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    });
</script>

<style>
    .card {
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: rgba(42, 10, 69, 0.5);
        box-shadow: 0 0 0 0.25rem rgba(42, 10, 69, 0.15);
    }
    
    .input-group-text {
        transition: all 0.3s ease;
    }
    
    .input-group:focus-within .input-group-text {
        background-color: rgba(42, 10, 69, 0.8) !important;
        color: white !important;
    }
    
    .breadcrumb-item.active {
        font-weight: 500;
    }
</style>

@endsection