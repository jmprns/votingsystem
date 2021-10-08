@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')
{{ $election->elc_name }}
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
{{ $election->elc_name }}<small> Precinct</small>
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li>
	<a href="/admin/dashboard">Voting System</a>
</li>
<li>
	<a href="/admin/election">Election</a>
</li>
<li class="active">
	Precinct
</li>
@endsection

{{-- Main Content --}}
@section('main-content')
<!-- Add Hero -->
                        <div class="row">

                            <div class="col-sm-3">
                                <div class="panel">
                                    <div class="panel-body">
                                        <center>
                                            @if(Auth::user()->lvl == 0)
                                            <a href="/admin/election/position/add/{{ $election->id }}">
                                            <img width="100px" height="100px" src="{{ asset('media/icons/position-y.svg') }}" /><br><br>
                                            <span style="font-weight: bolder;">Add Position</span>
                                            </a>
                                            @else
                                            <img width="100px" height="100px" src="{{ asset('media/icons/position-y.svg') }}" /><br><br>
                                            <span style="font-weight: bolder;">Add Position</span>
                                            @endif
                                        </center>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="panel">
                                    <div class="panel-body">
                                        <center>
                                            @if(Auth::user()->lvl == 0)
                                            <a href="#voter-table-con">
                                            <img width="100px" height="100px" src="{{ asset('media/icons/candidate-alt.svg') }}" /><br><br>
                                            <span style="font-weight: bolder;">Add Candidate</span>
                                            </a>
                                            @else
                                            <img width="100px" height="100px" src="{{ asset('media/icons/candidate-alt.svg') }}" /><br><br>
                                            <span style="font-weight: bolder;">Add Candidate</span>
                                            @endif
                                        </center>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="panel">
                                    <div class="panel-body">
                                        <center>
                                            <a href="/admin/election/voter/add/{{ $election->id }}">
                                            <img width="100px" height="100px" src="{{ asset('media/icons/voter-y.svg') }}" /><br><br>
                                            <span style="font-weight: bolder;">Add Voter</span>
                                            </a>
                                        </center>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="panel">
                                    <div class="panel-body">
                                        <center>
                                            <a href="/admin/election/result/{{ $election->id }}">
                                            <img width="100px" height="100px" src="{{ asset('media/icons/result.svg') }}" /><br><br>
                                            <span style="font-weight: bolder;">Election Result</span>
                                            </a>
                                        </center>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- end row -->
                        <!-- End Hero -->

                        <!-- Position list -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <h4 class="m-t-0 header-title"><b>Position List</b></h4>
                                    <p class="text-muted font-13 m-b-30">
                                        This is the complete positions for {{ $election->elc_name }} Precinct.
                                    </p>

                                    <table id="position-table" class="table table-hover table-colored table-inverse">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Max Choice</th>
                                            <th>Candidates</th>
                                            @if(Auth::user()->lvl == 0)
                                            <th><center>Action</center></th>
                                            @endif
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @php($x = 1)
                                        @foreach($position as $pos)
                                        <tr id="position-tr-{{ $pos->id }}">
                                            <td>{{ $x }}</td>
                                            <td>{{ $pos->position_name }}</td>
                                            <td>{{ position_decode($pos->type) }}</td>
                                            <td>{{ $pos->max }}</td>
                                            <td>{{ $pos->cand_count }}</td>
                                            @if(Auth::user()->lvl == 0)
                                            <td align="center">
                                                <a href="/admin/election/position/edit/{{ $pos->id }}" class="table-action-btn h3" title="Edit Position"><i class="mdi mdi-pencil-box-outline text-success"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_position('{{ $pos->id }}')" class="table-action-btn h3" title="Delete Position"><i class="mdi mdi-close-box-outline text-danger"></i></a>
                                            </td>
                                            @endif
                                        </tr>
                                        @php($x++)
                                       @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Candidate list -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <h4 class="m-t-0 header-title"><b>Candidate List</b></h4>
                                    <p class="text-muted font-13 m-b-30">
                                        This is the complete candidates for {{ $election->elc_name }} Precinct.
                                    </p>

                                    <table id="candidate-table" class="table table-hover table-colored table-inverse">
                                        <thead>
                                        <tr>
                                            
                                            <th>#</th>
                                            <th align="center"><center>Image</center></th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Position</th>
                                            <th>Partylist</th>
                                            @if(Auth::user()->lvl == 0)
                                            <th><center>Action</center></th>
                                            @endif
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @php($y = 1)
                                        @foreach($candidates as $candidate)
                                        <tr id="candidate-tr-{{ $candidate->cand_id }}">
                                            <td>{{ $y++ }}</td>
                                            <td align="center">
                                                <a href="javascript:void(0)" onclick="show_image('{{ $candidate->image }}')">
                                                <img src="{{ asset('media/candidates') }}/{{ $candidate->image }}" alt="user" class="thumb-sm" />
                                                </a>
                                            </td>
                                            <td>{{ $candidate->lname }}, {{ $candidate->fname }} @if($candidate->mname !== '') {{ $candidate->mname }}. @endif</td>
                                            <td>{{ $candidate->dept_name }} - {{ $candidate->year_name }}</td>
                                            <td>{{ $candidate->position_name }}</td>
                                            <td>{{ $candidate->party_name }}</td>
                                            @if(Auth::user()->lvl == 0)
                                            <td align="center">
                                                <a href="/admin/election/candidate/edit/{{ $candidate->cand_id }}" class="table-action-btn h3" title="Edit Position"><i class="mdi mdi-pencil-box-outline text-success"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_candidate('{{ $candidate->cand_id }}')" class="table-action-btn h3" title="Delete Position"><i class="mdi mdi-close-box-outline text-danger"></i></a>
                                            </td>
                                            @endif
                                        </tr>
                                       @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Voters list -->
                        <div class="row" id="voter-table-con">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <h4 class="m-t-0 header-title"><b>Voters List</b></h4>
                                    <p class="text-muted font-13 m-b-30">
                                        This is the complete voter list for {{ $election->elc_name }} Precinct.
                                    </p>

                                    <table id="voter-table" class="table table-hover table-colored table-inverse">
                                        <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>Password</th>
                                            <th>Name</th>
                                            <th>Department - Year</th>
                                            <th>Vote Status</th>
                                            <th><center>Action</center></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($voters as $voter)
                                        <tr id="voter-tr-{{ $voter->user_id }}">
                                            <td>{{ $voter->user_id }}</td>
                                            <td>{{ $voter->alias }}</td>
                                            <td>{{ $voter->lname }}, {{ $voter->fname }} @if($voter->mname !== '') {{ $voter->mname }}.@endif</td>
                                            <td>{{ $voter->dept_name }} - {{ $voter->year_name }}</td>
                                            <td>{!! vote_stat($voter->cast) !!}</td>
                                            <td align="center">
                                                @if($voter->isCandidate == 0 && Auth::user()->lvl == 0)
                                                <a href="/admin/election/candidate/add/{{ $election->id }}/{{ $voter->user_id }}" class="table-action-btn h3" title="Add candidate"><i class=" mdi mdi-account-box-outline text-primary"></i></a>
                                                @endif
                                                <a href="/admin/voters/edit/{{ $voter->user_id }}" data-toggle="modal" class="table-action-btn h3" title="Edit Election"><i class="mdi mdi-pencil-box-outline text-success"></i></a>
                                                <a href="javascript:void(0)" onclick="delete_voter('{{ $voter->user_id }}')" class="table-action-btn h3" title="Delete Election"><i class="mdi mdi-close-box-outline text-danger"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


