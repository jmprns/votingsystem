
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" href="{{ asset('media/favicon.ico') }}">

        <title>Ballot</title>

        <!-- App css -->
        <link href="{{ asset('css/ballot') }}/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/ballot') }}/core.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/ballot') }}/components.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/ballot') }}/icons.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/ballot') }}/pages.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/ballot') }}/menu.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/ballot') }}/responsive.css" rel="stylesheet" type="text/css" />


        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="assets/js/modernizr.min.js"></script>

    </head>


   <body class="bg-transparent">

        <!-- HOME -->
        <section>
            <div class="container-alt">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="wrapper-page">

                            <div class="m-t-40 account-pages">
                                <div class="text-center account-logo-box">
                                    <h2 class="text-uppercase">
                                        <a href="index.html" class="text-success">
                                            VOTING SYSTEM
                                        </a>
                                    </h2>
                                    <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                                </div>
                                <div class="account-content">
                               
                                <div class="text-center m-b-20">
                                        <div class="m-b-20">
                                            <h1 style="font-size:70px; color: red;">CLOSE</h1>
                                        </div>
                                        <p class="text-muted font-13 m-t-10">
                                           The voting system that you have been requesting is currently <strong>closed.</strong> Please contact the administrator for assistance.
                                        </p>
                                        <br>
                                        <a href="/logging?action=out&lvl=1" class="btn btn-bordered btn-primary btn-lg">Return Login</a>
                                    </div>
                               
                                </div>
                            </div>
                            <!-- end card-box-->


                            <div class="row m-t-30">
                                <div class="col-sm-12 text-center">
                                    <p class="text-muted">Automatically redirect in <span id="countdowntimer">10 </span> seconds</p>
                                </div>
                            </div>

                        </div>
                        <!-- end wrapper -->

                    </div>
                </div>
            </div>
          </section>
          <!-- END HOME -->

        <script>
            var resizefunc = [];
        </script>

        <script type="text/javascript">
            var timeleft = 10;
            var downloadTimer = setInterval(function(){
                timeleft--;
                document.getElementById("countdowntimer").textContent = timeleft;
                if(timeleft <= 0){
                    clearInterval(downloadTimer);
                    window.location = '/logging?action=out&lvl=1';
                }
            },1000);
        </script>

        <!-- jQuery  -->
        <script src="{{asset('js/ballot')}}/jquery.min.js"></script>
        <script src="{{asset('js/ballot')}}/bootstrap.min.js"></script>
        <script src="{{asset('js/ballot')}}/detect.js"></script>
        <script src="{{asset('js/ballot')}}/fastclick.js"></script>
        <script src="{{asset('js/ballot')}}/jquery.blockUI.js"></script>
        <script src="{{asset('js/ballot')}}/waves.js"></script>
        <script src="{{asset('js/ballot')}}/jquery.slimscroll.js"></script>
        <script src="{{asset('js/ballot')}}/jquery.scrollTo.min.js"></script>

        <script src="{{asset('vendor')}}/image-picker/image-picker.min.js"></script>
      

        <!-- App js -->
        <script src="{{asset('js/ballot')}}/jquery.core.js"></script>
        <script src="{{asset('js/ballot')}}/jquery.app.js"></script>
    </body>
</html>