@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')
{{ $elc->elc_name }} Winner Result
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
	Winner
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
                        <h3><b>ELECTION WINNER RESULT</b><h3>
                    </div>
                </div>
                <hr>
                
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
                                <strong>Election Status: </strong>@if(is_between(time(), $elc->start, $elc->end) == false) <span class="label label-danger">CLOSED</span> @else <span class="label label-success">OPEN</span> @endif</span>
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
                                        @if($position->max > 1)
                                            @foreach($position->candidate->take($position->max) as $candidate)
                                                <tr>
                                                    <td><b>{{ $position->position_name }}</b></td>
                                                    <td>{{ $candidate->lname }}, {{ $candidate->fname }}</td>
                                                    <td>{{ $candidate->party->party_name }}</td>
                                                    <td>{{ $elc_info['voter'] }}</td>
                                                    <td>{{ $candidate->votes }}</td>
                                                    <td>{{ vote_percent($candidate->votes, $elc_info['voter']) }}%</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach($position->candidate->take(1) as $candidate)
                                                <tr>
                                                    <td><b>{{ $position->position_name }}</b></td>
                                                    <td>{{ $candidate->lname }}, {{ $candidate->fname }}</td>
                                                    <td>{{ $candidate->party->party_name }}</td>
                                                    <td>{{ $elc_info['voter'] }}</td>
                                                    <td>{{ $candidate->votes }}</td>
                                                    <td>{{ vote_percent($candidate->votes, $elc_info['voter']) }}%</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @elseif($position->type == 2)
                                        <?php
                                            $department_array = array();
                                            foreach($position->candidate as $candidate){
                                                if(!in_array($candidate->year->dept_id, $department_array)){
                                                    $department_array[] = $candidate->year->dept_id;
                                                }
                                            }
                                        ?>
                                        @if($position->max > 1)
                                            @foreach($department_array as $dept_id)


                                                <?php 
                                                    $voter_count = 0;
                                                    foreach($voters as $voter){
                                                        if($voter->year->dept_id == $dept_id){
                                                            $voter_count++;
                                                        }
                                                    }
                                                ?>

                                                @foreach($position->candidate->where('year.dept_id', $dept_id)->take($position->max) as $candidate)
                                                    @if($candidate->year->dept_id == $dept_id)
                                                        <tr>
                                                            <td><b>{{ $position->position_name }}</b><br />({{ $candidate->year->department->dept_name }})</td>
                                                            <td>{{ $candidate->lname }}, {{ $candidate->fname }}</td>
                                                            <td>{{ $candidate->party->party_name }}</td>
                                                            <td>{{ $voter_count }}</td>
                                                            <td>{{ $candidate->votes }}</td>
                                                            <td>{{ vote_percent($candidate->votes, $voter_count) }}%</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @else
                                            @foreach($department_array as $dept_id)

                                                <?php 
                                                    $voter_count = 0;
                                                    foreach($voters as $voter){
                                                        if($voter->year->dept_id == $dept_id){
                                                            $voter_count++;
                                                        }
                                                    }
                                                ?>


                                                @foreach($position->candidate->where('year.dept_id', $dept_id)->take(1) as $candidate)
                                                    @if($candidate->year->dept_id == $dept_id)
                                                        <tr>
                                                            <td><b>{{ $position->position_name }}</b><br />({{ $candidate->year->department->dept_name }})</td>
                                                            <td>{{ $candidate->lname }}, {{ $candidate->fname }}</td>
                                                            <td>{{ $candidate->party->party_name }}</td>
                                                            <td>{{ $voter_count }}</td>
                                                            <td>{{ $candidate->votes }}</td>
                                                            <td>{{ vote_percent($candidate->votes, $voter_count) }}%</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    @elseif($position->type == 3)
                                        <?php
                                            $year_array = array();
                                            foreach($position->candidate as $candidate){
                                                if(!in_array($candidate->year_id, $year_array)){
                                                    $year_array[] = $candidate->year_id;
                                                }
                                            }
                                        ?>

                                        @if($position->max > 1)
                                            @foreach($year_array as $year_id)

                                                <?php 
                                                    $voter_count = 0;
                                                    foreach($voters as $voter){
                                                        if($voter->year_id == $year_id){
                                                            $voter_count++;
                                                        }
                                                    }
                                                ?>
                                                @foreach($position->candidate->where('year_id', $year_id)->sortBy('year_id')->take($position->max) as $candidate)
                                                    @if($candidate->year_id == $year_id)
                                                        <tr>
                                                            <td><b>{{ $position->position_name }}</b><br />({{ $candidate->year->department->dept_name }} - {{ $candidate->year->year_name }})</td>
                                                            <td>{{ $candidate->lname }}, {{ $candidate->fname }}</td>
                                                            <td>{{ $candidate->party->party_name }}</td>
                                                            <td>{{ $voter_count }}</td>
                                                            <td>{{ $candidate->votes }}</td>
                                                            <td>{{ vote_percent($candidate->votes, $voter_count) }}%</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @else
                                            @foreach($year_array as $year_id)

                                                <?php 
                                                    $voter_count = 0;
                                                    foreach($voters as $voter){
                                                        if($voter->year_id == $year_id){
                                                            $voter_count++;
                                                        }
                                                    }
                                                ?>
                                                @foreach($position->candidate->where('year_id', $year_id)->sortBy('year_id')->take(1) as $candidate)
                                                    @if($candidate->year_id == $year_id)
                                                        <tr>
                                                            <td><b>{{ $position->position_name }}</b><br />({{ $candidate->year->department->dept_name }} - {{ $candidate->year->year_name }})</td>
                                                            <td>{{ $candidate->lname }}, {{ $candidate->fname }}</td>
                                                            <td>{{ $candidate->party->party_name }}</td>
                                                            <td>{{ $voter_count }}</td>
                                                            <td>{{ $candidate->votes }}</td>
                                                            <td>{{ vote_percent($candidate->votes, $voter_count) }}%</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    @else
                                    @continue;
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