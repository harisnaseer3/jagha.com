<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name', 'Property Management') }}</title>

    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/fontawesome-pro-5.12.0/css/all.min.css')}}"/>


    @yield('css')
</head>
<body class="hold-transition sidebar-mini text-sm">

<div class="wrapper">


<!-- Content Wrapper. Contains page content -->
@yield('content')
<!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer text-sm">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
{{--            Sure, you can do this--}}
        </div>
        <!-- Default to the left -->
{{--        <strong>Copyright &copy; 2019-{{date("Y")}} <a href="{{route('home')}}">Property Management</a></strong>--}}
    </footer>
</div>
<!-- ./wrapper -->


<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- Fontawesome script -->
{{--<script src="{{asset('plugins/fontawesome-pro-5.12.0/js/fontawesome.min.js')}}"></script>--}}
<script src="{{asset('plugins/fontawesome-pro-5.12.0/js/all.min.js')}}"></script>
<script src="{{asset('js/script-navbar.js')}}"></script>

@yield('script')
</body>
</html>
