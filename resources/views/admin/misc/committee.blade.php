
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
Election Committee Dashboard
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
Voters List
@endsection

{{-- Main Content --}}
@section('main-content')

<!-- Voters list -->
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Voters List</b></h4>
            <p class="text-muted font-13 m-b-30">
                This is the complete voter list for all elections.
            </p>

            <table id="datatable" class="table table-hover table-colored table-inverse">

                <thead>
                <tr>
                    <th>User ID</th>
                    <th>Password</th>
                    <th>Name</th>
                    <th>Department - Year</th>
                    <th>Election Precient</th>
                    <th>CP Number</th>
                    <th>Vote Status</th>
                </tr>
                </thead>

                <tbody>
                @foreach($voters as $voter)
                	<tr>
                		<td>{{ $voter->id }}</td>
                		<td>{{ $voter->alias }}</td>
                		<td>{{ $voter->lname }}, {{ $voter->fname }} @if($voter->mname !== ''){{ $voter->mname }}.@endif</td>
                		<td>{{ $voter->year->department->dept_name }} - {{ $voter->year->year_name }}</td>
                		<td>{{ $voter->elc->elc_name }}</td>
                		<td>{{ $voter->number }}</td>
                		<td>{!! vote_stat($voter->cast) !!}</td>
                	</tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


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

$(document).ready(function () {
    $('#datatable').dataTable();
});
         
</script>
@endsection