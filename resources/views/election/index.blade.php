@extends('layouts.app')

{{-- HTML TITLE --}}
@section('html-title')
Election List
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
        <h2>Election</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/dashboard">Voting System</a>
            </li>
            
            <li class="active">
                <strong>Election</strong>
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
    <div class="col-lg-12" id="election-col">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Election List</h5>
                <div class="ibox-tools">
                    @if(Auth::user()->lvl == 0)
                    <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#election-add"><i class="fa fa-plus"></i>&nbsp;&nbsp;<span class="bold">Add New Election</span></button>
                    @endif
                </div>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover election-table" >
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Election Name</th>
                                <th>Candidates</th>
                                <th>Voters</th>
                                <th>Votes</th>
                                <th>Time Range</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($x = 1)
                            @foreach($elections as $election)
                                @php($elc_start = explode(' ', $election->start))
                                @php($elc_end = explode(' ', $election->end))
                            <tr>
                                <td>{{ $x++ }}</td>
                                <td><strong><a href="/election/show/{{ $election->id }}">{{ $election->name }}</a></strong></td>
                                <td>{{ $election->candidates->count() }}</td>
                                <td>{{ $election->voters->count() }}</td>
                                <td>
                                    <strong>Casted:</strong> {{ $election->voters->where('cast', '1')->count() }}
                                    <br> 
                                    <strong>Uncasted: </strong>{{ $election->voters->where('cast', '0')->count() }}
                                </td>
                                <td>
                                    <strong>Start: </strong>{{ $election->start }} <br>
                                    <strong>End: </strong>{{ $election->end }}
                                </td>
                                <td align="center">
                                    @if(Auth::user()->lvl == 0)
                                    <button onclick="editElection('{{ $election->id }}', '{{ $election->name }}', '{{ $elc_start[0] }}', '{{ $elc_start[1] }}', '{{ $elc_end[0] }}', '{{ $elc_end[1] }}')" class="btn btn-warning btn-sm btn-bitbucket" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button onclick="deleteElection('{{ $election->id }}')" class="btn btn-danger btn-sm btn-bitbucket" title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                    @endif
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

@if(Auth::user()->lvl == 0)

<div class="modal inmodal fade" id="election-add" tabindex="-1" role="dialog"  aria-hidden="true">
    <div id="add-election-whirl" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Add Election</h4>
            </div>
            <div class="modal-body">
               <form id="add-election-form" method="POST">

                   <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Election Name</label>
                                <input required type="text" id="electionName" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Election Start Date</label>
                                <input required type="date" id="start-date" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Election Start Time</label>
                                <input required type="time" id="start-time" class="form-control">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Election End Date</label>
                                <input required type="date" id="end-date" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Election End Time</label>
                                <input required type="time" id="end-time" class="form-control">
                            </div>
                        </div>
                        
                    </div>

               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Election</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal inmodal fade" id="election-edit" tabindex="-1" role="dialog"  aria-hidden="true">
    <div id="edit-election-whirl" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Edit Election</h4>
            </div>
            <div class="modal-body">
               <form id="edit-election-form" method="POST">

                   <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Election Name</label>
                                <input type="hidden" id="edit-elc-id" name="elc_id" value="">
                                <input required type="text" id="edit-elc-name" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Election Start Date</label>
                                <input required type="date" id="edit-elc-start-date" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Election Start Time</label>
                                <input required type="time" id="edit-elc-start-time" class="form-control">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Election End Date</label>
                                <input required type="date" id="edit-elc-end-date" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Election End Time</label>
                                <input required type="time" id="edit-elc-end-time" class="form-control">
                            </div>
                        </div>
                        
                    </div>

               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

{{-- JS VENDOR --}}
@section('js-top')
<script src="{{ asset('vendor/dataTables/datatables.min.js') }}"></script>
@endsection

{{-- JS SECTION --}}
@section('js-bot')
<script>
$(document).ready(function(){

    $('.election-table').DataTable({
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'print',
                title: '',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).prepend(
                        '<h2 align="center">Election List</h2>'
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
                    columns: [1,2,3,4,5],
                    stripHtml: false
                }

            }
        ]

    });

});

$('#add-election-form').submit(function(e){

    e.preventDefault();

    $.ajax({
        url: "/election/add",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : $("meta[name='_token']").attr("content"),
            'electionName' : $('#electionName').val(),
            'startDate' : $('#start-date').val(),
            'startTime' : $('#start-time').val(),
            'endDate' : $('#end-date').val(),
            'endTime' : $('#end-time').val()
        },
        success:function(Result)
        {   
            $("#add-election").modal('toggle');

            swal({
                title: "Success",
                text: "The election has been added.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ok",
                closeOnConfirm: false
            }, function () {
               location.reload();
            });
            

        },
        error:function(xhr){
            if(xhr.status == 406){
                var message_er = JSON.parse(xhr.responseText);
                toastr.error(message_er['message']);
            }else if(xhr.status == 422){
                toastr.error("All fields are required!");
            }
        },
        beforeSend: function(){
            var element = document.getElementById('add-election-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('add-election-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
});

$('#edit-election-form').submit(function(e){

    e.preventDefault();

    $.ajax({
        url: "/election/update",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : $("meta[name='_token']").attr("content"),
            'electionId' : $('#edit-elc-id').val(),
            'electionName' : $('#edit-elc-name').val(),
            'startDate' : $('#edit-elc-start-date').val(),
            'startTime' : $('#edit-elc-start-time').val(),
            'endDate' : $('#edit-elc-end-date').val(),
            'endTime' : $('#edit-elc-end-time').val()
        },
        success:function(Result)
        {   
            $("#election-edit").modal('toggle');

            swal({
                title: "Success",
                text: "The election has been updated.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ok",
                closeOnConfirm: false
            }, function () {
               location.reload();
            });
            

        },
        error:function(xhr){
            if(xhr.status == 406){
                var message_er = JSON.parse(xhr.responseText);
                toastr.error(message_er['message']);
            }else if(xhr.status == 422){
                toastr.error("All fields are required!");
            }
        },
        beforeSend: function(){
            var element = document.getElementById('edit-election-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('edit-election-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
});

function editElection(id, elcname, startDate, startTime, endDate, endTime){
    $('#edit-elc-id').val(id);
    $('#edit-elc-name').val(elcname);
    $('#edit-elc-start-date').val(startDate);
    $('#edit-elc-start-time').val(startTime);
    $('#edit-elc-end-date').val(endDate);
    $('#edit-elc-end-time').val(endTime);
    $('#election-edit').modal('toggle');
}

function deleteElection(id){
    swal({
        title: "Delete this election?",
        text: "Linked information to this election will also be delete. Continue?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        closeOnConfirm: true
    }, function () {


        $.ajax({
            url: "/election/delete/"+id,
            type: 'POST',
            dataType: 'json',
            data:{
                '_token' : $("meta[name='_token']").attr("content"),
                'election_id' : id
            },
            success:function(Result)
            {   
                swal({
                    title: "Success",
                    text: "The election has been deleted.",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ok",
                    closeOnConfirm: false
                }, function () {
                   location.reload();
                });
                

            },
            error:function(xhr){
                if(xhr.status == 406){
                    var message_er = JSON.parse(xhr.responseText);
                    toastr.error(message_er['message']);
                }else if(xhr.status == 422){
                    toastr.error("All fields are required!");
                }
            },
            beforeSend: function(){
                var element = document.getElementById('election-col');
                element.classList.add("whirl", "traditional");
            },
            complete: function(){
                var element = document.getElementById('election-col');
                element.classList.remove("whirl", "traditional");
            }
        });
       
    });
}
</script>

@endsection