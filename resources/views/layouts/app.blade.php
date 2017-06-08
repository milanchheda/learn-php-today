<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Learn PHP Today</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nprogress.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <!-- {{ config('app.name', 'Laravel') }} -->
                        <img class="logo" src="{{ asset('images/logo.jpg') }}">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                    @if (!Auth::guest())
                        <li><a href="{{ url('upvotes') }}">My Upvotes</a></li>
                        <li><a href="{{ url('recommends') }}">Recommends by me</a></li>
                    @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <!-- <li><a href="{{ route('login') }}">Login</a></li> -->
                            <!-- <li><a href="{{ route('register') }}">Register</a></li> -->
                            <li><a href="#" data-toggle="modal" data-target="#loginModal" id="loginNavigation">Login</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#registerModal" id="registerNavigation">Register</a></li>

                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>



    <div class="modal fade" hidden="true" id="registerModal" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" 
                      data-dismiss="modal" 
                      aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" 
                    id="favoritesModalLabel">Register</h4>
                </div>
                <div class="panel panel-filled">
                    <div class="panel-body">
                        <form action="{{url('/register')}}" id="registerForm" method="post" name="registerForm">
                            <div class="form-group" id="register-name">
                                <label class="control-label" for="name">Name</label> <input class="form-control" id="name" name="name"
                                placeholder="choose name" required="" title="Please enter you name" type="text"> <span class=
                                "help-block"><strong id="register-errors-name"></strong></span> 
                            </div>
                            <div class="form-group" id="register-email">
                                {{ csrf_field() }} <label class="control-label" for="email">Email</label> <input class="form-control" id=
                                "email" name="email" placeholder="example@gmail.com" required="" title="Please enter you email" type="email"
                                value=""> <span class="help-block"><strong id="register-errors-email"></strong></span>
                            </div>
                            <div class="form-group" id="register-password">
                                <label class="control-label" for="password">Password</label> <input class="form-control" id="password" name=
                                "password" placeholder="******" required="" title="Please enter your password" type="password" value="">
                                <span class="help-block"><strong id="register-errors-password"></strong></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password-confirm">Confirm Password</label> <input class="form-control" id=
                                "password-confirm" name="password_confirmation" placeholder="******" type="password"> <span class=
                                "help-block"><strong id="form-errors-password-confirm"></strong></span>
                            </div>
                            <div class="form-group" id="login-errors">
                                <span class="help-block"><strong id="form-login-errors"></strong></span>
                            </div>
                            <div>
                                <button class="btn btn-login btn-primary right">Register</button>
                                <a href="#" class="linkLookLikeButton" id="existingUserLogin">Existing User? Log in</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" hidden="true" id="loginModal" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" 
                      data-dismiss="modal" 
                      aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" 
                    id="favoritesModalLabel">Sign In</h4>
                </div>

                <div class="panel panel-filled">
                    <div class="panel-body">
                        <form action="{{url('/login')}}" id="loginForm" method="post" name="registerForm">
                            {{ csrf_field() }}
                            <div class="form-group" id="login-email">
                                <label class="control-label" for="name">E-Mail Address</label> <input class="form-control" id="email" name="email"
                                placeholder="Enter email-address" required="" title="Please enter you email address" type="text"> <span class=
                                "help-block"><strong id="login-errors-email"></strong></span> 
                            </div>
                            
                            <div class="form-group" id="login-password">
                                <label class="control-label" for="password">Password</label> <input class="form-control" id="password" name=
                                "password" placeholder="******" required="" title="Please enter your password" type="password" value="">
                                <span class="help-block"><strong id="login-errors-password"></strong></span>
                            </div>
                            
                            <div>
                                <button class="btn btn-login btn-primary right">Login</button>
                                <a href="#" class="linkLookLikeButton" id="newUserLogin">New to LearnPHPtoday? Register</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/nprogress.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="/js/main.js"></script>
</body>
</html>
