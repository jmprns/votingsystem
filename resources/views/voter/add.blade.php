@extends('layouts.app')

{{-- HTML TITLE --}}
@section('html-title')
Add Voter
@endsection

{{-- CSS VENDOR --}}
@section('css-top')
<link href="{{ asset('vendor/chosen/chosen.css') }}" rel="stylesheet">
@endsection

{{-- CSS STYLES --}}
@section('css-bot')
@endsection

{{-- Bread --}}
@section('bread')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Add Voter</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/dashboard">Voting System</a>
            </li>
            <li>
                <a href="/voters">Voter</a>
            </li>
            <li class="active">
                <strong>Add Voter</strong>
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
    <div id="add-voter-whirl" class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Fill up the form with correct responding value</h5>
                <div class="ibox-tools">
                    
                </div>
            </div>
            <div class="ibox-content">
                <form id="add-voter-form" method="POST" class="form-horizontal">

                    <div class="form-group"><label class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-3"><input type="text" id="lname" placeholder="Last Name" class="form-control" required></div>
                                <div class="col-md-3"><input type="text" id="fname" placeholder="First Name" class="form-control" required></div>
                                <div class="col-md-3"><input type="text" id="mname" placeholder="Middle Name" class="form-control"></div>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">Course - Year</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-9">

                                    <select data-placeholder="Choose Course and Year" id="cy-select" class="form-control" style="width:100%;" tabindex="4" required>
                                        <option value="">Choose Course and Year</option>
                                        @foreach($years as $year)
                                        <option value="{{ $year->course->id }}__{{ $year->id }}">{{ $year->course->name }} - {{ $year->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">Election</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-9">
                                    <select data-placeholder="Choose Election" id="election-select" class="form-control" style="width:100%;" tabindex="4" required>
                                        <option value="">Choose Election</option>
                                        @foreach($elections as $election)
                                            <option value="{{ $election->id }}">{{ $election->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-white" type="reset">Reset</button>
                            <button class="btn btn-primary" type="submit">Add Voter</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- JS VENDOR --}}
@section('js-top')
<!-- Chosen -->
<script src="{{ asset('vendor/chosen/chosen.jquery.js') }}"></script>

@endsection

{{-- JS SECTION --}}
@section('js-bot')
<script type="text/javascript">
    $("#cy-select").chosen();
    $("#election-select").chosen();
</script>

<script>
@if($elections->count() == 0)
toastr.warning("There is no election found. Please create an election first to register voters.", "Warning");
@endif
</script>

<script>
$('#add-voter-form').submit(function(e){

     e.preventDefault();

    $.ajax({
        url: "/voters/add",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : $("meta[name='_token']").attr("content"),
            'lname' : $('#lname').val(),
            'fname' : $('#fname').val(),
            'mname' : $('#mname').val(),
            'cy' : $('#cy-select').val(),
            'election' : $('#election-select').val()
        },
        success:function(Result)
        {   
            toastr.success("Voter has been registered.");
            $('#fname').val('');
            $('#lname').val('');
            $('#mname').val('');
            $('#lname').focus();
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