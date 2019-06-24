@extends('layouts.app')

{{-- HTML TITLE --}}
@section('html-title')
Voter List
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
        <h2>Voters</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/dashboard">Voting System</a>
            </li>
            <li class="active">
                <strong>Voter List</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endsection

{{-- MAIN CONTENT --}}
@section('main')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Voter List</h5>
                <div class="ibox-tools">
                    <a href="/voters/add" class="btn btn-success btn-xs"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold" style="color:white;">Add New Voter</span></a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover voter-table" >
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Password</th>
                                <th>Name</th>
                                <th>Course - Year</th>
                                <th>Election Precinct</th>
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
                                    <td>{{ $name[0].", ".$name[1]." ".@$name[2][0]."." }}</td>
                                    <td>{{ $voter->course['name'] }} - {{ $voter->year['name'] }}</td>
                                    <td><a href="/election/show/{{ $voter->election->id }}"><strong>{{ $voter->election->name }}</strong></a></td>
                                    <td align="center">
                                        @if($voter->cast == 1)
                                            <span class="label label-success">Casted</span>
                                        @else
                                            <span class="label label-danger">Uncast</span>
                                        @endif
                                    </td>
                                    <td align="center">
                                        <a href="/voters/edit/{{ $voter->id }}" class="btn btn-warning btn-sm btn-bitbucket" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <button onclick="deleteVoter('{{ $voter->id }}')" class="btn btn-danger btn-sm btn-bitbucket" title="Delete">
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
                        '<h2 align="center">Voter List</h2>'
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
                    columns: [0, 1,2,3,4,5],
                    stripHtml: true
                }

            }
        ]

    });

});

function deleteVoter(id){
    swal({
        title: "Delete this voter?",
        text: "Linked information to this voter will also be delete. Continue?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        closeOnConfirm: false
    }, function () {
       window.location = '/voters/delete/'+id;
    });
}
</script>
@endsection