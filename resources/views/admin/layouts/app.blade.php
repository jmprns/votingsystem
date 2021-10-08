<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="_token" content="{{ csrf_token() }}">
        

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('media/favicon.ico') }}">

        <!-- App title -->
        <title>Voting System - @yield('title')</title>

        {{-- Sweet Alert --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/swal/sweet-alert.css') }}">

        @section('css-top')
        @show

        <!-- App css -->
        <link href="{{ asset('css/admin/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/admin/core.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/admin/components.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/admin/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/admin/pages.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/admin/menu.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/admin/responsive.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/whirl/whirl.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/toastr/min.css') }}" rel="stylesheet" type="text/css" />

        

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        @section('css-bot')
        @show

        <script src="{{ asset('js/admin/modernizr.min.js') }}"></script>

    </head>


    <body id="whirl-whole-body" class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="/admin/dashboard" class="logo"><span>WUP<span>AURORA</span></span><i><img src="{{ asset('media/seal.png') }}" width="50px" height="50px"></i></a>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">

                        <!-- Navbar-left -->
                        <ul class="nav navbar-nav navbar-left">
                            <li>
                                <button class="button-menu-mobile open-left waves-effect">
                                    <i class="mdi mdi-menu"></i>
                                </button>
                            </li>
                            <li class="hidden-xs">
                                <a class="menu-item">Voting System</a>
                            </li>
                        </ul>



                        <!-- Right(Notification) -->
                        <ul class="nav navbar-nav navbar-right">

                            <li class="dropdown user-box">
                                <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                                    <img id="primary-app-avatar" src="{{ asset('media/admin') }}/{{ Auth::user()->image }}" alt="user-img" class="img-circle user-img">
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                                    <li>
                                        <h5>Hi, {{ Auth::user()->fname }}</h5>
                                    </li>
                                    <li><a href="/logging?action=out&lvl=0"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul> <!-- end navbar-right -->

                    </div><!-- end container -->
                </div><!-- end navbar -->
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <ul>
                        	<li class="menu-title">Navigation</li>
                            <li>
                                <a href="/admin/dashboard" class="waves-effect {{sidebarHelper('/admin/dashboard')}}"><i class="mdi mdi-view-dashboard"></i><span> Dashboard </span></a>
                            </li>
                            @if(Auth::user()->lvl == 0 || Auth::user()->lvl == 1)
                            <li>
                                <a href="/admin/election" class="waves-effect {{sidebarHelper('/admin/election')}}"><i class="mdi mdi-archive"></i><span> Election </span></a>
                            </li>
                            <li>
                                <a href="/admin/voters" class="waves-effect {{sidebarHelper('/admin/voters')}}"><i class="mdi mdi-account-multiple"></i><span> Voters </span></a>
                            </li>
                            <li>
                                <a href="/admin/settings" class="waves-effect {{sidebarHelper('/admin/settings')}}"><i class="mdi mdi-settings"></i><span> Settings </span></a>
                            </li>
                            @endif
                            <li>
                                <a href="/logging?action=out&lvl=0" class="waves-effect"><i class="mdi mdi-logout-variant"></i><span> Logout </span></a>
                            </li>
                            
                        </ul>
                    </div>
                    <!-- Sidebar -->
                    <div class="clearfix"></div>

                    <div class="help-box">
                        {{-- <h5 class="text-muted m-t-0">For Help ?</h5>
                        <p class=""><span class="text-custom">Email:</span> <br/> jp.pagapulan@gmail.com</p>
                        <p class="m-b-0"><span class="text-custom">Call:</span> <br/> (+639) 467 034 972</p> --}}
                        <img src="{{ asset('media/seal.png') }}" width="140px" height="140px" style="display: flex; justify-content: center; align-items: center;" >
                    </div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div id="whirl-content-page" class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">


                        <div class="row">
							<div class="col-xs-12">
								<div class="page-title-box">
                                    <h4 class="page-title">@yield('page-title')</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        @section('breadcrumb')
                                        @show
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
							</div>
						</div>
                        <!-- end row -->

                        @section('main-content')
                        @show


                    </div> <!-- container -->

                </div> <!-- content -->

                <footer class="footer">
                    <span>2018 © Voting System.</span>
                    <span class="pull-right">{{ $_SERVER['SERVER_NAME'] }}:{{ $_SERVER['SERVER_PORT'] }}</span>
                </footer>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->



        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="{{ asset('js/admin/jquery.min.js') }}"></script>
        <script src="{{ asset('js/admin/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/admin/detect.js') }}"></script>
        <script src="{{ asset('js/admin/fastclick.js') }}"></script>
        <script src="{{ asset('js/admin/jquery.blockUI.js') }}"></script>
        <script src="{{ asset('js/admin/waves.js') }}"></script>
        <script src="{{ asset('js/admin/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('js/admin/jquery.scrollTo.min.js') }}"></script>

        <script src="{{ asset('vendor/toastr/min.js') }}"></script>

        <script src="{{ asset('vendor/swal/sweet-alert.min.js') }}"></script>

        @section('js-top')
        @show


        <!-- App js -->
        <script src="{{ asset('js/admin/jquery.core.js') }}"></script>
        <script src="{{ asset('js/admin/jquery.app.js') }}"></script>


        @section('js-bot')
        @show

    </body>
</html>