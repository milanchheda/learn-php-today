<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Description" content="LearnPHPToday is a news & feeds related to PHP. Learn something new everyday."/>
    <meta name="Keywords" content="Learn PHP, PHP, PHP7, PHP5.6, Laravel, Learn PHP Today, PHP Today"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Learn PHP Today</title>

    <link href="{{ mix('css/custom.min.css') }}" rel="stylesheet">
    
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
    <?php
    if(env('APP_ENV') != 'local') {
    ?>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-100841850-1', 'auto');
      ga('send', 'pageview');
    </script>
    <?php
    }
    ?>
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
                        <li {{{ (Request::is('top-views') ? 'class=active' : '') }}}><a href="{{ url('top-views') }}">Top Views</a></li>
                        <li {{{ (Request::is('tags') ? 'class=active' : '') }}}><a href="{{ url('tags') }}">Categories</a></li>
                        <!-- <li {{{ (Request::is('top-upvotes') ? 'class=active' : '') }}}><a href="{{ url('top-upvotes') }}">Top Upvotes</a></li>
                        <li {{{ (Request::is('top-recommends') ? 'class=active' : '') }}}><a href="{{ url('top-recommends') }}">Top Recommends</a></li> -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <!-- <li><a href="{{ route('login') }}">Login</a></li> -->
                            <!-- <li><a href="{{ route('register') }}">Register</a></li> -->
                            <!-- <li>
                                <a href="#" id="Search">Search</a>
                            </li> -->
                            <li><a href="#" data-toggle="modal" data-target="#loginModal" id="loginNavigation">Login</a></li>
                            <!-- <li><a href="#" data-toggle="modal" data-target="#registerModal" id="registerNavigation">Register</a></li> -->

                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @if (!Auth::guest())
                                        <li><a href="{{ url('upvotes') }}">My Upvotes</a></li>
                                        <li><a href="{{ url('recommends') }}">Recommends by me</a></li>
                                    @endif
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
        <div class="container container-fluid" id="breadCrumbContainer">
            <ul class="page-breadcrumb navbar-nav">
                <li>
                    <i class="fa fa-home"></i>
                        <a href="{{url('/')}}">Home</a>
                        @if(count(Request::segments()) > 0)
                            <i class="fa fa-angle-right"></i>
                        @endif
                </li>
                @for($i = 0; $i <= count(Request::segments()); $i++)
                <li>
                    <a href="">{{ str_replace('-', ' ', ucfirst(Request::segment($i))) }}</a>
                    @if($i < count(Request::segments()) & $i > 0)
                        {!!'<i class="fa fa-angle-right"></i>'!!}
                    @endif
                </li>
                @endfor
            </ul>
        </div>
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
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6Lf7qCQUAAAAAHup0RNAyFHXOGzJcI5DXXkK8j-J"></div>
                            </div>
                            <div>
                                <button id="registerToSystem" class="btn btn-login btn-primary right">Register</button>
                                <a href="#" class="linkLookLikeButton" id="existingUserLogin">Existing User? Login</a>
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
                    id="favoritesModalLabel">Log In</h4>
                </div>

                <div class="panel panel-filled">
                    <div class="panel-body">
                        <form action="{{url('/login')}}" id="loginForm" method="post" name="loginForm">
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
                                <button id="loginToSystem" class="btn btn-login btn-primary right">Login</button>
                                <a href="#" class="linkLookLikeButton" id="newUserLogin">Register</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" hidden="true" id="feedbackModal" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" 
                      data-dismiss="modal" 
                      aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" 
                    id="favoritesModalLabel">Feedback</h4>
                </div>
                <div class="panel panel-filled">
                    <div class="panel-body">
                        <div class="feedbackContainer">
                            <!-- <h1>Feedback Form</h1> -->

                            
                                <div class="alert alert-success hidden">
                                </div>
                            
                            {!! Form::open(['route'=>'feedback.store', 'id' => 'feedbackForm', 'name' => 'feedbackForm']) !!}

                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    {!! Form::label('Name:') !!}
                                    {!! Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=>'Enter Name']) !!}
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>

                                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                    {!! Form::label('Email:') !!}
                                    {!! Form::text('email', old('email'), ['class'=>'form-control', 'placeholder'=>'Enter Email']) !!}
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>

                                <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                                    {!! Form::label('Message:') !!}
                                    {!! Form::textarea('message', old('message'), ['class'=>'form-control', 'placeholder'=>'Enter Message']) !!}
                                    <span class="text-danger">{{ $errors->first('message') }}</span>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-success">Submit</button>
                                </div>

                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button id="feedback-button" data-toggle="modal" data-target="#feedbackModal" style="visibility: hidden;">Feedback</button>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="{{ mix('js/custom.min.js') }}"></script>
</body>
</html>
