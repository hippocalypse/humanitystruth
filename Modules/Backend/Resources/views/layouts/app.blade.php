<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Humanitys Truth Admin</title>

        <link href="{{asset('admin/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('admin/css/startmin.css')}}" rel="stylesheet">
        <link href="{{asset('admin/css/style.css')}}" rel="stylesheet">
        <link href="{{asset('admin/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
        <link type="text/css" rel="stylesheet" href="/css/w3.css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

        <script src="{{asset('admin/js/jquery.min.js')}}"></script>
        <script src="{{asset('admin/js/bootstrap.min.js')}}"></script>

    </head>
    <body>
        
        <div id="wrapper" class="w3-padding w3-container">
            @include('backend.layouts.sidebar')
            <div class="w3-margin-top"></div>
            @yield('content')
        </div>
        @stack('scripts')
    </body>
</html>
