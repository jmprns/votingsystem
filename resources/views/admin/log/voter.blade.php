@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')
Votes Log
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
Voter Log
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li>
	<a href="/admin/dashboard">Voting System</a>
</li>
<li>
	<a href="/admin/settings">Logs</a>
</li>
<li class="active">
	Voter
</li>
@endsection

{{-- Main Content --}}
@section('main-content')
<table id="datatable" class="table table-hover table-colored table-inverse">

                <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody> 
                	@foreach($voters as $voter)
                        <tr>
                            <td>{{ $voter->created_at }}</td>
                            <td>{{ $voter->user->lname }}, {{ $voter->user->fname }}</td>
                            <td>@if($voter->action == 0)Log-in @else Log-out @endif</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
</script>
@endsection