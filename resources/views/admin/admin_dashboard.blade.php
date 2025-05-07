<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Family Mart Inventory</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <link rel="shortcut icon" href="{{ asset('uploads/icon.jpeg') }}">

        <!-- Link to Google Fonts (Quicksand) -->
         <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">

        <!-- Bootstrap Icons CDN (for the person icon) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

        <!-- jquery.vectormap css -->
        <link href="{{asset('backend/}assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css" />

        <!-- DataTables -->
        <link href="{{asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="{{asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />  

        <!-- Bootstrap Css -->
        <link href="{{asset('backend/assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />

        <!-- Bootstrap Icons CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Icons Css -->
        <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        
        <!-- App Css-->
        <link href="{{asset('backend/assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

        <!-- CSS custom file -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <!-- CSS custom file -->
        <link href="/css/dashboard.css" rel="stylesheet">

        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/app.min.css') }}">
    </head>

    <body data-topbar="dark">
    
        <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <div id="layout-wrapper">
            @include('admin.sections.header')

            @yield('admin') 
        </div>

        <!-- end main content-->

    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{asset('backend/assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('backend/assets/libs/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{asset('backend/assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('backend/assets/libs/node-waves/waves.min.js')}}"></script>

    <!-- apexcharts -->
    <script src="{{asset('backend/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

    <!-- jquery.vectormap map -->
    <script src="{{asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{asset('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js')}}"></script>

    <!-- Required datatable js -->
    <script src="{{asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    
    <!-- Responsive examples -->
    <script src="{{asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

    <!-- Required datatable js -->
    <script src="{{asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Datatable init js -->
    <script src="{{asset('backend/assets/js/pages/datatables.init.js')}}"></script>

    <script src="{{asset('backend/assets/js/pages/dashboard.init.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('backend/assets/js/app.js')}}"></script>

    <!-- Admin Profile js -->
    <script src="{{asset('js/admin_profile.js')}}"></script>

    <!-- Add Student (Image Preview) js -->
    <script src="{{asset('js/add_student.js')}}"></script>

    <!-- Add Subject Combination -->
    <script src="{{asset('js/subject_combination.js')}}"></script>

    <!-- Add Dashboard JS file -->
    <script src="{{asset('js/dashboard.js')}}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.rawgit.com/mhuggins/countUp.js/master/dist/countUp.min.js"></script>

    <!-- Chart.js for inventory movement graph -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Show SweetAlert -->
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Try Again'
            });
        @endif
    </script>

    @if(session('swal'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '{{ session('swal')['title'] }}',
                text: '{{ session('swal')['text'] }}',
                icon: '{{ session('swal')['icon'] }}',
                showConfirmButton: {{ json_encode(session('swal')['showConfirmButton'] ?? false) }},
                timer: {{ session('swal')['timer'] ?? 2000 }},
                position: '{{ session('swal')['position'] ?? 'center' }}',
                background: '{{ session('swal')['background'] ?? '#f8f9fa' }}',
                iconColor: '{{ session('swal')['iconColor'] ?? '#28a745' }}',
                customClass: {
                    popup: 'animated bounceIn'
                }
            });
        });
    </script>
    @endif

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // For Low Stock
        var lowStock = new CountUp('.count-up[data-target]', document.querySelector('.count-up[data-target]').getAttribute('data-target'));
        lowStock.start();
        
        // For Urgent Restock
        var urgentRestock = new CountUp('.count-up[data-target]', document.querySelector('.count-up[data-target]').getAttribute('data-target'));
        urgentRestock.start();
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle delete forms with SweetAlert
        const deleteForms = document.querySelectorAll('.delete-form');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form if confirmed
                        form.submit();
                    }
                });
            });
        });

        // Show success message after deletion if session has 'success'
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
    </script>


    <style>
        body {
            padding-top: 50px;
        }
    </style>

</body>
</html>
