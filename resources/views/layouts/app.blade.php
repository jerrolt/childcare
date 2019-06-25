<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


<!-- Styles  -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/addon.css') }}" rel="stylesheet">

   
    <style>
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 6px 6px 6px;
    -moz-border-radius: 0 6px 6px;
    border-radius: 0 6px 6px 6px;
}

.dropdown-submenu:hover>.dropdown-menu {
    display: block;
}

.dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #ccc;
    margin-top: 5px;
    margin-right: -10px;
}

.dropdown-submenu:hover>a:after {
    border-left-color: #fff;
}

.dropdown-submenu.pull-left {
    float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
    left: -100%;
    margin-left: 10px;
    -webkit-border-radius: 6px 0 6px 6px;
    -moz-border-radius: 6px 0 6px 6px;
    border-radius: 6px 0 6px 6px;
}

a.bkright, a.bkright:hover {
	text-decoration: underline;
}


.rotate-90 {
  -moz-transform: rotate(90deg);
  -webkit-transform: rotate(90deg);
  -o-transform: rotate(90deg);
  transform: rotate(90deg);
}

.rotate-180 {
  -moz-transform: rotate(180deg);
  -webkit-transform: rotate(180deg);
  -o-transform: rotate(180deg);
  transform: rotate(180deg);
}
			
.rotate-270 {
  -moz-transform: rotate(270deg);
  -webkit-transform: rotate(270deg);
  -o-transform: rotate(270deg);
  transform: rotate(270deg);
}

.flip {
  -moz-transform: scaleX(-1);
  -webkit-transform: scaleX(-1);
  -o-transform: scaleX(-1);
  transform: scaleX(-1);
}

.flip-and-rotate-90 {
  -moz-transform: rotate(90deg) scaleX(-1);
  -webkit-transform: rotate(90deg) scaleX(-1);
  -o-transform: rotate(90deg) scaleX(-1);
  transform: rotate(90deg) scaleX(-1);
}
			
.flip-and-rotate-180 {
  -moz-transform: rotate(180deg) scaleX(-1);
  -webkit-transform: rotate(180deg) scaleX(-1);
  -o-transform: rotate(180deg) scaleX(-1);
  transform: rotate(180deg) scaleX(-1);
}
			
.flip-and-rotate-270 {
  -moz-transform: rotate(270deg) scaleX(-1);
  -webkit-transform: rotate(270deg) scaleX(-1);
  -o-transform: rotate(270deg) scaleX(-1);
  transform: rotate(270deg) scaleX(-1);
}
	</style>
	

  	



</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-left">
                        <!-- Authentication Links -->
                        @guest
                        	@if(!session()->has('fingerprint_raw'))
                        		<li><a href="{{ route('fingerprint-login') }}">Fingerprint Login</a></li>
                        	@endif
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            @includeIf($nav, ['facilities' => (isset($facilities) ? $facilities : [])])
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
    

    <!-- Scripts 
    <script src="{{ asset('js/binaryajax.js') }}"></script>
    <script src="{{ asset('js/exif.js') }}"></script>
    -->
    
    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
