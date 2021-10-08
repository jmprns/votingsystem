<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" href="{{ asset('media/favicon.ico') }}">

        <title>Ballot - {{ $election->elc_name }}</title>

        <!-- App css -->
        <link href="{{ asset('css/ballot') }}/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/ballot') }}/core.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/ballot') }}/components.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/ballot') }}/icons.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/ballot') }}/pages.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/ballot') }}/menu.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/ballot') }}/responsive.css" rel="stylesheet" type="text/css" />

        <link href="{{ asset('vendor/whirl/whirl.min.css') }}" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="{{asset('vendor')}}/image-picker/image-picker.css">

		<style type="text/css">
			.center-div{
				display: flex;
				justify-content: center;
				align-items: center;
			}
		</style>

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->


    </head>


    <body>


        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">

                    <!-- Logo container-->
                    <div class="logo">
                        <!-- Text Logo -->
                        <!--<a href="index.html" class="logo">-->
                            <!--Zircos-->
                        <!--</a>-->
                        <!-- Image Logo -->
                        <a href="/ballot" class="logo">
                            WUP VOTING SYSTEM
                        </a>

                    </div>
                    <!-- End Logo container-->


                    <div class="menu-extras">

                        <ul class="nav navbar-nav navbar-right pull-right">
                           
                            <li class="navbar-c-items">
                                 <a href="/logging?action=out&lvl=1">
                                    <i class="mdi mdi-logout-variant"></i>
                                </a>
                            </li>                            
                        </ul>
                        <div class="menu-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </div>
                    </div>
                    <!-- end menu-extras -->

                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->

            <div class="navbar-custom">
                <div class="container">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <h3 class="text-center">{{ $election->elc_name }}</h3>
                        <!-- End navigation menu -->
                    </div> <!-- end #navigation -->
                </div> <!-- end container -->
            </div> <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->


        <div class="wrapper">
            <div class="container">
    
            <form id="ballot-form" method="POST" action="/ballot/cast">
                @csrf
                @foreach($positions as $position)
                    @if($position->type == 1)
                        @php
                            $a = $position->candidate;
                            $count = $a->count();
                        @endphp
                        @if($count > 0)
                            @if($position->max > 1)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box">
                                            <h2 class="header-title m-t-0 text-center">{{ $position->position_name }}</h2>
                                            <h4 class="header-title m-t-0 text-center">Select up to {{ $position->max }} candidates only.</h4>
                                            <hr>
                                            <div class="center-div">
                                                <select name="position-ballot-{{ $position->id }}[]" multiple="multiple" data-limit="{{ $position->max }}" id="choices-ballot-{{ $position->id }}" class="image-picker text-center">
                                                    <option value=""></option>
                                                    @foreach($position->candidate as $candidate)
                                                    <option 
                                                        data-img-src="{{ asset('media/candidates') }}/{{ $candidate->image }}"
                                                        data-img-label="<p align='center' class='picker-label'><b>{{ $candidate->fname }} @if($candidate->mname !== ''){{ $candidate->mname }}.@endif {{ $candidate->lname }}</b></p><p align='center'>{{ $candidate->party->party_name }}</p>"
                                                        value="{{ $candidate->id }}" >
                                                           {{ $candidate->fname }} @if($candidate->mname !== ''){{ $candidate->mname }}.@endif {{ $candidate->lname }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                    
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box">
                                            <h2 class="header-title m-t-0 text-center">{{ $position->position_name }}</h2>
                                            <h4 class="header-title m-t-0 text-center">Select 1 candidate only.</h4>
                                            <hr>
                                            <div class="center-div">
                                                <select name="position-ballot-{{ $position->id }}" id="choices-ballot-{{ $position->id }}" class="image-picker text-center">
                                                    <option value=""></option>
                                                    @foreach($position->candidate as $candidate)
                                                    <option 
                                                        data-img-src="{{ asset('media/candidates') }}/{{ $candidate->image }}"
                                                        data-img-label="<p align='center' class='picker-label'><b>{{ $candidate->fname }} @if($candidate->mname !== ''){{ $candidate->mname }}.@endif {{ $candidate->lname }}</b></p><p align='center'>{{ $candidate->party->party_name }}</p>"
                                                        value="{{ $candidate->id }}" >
                                                           {{ $candidate->fname }} @if($candidate->mname !== ''){{ $candidate->mname }}.@endif {{ $candidate->lname }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                    
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                            @endif
                        @endif
                    @elseif($position->type == 2)
                       @php
                            $count = 0;
                            foreach($position->candidate as $candidate){
                                if($candidate->year->dept_id == $userInfo->year->dept_id){
                                    $count++;
                                }
                            } 
                       @endphp
                       @if($count > 0)
                            @if($position->max > 1)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box">
                                            <h2 class="header-title m-t-0 text-center">{{ $position->position_name }}</h2>
                                            <h4 class="header-title m-t-0 text-center">Select up to {{ $position->max }} candidates only.</h4>
                                            <hr>
                                            <div class="center-div">
                                                <select name="position-ballot-{{ $position->id }}[]" multiple="multiple" data-limit="{{ $position->max }}" id="choices-ballot-{{ $position->id }}" class="image-picker text-center">
                                                    <option value=""></option>
                                                    @foreach($position->candidate as $candidate)
                                                    @if($candidate->year->dept_id == $userInfo->year->dept_id)
                                                            <option 
                                                                data-img-src="{{ asset('media/candidates') }}/{{ $candidate->image }}"
                                                                data-img-label="<p align='center' class='picker-label'><b>{{ $candidate->fname }} @if($candidate->mname !== ''){{ $candidate->mname }}.@endif {{ $candidate->lname }}</b></p><p align='center'>{{ $candidate->party->party_name }}</p>"
                                                                value="{{ $candidate->id }}" >
                                                                   {{ $candidate->fname }} @if($candidate->mname !== ''){{ $candidate->mname }}.@endif {{ $candidate->lname }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                    
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box">
                                            <h2 class="header-title m-t-0 text-center">{{ $position->position_name }}</h2>
                                            <h4 class="header-title m-t-0 text-center">Select 1 candidate only.</h4>
                                            <hr>
                                            <div class="center-div">
                                                <select name="position-ballot-{{ $position->id }}" id="choices-ballot-{{ $position->id }}" class="image-picker text-center">
                                                    <option value=""></option>
                                                    @foreach($position->candidate as $candidate)
                                                        @if($candidate->year->dept_id == $userInfo->year->dept_id)
                                                            <option 
                                                                data-img-src="{{ asset('media/candidates') }}/{{ $candidate->image }}"
                                                                data-img-label="<p align='center' class='picker-label'><b>{{ $candidate->fname }} @if($candidate->mname !== ''){{ $candidate->mname }}.@endif {{ $candidate->lname }}</b></p><p align='center'>{{ $candidate->party->party_name }}</p>"
                                                                value="{{ $candidate->id }}" >
                                                                   {{ $candidate->fname }} @if($candidate->mname !== ''){{ $candidate->mname }}.@endif {{ $candidate->lname }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                    
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                            @endif
                       @endif
                    @elseif($position->type == 3)
                       @php
                            $count = 0;
                            foreach($position->candidate as $candidate){
                                if($candidate->year_id == Auth::user()->year_id){
                                    $count++;
                                }
                            } 
                       @endphp
                       @if($count > 0)
                            @if($position->max > 1)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box">
                                            <h2 class="header-title m-t-0 text-center">{{ $position->position_name }}</h2>
                                            <h4 class="header-title m-t-0 text-center">Select up to {{ $position->max }} candidates only.</h4>
                                            <hr>
                                            <div class="center-div">
                                                <select name="position-ballot-{{ $position->id }}[]" multiple="multiple" data-limit="{{ $position->max }}" id="choices-ballot-{{ $position->id }}" class="image-picker text-center">
                                                    <option value=""></option>
                                                    @foreach($position->candidate as $candidate)
                                                    @if($candidate->year_id == Auth::user()->year_id)
                                                            <option 
                                                                data-img-src="{{ asset('media/candidates') }}/{{ $candidate->image }}"
                                                                data-img-label="<p align='center' class='picker-label'><b>{{ $candidate->fname }} @if($candidate->mname !== ''){{ $candidate->mname }}.@endif {{ $candidate->lname }}</b></p><p align='center'>{{ $candidate->party->party_name }}</p>"
                                                                value="{{ $candidate->id }}" >
                                                                   {{ $candidate->fname }} @if($candidate->mname !== ''){{ $candidate->mname }}.@endif {{ $candidate->lname }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                    
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box">
                                            <h2 class="header-title m-t-0 text-center">{{ $position->position_name }}</h2>
                                            <h4 class="header-title m-t-0 text-center">Select 1 candidate only.</h4>
                                            <hr>
                                            <div class="center-div">
                                                <select name="position-ballot-{{ $position->id }}" id="choices-ballot-{{ $position->id }}" class="image-picker text-center">
                                                    <option value=""></option>
                                                    @foreach($position->candidate as $candidate)
                                                        @if($candidate->year_id == Auth::user()->year_id)
                                                            <option 
                                                                data-img-src="{{ asset('media/candidates') }}/{{ $candidate->image }}"
                                                                data-img-label="<p align='center' class='picker-label'><b>{{ $candidate->fname }} @if($candidate->mname !== ''){{ $candidate->mname }}.@endif {{ $candidate->lname }}</b></p><p align='center'>{{ $candidate->party->party_name }}</p>"
                                                                value="{{ $candidate->id }}" >
                                                                   {{ $candidate->fname }} @if($candidate->mname !== ''){{ $candidate->mname }}.@endif {{ $candidate->lname }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                    
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                            @endif
                       @endif
                    @endif
                @endforeach
            
                <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"><a href="#" onclick="review()" data-toggle="modal" data-target="#review-modal" class="btn btn-lg btn-success btn-bordered btn-block">Vote</a></div>
                </div>

                {{-- Modal Review --}}
                <div id="review-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div id="review-modal-whirl" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="myModalLabel">WUP Voting System</h4>
                            </div>
                            <div class="modal-body">
                                <h4 class="text-center">REVIEW YOUR BALLOT</h4>
                                <p>Review the candidates that you've been select.</p>
                                <ul id="ballot-candidates-review">
                                    
                                </ul>

                                <p>If you wish to continue, please click the button below:</p>
                                
                                <button onclick="cast()" class="btn btn-lg btn-block btn-inverse">Submit your vote</button>
                            
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal" onclick="reset_review()">Close</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


            </form>

				<br /><br /><br /><br />
               <footer class="footer text-right">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                © {{ date('Y', time()) }}. Voting System.
                                <br><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <img src="{{asset('media/researcher/5.jpg')}}" title="Marlon Sumait" class="img-circle img-thumbnail thumb-md">
                                <img src="{{asset('media/researcher/1.jpg')}}" title="Jimwell Parinas" class="img-circle img-thumbnail thumb-md">
                                <img src="{{asset('media/researcher/2.jpg')}}" title="Arianne Gulla" class="img-circle img-thumbnail thumb-md">
                                <img src="{{asset('media/researcher/3.jpg')}}" title="Sarah Jane Catipon" class="img-circle img-thumbnail thumb-md">
                                <img src="{{asset('media/researcher/4.jpg')}}" title="Christian Jay Campos" class="img-circle img-thumbnail thumb-md">
                                <img src="{{asset('media/researcher/6.jpg')}}" title="Chadric Gotis" class="img-circle img-thumbnail thumb-md">
                            </div>
                        </div>
                    </div>
                </footer>

            </div>
        </div>



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

        <script src="{{ asset('vendor/swal2/swal2.min.all.js') }}"></script>
      

        <!-- App js -->
        <script src="{{asset('js/ballot')}}/jquery.core.js"></script>
        <script src="{{asset('js/ballot')}}/jquery.app.js"></script>

        <script type="text/javascript">

            function review()
            {

                $.ajax({
                    type: 'POST',
                    url: '/ballot/review',
                    data: $('#ballot-form').serialize(),
                    success: function (data) {
                        $.each(data, function(i, item) {
                            $("#ballot-candidates-review").append('<li>'+item+'</li>');
                        })
                    },
                    error: function (data) {
                        console.log('An error occurred.');
                        console.log(data);
                    },
                    beforeSend: function(){
                        var element = document.getElementById('review-modal-whirl');
                        element.classList.add("whirl", "traditional");
                    },
                    complete: function(){
                        var element = document.getElementById('review-modal-whirl');
                        element.classList.remove("whirl", "traditional");
                    }
                });
            }

            function cast()
            {
                var element = document.getElementById('review-modal-whirl');
                element.classList.add("whirl", "traditional");
                $('#ballot-form').submit();
            }

            function reset_review()
            {
                $('#ballot-candidates-review').find('li').remove();
            }


        </script>

        @foreach($positions as $position)

        @if($position->max > 1)
            <script type="text/javascript">
                $("#choices-ballot-{{ $position->id }}").imagepicker({
                    hide_select : true,
                    show_label : true,
                    limit_reached : function(){
                        swal("You already select {{ $position->max }} {{ strtolower($position->position_name) }}s")
                    }
                });
            </script>
        @else
            <script type="text/javascript">
                $("#choices-ballot-{{ $position->id }}").imagepicker({
                    hide_select : true,
                    show_label : true
                });
            </script>
        @endif

        @endforeach

    </body>
</html>