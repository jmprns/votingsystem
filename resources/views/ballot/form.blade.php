<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Voting System | National Election 2019</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('vendor')}}/image-picker/image-picker.css">

    <style type="text/css">
            .center-div{
                display: flex;
                justify-content: center;
                align-items: center;
            }
        </style>
</head>


<body class="canvas-menu">

    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            
            <form role="search" class="navbar-form-custom">
                <div class="form-group">
                    <input type="text" placeholder="OVS {{ date('Y', time()) }}" readonly class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    @php($vname = explode('__', $voter->name))
                    <span class="m-r-sm text-muted welcome-message">Welcome {{ $vname[1] }} {{ $vname[0] }}</span>
                </li>
               
                <li>
                    <a href="/ballot">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-12">
                    <center>
                        <h1>Online Voting System</h1>
                        <ol class="breadcrumb">
                            <li class="active" style="font-size: 16px;">
                                <strong>National Election 2018</strong>
                            </li>
                        </ol>
                    </center>
                </div>
            </div>

            <div class="wrapper wrapper-content article">

                <form id="ballot-form" method="POST" action="/ballot/cast/{{ $voter->id }}">
                @csrf

                @foreach($positions as $position)
                @php($candidates = $position->candidates)
                @if($candidates->count() != 0)


                    @switch($position->type)
                    @case(1)
                        @if($position->max > 1)
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <div class="ibox">
                                        <div class="ibox-content">
                                            
                                            <div class="text-center {{-- article-title --}}">
                                                <h1>{{ $position->name }}</h1>
                                                <h2>Please select upto {{ $position->max }} candidates only.</h2>
                                            </div>
                                            <hr>
                                                <div class="center-div">
                                                    <select name="position-ballot-{{ $position->id }}[]" id="choices-ballot-{{ $position->id }}" multiple="multiple" data-limit="{{ $position->max }}" class="image-picker text-center">
                                                        <option value=""></option>
                                                        @php($candidates = $candidates->shuffle())

                                                        @foreach($candidates as $candidate)
                                                       @php($cname = explode('__', $candidate->info->name))
                                                        <option 
                                                            data-img-src="{{ asset('img/candidates') }}/{{ $candidate->image }}"
                                                            data-img-label="<p align='center' class='picker-label'><b>{{ $cname[1] }} {{ $cname[0] }}</b></p><p align='center'>{{ $candidate->party->name }}</p>"
                                                            value="{{ $candidate->id }}" >
                                                               {{ $cname[1] }} {{ $cname[0] }}
                                                        </option>

                                                        @endforeach

                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <div class="ibox">
                                        <div class="ibox-content">
                                            
                                            <div class="text-center {{-- article-title --}}">
                                                <h1>{{ $position->name }}</h1>
                                                <h2>Please select 1 candidate only.</h2>
                                            </div>
                                            <hr>
                                                <div class="center-div">
                                                    <select name="position-ballot-{{ $position->id }}" id="choices-ballot-{{ $position->id }}" class="image-picker text-center">
                                                        <option value=""></option>
                                                        @php($candidates = $candidates->shuffle())
                                                        @foreach($candidates as $candidate)
                                                       @php($cname = explode('__', $candidate->info->name))
                                                        <option 
                                                            data-img-src="{{ asset('img/candidates') }}/{{ $candidate->image }}"
                                                            data-img-label="<p align='center' class='picker-label'><b>{{ $cname[1] }} {{ $cname[0] }}</b></p><p align='center'>{{ $candidate->party->name }}</p>"
                                                            value="{{ $candidate->id }}" >
                                                               {{ $cname[1] }} {{ $cname[0] }}
                                                        </option>

                                                        @endforeach

                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @break
                    @case(2)
                        @php($candidates = $candidates->where('info.course_id', $voter->course_id))
                        @if($candidates->count() != 0)
                        @if($position->max > 1)
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <div class="ibox">
                                        <div class="ibox-content">
                                            
                                            <div class="text-center {{-- article-title --}}">
                                                <h1>{{ $position->name }}</h1>
                                                <h2>Please select upto {{ $position->max }} candidates only.</h2>
                                            </div>
                                            <hr>
                                                <div class="center-div">
                                                    <select name="position-ballot-{{ $position->id }}[]" id="choices-ballot-{{ $position->id }}" multiple="multiple" data-limit="{{ $position->max }}" class="image-picker text-center">
                                                        <option value=""></option>
                                                        @php($candidates = $candidates->shuffle())
                                                        @foreach($candidates as $candidate)
                                                       @php($cname = explode('__', $candidate->info->name))
                                                        <option 
                                                            data-img-src="{{ asset('img/candidates') }}/{{ $candidate->image }}"
                                                            data-img-label="<p align='center' class='picker-label'><b>{{ $cname[1] }} {{ $cname[0] }}</b></p><p align='center'>{{ $candidate->party->name }}</p>"
                                                            value="{{ $candidate->id }}" >
                                                               {{ $cname[1] }} {{ $cname[0] }}
                                                        </option>

                                                        @endforeach

                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <div class="ibox">
                                        <div class="ibox-content">
                                            
                                            <div class="text-center {{-- article-title --}}">
                                                <h1>{{ $position->name }}</h1>
                                                <h2>Please select 1 candidate only.</h2>
                                            </div>
                                            <hr>
                                                <div class="center-div">
                                                    <select name="position-ballot-{{ $position->id }}" id="choices-ballot-{{ $position->id }}" class="image-picker text-center">
                                                        <option value=""></option>
                                                        @php($candidates = $candidates->shuffle())
                                                        @foreach($candidates as $candidate)
                                                       @php($cname = explode('__', $candidate->info->name))
                                                        <option 
                                                            data-img-src="{{ asset('img/candidates') }}/{{ $candidate->image }}"
                                                            data-img-label="<p align='center' class='picker-label'><b>{{ $cname[1] }} {{ $cname[0] }}</b></p><p align='center'>{{ $candidate->party->name }}</p>"
                                                            value="{{ $candidate->id }}" >
                                                               {{ $cname[1] }} {{ $cname[0] }}
                                                        </option>

                                                        @endforeach

                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endif
                    @break
                    @case(3)
                        @php($candidates = $candidates->where('info.year_id', $voter->year_id))
                        @if($candidates->count() != 0)
                        @if($position->max > 1)
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <div class="ibox">
                                        <div class="ibox-content">
                                            
                                            <div class="text-center {{-- article-title --}}">
                                                <h1>{{ $position->name }}</h1>
                                                <h2>Please select upto {{ $position->max }} candidates only.</h2>
                                            </div>
                                            <hr>
                                                <div class="center-div">
                                                    <select name="position-ballot-{{ $position->id }}[]" id="choices-ballot-{{ $position->id }}" multiple="multiple" data-limit="{{ $position->max }}" class="image-picker text-center">
                                                        <option value=""></option>
                                                        @php($candidates = $candidates->shuffle())
                                                        @foreach($candidates as $candidate)
                                                       @php($cname = explode('__', $candidate->info->name))
                                                        <option 
                                                            data-img-src="{{ asset('img/candidates') }}/{{ $candidate->image }}"
                                                            data-img-label="<p align='center' class='picker-label'><b>{{ $cname[1] }} {{ $cname[0] }}</b></p><p align='center'>{{ $candidate->party->name }}</p>"
                                                            value="{{ $candidate->id }}" >
                                                               {{ $cname[1] }} {{ $cname[0] }}
                                                        </option>

                                                        @endforeach

                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <div class="ibox">
                                        <div class="ibox-content">
                                            
                                            <div class="text-center {{-- article-title --}}">
                                                <h1>{{ $position->name }}</h1>
                                                <h2>Please select 1 candidate only.</h2>
                                            </div>
                                            <hr>
                                                <div class="center-div">
                                                    <select name="position-ballot-{{ $position->id }}" id="choices-ballot-{{ $position->id }}" class="image-picker text-center">
                                                        <option value=""></option>
                                                        @php($candidates = $candidates->shuffle())
                                                        @foreach($candidates as $candidate)
                                                       @php($cname = explode('__', $candidate->info->name))
                                                        <option 
                                                            data-img-src="{{ asset('img/candidates') }}/{{ $candidate->image }}"
                                                            data-img-label="<p align='center' class='picker-label'><b>{{ $cname[1] }} {{ $cname[0] }}</b></p><p align='center'>{{ $candidate->party->name }}</p>"
                                                            value="{{ $candidate->id }}" >
                                                               {{ $cname[1] }} {{ $cname[0] }}
                                                        </option>

                                                        @endforeach

                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endif
                    @break
                    @default

                @endswitch
                @endif

                @endforeach

                </form>

                <div class="row">
                    <div class="col-lg-4 col-lg-offset-4">
                        <div class="ibox">
                            <div class="ibox-content">
                                <button onclick="review()" data-toggle="modal" data-target="#review-modal" data-backdrop="static" data-keyboard="false"  class="btn btn-primary btn-block btn-lg">Vote</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Review --}}
                <div id="review-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div id="review-modal-whirl" class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                
                                <h4 class="modal-title" id="myModalLabel">Online Voting System</h4>
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


            </div>
            <div class="footer">
                <div class="pull-right">
                    <strong>Developed by: <a href="https:://facebook.com/jp.pagapulan" target="_new">Jimwell Parinas</a></strong>
                </div>
                <div>
                    <strong>OVS</strong> Online Voting System {{ date('Y', time()) }}
                </div>
            </div>

        </div>
        </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-2.1.1.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script src="{{asset('vendor')}}/image-picker/image-picker.min.js"></script>

    <script type="text/javascript">
        @foreach($positions as $position)
            $("#choices-ballot-{{ $position->id }}").imagepicker({
                hide_select : true,
                show_label : true
            });
        @endforeach

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


</body>

</html>
