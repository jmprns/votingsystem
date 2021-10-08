
@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')
Voters
@endsection

{{-- Top Css --}}
@section('css-top')
<link href="{{ asset('vendor/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('vendor/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('vendor/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Bottom Css --}}
@section('css-bot')

@endsection

{{-- Page Title --}}
@section('page-title')
Voters
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li>
    <a href="/admin/dashboard">Voting System</a>
</li>
<li class="active">
   Voters
</li>
@endsection

{{-- Main Content --}}
@section('main-content')

<!-- Voters list -->
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false"> Actions <span class="caret"></span> </button>
                    <ul class="dropdown-menu">
                        <li><a href="/admin/voters/add">Add new voter</a></li>
                        <li><a href="/admin/voters/print" target="_new">Print Voter</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#modal-migrate">Migrate selected voters</a></li>
                        <li><a href="#" onclick="dmv()">Delete selected voters</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#modal-scsms">Send credentials via SMS</a></li>
                    </ul>
            </div>

            <h4 class="m-t-0 header-title"><b>Voters List</b></h4>
            <p class="text-muted font-13 m-b-30">
                This is the complete voter list for all elections.
            </p>

            <table id="datatable" class="table table-hover table-colored table-inverse">

                <thead>
                <tr>
                    <th></th>
                    <th>User ID</th>
                    <th>Password</th>
                    <th>Name</th>
                    <th>Department - Year</th>
                    <th>Election Precient</th>
                    <th>CP Number</th>
                    <th>Vote Status</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($userData as $user)
                <tr id="user-tr-{{ $user->user_id }}">
                    <td>
                        <div class="checkbox checkbox-success">
                            <input id="voter-checkbox-{{ $user->user_id }}" name="remember[]" type="checkbox" onchange="check({{ $user->user_id }})">
                            <label for="voter-checkbox-{{ $user->user_id }}"></label>
                        </div>
                    </td>
                    <td>{{ $user->user_id }}</td>
                    <td>{{ $user->alias }}</td>
                    <td>{{ $user->lname }}, {{ $user->fname }} @if($user->mname !== '' || $user->mname !== NULL) {{ $user->mname }}. @endif</td>
                    <td>{{ $user->dept_name }} - {{ $user->year_name }}</td>
                    <td>{{ $user->elc_name }}</td>
                    <td>{{ $user->number }}</td>
                    <td>{!! vote_stat($user->cast) !!}</td>
                    <td align="center">
                        <a href="/admin/voters/edit/{{ $user->user_id }}" class="table-action-btn h3"><i class="mdi mdi-pencil-box-outline text-success"></i></a>
                        <a href="#" onclick="delete_voter('{{ $user->user_id }}')" class="table-action-btn h3"><i class="mdi mdi-close-box-outline text-danger"></i></a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal send credentials --}}
<div id="modal-scsms" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div id="modal-scsms-whirl" class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Select Election</h4>
            </div>
            <div class="modal-body">
               
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                                <select required id="elc-select" class="form-control" placeholder="Choose..." required>
                                    <option value="">Choose...</option>
                                    @foreach($elections as $elc)
                                        <option value="{{ $elc->id }}">{{ $elc->elc_name }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>
                <button type="submit" onclick="scsms()" class="btn btn-lg btn-block btn-primary">Send</button>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{-- Modal migrate voters --}}
<div id="modal-migrate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div id="modal-migrate-whirl" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Migrate Voters</h4>
            </div>
            <div class="modal-body">
                <p>Migrating the selected voters will do the following:</p>
                    <ul id="ballot-candidates-review">
                        <li>Generate new password</li>
                        <li>Changing the election precinct</li>
                        <li>Reset the voting status</li>
                        <li>Remove in the candidate list of previous election.</li>
                    </ul>

                <p>If you wish to continue,fill up the form and click the button below:</p>
               
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                                <select class="select2 form-control" id="elc-migrate" data-placeholder="Choose Election ...">
                                    <option value="">Choose Election..</option>
                                    @foreach($elections as $elc)
                                        <option value="{{ $elc->id }}">{{ $elc->elc_name }} ({{ date('Y', $elc->start) }})</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group"> 
                                <select class="select2 form-control" id="year-migrate" data-placeholder="Choose Department ...">
                                    <option value="">Choose Department..</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year->id }}">{{ $year->department->dept_name }} - {{ $year->year_name }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>
                <button onclick="migrate()" class="btn btn-lg btn-block btn-inverse">Migrate</button>
                

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

