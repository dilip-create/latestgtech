<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{ $title ?? 'PAYMENT GATEWAY' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::to('newassets/images/favicon.ico') }}">
    <!-- App css -->
    <link href="{{ URL::to('newassets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{ URL::to('newassets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('newassets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-stylesheet" />

    <!-- Table datatable css -->
    <link href="{{ URL::to('newassets/libs/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('newassets/libs/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('newassets/libs/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('newassets/libs/datatables/select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Notification css (Toastr) -->
    <link href="{{ URL::to('newassets/libs/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Toster CSS START Livewire-->
    <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <!-- Toster CSS END Livewire-->
    <!-- Custom box css -->
    <link href="{{ URL::to('newassets/libs/custombox/custombox.min.css') }}" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@3.10.3/dist/alpine.min.js" defer ></script>

       
    @livewireStyles
</head>

<body>

    <!-- Begin page -->
    <div id="wrapper">

            <!-- Topbar Start -->
           <livewire:layouts.header />
            <!-- end Topbar -->
            <!-- ========== Left Sidebar Start ========== -->
            <livewire:layouts.sidebar />
            <!-- Left Sidebar End -->

            <div class="content-page">
                <div class="content"><!-- Start Content-->
                    <div class="container-fluid">
            
                         {{ $slot }}

                    </div> <!-- end container-fluid -->
                </div> <!-- end content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                2025 - 2026 &copy; theme by <a href="https://zaffrantech.com/" target="_blank">ZaffranTech</a>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>


    </div>
    <!-- END wrapper -->


    <!-- Vendor js -->
    <script src="{{ URL::to('newassets/js/vendor.min.js') }}"></script>
    <!--Morris Chart-->
    <script src="{{ URL::to('newassets/libs/morris-js/morris.min.js') }}"></script>
    <script src="{{ URL::to('newassets/libs/raphael/raphael.min.js') }}"></script>
    <!-- Dashboard init js-->
    <script src="{{ URL::to('newassets/js/pages/dashboard.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ URL::to('newassets/js/app.min.js') }}"></script>

    <!-- Datatable plugin js -->
    <script src="{{ URL::to('newassets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::to('newassets/libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::to('newassets/libs/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::to('newassets/libs/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::to('newassets/libs/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::to('newassets/libs/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::to('newassets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::to('newassets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::to('newassets/libs/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ URL::to('newassets/libs/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::to('newassets/libs/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ URL::to('newassets/libs/datatables/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ URL::to('newassets/libs/datatables/dataTables.select.min.js') }}"></script>
    <!-- Datatables init -->
    <script src="{{ URL::to('newassets/js/pages/datatables.init.js') }}"></script>

    <!-- Toastr js -->
        <script src="{{ URL::to('newassets/libs/toastr/toastr.min.js') }}"></script>
        <script src="{{ URL::to('newassets/js/pages/toastr.init.js') }}"></script>
    <!-- Chart JS -->
        <script src="{{ URL::to('newassets/libs/chart-js/Chart.bundle.min.js') }}"></script>
    <!-- Init js -->
        <script src="{{ URL::to('newassets/js/pages/chartjs.init.js') }}"></script>
    <!-- Modal-Effect -->
        <script src="{{ URL::to('newassets/libs/custombox/custombox.min.js') }}"></script>
       

    @livewireScripts
</body>

</html>