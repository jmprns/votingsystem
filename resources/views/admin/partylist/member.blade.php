@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')
Member
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
{{ $party->party_name }} <small>Party</small>
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li>
    <a href="/admin/dashboard">Voting System</a>
</li>
<li>
    <a href="/admin/partylist">Partylist</a>
</li>
<li class="active">
  Member
</li>
@endsection

{{-- Main Content --}}
@section('main-content')
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>{{ $party->party_name }} Party</b></h4>
            <p class="text-muted font-13 m-b-30">
                This is the complete list of members
            </p>

            <table id="datatable" class="table table-hover table-colored table-inverse">
                <thead>
                <tr>
                    
                    <th width="5%">#</th>
                    <th width="7%" align="center"><center>Image</center></th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Election</th>
                    <th>Position</th>
                </tr>
                </thead>

                <tbody>
                @php($x = 1)
                @foreach($members as $member)
                <tr>
                    <td>{{ $x }}</td>
                    <td align="center">
                        <a href="javascript:void(0)" onclick="show_image('{{ $member->image }}')">
                            <img src="{{ asset('media/candidates') }}/{{ $member->image }}" alt="user" class="thumb-sm" />
                        </a>
                    </td>
                    <td>{{ $member->lname }}, {{ $member->fname }} {{ $member->mname }}.</td>
                    <td>{{ $member->dept_name }} - {{ $member->year_name }}</td>
                    <td>{{ $member->elc_name }}</td>
                    <td>{{ $member->position_name }}</td>
                </tr>
                @php($x++)
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

function show_image(src){
    $("#cand-image").attr("src", '{{ asset('media/candidates') }}/'+src);
    $("#modal-candidate-image").modal('show');
}
$(document).ready(function () {
    $('#datatable').dataTable();
    
});
$(document).ready(function() {
    $('.image-popup').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        mainClass: 'mfp-fade',
        gallery: {
            enabled: false,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        }
    });
});
</script>
@endsection