@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')
{{ $elc->elc_name }} Result
@endsection

{{-- Top Css --}}
@section('css-top')

@endsection

{{-- Bottom Css --}}
@section('css-bot')

@endsection

{{-- Page Title --}}
@section('page-title')
{{ $elc->elc_name }} <small>Result</small>
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
	<a href="/admin/election/precinct/show/{{ $elc->id }}">{{ $elc->elc_name }}</a>
</li>
<li>
    <a href="/admin/election/result/{{ $elc->id }}">Result</a>
</li>
<li class="active">
	All
</li>
@endsection

{{-- Main Content --}}
@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <!-- <div class="panel-heading">
                <h4>Invoice</h4>
            </div> -->
            <div class="panel-body">
                <div class="clearfix">
                    <div class="text-center">
                        <h2>Wesleyan University-Philippines</h2>
                        <h3><b>{{ $elc->elc_name }}</b><h3>
                        <h3><b>ELECTION RESULT</b><h3>
                    </div>
                </div>
                <hr>
                <br>
                <div class="text-center">
                        
                    </div>
                
                <div class="row">
                    <div class="col-md-12">

                        <div class="pull-left m-t-30">
                            <address>
                              <strong>Wesleyan University-Philippines</strong><br>
                                Maria Aurora<br>
                              Aurora, Philippines 3202
                              </address>
                        </div>
                        <div class="pull-right m-t-30">
                            <address>
                                <strong>Election Start: </strong> {{ elc_time($elc->start) }} <br>
                                <strong>Election End: </strong> {{ elc_time($elc->end) }} <br>
                                <strong>Election Status: </strong>@if(is_between(time(), $elc->start, $elc->end) == false) <span class="label label-danger">CLOSED</span> @else <span class="label label-success">OPEN</span> @endif
                            </address>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->

                <div class="m-h-50"></div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table m-t-30">
                                <thead>
                                <tr>
                                    <th>Position</th>
                                    <th>Name</th>
                                    <th>Partylist</th>
                                    <th>Total Voters</th>
                                    <th>Accumulated Votes</th>
                                    <th>Total % of Votes</th>
                                <tr>
                                </thead>
                                <tbody>
                                   @foreach($positions as $position)
                                        @if($position->type == 1)
                                            @foreach($position->candidate->sortBy('year_id') as $candidate)
                                                <tr>
                                                    <td><b>{{ $position->position_name }}</b></td>
                                                    <td>{{ $candidate->lname }}, {{ $candidate->fname }}</td>
                                                    <td>{{ $candidate->party->party_name }}</td>
                                                    <td>{{ $elc_info['voter'] }}</td>
                                                    <td>{{ $candidate->votes }}</td>
                                                    <td>{{ vote_percent($candidate->votes, $elc_info['voter']) }}%</td>
                                                </tr>
                                            @endforeach
                                        @elseif($position->type == 2)
                                            @foreach($position->candidate as $candidate)

                                                <?php 
                                                    $voter_count = 0;
                                                    foreach($voters as $voter){
                                                        if($voter->year->dept_id == $candidate->year->dept_id){
                                                            $voter_count++;
                                                        }
                                                    }
                                                ?>

                                                <tr>
                                                    <td><b>{{ $position->position_name }}</b><br />({{ $candidate->year->department->dept_name }})</td>
                                                    <td>{{ $candidate->lname }}, {{ $candidate->fname }}</td>
                                                    <td>{{ $candidate->party->party_name }}</td>
                                                    <td>{{ $voter_count }}</td>
                                                    <td>{{ $candidate->votes }}</td>
                                                    <td>{{ vote_percent($candidate->votes, $voter_count) }}%</td>
                                                </tr>
                                            @endforeach
                                        @elseif($position->type == 3)
                                            @foreach($position->candidate->sortBy('year_id') as $candidate)

                                                <?php 
                                                    $voter_count = 0;
                                                    foreach($voters as $voter){
                                                        if($voter->year_id == $candidate->year_id){
                                                            $voter_count++;
                                                        }
                                                    }
                                                ?>

                                                <tr>
                                                    <td><b>{{ $position->position_name }}</b><br />({{ $candidate->year->department->dept_name }} - {{ $candidate->year->year_name }})</td>
                                                    <td>{{ $candidate->lname }}, {{ $candidate->fname }}</td>
                                                    <td>{{ $candidate->party->party_name }}</td>
                                                    <td>{{ $voter_count }}</td>
                                                    <td>{{ $candidate->votes }}</td>
                                                    <td>{{ vote_percent($candidate->votes, $voter_count) }}%</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="clearfix m-t-40">
                            <h4 class="text-inverse font-600">PROOFREAD BY:</h4>
                            <br><br>
                            <h5 class="text-inverse font-600">{{ strtoupper(Auth::user()->fname) }} {{ strtoupper(Auth::user()->mname) }}. {{ strtoupper(Auth::user()->lname) }}</h5>
                            <small>{{ Auth::user()->position }}</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6 col-md-offset-3">
                        <p class="text-right"><b>Total voters:</b> {{ $elc_info['voter'] }}</p>
                        <p class="text-right">Casted Votes: {{ $elc_info['cast'] }}</p>
                        <p class="text-right">Uncasted Votes: {{ $elc_info['uncast'] }}</p>
                        <hr>
                        <div class="hidden-print">
                            <div class="pull-right">
                                <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"> Print</i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                
            </div>
        </div>

    </div>

</div>
<!-- end row -->
@endsection

{{-- Top Page Js --}}
@section('js-top')

@endsection

{{-- Bottom Js Script --}}
@section('js-bot')

@endsection