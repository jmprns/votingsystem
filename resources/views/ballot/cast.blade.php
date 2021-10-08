
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
                                            <div class="checkmark">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                         viewBox="0 0 161.2 161.2" enable-background="new 0 0 161.2 161.2" xml:space="preserve">
                                                    <path class="path" fill="none" stroke="#4bd396" stroke-miterlimit="10" d="M425.9,52.1L425.9,52.1c-2.2-2.6-6-2.6-8.3-0.1l-42.7,46.2l-14.3-16.4
                                                        c-2.3-2.7-6.2-2.7-8.6-0.1c-1.9,2.1-2,5.6-0.1,7.7l17.6,20.3c0.2,0.3,0.4,0.6,0.6,0.9c1.8,2,4.4,2.5,6.6,1.4c0.7-0.3,1.4-0.8,2-1.5
                                                        c0.3-0.3,0.5-0.6,0.7-0.9l46.3-50.1C427.7,57.5,427.7,54.2,425.9,52.1z"/>
                                                    <circle class="path" fill="none" stroke="#4bd396" stroke-width="4" stroke-miterlimit="10" cx="80.6" cy="80.6" r="62.1"/>
                                                    <polyline class="path" fill="none" stroke="#4bd396" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="113,52.8
                                                        74.1,108.4 48.2,86.4 "/>

                                                    <circle class="spin" fill="none" stroke="#4bd396" stroke-width="4" stroke-miterlimit="10" stroke-dasharray="12.2175,12.2175" cx="80.6" cy="80.6" r="73.9"/>

                                                </svg>
                                            </div>
                                        </div>
                                        <p class="text-muted font-13 m-t-10"> Your vote has successfully save. Please click the button below to return to the login page or wait 10 seconds to automatically redirect. </p>
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