@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')
Add Admin
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
Add Admin
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li>
	<a href="/admin/dashboard">Voting System</a>
</li>
<li>
	<a href="/admin/settings">Settings</a>
</li>
<li>Add Admin</li>
@endsection

{{-- Main Content --}}
@section('main-content')
<div class="row">
    <div class="col-sm-12">
        <div id="add-admin-whirl" class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Add Admin</b></h4>
            <p class="text-muted font-13 m-b-30">
                Please fill up the form with correct responding value
            </p>
            <form id="add-admin-form" class="form-horizontal" role="form">
                @csrf
                        <div class="form-group">
                            <label class="col-md-2 control-label">Full Name</label>
                            <div class="col-md-2">
                                <input type="text" id="lname" class="form-control" placeholder="Last Name">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="fname" class="form-control" placeholder="First Name">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="mname" class="form-control" placeholder="MI">
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-2 control-label">Username</label>
                            <div class="col-md-6">
                               <input  id="uid" type="text" class="form-control" placeholder="Username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Password</label>
                            <div class="col-md-3">
                               <input  id="pwd-1" type="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="col-md-3">
                               <input  id="pwd-2" type="password" class="form-control" placeholder="Confirm Password">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label">Position</label>
                            <div class="col-md-3">
                                <select class="select2 form-control" id="pos-lvl" data-placeholder="Choose Level ...">
                                    <option value="">Choose Level..</option>
                                      <option value="1">Admin</option>              
                                      <option value="2">Committee</option>              
                                </select>
                            </div>
                            <div class="col-md-3">
                               <input  id="position" type="text" class="form-control" placeholder="School Admin">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Image</label>
                            <div class="col-md-6">
                                <input type="hidden" id="crop-image" value="" required>
                               <input type="file" name="upload_image" id="upload_image" accept="image/*" data-buttonbefore="true" class="filestyle" required>
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

{{-- Top Page Js --}}
@section('js-top')

<script src="{{ asset('vendor/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/croppie/croppie.min.js') }}"></script>
<script src="{{ asset('vendor/croppie/exif.js') }}"></script>
@endsection

{{-- Bottom Js Script --}}
@section('js-bot')
<!-- Page js -->
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">


$(document).ready(function(){
$("#pos-lvl").select2();
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
            $('#uploadimageModal').modal('toggle');
        })
    });

});

$('#add-admin-form').submit(function(e){

    e.preventDefault();


    var token = $("meta[name='_token']").attr("content");
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var mname = $('#mname').val();
    var uid = $('#uid').val();
    var pass1 = $('#pwd-1').val();
    var pass2 = $('#pwd-2').val();
    var poslvl = $('#pos-lvl').val();
    var position = $('#position').val();
    var image = $('#crop-image').val();

    if(pass1 !== pass2){
    	toastr['error']("Password mismatch");
    	return;
    }

    // console.log(lvl);
    
    $.ajax({
        url: "/admin/settings",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'fname' : fname,
            'lname' : lname,
            'uid' : uid,
            'pass' : pass2,
            'poslvl'  : poslvl,
            'position'  : position,
            'image' : image,
            'setId' : '4'      
        },
        success:function(Result)
        {   
            if(Result.response == 200)
            {
                toastr['success'](fname+" "+lname+" has been registered as admin.");
                $('#add-admin-form').trigger("reset");
                $("#pos-lvl").select2();
            }else if(Result.response == 100)
            {
            	toastr['error']("Username not available.");
            }else{
            	toastr['error']("Something went wrong.");
            }
        },
        beforeSend: function(){
            var element = document.getElementById('add-admin-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('add-admin-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
});


</script>
@endsection