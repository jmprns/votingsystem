@extends('layouts.app')

{{-- HTML TITLE --}}
@section('html-title')
Candidate for {{ $election->name }}
@endsection

{{-- CSS VENDOR --}}
@section('css-top')
<link href="{{ asset('vendor/chosen/chosen.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/croppie/croppie.css') }}">
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
    <div id="add-candidate-whirl" class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Fill up the form with correct responding value</h5>
                <div class="ibox-tools">
                    
                </div>
            </div>
            <div class="ibox-content">
                <form id="add-candidate-form" method="POST" class="form-horizontal">

                    <div class="form-group"><label class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10">
                            <div class="row">
                                @php($name = explode('__', $voter->name))
                                <div class="col-md-3"><input type="text" class="form-control" readonly value="{{ $name[0] }}"></div>
                                <div class="col-md-3"><input type="text" class="form-control" readonly value="{{ $name[1] }}"></div>
                                <div class="col-md-2"><input type="text" class="form-control" readonly value="{{ $name[2] }}"></div>
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
                                    <input type="hidden" id="crop-image" value="">
                                    <input type="file" name="upload_image" id="upload_image" accept="image/*" class="form-control">
                                </div>
                               
                            </div>
                        </div>
                    </div>

                   

                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a href="/election/show/{{ $election->id }}" class="btn btn-white">Return Back</a>
                            <button class="btn btn-primary" type="submit">Add Candidate</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Image Cropper -->
<div id="uploadimageModal" class="modal" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload & Crop Image</h4>
        </div>
        <div class="modal-body">
          <div class="row">
       <div class="col-md-12 text-center">
        <div id="image_demo"></div>
       </div>
    </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success crop_image">Crop</button>
        </div>
     </div>
    </div>
</div><!-- /.modal -->
@endsection

{{-- JS VENDOR --}}
@section('js-top')
<!-- Chosen -->
<script src="{{ asset('vendor/chosen/chosen.jquery.js') }}"></script>
<script src="{{ asset('vendor/croppie/croppie.min.js') }}"></script>
<script src="{{ asset('vendor/croppie/exif.js') }}"></script>
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
$(document).ready(function(){

    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
            width:200,
            height:200,
            type:'square' //circle
        },
        boundary:{
            width:300,
            height:300
        }
    });

    $('#upload_image').on('change', function(){
        var reader = new FileReader();
        reader.onload = function (event) {
        $image_crop.croppie('bind', {
            url: event.target.result
        }).then(function(){
          console.log('jQuery bind complete');
        });
        }
        reader.readAsDataURL(this.files[0]);
        $('#uploadimageModal').modal('show');
    });

    $('.crop_image').click(function(event){
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport',
            format: 'jpeg'
        }).then(function(response){
            console.log(response);
            $('#crop-image').val(response);
            $('#uploadimageModal').modal('toggle');
        })
    });

});
$('#add-candidate-form').submit(function(e){

    e.preventDefault();

    $.ajax({
        url: "/election/candidate/add",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : $("meta[name='_token']").attr("content"),
            'position' : $('#position-select').val(),
            'party' : $('#party-select').val(),
            'image' : $('#crop-image').val(),
            'voter' : {{ $voter->id }}
        },
        success:function(Result)
        {   
            swal({
                title: "Success",
                text: "The candidate has been added.",
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
            var element = document.getElementById('add-candidate-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('add-candidate-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
});
</script>
@endsection