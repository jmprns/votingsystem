@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')
Partylist
@endsection

{{-- Top Css --}}
@section('css-top')
<link href="{{ asset('vendor/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('vendor/datatables/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('vendor/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Bottom Css --}}
@section('css-bot')

@endsection

{{-- Page Title --}}
@section('page-title')
Partylist
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li>
	<a href="/admin/dashboard">Voting Sytem</a>
</li>
<li class="active">
	Partylist
</li>
@endsection

{{-- Main Content --}}
@section('main-content')
<!-- Add button -->
<div class="row">
    <div class="col-sm-4">
         <a class="btn btn-info btn-bordered waves-effect waves-light m-b-20" data-toggle="modal" data-target="#add-partylist"><i class="mdi mdi-plus"></i> Add party</a>
    </div><!-- end col -->
</div>

<!-- Voters list -->
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Partylist</b></h4>
            <p class="text-muted font-13 m-b-30">
                This is the complete partylist
            </p>

            <table id="datatable" class="table table-hover table-colored table-inverse">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Party Name</th>
                    <th>Members</th>
                    <th><center>Action</center></th>
                </tr>
                </thead>

                <tbody>
                @php($x = 1)
                @foreach($partyData as $party)
                <tr id="partylist-tr-{{ $party->id }}">
                    <td>{{ $x }}</td>
                    <td>
                       <a href="/admin/partylist/member/{{ $party->id }}"><b><span id="partylist-name-{{ $party->id }}">{{ $party->party_name }}</span></b></a>
                    </td>
                    <td>{{ $party->party_count }}</td>
                    <td align="center">
                        @if($party->id == 1)
                        @else
                        <a href="#" data-toggle="modal" data-target="#edit-partylist" class="table-action-btn h3" onclick="edit_partylist('{{ $party->id }}', '{{ $party->party_name }}')"><i class="mdi mdi-pencil-box-outline text-success"></i></a>
                        <a href="#" onclick="delete_partylist('{{ $party->id }}')" class="table-action-btn h3"><i class="mdi mdi-close-box-outline text-danger"></i></a>
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
 
<!-- Modal Add -->
<div id="add-partylist" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content" id="add-partylist-whirl">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Add Party</h4>
                        </div>
                        <div class="modal-body">
                           <form id="add-partylist-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="field-3" class="control-label">Party Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Party Name" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info waves-effect waves-light">Add</button>
                        </form>
                        </div>
                    </div>
                </div>
</div><!-- /.modal -->

<!-- Modal Edit -->
<div id="edit-partylist" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div id="edit-partylist-whirl" class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title">Edit Party</h4>
                        </div>
                        <div class="modal-body">
                           
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <form id="edit-partylist-form">
                                            <input type="hidden" id="edit-id" value="">
                                        <label for="field-3" class="control-label">Party Name</label>
                                        <input type="text" class="form-control" id="edit-name" value="" placeholder="Partylist Name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info waves-effect waves-light">Save changes</button>
                        </form>
                        </div>
                    </div>
                </div>
</div><!-- /.modal -->
@endsection

{{-- Top Page Js --}}
@section('js-top')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap.js') }}"></script>
@endsection

{{-- Bottom Js Script --}}
@section('js-bot')
<script type="text/javascript">

$(document).ready(function () {
    $('#datatable').dataTable();
});

$('#add-partylist-form').submit(function(e){

     e.preventDefault();

    var token = $("input[name='_token']").val();
    var name = $('#name').val();

    $.ajax({
        url: "/admin/partylist/store",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'name' : name
        },
        success:function(Result)
        {   
            if(Result.response == 200)
            {
                $('#name').val('');
                $('#add-partylist').modal('toggle');
                $('#datatable').DataTable().destroy();
                var party_id = "'"+Result.party_id+"'";
                var party_name = "'"+name+"'";
                $('#datatable tbody').append('<tr id="partylist-tr-'+Result.party_id+'"><td>{{ $x }}@php($x++)</td><td><a href="/admin/partylist/member/'+Result.party_id+'"><span id="partylist-name-'+Result.party_id+'">'+name+'</span></a></td><td>0</td><td align="center"><a href="#" data-toggle="modal" data-target="#edit-partylist" onclick="edit_partylist('+party_id+', '+party_name+')" class="table-action-btn h3"><i class="mdi mdi-pencil-box-outline text-success"></i></a><a href="#" onclick="delete_partylist('+party_id+')" class="table-action-btn h3"><i class="mdi mdi-close-box-outline text-danger"></i></a></td></tr>');
                $('#datatable').DataTable();
                toastr['success'](name+" has been added.");
            }
        },
        error:function(xhr)
        {
            if(xhr.status == 422){
                toastr['error']("Party name is required!");
            }
        },
        beforeSend: function(){
            var element = document.getElementById('add-partylist-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('add-partylist-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
});

function edit_partylist(id, name){
    $('#edit-id').val(id);
    $('#edit-name').val(name);
}

$('#edit-partylist-form').submit(function(e){

     e.preventDefault();

    var token = $("input[name='_token']").val();
    var name = $('#edit-name').val();
    var id = $('#edit-id').val();
    $.ajax({
        url: "/admin/partylist/update/"+id,
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'name' : name
        },
        success:function(Result)
        {   
            if(Result.response == 200)
            {
                $('#edit-name').val('');
                $('#edit-partylist').modal('toggle');
                $('#datatable').DataTable().destroy();
                $('#partylist-name-'+id).html(name);
                $('#datatable').DataTable();
                toastr['success']("Partylist has been updated.");
            }
        },
        error: function(xhr){
            if(xhr.status == 422){
                toastr['error']("Party name is required!");
            }
        },
        beforeSend: function(){
            var element = document.getElementById('edit-partylist-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('edit-partylist-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
});

function delete_partylist(id){

    var token = $("input[name='_token']").val();

    swal({
        title: "Delete the partylist?",
        text: "All candidates related to this party will be independent.",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-warning',
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: true
    }, function (){
        $.ajax({
            url: "/admin/partylist/delete/"+id,
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
                    toastr['success']("Partylist has been deleted.");
                    $('#datatable').DataTable().destroy();
                    $('#partylist-tr-'+id).remove();
                    $('#datatable').DataTable();
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