<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="_token" content="{{ csrf_token() }}">

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('media/favicon.ico')}}">
        <!-- App title -->
        <title>Voting System - Login</title>

        {{-- Sweet Alert --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/swal/sweet-alert.css') }}">

        <!-- App css -->
        <link href="{{asset('css/admin/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/admin/core.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/admin/components.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/admin/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/admin/pages.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/admin/menu.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/admin/responsive.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/whirl/whirl.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')}}"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js')}}"></script>
        <![endif]-->


    </head>


    <body class="bg-transparent">

        <!-- HOME -->
        <section>
            <div id="login-body" class="container-alt">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="wrapper-page">
                            <div class="clearfix"></div>
                            <div class="m-t-40 account-pages">
                                <div class="text-center account-logo-box">
                                    <h2 class="text-uppercase">
                                        <a href="javascript:void(0)" class="text-success">
                                            <span><img src="{{asset('media/logo2.png')}}" alt="" height="50"></span>
                                        </a>
                                    </h2>
                                    <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                                </div>
                                <div class="account-content">
                                    <form id="admin-login-form" action="/admin/login" class="form-horizontal" method="POST" >
                                        @csrf
                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                                <input class="form-control" name="user" type="text" required="" placeholder="Username">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input class="form-control" name="pass" type="password" required="" placeholder="Password">
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-signin" name="remember" type="checkbox">
                                                    <label for="checkbox-signin">
                                                        Remember me
                                                    </label>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-group account-btn text-center m-t-10">
                                            <div class="col-xs-12">
                                                <button class="btn w-md btn-bordered btn-danger waves-effect waves-light" onclick="submit_form()">Log In</button>
                                            </div>
                                        </div>

                                    </form>

                                    <div class="clearfix"></div>

                                </div>
                            </div>
                            <!-- end card-box-->


                           

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

        <!-- jQuery  -->
        <script src="{{asset('js/admin/jquery.min.js')}}"></script>
        <script src="{{asset('js/admin/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/admin/detect.js')}}"></script>
        <script src="{{asset('js/admin/fastclick.js')}}"></script>
        <script src="{{asset('js/admin/jquery.blockUI.js')}}"></script>
        <script src="{{asset('js/admin/waves.js')}}"></script>
        <script src="{{asset('js/admin/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('js/admin/jquery.scrollTo.min.js')}}"></script>
        <script src="{{ asset('vendor/swal2/swal2.min.all.js') }}"></script>

        <!-- App js -->
        <script src="{{asset('js/admin/jquery.core.js')}}"></script>
        <script src="{{asset('js/admin/jquery.app.js')}}"></script>


        <script>
            function submit_form()
            {
                var element = document.getElementById('login-body');
                element.classList.add("whirl", "traditional");

                $("#admin-login-form").submit();
            }

            @if(session('message') == 'error')
                swal('Error!', 'Invalid credentials', 'error');
            @endif
        </script>

        

        {{-- <script>
            $('#admin-login-form').submit(function(e){

                 e.preventDefault();

                var token = $("meta[name='_token']").attr("content");
                var user = $('#username').val();
                var pass = $('#password').val();
                var remember = $('#checkbox-signup').val();
                $.ajax({
                    url: "/admin/login",
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        '_token' : token,
                        'user' : user,
                        'pass' : pass,
                        'remember' : remember
                    },
                    success:function(Result)
                    {   
                        if(Result.response == 200)
                        {
                            window.location = '/logging?action=in&lvl=0';
                        }else{
                            swal('Error!', 'Invalid credentials', 'error');
                            var element = document.getElementById('login-body');
                            element.classList.remove("whirl", "traditional");
                        }
                    },
                    beforeSend: function(){
                        var element = document.getElementById('login-body');
                        element.classList.add("whirl", "traditional");
                    }
                });
            });
        </script> --}}

    </body>
</html>