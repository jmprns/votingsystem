@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')
Result
@endsection

{{-- Top Css --}}
@section('css-top')
<link href="{{ asset('vendor/magnific-popup/css/magnific-popup.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Bottom Css --}}
@section('css-bot')

@endsection

{{-- Page Title --}}
@section('page-title')
{{ $election->elc_name }} <small>Result</small>
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li>
	<a href="/admin/dashboard">Voting System</a>
</li>
<li>
	<a href="/admin/election">Election</a>
</li>
<li>
	<a href="/admin/election/precinct/show/{{ $election->id }}">{{ $election->elc_name }}</a>
</li>
<li class="active">
	Result
</li>
@endsection

{{-- Main Content --}}
@section('main-content')
<!-- Ongoing Election -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="demo-box">
                                                <h4 class="header-title m-t-0">Election Details</h4>
                                                <div class="table-responsive"> 
                                                    <table class="table table-responsive table-hover m-0">
                                                        <tr>
                                                            <td><b>Election Name:</b></td>
                                                            <td>{{ $election->elc_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Election Start:</b></td>
                                                            <td>{{ elc_time($election->start) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Election End:</b></td>
                                                            <td>{{ elc_time($election->end) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Positions:</b></td>
                                                            <td>{{ $elc_info['position'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Candidates:</b></td>
                                                            <td>{{ $elc_info['candidate'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Voters:</b></td>
                                                            <td>{{ $elc_info['voter'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Uncasted Votes:</b></td>
                                                            <td>{{ $elc_info['uncast'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Casted Votes:</b></td>
                                                            <td>{{ $elc_info['cast'] }}</td>
                                                        </tr>
                                                    </table>
        
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="demo-box">
                                                <h4 class="header-title m-t-0">Generate Results</h4>
                                                <div class="row">
                                                    
                                                    <div class="col-md-6">
                                                        <div class="panel">
                                                            <div class="panel-body">
                                                                <center>
                                                                    <a href="/admin/election/result/generate/all/{{ $election->id }}">
                                                                    <img width="100px" height="100px" src="{{ asset('media/icons/clipboard.svg') }}" /><br><br>
                                                                    <span style="font-weight: bolder;">Generate Election Result</span>
                                                                    </a>
                                                                </center>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="panel">
                                                            <div class="panel-body">
                                                                <center>
                                                                    <a href="/admin/election/result/generate/win/{{ $election->id }}">
                                                                    <img width="100px" height="100px" src="{{ asset('media/icons/result-x.svg') }}" /><br><br>
                                                                    <span style="font-weight: bolder;">Generate Winner Result</span>
                                                                    </a>
                                                                </center>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                       <div class="panel" id="announce-sms">
                                                            <div class="panel-body">
                                                                <center>
                                                                    <button onclick="announce('{{ $election->id }}')" class="btn btn-inverse btn-block btn-lg btn-bordered waves-effect w-md waves-light m-b-5">ANNOUNCE THE RESULT VIA SMS</button>
                                                                </center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->

                                </div>
                            </div>
                        </div>


<!-- Tables -->

@foreach($positions as $position)

    @if($position->type == 1)
        @php
            $a = $position->candidate;
            $count = $a->count();
        @endphp
        @if($count > 0)
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">

                        <h4 class="m-t-0 header-title"><b>Election Results for {{ $position->position_name }}</b></h4>
                        <p class="text-muted font-13">
                            @if(time() < $election->end)
                                @if(Auth::user()->lvl == 0)
                                    Partial election result.
                                @else
                                    Names will be reveal after the elections.
                                @endif
                            @else
                                Overall election results.
                            @endif
                        </p>
                        <table class="table table-responsive table-inverse table-hover m-b-0">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Partylist</th>
                                    <th>Accumulated Votes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($x = 1)
                                @foreach($position->candidate as $candidate)
                                <tr>
                                    <td>{{ $x++ }}</td>
                                    <td>
                                        @if(time() < $election->end)
                                            @if(Auth::user()->lvl == 0)
                                                {{-- Uncensored --}}
                                                <a href="{{ asset('media/candidates') }}/{{ $candidate->image }}" class="image-popup" title="{{ $candidate->fname}} {{ $candidate->lname}}">
                                                    <img src="{{ asset('media/candidates') }}/{{ $candidate->image }}" alt="user" class="thumb-sm" />
                                                </a>
                                            @else
                                                {{-- Cencored --}}
                                                <img src="{{ asset('media') }}/00.png" alt="censored-image" class="thumb-sm" />
                                            @endif
                                        @else
                                            {{-- Uncensored --}}
                                            <a href="{{ asset('media/candidates') }}/{{ $candidate->image }}" class="image-popup" title="{{ $candidate->fname}} {{ $candidate->lname}}">
                                                <img src="{{ asset('media/candidates') }}/{{ $candidate->image }}" alt="user" class="thumb-sm" />
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if(time() < $election->end)
                                            @if(Auth::user()->lvl == 0)
                                                {{-- Uncensored --}}
                                                {{ $candidate->lname}}, {{ $candidate->fname}}
                                            @else
                                                {{-- Cencored --}}
                                                ******, ******
                                            @endif
                                        @else
                                            {{-- Uncensored --}}
                                            {{ $candidate->lname}}, {{ $candidate->fname}}
                                        @endif
                                    </td>
                                    <td>
                                        @if(time() < $election->end)
                                            @if(Auth::user()->lvl == 0)
                                                {{-- Uncensored --}}
                                                {{ $candidate->party->party_name }}
                                            @else
                                                {{-- Cencored --}}
                                                ***********
                                            @endif
                                        @else
                                            {{-- Uncensored --}}
                                           {{ $candidate->party->party_name }}
                                        @endif
                                    </td>
                                    <td>{{ $candidate->votes}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif 
    @elseif($position->type == 2)
        <?php 
            $dept_array = array();
            foreach($position->candidate as $candidate){
               if(!array_key_exists($candidate->year->dept_id, $dept_array)){
                    $dept_array[$candidate->year->dept_id] = array('id' => $candidate->year->dept_id, 'dept_name' => $candidate->year->department->dept_name);
               }
            }
        ?>

        <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">

                        <h4 class="m-t-0 header-title"><b>Election Results for {{ $position->position_name }}</b></h4>
                        <p class="text-muted font-13">
                          @if(time() < $election->end)
                                @if(Auth::user()->lvl == 0)
                                    Partial election result.
                                @else
                                    Names will be reveal after the elections.
                                @endif
                            @else
                                Overall election results.
                            @endif
                        </p>
                        @foreach($dept_array as $deps)
                        <h4>{{ $deps['dept_name'] }}</h4>
                        <table class="table table-responsive table-inverse table-hover m-b-0">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Partylist</th>
                                    <th>Accumulated Votes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($x = 1)
                                @foreach($position->candidate as $candidate)
                                @if($candidate->year->dept_id == $deps['id'])
                                <tr>
                                    <td>{{ $x++ }}</td>
                                    <td>
                                        @if(time() < $election->end)
                                            @if(Auth::user()->lvl == 0)
                                                {{-- Uncensored --}}
                                                <a href="{{ asset('media/candidates') }}/{{ $candidate->image }}" class="image-popup" title="{{ $candidate->fname}} {{ $candidate->lname}}">
                                                    <img src="{{ asset('media/candidates') }}/{{ $candidate->image }}" alt="user" class="thumb-sm" />
                                                </a>
                                            @else
                                                {{-- Cencored --}}
                                                <img src="{{ asset('media') }}/00.png" alt="censored-image" class="thumb-sm" />
                                            @endif
                                        @else
                                            {{-- Uncensored --}}
                                            <a href="{{ asset('media/candidates') }}/{{ $candidate->image }}" class="image-popup" title="{{ $candidate->fname}} {{ $candidate->lname}}">
                                                <img src="{{ asset('media/candidates') }}/{{ $candidate->image }}" alt="user" class="thumb-sm" />
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if(time() < $election->end)
                                            @if(Auth::user()->lvl == 0)
                                                {{-- Uncensored --}}
                                                {{ $candidate->lname}}, {{ $candidate->fname}}
                                            @else
                                                {{-- Cencored --}}
                                                ******, ******
                                            @endif
                                        @else
                                            {{-- Uncensored --}}
                                            {{ $candidate->lname}}, {{ $candidate->fname}}
                                        @endif
                                    </td>
                                    <td>
                                        @if(time() < $election->end)
                                            @if(Auth::user()->lvl == 0)
                                                {{-- Uncensored --}}
                                                {{ $candidate->party->party_name }}
                                            @else
                                                {{-- Cencored --}}
                                                ***********
                                            @endif
                                        @else
                                            {{-- Uncensored --}}
                                           {{ $candidate->party->party_name }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $candidate->votes}}
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                        @endforeach
                    </div>
                </div>
        </div>
    @elseif($position->type == 3)
        <?php
            $year_array = array();
            foreach($position->candidate as $candidate){
               if(!array_key_exists($candidate->year_id, $year_array)){
                    $year_array[$candidate->year_id] = array('id' => $candidate->year_id, 'year_name' => $candidate->year->year_name, 'dept_name' => $candidate->year->department->dept_name);
               }
            }
        ?>
        <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">

                        <h4 class="m-t-0 header-title"><b>Election Results for {{ $position->position_name }}</b></h4>
                        <p class="text-muted font-13">
                           @if(time() < $election->end)
                                @if(Auth::user()->lvl == 0)
                                    Partial election result.
                                @else
                                    Names will be reveal after the elections.
                                @endif
                            @else
                                Overall election results.
                            @endif
                        </p>
                        @foreach($year_array as $years)
                        <h4>{{ $years['dept_name'] }} - {{ $years['year_name'] }}</h4>
                        <table class="table table-responsive table-inverse table-hover m-b-0">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Partylist</th>
                                    <th>Accumulated Votes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($x = 1)
                                @foreach($position->candidate as $candidate)
                                @if($candidate->year_id == $years['id'])
                                <tr>
                                    <td>{{ $x++ }}</td>
                                    <td>
                                        @if(time() < $election->end)
                                            @if(Auth::user()->lvl == 0)
                                                {{-- Uncensored --}}
                                                <a href="{{ asset('media/candidates') }}/{{ $candidate->image }}" class="image-popup" title="{{ $candidate->fname}} {{ $candidate->lname}}">
                                                    <img src="{{ asset('media/candidates') }}/{{ $candidate->image }}" alt="user" class="thumb-sm" />
                                                </a>
                                            @else
                                                {{-- Cencored --}}
                                                <img src="{{ asset('media') }}/00.png" alt="censored-image" class="thumb-sm" />
                                            @endif
                                        @else
                                            {{-- Uncensored --}}
                                            <a href="{{ asset('media/candidates') }}/{{ $candidate->image }}" class="image-popup" title="{{ $candidate->fname}} {{ $candidate->lname}}">
                                                <img src="{{ asset('media/candidates') }}/{{ $candidate->image }}" alt="user" class="thumb-sm" />
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if(time() < $election->end)
                                            @if(Auth::user()->lvl == 0)
                                                {{-- Uncensored --}}
                                                {{ $candidate->lname}}, {{ $candidate->fname}}
                                            @else
                                                {{-- Cencored --}}
                                                ******, ******
                                            @endif
                                        @else
                                            {{-- Uncensored --}}
                                            {{ $candidate->lname}}, {{ $candidate->fname}}
                                        @endif
                                    </td>
                                    <td>
                                        @if(time() < $election->end)
                                            @if(Auth::user()->lvl == 0)
                                                {{-- Uncensored --}}
                                                {{ $candidate->party->party_name }}
                                            @else
                                                {{-- Cencored --}}
                                                ***********
                                            @endif
                                        @else
                                            {{-- Uncensored --}}
                                           {{ $candidate->party->party_name }}
                                        @endif
                                    </td>
                                    <td>{{ $candidate->votes}}</td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                        @endforeach
                    </div>
                </div>
        </div>
    @endif

@endforeach

@endsection

{{-- Top Page Js --}}
@section('js-top')
<script src="{{ asset('vendor/magnific-popup/js/jquery.magnific-popup.min.js') }}"></script>
@endsection

{{-- Bottom Js Script --}}
@section('js-bot')
<script>
        
function announce(id){

    var isConfirm = confirm('Are you sure you want to announce the election result?');

    if(isConfirm == true){
        $.ajax({
            url: "/admin/election/result",
            type: 'POST',
            dataType: 'json',
            data:{
                '_token' : $("meta[name='_token']").attr("content"),
                'id' : {{ $election->id }}
                
            },
            success:function(Result)
            {   
                 toastr['success']("Election result has been announced.");
            },
            error: function(xhr)
            {

                if(xhr.status == 406){
                    var message_er = JSON.parse(xhr.responseText);
                    toastr['error'](message_er['message']);
                }else if(xhr.status == 422){
                    toastr['error']("All fields are required!");
                }else{
                    toastr['error']("Something went wrong.");
                }
            },
            beforeSend: function(){
                var element = document.getElementById('announce-sms');
                element.classList.add("whirl", "traditional");
            },
            complete: function(){
                var element = document.getElementById('announce-sms');
                element.classList.remove("whirl", "traditional");
            }
        });
    }
}
$(document).ready(function() {
    $('.image-popup').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        mainClass: 'mfp-fade',
        gallery: {
            enabled: false,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        }
    });



    
});
</script>
@endsection