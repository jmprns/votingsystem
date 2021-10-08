@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')
Add Position
@endsection

{{-- Top Css --}}
@section('css-top')
<!-- Page css -->
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Bottom Css --}}
@section('css-bot')

@endsection

{{-- Page Title --}}
@section('page-title')
{{ $elc->elc_name }} <small>Add Position</small>
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li>
	<a href="/admin/dashboard">Voting System</a>
</li>
<li>
	<a href="/admin/election">Election</a>
</li>
<li>
	<a href="/admin/election/precinct/show/{{ $elc->id }}">{{ $elc->elc_name }}</a>
</li>
<li class="active">
	Add Position
</li>
@endsection

{{-- Main Content --}}
@section('main-content')
<!-- Add Position Box -->
<div class="row">
    <div class="col-sm-12">
        <div id="add-position-whirl" class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Add Position</b></h4>
            <p class="text-muted font-13 m-b-30">
                Please fill up the form with correct responding value
            </p>
            <form id="add-position" class="form-horizontal">
                @csrf
                        <div class="form-group">
                            <label class="col-md-2 control-label">Position Name</label>
                            <div class="col-md-5">
                                <input type="hidden" id="elc-id" value="{{ $elc->id }}">
                                <input type="text" id="pos-name" class="form-control" placeholder="Position Name">
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="col-md-2 control-label">Position Type</label>
                            <div class="col-md-5">
                               <select id="pos-type" class="form-control">
                                    <option>Choose...</option>
                                    <option value="1">All</option>
                                    <option value="2">Department Select</option>
                                    <option value="3">Year Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Max Choice</label>
                            <div class="col-md-5">
                               <input  id="pos-max" type="number" class="form-control" placeholder="Choice">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <label class="col-md-2"></label>
                            <div class="col-md-10">
                                <a href="{{ URL::previous() }}" class="btn btn-danger btn-bordered waves-effect m-t-10 waves-light">Return back</a>
                                <button type="submit" class="btn btn-success btn-bordered waves-effect m-t-10 waves-light">Submit</button>
                            </div>
                            </div>
                    </form>
            
        </div>
    </div>
</div>
@endsection

{{-- Top Page Js --}}
@section('js-top')

@endsection

{{-- Bottom Js Script --}}
@section('js-bot')
<!-- Page js -->
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>

<script type="text/javascript">
// Select2
$("#pos-type").select2();

$('#add-position').submit(function(e){

     e.preventDefault();

    var token = $("input[name='_token']").val();
    var elc = $('#elc-id').val();
    var name = $('#pos-name').val();
    var type = $('#pos-type').val();
    var max = $('#pos-max').val();
    $.ajax({
        url: "/admin/election/position/store",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'elc' : elc,
            'name' : name,
            'type' : type,
            'max' : max
            
        },
        success:function(Result)
        {   
            if(Result.response == 200)
            {
                toastr['success'](name+" position has been added.");
                $('#pos-name').val('');
            }
        },
        beforeSend: function(){
            var element = document.getElementById('add-position-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('add-position-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
});
</script>
@endsection