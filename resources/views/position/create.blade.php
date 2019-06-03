@extends('layouts.app')

{{-- HTML TITLE --}}
@section('html-title')
Position fot {{ $election->name }}
@endsection

{{-- CSS VENDOR --}}
@section('css-top')
@endsection

{{-- CSS STYLES --}}
@section('css-bot')
@endsection

{{-- Bread --}}
@section('bread')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Position</h2>
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
                <strong>Position</strong>
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
    <div id="add-position-whirl" class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Fill up the form with correct responding value</h5>
                <div class="ibox-tools">
                    
                </div>
            </div>
            <div class="ibox-content">
                <form id="add-position-form" method="POST" class="form-horizontal">

                    <div class="form-group"><label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-6"><input type="text" id="name" placeholder="Position Name" class="form-control" required></div>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">Type</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <select id="type" class="form-control" required>
                                        <option value="1">All (All registered voters to this election can vote.)</option>
                                        <option value="2">Course (Voters can vote specific candidate according to course)</option>
                                        <option value="3">Year (Voters can vote specific candidate according to year)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">Max Choices</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-md-6"><input type="number" id="choice" placeholder="Max Choices" class="form-control" required></div>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a href="/election/show/{{ $election->id }}" class="btn btn-white">Return Back</a>
                            <button class="btn btn-primary" type="submit">Add Position</button>
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
@endsection

{{-- JS SECTION --}}
@section('js-bot')
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