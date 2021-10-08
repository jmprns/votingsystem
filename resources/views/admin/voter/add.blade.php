@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')
Add Voter
@endsection

{{-- Top Css --}}
@section('css-top')
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Bottom Css --}}
@section('css-bot')

@endsection

{{-- Page Title --}}
@section('page-title')
Add Voter
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li>
	<a href="/admin/dashboard">Voting System</a>
</li>
<li>
	<a href="/admin/voters">Voters</a>
</li>
<li>Add Voter</li>
@endsection

{{-- Main Content --}}
@section('main-content')
@if($election->count() == 0)
<div class="alert alert-icon alert-warning alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert"
            aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <i class="mdi mdi-alert"></i>
    <strong>Warning : Election.</strong> There are no election registered in this system. Voters will not be registered. Please <a href="/admin/election" class="alert-link"> create an election </a> first.
</div>
@endif

<div class="row">
    <div class="col-sm-12">
        <div id="add-voter-whirl" class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Add Voter</b></h4>
            <p class="text-muted font-13 m-b-30">
                Please fill up the form with correct responding value
            </p>
            <form id="add-voter-form" class="form-horizontal" role="form">
                @csrf
                        <div class="form-group">
                            <label class="col-md-2 control-label">Full Name</label>
                            <div class="col-md-2">
                                <input type="text" id="lname" class="form-control" placeholder="Last Name" value="" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="fname" class="form-control" placeholder="First Name" value="" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="mname" class="form-control" placeholder="M.I." value="" minlength="1" maxlength="1">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Department & Year</label>
                            <div class="col-md-6">
                                <select id="dept-select" class="form-control" required>
                                    <option value="">Choose...</option>
                                    @foreach($deptyear as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->dept_name }} - {{ $dept->year_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label">Election</label>
                            <div class="col-md-6">
                               <select id="elc-select" class="form-control" required>
                                    <option value="">Choose...</option>
                                    @foreach($election as $elc)
                                        <option value="{{ $elc->id }}" @if(session('elc_id') == $elc->id) selected @endif>{{ $elc->elc_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Phone Number</label>
                            <div class="col-md-6">
                               <input id="number" type="number" class="form-control" placeholder="09XXXXXXXXX" required>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <label class="col-md-2"></label>
                            <div class="col-md-10">
                                <button type="reset" class="btn btn-danger btn-bordered waves-effect m-t-10 waves-light">Reset</button>
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
<script src="{{ asset('vendor/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
// Select2
$("#dept-select").select2();
$("#elc-select").select2();

$('#add-voter-form').submit(function(e){

     e.preventDefault();

    var token = $("input[name='_token']").val();
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var mname = $('#mname').val();
    var year = $('#dept-select').val();
    var elc = $('#elc-select').val();
    var num = $('#number').val();
    $.ajax({
        url: "/admin/voters/store",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'fname' : fname,
            'lname' : lname,
            'mname' : mname,
            'year'  : year,
            'elc' : elc,
            'num' : num
             
            
        },
        success:function(Result)
        {   
            toastr['success'](fname+" "+mname+". "+lname+" has been registered.");
            $('#fname').val('');
            $('#lname').val('');
            $('#mname').val('');
            $('#number').val('');
            $('#lname').focus();
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
            var element = document.getElementById('add-voter-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('add-voter-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
});




</script>
@endsection