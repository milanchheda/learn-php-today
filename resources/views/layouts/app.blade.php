<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('images/apple-touch-icon.jpg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.jpg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.jpg') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- SEO  -->
    {!! SEO::generate() !!}
    <!-- Feed  -->
    {!! Feed::link(url('feed'), 'rss', 'Learn PHP Today Feed', 'en'); !!}
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ mix('css/custom.min.css') }}?v=1.2" rel="stylesheet">
    
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
        {!! Analytics::render() !!}
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
                    <!-- <button type="button" class="navbar-toggle mobile-search" data-toggle="collapse" data-target="#navbar-collapse-0">
                        <i class="fa fa-search"></i>
                    </button> -->

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <!-- {{ config('app.name', 'Laravel') }} -->
                        <img class="logo" src="{{ asset('images/logo_1.png') }}">
                    </a>
                </div>
                <!-- <div class="navbar-collapse hidden-desktop" id="navbar-collapse-0">
                    <form class="navbar-form navbar-right" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search" id="searchMobile">
                        </div>           
                    </form>
                </div> -->
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li {{{ (Request::is('top-views') ? 'class=active' : '') }}}><a href="{{ url('top-views') }}">Top Views</a></li>
                        <li {{{ (Request::is('tags') ? 'class=active' : '') }}}><a href="{{ url('tags') }}">Categories</a></li>
                        <!-- <li {{{ (Request::is('top-upvotes') ? 'class=active' : '') }}}><a href="{{ url('top-upvotes') }}">Top Upvotes</a></li>
                        <li {{{ (Request::is('top-recommends') ? 'class=active' : '') }}}><a href="{{ url('top-recommends') }}">Top Bookmarked</a></li> -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- <li>
                            <a href="#" id="addNews" class="hidden-mobile">
                                <i class="fa fa-plus"></i>
                            </a>
                        </li> -->
                        <!-- <li>
                            <a href="#" id="searchIcon" class="hidden-mobile">
                                <i class="fa fa-search"></i>
                            </a>
                        </li> -->
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <!-- <li><a href="{{ route('login') }}">Login</a></li> -->
                            <!-- <li><a href="{{ route('register') }}">Register</a></li> -->
                            <li><a href="#" data-toggle="modal" data-target="#loginModal" id="loginNavigation">Login</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#registerModal" id="registerNavigation" class="hidden">Register</a></li>

                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @if (!Auth::guest())
                                        <li><a href="{{ url('upvotes') }}">My Upvotes</a></li>
                                        <li><a href="{{ url('my-bookmarks') }}">My Bookmarks</a></li>
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
        <!-- <div class="row"> -->
            <!-- <div class="container container-fluid" id="searchContainer">
                <input type="text" id="search" name="query" placeholder="Search posts">
                <i id="searchclear" class="fa fa-times-circle" aria-hidden="true"></i>
            </div> -->
        <!-- </div> -->
        @if (Auth::guest())
        <div class="row header-banner-container">
            <div class="container cta-container">
                <div class="col-sm-8 text-center">
                    <h3 class="title">Discover all the top Articles & Tutorials related to PHP</h3>
                    <!-- Begin MailChimp Signup Form -->
                    <div id="mc_embed_signup">
                        <form action="//learnphptoday.us16.list-manage.com/subscribe/post?u=48ed5ee6722b8f1018036ed76&amp;id=426dfb94e2" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                            <div id="mc_embed_signup_scroll">
                                <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Email address" required>
                                <div style="position: absolute; left: -5000px;" aria-hidden="true">
                                    <input type="text" name="b_48ed5ee6722b8f1018036ed76_426dfb94e2" tabindex="-1" value="">
                                </div>
                                <div class="clear">
                                    <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--End mc_embed_signup-->
                    <div class="secondary-header-info mockup-container">
                        <p>
                        Join the daily newsletter and never miss out on important updates and news. You can expect quick tips, links to interesting tutorials, updates and packages. We will never ever ever ever send you ads as spam.
                        </p>
                    </div>
                    <div class="social-btn-group hidden-xs pull-left">
                        <!-- <iframe src="http://c.yvoschaap.com/producthunt/counter.html#href=http%3A%2F%2Fwww.producthunt.com%2Fr%2F9751924ee29033%2F50435&amp;layout=wide" width="120" height="25" scrolling="no" frameborder="0" allowtransparency="true"></iframe>
                        <iframe src="http://hn-button.herokuapp.com?title=GitLogs%20News%20-%20Discover%20The%20Top%20Trending%20Repos&amp;url=http%3A%2F%2Fwww.gitlogs.com&amp;&amp;count=horizontal" name="hn-button-p09jvrg" id="hn-button-p09jvrg" class="hn-button" data-title="GitLogs News - Discover The Top Trending Repos" data-url="http://www.gitlogs.com" data-count="horizontal" title="Hacker News Button" height="20" width="82" frameborder="0" allowtransparency="true" scrolling="no"></iframe> -->
                        <a href="http://feeds.feedburner.com/learnphptoday-feeds" title="Subscribe to my feed" rel="alternate" type="application/rss+xml"><img src="//feedburner.google.com/fb/images/pub/feed-icon32x32.png" alt="" style="border:0;margin-top: -3px;position: absolute;margin-left: 90px;" />
                        </a>
                        <a href="http://feeds.feedburner.com/learnphptoday-feeds" title="Subscribe to my feed" rel="alternate" type="application/rss+xml"></a>
                        <iframe id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true" class="twitter-follow-button twitter-follow-button-rendered" title="Twitter Follow Button" src="http://platform.twitter.com/widgets/follow_button.6f0f2e104cd4fbbafb16bbad6813f68d.en.html#dnt=false&amp;id=twitter-widget-0&amp;lang=en&amp;screen_name=learn_php_today&amp;show_count=false&amp;show_screen_name=false&amp;size=l" style="position:static;visibility:visible;width:100px;height:28px;" data-screen-name="learn_php_today"></iframe>
                    </div>
                </div>
                <div class="col-sm-4 mockup-container">
                    <div class="device-mockup animated fadeIn">
                        <div class="device">
                            <div class="screen"><img src="/images/homepage_banner.png" alt="Learn PHP Today newsletter">
                            </div>
                            <div class="button"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- <div class="container container-fluid" id="breadCrumbContainer">
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
            <ul class="page-breadcrumb navbar-nav pull-right social-icons">
                <li>
                    <a href="https://feedburner.google.com/fb/a/mailverify?uri=learnphptoday-feeds&amp;loc=en_US" title="Subscribe to Learn PHP Today by Email">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                    </a>
                </li>
                <li>
                    <a href="{{url('http://feeds.feedburner.com/learnphptoday-feeds')}}"><i class="fa fa-rss"></i></a>
                </li>
                <li>
                    <a href="{{url('http://twitter.com/learnphptoday')}}"><i class="fa fa-twitter"></i></a>
                </li>
            </ul>
        </div> -->
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
                        <div class="alert alert-success hidden"></div>
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
    <script src="{{ mix('js/custom.min.js') }}?v=1.2"></script>
</body>
</html>
