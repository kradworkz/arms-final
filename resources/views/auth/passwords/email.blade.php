


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

    <link rel="shortcut icon" href="assets/images/icon.png">
    <link type="text/css" rel="stylesheet" href="{{asset('css/style.css')}}" />
</head>

    <body data-topbar="dark" data-layout="horizontal">
        <div id="app"> 

            <div class="account-pages my-5 pt-sm-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="card overflow-hidden">
                                <div class="bg-soft-primary">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="text-primary p-4" style="margin-bottom: -20px;">
                                                <h5 class="text-primary">Reset Password</h5>
                                                <p>Please enter your email address.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0"> 
                                    <div class="p-2" style="margin-top: 10px;">
                                        @if (session('alert'))
                                            <div class="alert alert-danger" role="alert">
                                                {{ session('alert') }}
                                            </div>
                                        @endif
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @else
                                        <form  class="form-horizontal customerform" method="POST" action="{{ route('password.email') }}">@csrf    
                                            <div class="form-group">
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-block waves-effect waves-light" data-toggle="button" aria-pressed="false">
                                                Send password reset link
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 text-center">
                                <div>
                                    <p>©  RRDICOM. Developed by DOST-IX</p>
                                </div>
                            </div>
    
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>

