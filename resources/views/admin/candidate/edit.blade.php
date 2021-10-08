@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')
Edit Candidate
@endsection

{{-- Top Css --}}
@section('css-top')
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Bottom Css --}}
@section('css-bot')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/croppie/croppie.css') }}">
@endsection

{{-- Page Title --}}
@section('page-title')
{{ $election->elc_name }} <small>Edit Candidate</small>
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
	<a href="/admin/election/precinct/show/{{ $election->id }}">{{ $election->elc_name }}</a>
</li>
<li>Edit Candidate</li>
@endsection

{{-- Main Content --}}
@section('main-content')
<!-- Add Candidate Box -->
<div class="row">
    <div class="col-sm-12">
        <div id="add-candidate-whirl" class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Edit Candidate</b></h4>
            <p class="text-muted font-13 m-b-30">
                Please fill up the form with correct responding value
            </p>
            <div class="row">
                <div class="col-md-8">
                    <form id="add-candidate-form" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Full Name</label>
                            <div class="col-md-4">
                                <input type="text" id="lname" value="{{ $candidate->lname }}" required class="form-control" placeholder="Last Name">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="fname" value="{{ $candidate->fname }}" required class="form-control" placeholder="First Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Election</label>
                            <div class="col-md-4">
                               <select id="pos-select" class="form-control" required>
                                    <option>Choose Position...</option>
                                    @foreach($position as $pos)
                                    <option value="{{ $pos->id }}" @if($candidate->pos_id == $pos->id) selected @endif>{{ $pos->position_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                               <select id="party-select" class="form-control" required>
                                    <option>Choose Party...</option>
                                    @foreach($partylist as $party)
                                    <option value="{{ $party->id }}" @if($candidate->party_id == $party->id) selected @endif>{{ $party->party_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Department & Year</label>
                            <div class="col-md-8">
                                <select id="dept-select" class="form-control" required>
                                    <option>Choose...</option>
                                    @foreach($deptyear as $dy)
                                    <option value="{{ $dy->id }}" @if($candidate->year_id == $dy->id) selected @endif>{{ $dy->dept_name }} - {{ $dy->year_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Number</label>
                            <div class="col-md-8">
                               <input  id="cand-num" type="text" value="{{ $candidate->number }}" class="form-control" placeholder="09XXXXXXXXX" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Image</label>
                            <div class="col-md-8">
                                <input type="hidden" id="crop-image" value="">
                               <input type="file" name="upload_image" id="upload_image" accept="image/*" data-buttonbefore="true" class="filestyle">
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
                <div class="col-md-4">
                    <img id="cand-image" src="{{ asset('media/candidates') }}/{{ $candidate->image }}" alt="" class="img-thumbnail">
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Modal Add -->
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

{{-- Top Page Js --}}
@section('js-top')
<script src="{{ asset('vendor/croppie/croppie.min.js') }}"></script>
<script src="{{ asset('vendor/croppie/exif.js') }}"></script>
@endsection

{{-- Bottom Js Script --}}
@section('js-bot')
<!-- Page js -->
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>
<script>
// Select2
$("#dept-select").select2();
$("#pos-select").select2();
$("#party-select").select2();


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
            $('#crop-image').val(response);
            $("#cand-image").attr("src", response);
            $('#uploadimageModal').modal('toggle');
        })
    });

});

$('#add-candidate-form').submit(function(e){

     e.preventDefault();

    var token = $("meta[name='_token']").attr("content");
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var party = $('#party-select').val();
    var year = $('#dept-select').val();
    var pos = $('#pos-select').val();
    var num = $('#cand-num').val();
    var image = $('#crop-image').val();
    $.ajax({
        url: "/admin/election/candidate/update",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'id' : {{ $candidate->id }},
            'fname' : fname,
            'lname' : lname,
            'party' : party,
            'year' : year,
            'elc' : {{ $election->id }},
            'pos'  : pos,
            'image' : image,
            'num' : num
            
        },
        success:function(Result)
        {   
            if(Result.response == 200)
            {
               swal('Success!', 'Candidate information has been updated', 'success');
               window.location = '/admin/election/precinct/show/'+{{ $election->id }};
            }
        },
        error: function(xhr)
        {

            if(xhr.status == 406){
                var message_er = JSON.parse(xhr.responseText);
                toastr['error'](message_er['message']);
            }else if(xhr.status == 422){
                toastr['error']("All fields are required!");
            }else{
                toastr['error']("Something went wrong.");
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