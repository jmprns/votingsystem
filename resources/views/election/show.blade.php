@extends('layouts.app')

{{-- HTML TITLE --}}
@section('html-title')
{{ $election->name }}
@endsection

{{-- CSS VENDOR --}}
@section('css-top')
<link href="{{ asset('vendor/dataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

{{-- CSS STYLES --}}
@section('css-bot')
@endsection

{{-- Bread --}}
@section('bread')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ $election->name }}</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/dashboard">Voting System</a>
            </li>
            <li>
                <a href="/election">Election</a>
            </li>
            <li class="active">
                <strong>{{ $election->name }}</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2" >
        <button class="btn btn-primary" style="margin-top: 30px;">Election Result</button>
    </div>
</div>
@endsection

{{-- MAIN CONTENT --}}
@section('main')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Position List</h5>
                <div class="ibox-tools">
                    <a class="btn btn-success btn-xs" href="/election/position/{{ $election->id }}" style="color: white;"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Add New Position</span></a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover position-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Position Name</th>
                                <th>Type</th>
                                <th>Max Choices</th>
                                <th>Candidates</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($x = 1)
                            @foreach($positions as $position)
                                <tr>
                                    <td>{{ $x++ }}</td>
                                    <td>{{ $position->name }}</td>
                                    <td>
                                        @switch($position->type)
                                            @case(1)
                                                All
                                            @break
                                            @case(2)
                                                Course
                                            @break
                                            @case(3)
                                                Year
                                            @break
                                            @default
                                                Undefined
                                        @endswitch
                                    </td>
                                    <td>{{ $position->max }}</td>
                                    <td>{{ $position->candidates->count() }}</td>
                                    <td align="center">
                                        <button class="btn btn-warning btn-sm btn-bitbucket" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-bitbucket" title="Delete">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Candidate List</h5>
                <div class="ibox-tools">
                    {{-- <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#election-add"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Add New Position</span></button> --}}
                </div>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover candidate-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Course - Year</th>
                                <th>Position</th>
                                <th>Party</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($x = 1)
                            @foreach($candidates as $candidate)
                            @php($cname = explode('__', $candidate->info->name))
                                <tr>
                                    <td>{{ $x++ }}</td>
                                    <td></td>
                                    <td>{{ $cname[0] }}, {{ $cname[1] }} {{ $cname[2][0] }}.</td>
                                    <td>{{ $candidate->info->course->name }} - {{ $candidate->info->year->name }}</td>
                                    <td>{{ $candidate->position->name }}</td>
                                    <td>{{ $candidate->party->name }}</td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Voter List</h5>
                <div class="ibox-tools">
                    <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#election-add"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Add New Voter</span></button>
                </div>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover voter-table">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Password</th>
                                <th>Name</th>
                                <th>Course - Year</th>
                                <th>Vote Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($voters as $voter)
                            @php($name = explode('__', $voter->name))
                                <tr>
                                    <td>{{ $voter->id }}</td>
                                    <td>{{ $voter->password }}</td>
                                    <td>{{ $name[0] }}, {{ $name[1] }} {{ $name[2][0] }}.</td>
                                    <td>{{ $voter->course->name }} - {{ $voter->year->name }}</td>
                                    <td align="center">
                                        @if($voter->cast == 0)
                                            <span class="label label-danger">Uncast</span>
                                        @else
                                            <span class="label label-success">Casted</span>
                                        @endif
                                    </td>
                                    <td align="center">
                                        @if($voter->isCandidate == 0)
                                            <a href="/election/candidate/{{ $election->id }}/{{ $voter->id }}" class="btn btn-success btn-sm btn-bitbucket" title="Add Candidate">
                                                <i class="fa fa-user"></i>
                                            </a>
                                        @endif
                                        <button class="btn btn-warning btn-sm btn-bitbucket" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-bitbucket" title="Delete">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- JS VENDOR --}}
@section('js-top')
<script src="{{ asset('vendor/dataTables/datatables.min.js') }}"></script>
@endsection

{{-- JS SECTION --}}
@section('js-bot')
<script>
$(document).ready(function(){

    $('.position-table').DataTable({
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'print',
                title: '',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).prepend(
                        "<h2 align='center'>Position List</h2>"
                    );

                    $(win.document.body).prepend(
                        '<h1 align="center">{{ $election->name }}</h1>'
                    );
                    
                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
            },
                autoPrint:false,
                exportOptions:{
                    columns: [0,1,2,3,4],
                    stripHtml: false
                }

            }
        ]

    });

    $('.candidate-table').DataTable({
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'print',
                title: '',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).prepend(
                        "<h2 align='center'>Candidate List</h2>"
                    );

                    $(win.document.body).prepend(
                        '<h1 align="center">{{ $election->name }}</h1>'
                    );
                    
                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
            },
                autoPrint:false,
                exportOptions:{
                    columns: [0,1,2,3,4],
                    stripHtml: false
                }

            }
        ]

    });

    $('.voter-table').DataTable({
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'print',
                title: '',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).prepend(
                        "<h2 align='center'>{{ $election->name }} Voter List</h2>"
                    );

                    $(win.document.body).prepend(
                        '<h1 align="center">Online Voting System</h1>'
                    );
                    
                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
            },
                autoPrint:false,
                exportOptions:{
                    columns: [0,1,2,3,4],
                    stripHtml: false
                }

            }
        ]

    });

});
</script>
@endsection