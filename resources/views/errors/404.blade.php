
<!DOCTYPE html>
<html class="account-pages-bg">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- App title -->
        <title>Voting System - Page Not Found</title>

        <!-- App css -->
        <link href="{{ asset('css/admin/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/admin/core.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/admin/components.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/admin/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/admin/pages.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/admin/menu.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/admin/responsive.css') }}" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="{{ asset('js/admin/modernizr.min.js') }}"></script>

    </head>


    <body background="{{asset("media/dust.png")}}" class="bg-transparent">

        <!-- HOME -->
        <section>
            <div class="container-alt">
                <div class="row">
                    <div class="col-sm-12 text-center">

                        <div class="wrapper-page">
                            <img src="{{ asset('media/animat-search-color.gif') }}" alt="" height="120">
                            <h2 class="text-uppercase text-danger">Page Not Found</h2>
                            <p class="text-muted">It's looking like you may have taken a wrong turn. Don't worry... it
                                happens to the best of us. You might want to check your internet connection. Here's a
                                little tip that might help you get back on track.</p>

                            <a class="btn btn-success waves-effect waves-light m-t-20" href="{{ URL::previous() }}"> Return Back</a>
                        </div>

                    </div>
                </div>
            </div>
          </section>
          <!-- END HOME -->

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

        <!-- App js -->
        <script src="{{ asset('js/admin/jquery.core.js') }}"></script>
        <script src="{{ asset('js/admin/jquery.app.js') }}"></script>

    </body>
</html>