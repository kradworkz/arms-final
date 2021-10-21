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
    <link type="text/css" rel="stylesheet" href="{{asset('css/style.css')}}" />
    
</head>

    <body data-topbar="dark" data-layout="horizontal" style=" overflow-y: hidden; overflow-x: hidden;">
        <div id="app"> 

            <div id="layout-wrapper">
                <div class="account-pages pt-sm-4 ml-5 mr-5">
                    @yield('content')
                </div>
            </div>

            @include('layouts.rightbar')

            <div class="rightbar-overlay"></div>

        </div>

        <script src="{{asset('js/app.js')}}"></script>
        <script src="{{asset('js/frontend.js')}}"></script>
        <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet' defer>
    </body>
</html>
