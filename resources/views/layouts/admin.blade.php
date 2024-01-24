<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Google Font: Source Sans Pro -->

    @vite('resources/sass/app.scss')
    @vite(['resources/css/app.css'])
    @vite(['resources/js/app.js'])
    @yield('css')

    <script>
        window.APP=<?php echo json_encode([
        'currency_symbol'=>config('settings.currency_symbol')
    ]);?>;
    </script>
</head>


<body class="hold-transition sidebar-mini">


    <!-- Site wrapper -->
    <div class="wrapper">
        @include('layouts.partials.navbar')
        @include('layouts.partials.sidebar')


        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('content-header') </h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            @yield('content-actions')
                        </div>


                    </div>
                    @include('layouts.partials.alert.success')
                    @include('layouts.partials.alert.error')
                    @yield('content')
                </div>

            </div>




        </div>

        @include('layouts.partials.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    @yield('js')
</body>

</html>