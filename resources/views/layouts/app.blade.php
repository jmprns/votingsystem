<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}">

    <title>Voting System | @yield('html-title')</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="{{ asset('vendor/sweetalert/sweetalert.css') }}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- Whirl -->
    <link href="{{ asset('vendor/whirl/whirl.min.css') }}" rel="stylesheet">

    @section('css-top')
    @show


    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @section('css-bot')
    @show

</head>

<body>

<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="{{ asset('img/users') }}/{{ Auth::user()->image }}" width="50px" height="50px" />
                             </span>
                            @php($adminName = explode('__',Auth::user()->name))
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold" style="color: white;">{{ $adminName[1] }} {{ $adminName[0] }}</strong>
                             </span>  </span> </a>
                        
                    </div>
                    <div class="logo-element">
                        OVS
                    </div>
                </li>


                <li @if(strpos(url()->current(), request()->getHttpHost().'/election') == true) class="active" @endif>
                    <a href="/election"><i class="fa fa-archive"></i> <span class="nav-label">Election</span></a>
                </li>

                <li @if(strpos(url()->current(), request()->getHttpHost().'/party') == true) class="active" @endif>
                    <a href="/party"><i class="fa fa-flag"></i> <span class="nav-label">Party</span></a>
                </li>


                <li @if(strpos(url()->current(), request()->getHttpHost().'/settings') == true) class="active" @endif>
                    <a href="/settings"><i class="fa fa-cogs"></i> <span class="nav-label">Settings</span></a>
                </li>
                
            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" method="post" action="#">
                        <div class="form-group">
                            <input type="text" readonly placeholder="Online Voting System" class="form-control" name="top-search" id="top-search">
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </nav>
        </div>
        @section('bread')
        @show
        <div class="wrapper wrapper-content">
            @section('main')
            @show
        </div>
        <div class="footer">
            <div class="pull-right">
                <strong>Developed By:</strong> <a href="https://github.com/jmprns" target="_new">Jimwell Parinas</a>
            </div>
            <div>
                <strong>Online Voting System</strong>
            </div>
        </div>

    </div>
</div>

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-2.1.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

@section('js-top')
@show

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Toastr script -->
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>

<!-- Sweet alert -->
<script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>

<script type="text/javascript">
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>

@section('js-bot')
@show

</body>

</html>
