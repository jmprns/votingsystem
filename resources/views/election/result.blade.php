@extends('layouts.app')

{{-- HTML TITLE --}}
@section('html-title')
{{ $election->name }} Results
@endsection

{{-- CSS VENDOR --}}
@section('css-top')
@endsection

{{-- CSS STYLES --}}
@section('css-bot')
@endsection

{{-- Bread --}}
@section('bread')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ $election->name }} Result</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/dashboard">Voting System</a>
            </li>
            <li>
                <a href="/election">Election</a>
            </li>
            <li>
                <a href="/election/show/{{ $election->id }}">{{ $election->name }}</a>
            </li>
            <li class="active">
                <strong>Result</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <a href="/election/result/{{ $election->id }}" class="btn btn-primary" style="margin-top: 30px;">Election Result</a>
    </div>
</div>
@endsection

{{-- MAIN CONTENT --}}
@section('main')
@foreach($positions as $position)
@php($count = $position->candidates->count())

@if($count > 0)

    @if($position->type == 1)

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Election Result for {{ $position->name }}</h5>
                    <div class="ibox-tools">
                        {{-- <a class="btn btn-success btn-xs" href="/election/position/{{ $election->id }}" style="color: white;"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Add New Position</span></a> --}}
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Party</th>
                                    <th>Accumulated Votes</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php($candidates = $position->candidates->sortByDesc('votes_count'))
                            @php($x = 1)
                            @foreach($candidates as $candidate)
                            @php($cname = explode('__', $candidate->info->name))
                                <tr>
                                    <td>{{ $x++ }}</td>
                                    <td align="center"><img src="{{ asset('img/candidates') }}/{{ $candidate->image }}" width="50px" height="50px"></td>
                                    <td>{{ $cname[0] }}, {{ $cname[1] }} {{ @$cname[2][0] }}</td>
                                    <td>{{ $candidate->party->name }}</td>
                                    <td>{{ $candidate->votes_count }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @elseif($position->type == 2)

    <?php
        $courses = array();
        foreach($position->candidates as $candidate){
            if(!array_key_exists($candidate->info->course_id, $courses)){
                $courses[$candidate->info->course_id] = array('id' => $candidate->info->course_id, 'name' => $candidate->info->course->name);
            }
        }
    ?>
   
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Election Result for {{ $position->name }}</h5>
                    <div class="ibox-tools">
                        {{-- <a class="btn btn-success btn-xs" href="/election/position/{{ $election->id }}" style="color: white;"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Add New Position</span></a> --}}
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        @foreach($courses as $course)
                        <h4>{{ $course['name'] }}</h4>
                        <hr>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Party</th>
                                    <th>Accumulated Votes</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php($candidates = $position->candidates->sortByDesc('votes_count'))
                            @php($x = 1)
                            @foreach($candidates as $candidate)
                            @if($candidate->info->course_id == $course['id'])
                            @php($cname = explode('__', $candidate->info->name))
                                <tr>
                                    <td>{{ $x++ }}</td>
                                    <td align="center"><img src="{{ asset('img/candidates') }}/{{ $candidate->image }}" width="50px" height="50px"></td>
                                    <td>{{ $cname[0] }}, {{ $cname[1] }} {{ @$cname[2][0] }}</td>
                                    <td>{{ $candidate->party->name }}</td>
                                    <td>{{ $candidate->votes_count }}</td>
                                </tr>
                            @endif
                            @endforeach
                            </tbody>
                        </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else

    <?php 
        $years = array();
        foreach($position->candidates as $candidate){
            if(!array_key_exists($candidate->info->year_id, $years)){
                $years[$candidate->info->year_id] = array('id' => $candidate->info->year_id,'yearName' => $candidate->info->year->name, 'courseName' => $candidate->info->course->name);
            }
        }

    ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Election Result for {{ $position->name }}</h5>
                    <div class="ibox-tools">
                        {{-- <a class="btn btn-success btn-xs" href="/election/position/{{ $election->id }}" style="color: white;"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Add New Position</span></a> --}}
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        @foreach($years as $year)
                        <h4>{{ $year['courseName'] }} - {{ $year['yearName'] }}</h4>
                        <hr>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Party</th>
                                    <th>Accumulated Votes</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php($candidates = $position->candidates->sortByDesc('votes_count'))
                            @php($x = 1)
                            @foreach($candidates as $candidate)
                            @if($candidate->info->year_id == $year['id'])
                            @php($cname = explode('__', $candidate->info->name))
                                <tr>
                                    <td>{{ $x++ }}</td>
                                    <td align="center"><img src="{{ asset('img/candidates') }}/{{ $candidate->image }}" width="50px" height="50px"></td>
                                    <td>{{ $cname[0] }}, {{ $cname[1] }} {{ @$cname[2][0] }}</td>
                                    <td>{{ $candidate->party->name }}</td>
                                    <td>{{ $candidate->votes_count }}</td>
                                </tr>
                            @endif
                            @endforeach
                            </tbody>
                        </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif
@endif
@endforeach
@endsection

{{-- JS VENDOR --}}
@section('js-top')
@endsection

{{-- JS SECTION --}}
@section('js-bot')
@endsection