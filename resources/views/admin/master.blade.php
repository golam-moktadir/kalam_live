<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Bootstrap demo</title>
<link href="{{asset('build/assets/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('build/assets/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<!-- <link href="{{asset('build/assets/css/style.css')}}" rel="stylesheet"> -->
<link href="{{asset('build/assets/css/all.min.css')}}" rel="stylesheet">
<link href="{{asset('build/assets/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('build/assets/css/toastr.min.css')}}" rel="stylesheet">
<script src="{{asset('build/assets/js/jquery-3.7.1.js')}}"></script>
<script src="{{asset('build/assets/js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('build/assets/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('build/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('build/assets/js/toastr.min.js')}}"></script>
<script src="{{asset('build/assets/js/sweetalert.min.js')}}"></script>
<script type="text/javascript">
   $(document).ready(function(){
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });
   });
</script>
<style>
   .own-nav-link {
     color: #fff;
   }

   .own-nav-link:hover {
     color: #ccc; 
   }

   .sidebar {
     padding: 60px 0px; 
     background-color: lightblue;
   }

   .main-content { 
     padding: 60px 10px; 
     background-color: antiquewhite;
   }

   .dataTables_wrapper .dataTables_filter {
      margin-bottom: 10px;
   }
</style>
</head>
  <body>
    <!-- Navbar Start -->
    @include('admin.navbar')
    <!-- Navbar End -->
    <div class="container-fluid">
      <div class="row">
        <!-- Sidebar Start -->
        @include('admin.sidebar')
        <!-- Sidebar End -->

        <!-- Main content Start-->
        @yield('content')
        <!-- Main content End -->
      </div>
    </div>
    <!-- Footer Start -->
    @include('admin.footer')
    <!-- Footer End -->
  </body>
</html>