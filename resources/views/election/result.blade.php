@extends('layouts.app')

{{-- HTML TITLE --}}
@section('html-title')
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

    </div>
</div>
@endsection

{{-- MAIN CONTENT --}}
@section('main')
@foreach($positions as $position)
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
                                <td></td>
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
@endforeach
@endsection

{{-- JS VENDOR --}}
@section('js-top')
@endsection

{{-- JS SECTION --}}
@section('js-bot')
@endsection