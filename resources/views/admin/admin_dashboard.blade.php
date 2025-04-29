<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>SRMS | Student Result Management System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <link rel="shortcut icon" href="{{asset('https://cdn-icons-png.flaticon.com/128/754/754822.png')}}">

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

        <!-- Toaster Link -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

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

    <!-- Toaster -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('backend/assets/js/code.js') }}"></script>

    <!-- Laravel Flash Message Notification with Toastr.js -->
    @if(session()->has('message'))
        <script>
            var type = "{{ session()->get('alert-type', 'info') }}";
            switch (type) {
                case 'info':
                    toastr.info("{{ session()->get('message') }}");
                    break;

                case 'success':
                    toastr.success("{{ session()->get('message') }}");
                    break;

                case 'warning':
                    toastr.warning("{{ session()->get('message') }}");
                    break;

                case 'error':
                    toastr.error("{{ session()->get('message') }}");
                    break;
            }
        </script>
    @endif
        <script>
        $(function(){
            $(document).on('click', '#delete', function (e) {
                e.preventDefault();
                var link = $(this).attr("href");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete This Data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Your file has been deleted.',
                            icon: 'success',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            },
                            timer: 1500, // Time to show success message
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = link;
                        });
                    }
                });
            });
        });
        </script>
</body>
</html>