{{-- Top Page Js --}}
@section('js-top')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
@endsection

{{-- Bottom Js Script --}}
@section('js-bot')
<script type="text/javascript">
$("#elc-select").select2();
$("#elc-migrate").select2();
$("#year-migrate").select2();
function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

var ids = [];

function check(id){
    if(ids.includes(id) == true){
        removeA(ids, id)
    }else{
        ids.push(id);
    }
}

function migrate()
{   
   $.ajax({
            url: "/admin/voters/action",
            type: 'POST',
            dataType: 'json',
            data:{
                '_token' : $("meta[name='_token']").attr("content"),
                'aid' : 3,
                'ids' : ids,
                'year' : $('#year-migrate').val(),
                'elc' : $('#elc-migrate').val()
            },
            success:function(Result)
            {   
                $('#modal-migrate').modal('toggle');
                toastr['success']("Voters has been migrated.");
                location.reload();
            },
            error:function(xhr)
            {
                if(xhr.status == 406){
                    var message_er = JSON.parse(xhr.responseText);
                    toastr['error'](message_er['message']);
                }else {
                    toastr['error']("Something went wrong. Error code: "+xhr.status);
                }

            },
            beforeSend: function(){
                var element = document.getElementById('modal-migrate-whirl');
                element.classList.add("whirl", "traditional");
            },
            complete: function(){
                var element = document.getElementById('modal-migrate-whirl');
                element.classList.remove("whirl", "traditional");
            }
    });
}


function dmv()
{
    swal({
        title: "Delete the voters?",
        text: "You will not be able to recover this information!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-warning',
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: true
    }, function () {
        $.ajax({
            url: "/admin/voters/action",
            type: 'POST',
            dataType: 'json',
            data:{
                '_token' : $("meta[name='_token']").attr("content"),
                'aid' : 1,
                'ids' : ids
            },
            success:function(Result)
            {   
                toastr['success']("Voters has been deleted");
                location.reload();
            },
            error:function(xhr)
            {
                if(xhr.status == 406){
                    var message_er = JSON.parse(xhr.responseText);
                    toastr['error'](message_er['message']);
                }else {
                    toastr['error']("Something went wrong. Error code: "+xhr.status);
                }

            },
            beforeSend: function(){
                var element = document.getElementById('datatable');
                element.classList.add("whirl", "traditional");
            },
            complete: function(){
                var element = document.getElementById('datatable');
                element.classList.remove("whirl", "traditional");
            }
        });
        
    });
}

function scsms()
{
    $.ajax({
            url: "/admin/voters/action",
            type: 'POST',
            dataType: 'json',
            data:{
                '_token' : $("meta[name='_token']").attr("content"),
                'aid' : 2,
                'id' : $('#elc-select').val()
            },
            success:function(Result)
            {   
                toastr['success']("Credentials has been send.");
                $('#modal-scsms').modal('toggle');
            },
            error:function(xhr)
            {
                if(xhr.status == 406){
                    var message_er = JSON.parse(xhr.responseText);
                    toastr['error'](message_er['message']);
                }else {
                    toastr['error']("Something went wrong. Error code: "+xhr.status);
                }
               

            },
            beforeSend: function(){
                var element = document.getElementById('modal-scsms-whirl');
                element.classList.add("whirl", "traditional");
            },
            complete: function(){
                var element = document.getElementById('modal-scsms-whirl');
                element.classList.remove("whirl", "traditional");
            }
        });
}


$(document).ready(function () {
    $('#datatable').dataTable();
});

function delete_voter(id){

    var token = $("meta[name='_token']").attr("content");


    swal({
        title: "Delete the voter?",
        text: "You will not be able to recover this information!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-warning',
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: true
    }, function () {
        $.ajax({
            url: "/admin/voters/destroy/"+id,
            type: 'POST',
            dataType: 'json',
            data:{
                '_token' : token,
                'id' : id,
            },
            success:function(Result)
            {   
                if(Result.response == 200)
                {
                    $('#datatable').DataTable().destroy();
                    $('#user-tr-'+id).remove();
                    $('#datatable').DataTable();
                    toastr['success']("Voter has been deleted.");
                }
            },
            beforeSend: function(){
                var element = document.getElementById('datatable');
                element.classList.add("whirl", "traditional");
            },
            complete: function(){
                var element = document.getElementById('datatable');
                element.classList.remove("whirl", "traditional");
            }
        });
        
    });


}

         
</script>
@endsection