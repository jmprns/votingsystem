
@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')
Election
@endsection

{{-- Top Css --}}
@section('css-top')
<!-- DataTables -->
<link href="{{ asset('vendor/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('vendor/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('vendor/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Bottom Css --}}
@section('css-bot')

@endsection

{{-- Page Title --}}
@section('page-title')
Election
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li>
    <a href="/admin/dashboard">Voting System</a>
</li>
<li class="active">
    Election
</li>
@endsection

{{-- Main Content --}}
@section('main-content')
{{-- Alert --}}
@if(session("message") == "delete")
<div class="alert alert-success alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <i class="mdi mdi-check-all"></i>
    <strong>Success!</strong> <u>{{ session("election_name") }}</u> has been deleted in election list.
</div>
@endif

@if(Auth::user()->lvl == 0)
<!-- Add button -->
<div class="row">
    <div class="col-sm-4">
         <a class="btn btn-info btn-bordered waves-effect waves-light m-b-20" data-toggle="modal" data-target="#add-election"><i class="mdi mdi-plus"></i> Add election</a>
    </div><!-- end col -->
</div>
@endif

<!-- Election list -->
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Election List</b></h4>
            <p class="text-muted font-13 m-b-30">
                This is the complete election list
            </p>

            <table id="datatable" class="table table-hover table-colored table-inverse">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Election Name</th>
                    <th>Candidates</th>
                    <th>Voters</th>
                    <th>Cast Votes</th>
                    <th>Uncast Votes</th>
                    <th>Time Range</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @php($x = 1)

                @foreach($data as $elc)

                @php($sd = timestamp_to_date($elc->start))
                @php($st = timestamp_to_time($elc->start))
                @php($ed = timestamp_to_date($elc->end))
                @php($et = timestamp_to_time($elc->end))

                
                <tr>
                    <td>{{ $x }}</td>
                    <td>
                       <a href="/admin/election/precinct/show/{{ $elc->id }}"><b>{{ $elc->elc_name }}</b></a>
                    </td>
                    <td>{{ $elc->candidate_count }}</td>
                    <td>{{ $elc->voter_count }}</td>
                    <td>{{ $elc->cast_count }}</td>
                    <td>{{ $elc->uncast_count }}</td>
                    <td>
                        <b>Start: </b>{{ elc_time($elc->start) }}<br>
                        <b>End: </b>{{ elc_time($elc->end) }}
                    </td>
                    <td align="center">

                        <a href="/admin/election/show/{{ $elc->id }}" target="_new" class="table-action-btn h3" title="Open poll page"><i class="mdi mdi-poll-box text-primary"></i></a>
                        @if(Auth::user()->lvl == 0)
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#edit-election" onclick="editElection('{{ $elc->id }}', '{{ $elc->elc_name }}', '{{ $sd }}', '{{ $st }}', '{{ $ed }}', '{{ $et }}')" class="table-action-btn h3" title="Edit Election"><i class="mdi mdi-pencil-box-outline text-success"></i></a>
                        <a href="javascript:void(0)" onclick="deleteElection('{{ $elc->id }}')" class="table-action-btn h3" title="Delete Election"><i class="mdi mdi-close-box-outline text-danger"></i></a>
                        @endif
                    </td>
                </tr>
                @php($x++)
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(Auth::user()->lvl == 0)
<!-- Modal Add -->
<div id="add-election" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content" id="add-election-whirl">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Add Election</h4>
            </div>
            <div class="modal-body">
            <form id="add-election-form" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-3" class="control-label">Election Name</label>
                            <input type="text" id="name" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Start Date</label>
                            <input type="date" id="startDate" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">Start Time</label>
                            <input type="time" id="startTime" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">End Date</label>
                            <input type="date" id="endDate" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">End Time</label>
                            <input type="time" id="endTime" class="form-control">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button id="add-btn" type="submit" class="btn btn-info waves-effect waves-light">Add</button>
            </div>
        </form>
        </div>
    </div>
</div><!-- /.modal -->

<!-- Modal Edit -->
<div id="edit-election" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div id="edit-election-whirl" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Edit Election</h4>
            </div>
            <div class="modal-body">
               <form id="edit-election-form">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="field-3" class="control-label">Election Name</label>
                            <input type="hidden" id="edit-id" value="">
                            <input type="text" class="form-control" id="edit-name" value="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">Start Date</label>
                            <input type="date" class="form-control" id="edit-sd" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">Start Time</label>
                            <input type="time" class="form-control" id="edit-st" value="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-1" class="control-label">End Date</label>
                            <input type="date" class="form-control" id="edit-ed" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-2" class="control-label">End Time</label>
                            <input type="time" class="form-control" id="edit-et" value="">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info waves-effect waves-light">Save changes</button>
            </div>
        </form>
        </div>
    </div>
</div><!-- /.modal -->
@endif
@endsection

{{-- Top Page Js --}}
@section('js-top')
<!-- Datatables js -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap.js') }}"></script>
@endsection

{{-- Bottom Js Script --}}
@section('js-bot')
<script type="text/javascript">

$(document).ready(function () {
    $('#datatable').dataTable();
});

$('#add-election-form').submit(function(e){

     e.preventDefault();

     var token = $("input[name='_token']").val();
     var name = $('#name').val();
     var startDate = $('#startDate').val();
     var startTime = $('#startTime').val();
     var endDate = $('#endDate').val();
     var endTime = $('#endTime').val();
    $.ajax({
        url: "/admin/election/store",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'name' : name,
            'startDate' : startDate,
            'startTime' : startTime,
            'endDate' : endDate,
            'endTime' : endTime
        },
        success:function(Result)
        {     
            if(Result.response == 200){
                swal("Added!", "The election has been added.", "success");
                $("#add-election").modal('toggle');
                location.reload();
            }
        },
        error:function(xhr){
            if(xhr.status == 406){
                var message_er = JSON.parse(xhr.responseText);
                toastr['error'](message_er['message']);
            }else if(xhr.status == 422){
                toastr['error']("All fields are required!");
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


function editElection(id, name, sd, st, ed, et){
     $('#edit-id').val(id);
     $('#edit-name').val(name);
     $('#edit-sd').val(sd);
     $('#edit-st').val(st);
     $('#edit-ed').val(ed);
     $('#edit-et').val(et);
}

$('#edit-election-form').submit(function(e){

     e.preventDefault();

     var token = $("input[name='_token']").val();
     var id = $('#edit-id').val();
     var name = $('#edit-name').val();
     var startDate = $('#edit-sd').val();
     var startTime = $('#edit-st').val();
     var endDate = $('#edit-ed').val();
     var endTime = $('#edit-et').val();
    $.ajax({
        url: "/admin/election/update",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'id' : id,
            'name' : name,
            'startDate' : startDate,
            'startTime' : startTime,
            'endDate' : endDate,
            'endTime' : endTime
        },
        success:function(Result)
        {     
            if(Result.response == 200){
                swal("The election has been edited.", 'success');
                $("#edit-election").modal('toggle');
                location.reload();
            }
        },
        error:function(xhr){
            if(xhr.status == 406){
                var message_er = JSON.parse(xhr.responseText);
                toastr['error'](message_er['message']);
            }else if(xhr.status == 422){
                toastr['error']("All fields are required!");
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

function deleteElection(id){

    swal({
        title: "Delete the election?",
        text: "All information related to this election will also delete!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-warning',
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: true
    }, function () {

        window.location = '/admin/election/delete/'+id;
    });

}


</script>
@endsection