{{-- Modal Candidate Image --}}
<div id="modal-candidate-image" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Candidate Image</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" style="display: flex; justify-content: center; align-items: center;">
                        <img id="cand-image" src="" alt="" class="img-thumbnail">
                    </div>
                </div>
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
@endsection

{{-- Bottom Js Script --}}
@section('js-bot')
<script type="text/javascript">
$(document).ready(function () {
    $('#position-table').dataTable();
    $('#candidate-table').dataTable();
    $('#voter-table').dataTable();
    
});

function show_image(src){
    $("#cand-image").attr("src", '{{ asset('media/candidates') }}/'+src);
    $("#modal-candidate-image").modal('show');
}

@if(Auth::user()->lvl == 0)

function delete_position(id){

    var token = $("meta[name='_token']").attr("content");

    swal({
        title: "Delete the position?",
        text: "You will not be able to recover this information!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-warning',
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: true
    }, function () {
        $.ajax({
            url: "/admin/election/position/delete/"+id,
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
                    $('#position-table').DataTable().destroy();
                    $('#position-tr-'+id).remove();
                    $('#position-table').DataTable();
                    toastr['success']("Position has been deleted.");
                }
            },
            beforeSend: function(){
                var element = document.getElementById('position-table');
                element.classList.add("whirl", "traditional");
            },
            complete: function(){
                var element = document.getElementById('position-table');
                element.classList.remove("whirl", "traditional");
            }
        });
        
    });

}

function delete_candidate(id){

    var token = $("meta[name='_token']").attr("content");

    swal({
        title: "Delete the candidate?",
        text: "You will not be able to recover this information!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-warning',
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: true
    }, function () {
        $.ajax({
            url: "/admin/election/candidate/delete",
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
                    $('#candidate-table').DataTable().destroy();
                    $('#candidate-tr-'+id).remove();
                    $('#candidate-table').DataTable();
                    toastr['success']("Candidate has been deleted.");
                }
            },
            beforeSend: function(){
                var element = document.getElementById('candidate-table');
                element.classList.add("whirl", "traditional");
            },
            complete: function(){
                var element = document.getElementById('candidate-table');
                element.classList.remove("whirl", "traditional");
            }
        });
        
    });

}

@endif

function delete_voter(id){

    var token = $("meta[name='_token']").attr("content");

    swal({
        title: "Delete the candidate?",
        text: "You will not be able to recover this information!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-warning',
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: true
    }, function () {
        $.ajax({
            url: "/admin/voters/delete/"+id,
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
                    $('#voter-table').DataTable().destroy();
                    $('#voter-tr-'+id).remove();
                    $('#voter-table').DataTable();
                    toastr['success']("Voter has been deleted.");
                }
            },
            beforeSend: function(){
                var element = document.getElementById('voter-table');
                element.classList.add("whirl", "traditional");
            },
            complete: function(){
                var element = document.getElementById('voter-table');
                element.classList.remove("whirl", "traditional");
            }
        });
        
    });

}

</script>
@endsection