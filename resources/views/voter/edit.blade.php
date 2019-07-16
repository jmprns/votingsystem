@extends('layouts.app')

{{-- HTML TITLE --}}
@section('html-title')
Edit Voter
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
        <h2>Edit Voter</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/dashboard">Voting System</a>
            </li>
            <li>
                <a href="/election">Election</a>
            </li>
            <li>
                <a href="/election/show/{{ $election->id }}">{{ $election->name }}</a>
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
    <div id="edit-voter-whirl" class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Fill up the form with correct responding value</h5>
                <div class="ibox-tools">
                    
                </div>
            </div>
            <div class="ibox-content">
                <form id="edit-voter-form" method="POST" class="form-horizontal">
                    <div class="form-group"><label class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10">
                            <div class="row">
                                @php($voterName = explode('__', $voter->name))
                                <div class="col-md-3"><input type="text" id="lname" value="{{ $voterName[0] }}" placeholder="Last Name" class="form-control" required></div>
                                <div class="col-md-3"><input type="text" id="fname" value="{{ $voterName[1] }}" placeholder="First Name" class="form-control" required></div>
                                <div class="col-md-3"><input type="text" id="mname" value="{{ $voterName[2] }}" placeholder="Middle Name" class="form-control"></div>
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
                                            <option value="{{ $year->course->id }}__{{ $year->id }}" @if($voter->year_id == $year->id) selected @endif>{{ $year->course->name }} - {{ $year->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>


                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a href="/election/show/{{ $election->id }}" class="btn btn-white" type="reset">Return Back</a>
                            <button class="btn btn-primary" type="submit">Update Voter</button>
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
$('#edit-voter-form').submit(function(e){

     e.preventDefault();

    $.ajax({
        url: "/election/voters/update/{{ $voter->id }}",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : $("meta[name='_token']").attr("content"),
            'lname' : $('#lname').val(),
            'fname' : $('#fname').val(),
            'mname' : $('#mname').val(),
            'cy' : $('#cy-select').val()
        },
        success:function(Result)
        {   
            swal({
                title: "Success",
                text: "The voter has been updated.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ok",
                closeOnConfirm: false
            }, function () {
               window.location = '/election/show/{{ $election->id }}'
            });
            
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
            var element = document.getElementById('edit-voter-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('edit-voter-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
});
</script>
@endsection