$("#dept-select").select2();

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
            $('#edit-avatar').attr('src', response);
            $('#uploadimageModal').modal('toggle');
        })
    });

});


$('#setting-admin-info').submit(function(e){
     e.preventDefault();
    var token = $("meta[name='_token']").attr("content");
    var fname = $('#admin-fname').val();
    var lname = $('#admin-lname').val();
    var mname = $('#admin-mname').val();
    var pos = $('#admin-pos').val();

    // console.log(fname);
    $.ajax({
        url: "/admin/settings",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'setId' : '1',
            'fname' : fname,
            'lname' : lname,
            'mname' : mname,
            'pos'  : pos 
        },
        success:function(Result)
        {   
            if(Result.response == 200)
            {
                toastr['success']("Your information has been updated.");
            }
        },
        beforeSend: function(){
            var element = document.getElementById('profile-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('profile-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
});


$('#setting-admin-pass').submit(function(e){

     e.preventDefault();

    var token = $("meta[name='_token']").attr("content");
    var old = $('#old-pass').val();
    var new_pass = $('#new-pass').val();

    // console.log(fname);
    $.ajax({
        url: "/admin/settings",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'setId' : '2',
            'old' : old,
            'new' : new_pass
        },
        success:function(Result)
        {   
            if(Result.response == 200)
            {
                toastr['success']("Your password has been updated.");
            }else if(Result.response == 100)
            {
                toastr['error']("Wrong password.");
            }else
            {
                toastr['error']("Something went wrong.");
            }
        },
        beforeSend: function(){
            var element = document.getElementById('profile-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('profile-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
});

$('#setting-admin-image').submit(function(e){

     e.preventDefault();

    var token = $("meta[name='_token']").attr("content");
    var image = $('#crop-image').val();

    // console.log(fname);
    $.ajax({
        url: "/admin/settings",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'setId' : '3',
            'image' : image
        },
        success:function(Result)
        {   
            if(Result.response == 200)
            {
                toastr['success']("Your profile image has been updated.");
                $('#primary-app-avatar').attr('src', Result.image);
                location.reload();
            }
            else
            {
                toastr['error']("Something went wrong.");
            }
        },
        beforeSend: function(){
            var element = document.getElementById('profile-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('profile-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
});

$('#setting-reset-form').submit(function(e){

     e.preventDefault();

     $('#reset-modal').modal('toggle');

    var token = $("meta[name='_token']").attr("content");
    var pass = $('#reset-pwd').val();

    // console.log(fname);
    $.ajax({
        url: "/admin/settings",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'setId' : '5',
            'password' : pass
        },
        success:function(Result)
        {   
            if(Result.response == 200)
            {
                toastr['success']("Application has been rest. Logging out.");
                window.location = '/admin/logout';
            }else if(Result.response == 100)
            {
                toastr['error']("Wrong password.");
            }else
            {
                toastr['error']("Something went wrong.");
            }
        },
        beforeSend: function(){
            var element = document.getElementById('whirl-content-page');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('whirl-content-page');
            element.classList.remove("whirl", "traditional");
        }
    });
});


function sms_gateway()
{
    var token = $("meta[name='_token']").attr("content");
    var mode = $('#sms-switch').is(':checked');

   if(mode == false){
        var stat = 0;
   }else{
        var stat = 1;
   }


    $.ajax({
        url: "/admin/settings",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'setId' : '6',
            'stat' : stat
        },
        success:function(Result)
        {   
            if(Result.response == 200)
            {
                toastr['success']("Gateway mode has been updated.");

            }
            else
            {
                toastr['error']("Something went wrong.");
            }
        },
        beforeSend: function(){
            var element = document.getElementById('system-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('system-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });

   
}


function sms_ip()
{
    $('#sms-modal').modal('toggle');

    var token = $("meta[name='_token']").attr("content");
    var ip = $('#sms-ip').val();

    $.ajax({
        url: "/admin/settings",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'setId' : '8',
            'ip' : ip
        },
        success:function(Result)
        {   
            if(Result.response == 200)
            {
                toastr['success']("Gateway IP has been updated.");
                $('#sms-ip-inner').html(ip);
            }
            else
            {
                toastr['error']("Something went wrong.");
            }
        },
        beforeSend: function(){
            var element = document.getElementById('system-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('system-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });

   
}

function delete_admin(id){

    var token = $("meta[name='_token']").attr("content");
    var admin_id = id;

    swal({
        title: "Delete this admin?",
        text: "You will not be able to recover this information!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-warning',
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: true
    }, function () {
        $.ajax({
            url: "/admin/settings",
            type: 'POST',
            dataType: 'json',
            data:{
                '_token' : token,
                'admin_id' : admin_id,
                'setId' : '7'
            },
            success:function(Result)
            {   
                if(Result.response == 200)
                {
                    $('#admin-tr-'+id).remove();
                    toastr['success']("The admin has been deleted.");
                }
            },
            beforeSend: function(){
                var element = document.getElementById('system-whirl');
                element.classList.add("whirl", "traditional");
            },
            complete: function(){
                var element = document.getElementById('system-whirl');
                element.classList.remove("whirl", "traditional");
            }
        });
        
    });


}

function add_dept(){



    var token = $("meta[name='_token']").attr("content");
    var dept_name = $('#dept-name').val();

    if(dept_name == ''){
        alert('Department Name cannot be empty');
        return;
    }



    $.ajax({
        url: "/admin/settings",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'setId' : '9',
            'name' : dept_name
        },
        success:function(Result)
        {   
            if(Result.response == 200)
            {

                $('#modal-add-dept').modal('toggle');
                toastr['success'](dept_name+" department has been added.");
                location.reload();

                
            }
            else
            {
                toastr['error']("Something went wrong.");
            }
        },
        beforeSend: function(){
            var element = document.getElementById('modal-add-dept-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('modal-add-dept-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
}


function add_year(){



    var token = $("meta[name='_token']").attr("content");
    var dept_name = $('#dept-select').val();
    var year_name = $('#year-name').val();

    if(dept_name == 'Choose...'){
        alert('Please select a department');
        return;
    }

    if(year_name == ''){
        alert('Year name cannot be empty');
        return;
    }



    $.ajax({
        url: "/admin/settings",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'setId' : '10',
            'dept' : dept_name,
            'year' : year_name
        },
        success:function(Result)
        {   
            if(Result.response == 200)
            {

                $('#modal-add-year').modal('toggle');
                toastr['success'](year_name+"  has been added.");
                location.reload();

                
            }
            else
            {
                toastr['error']("Something went wrong.");
            }
        },
        beforeSend: function(){
            var element = document.getElementById('modal-add-year-whirl');
            element.classList.add("whirl", "traditional");
        },
        complete: function(){
            var element = document.getElementById('modal-add-year-whirl');
            element.classList.remove("whirl", "traditional");
        }
    });
}


function delete_dept(id){

    var token = $("meta[name='_token']").attr("content");
    var dept_id = id;

    swal({
        title: "Delete this department?",
        text: "All candidates and voters related to this department will also be deleted. Continue?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-warning',
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: true
    }, function () {
        $.ajax({
            url: "/admin/settings",
            type: 'POST',
            dataType: 'json',
            data:{
                '_token' : token,
                'dept_id' : dept_id,
                'setId' : '11'
            },
            success:function(Result)
            {   
                if(Result.response == 200)
                {
                    $('#modal-dept-map').modal('toggle');
                    toastr['success']("The department has been deleted.");
                    location.reload();
                }
            },
            beforeSend: function(){
                var element = document.getElementById('dept-map-whirl');
                element.classList.add("whirl", "traditional");
            },
            complete: function(){
                var element = document.getElementById('dept-map-whirl');
                element.classList.remove("whirl", "traditional");
            }
        });
        
    });


}

function delete_year(id){

    var token = $("meta[name='_token']").attr("content");
    var year_id = id;

    swal({
        title: "Delete this Year?",
        text: "All candidates and voters related to this year will also be deleted. Continue?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-warning',
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: true
    }, function () {
        $.ajax({
            url: "/admin/settings",
            type: 'POST',
            dataType: 'json',
            data:{
                '_token' : token,
                'year_id' : year_id,
                'setId' : '12'
            },
            success:function(Result)
            {   
                if(Result.response == 200)
                {
                    $('#modal-dept-map').modal('toggle');
                    toastr['success']("The year has been deleted.");
                    location.reload();
                }
            },
            beforeSend: function(){
                var element = document.getElementById('dept-map-whirl');
                element.classList.add("whirl", "traditional");
            },
            complete: function(){
                var element = document.getElementById('dept-map-whirl');
                element.classList.remove("whirl", "traditional");
            }
        });
        
    });


}
