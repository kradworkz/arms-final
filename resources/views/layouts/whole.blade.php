<!doctype html>
<html lang="en">

<head>
    <title>{{config('app.name')}}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Krad was here" name="description" />
    <meta content="KradWasHere" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>

    <link rel="shortcut icon" href="{{asset('assets/images/icon.png')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('css/style.css')}}" />
    <!-- <link type="text/css" rel="stylesheet" href="{{asset('fonts/boxicons-2.0.7/css/boxicons.css')}}" /> -->
</head>

    <body data-sidebar="dark" data-keep-enlarged="true" class="vertical-collpsed">
        <div id="app"> 
            <div id="layout-wrapper">
                @include('layouts.header')
                @include('layouts.navigation')

                <div class="main-content">
                    <div class="page-content">
                        <div class="container-fluid">
                            @yield('content')
                        </div>
                    </div>
                    @include('layouts.login')
                    @include('layouts.footer')
                </div>
            </div>

            <div class="rightbar-overlay"></div>
        </div>

        <script src="{{asset('js/pusher.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        <script src="{{asset('js/frontend.js')}}"></script>
       <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet' defer> 
        
    </body>
</html>
