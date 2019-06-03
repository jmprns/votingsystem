@extends('layouts.app')

{{-- HTML TITLE --}}
@section('html-title')
Candidate for {{ $election->name }}
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
        <h2>Add Candidate</h2>
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
                <strong>Add Candidate</strong>
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
                                @php($name = explode('__', $voter->name))
                                <div class="col-md-3"><input type="text" class="form-control" readonly value="{{ $name[0] }}"></div>
                                <div class="col-md-3"><input type="text" class="form-control" readonly value="{{ $name[1] }}"></div>
                                <div class="col-md-2"><input type="text" class="form-control" readonly value="{{ $name[2][0] }}."></div>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">Election</label>
                        <div class="col-sm-10">
                            <div class="row">

                                <div class="col-md-4">
                                    <select data-placeholder="Choose Position" id="position-select" class="form-control" style="width:100%;" tabindex="4" required>
                                        <option value="">Choose Position</option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <select data-placeholder="Choose Party" id="party-select" class="form-control" style="width:100%;" tabindex="4" required>
                                        <option value="">Choose Party</option>
                                        @foreach($parties as $party)
                                            <option value="{{ $party->id }}">{{ $party->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                               
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">Course - Year</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" class="form-control" readonly value="{{ $voter->course->name." - ".$voter->year->name }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="file" class="form-control" required>
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
<script>
@if($positions->count() == 0)
toastr.warning("There is no position found. Please create an position first to register candidates.", "Warning");
@endif
</script>
<script>
    $("#position-select").chosen();
    $("#party-select").chosen();
</script>
<script>
$('#add-position-form').submit(function(e){

     e.preventDefault();

    $.ajax({
        url: "/election/position",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : $("meta[name='_token']").attr("content"),
            'name' : $('#name').val(),
            'type' : $('#type').val(),
            'choice' : $('#choice').val(),
            'election' : {{ $election->id }}
        },
        success:function(Result)
        {   
            toastr.success("Position has been added.");
            $('#name').val('');
            $('#choice').val('');
            $('#type').val('1');
            $('#name').focus();
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